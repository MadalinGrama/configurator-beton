<?php
/**
 * Enqueue script and styles for child theme
 */
function woodmart_child_enqueue_styles() {
	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( 'woodmart-style' ), woodmart_get_theme_info( 'Version' ) );
}
add_action( 'wp_enqueue_scripts', 'woodmart_child_enqueue_styles', 10010 );

// Configurator Beton
add_action('wp_ajax_add_custom_beton_to_cart', 'add_custom_beton_to_cart');
add_action('wp_ajax_nopriv_add_custom_beton_to_cart', 'add_custom_beton_to_cart');

function add_custom_beton_to_cart() {
    // Verifică nonce-ul pentru securitate
    check_ajax_referer('produse_beton_nonce_action', 'nonce');

    // Obține datele din cererea AJAX
    $infrastructura = sanitize_text_field($_POST['infrastructura']);
	$clase_beton = sanitize_text_field($_POST['clase_beton']);
	$cantitate = floatval($_POST['cantitate']);    
    $transport = sanitize_text_field($_POST['transport']);
    $location = sanitize_text_field($_POST['location']);
    $cod_postal = sanitize_text_field($_POST['cod_postal']);
	$delivery_date = sanitize_text_field($_POST['delivery_date']);
	$delivery_time =  sanitize_text_field($_POST['delivery_time']);

    // Prețul de bază
    $base_price = 200; // Poți ajusta acest preț în funcție de cerințele tale

    // Calcul în funcție de rețetă
    switch ($reteta_beton) {
        case 'standard':
            $price_per_m3 = $base_price; // Prețul de bază
            break;
        case 'rezistent':
            $price_per_m3 = $base_price * 1.2; // Ajustăm prețul pentru betonul rezistent
            break;
        default:
            $price_per_m3 = $base_price;
            break;
    }

    // Calcul total preț fără transport
    $total_price = $price_per_m3 * $cantitate;

    // Adaugă costul de transport dacă se folosește "pompa"
    if ($transport === 'pompa') {
        $total_price += 50 * $cantitate; // 50 lei/m³ pentru pompă
    }

    // Adaugă produsul în coș
    $cart_item_data = array(
        'infrastructura' => $infrastructura,
        'cantitate' => $cantitate,
        'clase_beton' => $clase_beton,
        'transport' => $transport,
        'location' => $location,
        'cod_postal' => $cod_postal,
        'custom_price' => $total_price, // Folosește prețul total calculat
		'delivery_date' => $delivery_date,
		'delivery_time' => $delivery_time
    );

    $product_id = 15706; // ID-ul produsului asociat

    $added = WC()->cart->add_to_cart($product_id, $cantitate, 0, array(), $cart_item_data);

    if ($added) {
        wp_send_json_success(array(
            'infrastructura' => $infrastructura,
			'clase_beton' => $clase_beton,
            'cantitate' => $cantitate,            
            'transport' => $transport,
            'location' => $location,
            'cod_postal' => $cod_postal,
            'total_price' => $total_price, // Returnează prețul total
			'delivery_date' => $delivery_date,
			'delivery_time' => $delivery_time
        ));
    } else {
        wp_send_json_error('Eroare la adăugarea produsului în coș.');
    }
}


// Funcția de calcul a prețului personalizat
function calculate_price($cantitate, $reteta_beton, $transport) {
    $product_id = 15706; // ID-ul produsului tău
    $product = wc_get_product($product_id);
    $base_price = (float)$product->get_price(); // Prețul de bază pentru un m³ de beton
    
    // Calcul în funcție de rețetă
    switch ($reteta_beton) {
        case 'standard':
            $price_per_m3 = $base_price; // Prețul de bază
            break;
        case 'rezistent':
            $price_per_m3 = $base_price * 1.2; // Ajustăm prețul pentru betonul rezistent
            break;
        default:
            $price_per_m3 = $base_price;
            break;
    }

    // Calcul total preț fără transport
    $total_price = $price_per_m3 * $cantitate;

    // Adaugă costul de transport dacă se folosește "pompa"
    if ($transport === 'pompa') {
        $total_price += 50 * $cantitate; // 50 lei/m³ pentru pompa
    }

    return $total_price; // Returnează prețul total calculat
}

// Afișează datele personalizate în comanda WooCommerce
add_action('woocommerce_checkout_create_order_line_item', 'add_custom_data_to_order_item', 10, 4);
function add_custom_data_to_order_item($item, $cart_item_key, $values, $order) {
	 global $wpdb;

    if (isset($values['infrastructura'])) {
        $item->add_meta_data('Tip lucrare', $values['infrastructura']);
    }	
    if (isset($values['clase_beton'])) {
        $item->add_meta_data('Rețetă beton', $values['clase_beton']);
    }
    if (isset($values['cantitate'])) {
        $item->add_meta_data('Cantitate (m³)', $values['cantitate']);
	}

    if (isset($values['transport'])) {
        $item->add_meta_data('Transport', $values['transport']);
    }
	if (isset($values['location'])) {
    $item->add_meta_data('Adresă', sanitize_textarea_field($values['location']));
	}

    if (isset($values['cod_postal'])) {
        $item->add_meta_data('Cod Poștal', sanitize_text_field($values['cod_postal']));
    }
    if (isset($values['custom_price'])) {
        $item->add_meta_data('Preț total', $values['custom_price']);
    }
	

    if (isset($values['delivery_date']) && isset($values['delivery_time'])) {
        $item->add_meta_data('Data livrare', $values['delivery_date']);
        $item->add_meta_data('Oră livrare', $values['delivery_time']);

        // Adăugăm loguri pentru depanare
        error_log("Saving delivery date and time: " . $values['delivery_date'] . " " . $values['delivery_time']);

        // Salvăm datele în tabelul wp5h_calendar_slots
        $table_name = $wpdb->prefix . 'calendar_slots';
        $result = $wpdb->insert($table_name, [
            'delivery_date' => sanitize_text_field($values['delivery_date']),
            'delivery_time' => sanitize_text_field($values['delivery_time']),
            'order_id' => $order->get_id()
        ]);

        // Adăugăm loguri pentru a verifica rezultatul inserției
        if ($result === false) {
            error_log("Database insert failed: " . $wpdb->last_error);
        } else {
            error_log("Database insert succeeded");
        }
    }
	
}

// Actualizează prețul personalizat în coș
add_action('woocommerce_before_calculate_totals', 'update_cart_item_prices');

function update_cart_item_prices($cart_object) {
    foreach ($cart_object->get_cart() as $cart_item_key => $cart_item) {
        // Log pentru a verifica cheia produsului din coș
        error_log("Cart item key: $cart_item_key");

        // Verifică dacă există un preț personalizat
        if (isset($cart_item['custom_price'])) {
            // Log pentru depanare
            error_log("Setarea prețului personalizat pentru produsul din coș: " . $cart_item['custom_price']);
            
            // Aplică prețul personalizat în coș
            $cart_item['data']->set_price($cart_item['custom_price'] / $cart_item['quantity']); // Prețul per unitate
        } else {
            error_log("Nu există preț personalizat pentru acest produs.");
        }
    }
}

add_filter('woocommerce_order_item_display_meta_value', 'custom_order_item_meta_value', 10, 3);
function custom_order_item_meta_value($display_value, $meta_key, $item) {
    if ($meta_key === 'Adresă') {
        return esc_html($item->get_meta('location')); // Folosește esc_html pentru a afișa în siguranță
    }
    return $display_value;
}


// Înregistrăm endpoint-ul AJAX pentru verificarea slotului
add_action('wp_ajax_check_slot_availability', 'check_slot_availability');
add_action('wp_ajax_nopriv_check_slot_availability', 'check_slot_availability');

function check_slot_availability() {
    global $wpdb;

    // Verificăm nonce-ul pentru securitate
    check_ajax_referer('produse_beton_nonce_action', 'nonce');

    // Obținem datele din cererea AJAX
    $delivery_date = sanitize_text_field($_POST['delivery_date']);
    $delivery_time = sanitize_text_field($_POST['delivery_time']);

    // Verificăm dacă slotul există în baza de date
    $table_name = $wpdb->prefix . 'calendar_slots';
    $slot_exists = $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM $table_name WHERE delivery_date = %s AND delivery_time = %s",
        $delivery_date,
        $delivery_time
    ));

    if ($slot_exists) {
        wp_send_json_error('Slotul selectat nu este disponibil.');
    } else {
        wp_send_json_success('Slotul selectat este disponibil.');
    }
}

// Funcție pentru a crea tabelul wp5h_calendar_slots dacă nu există
function create_calendar_slots_table() {
    global $wpdb;

    $table_name = $wpdb->prefix . 'calendar_slots';

    // Verificăm dacă tabelul există deja
    if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            delivery_date date NOT NULL,
            delivery_time varchar(255) NOT NULL,
            order_id bigint(20) NOT NULL,
            PRIMARY KEY (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}

// Apelăm funcția la activarea temei
add_action('after_switch_theme', 'create_calendar_slots_table'); 

?>