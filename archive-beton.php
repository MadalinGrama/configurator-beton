<?php
/*
Template Name: Configurator Beton
*/

get_header(); ?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBERgBUns_cfrCTXbqXI_Fo9yWVRfDY6IE&libraries=places&callback=initMap" async defer></script>


<style>
    .progress-bar-container {
        position: relative;
        width: 100%;
        margin-bottom: 20px;
    }

    .progress-bar {
        background-color: #E0B13A!important;
        height: 10px;
        width: 100%;
        border-radius: 5px;
        overflow: hidden;
        position: relative;
    }

    .progress-fill {
        background-color: #D29E31;
        height: 100%;
        width: 0; /* Start la 0% */
        transition: width 0.3s ease;
        position: absolute;
        top: 0;
        left: 0;
    }

    .step-labels {
        display: flex;
        justify-content: space-between;
        margin-top: 10px;
    }

    .step-label {
        font-size: 12px;
        width: 20%;
        text-align: center;
        color: #666;
    }

    .step-label.active {
        font-weight: bold;
        color: #4caf50;
    }
    .btn-beton-primary{
        background-color: #E0B13A;
    }
        .btn-beton-primary:hover{
        background-color: #D29E31;
    }
    
    .btn-beton-secondary {
    background-color: #A6A6A6;
    color: #FFFFFF; 
    border: none;
}

    .btn-beton-secondary:hover {
    background-color: #8C8C8C;
    color: #FFFFFF; 
}

    input#adresa {
    
    width: 100%;
    min-width: 559px!important;
    margin-bottom: 3px;
    }
    
   

</style>

<div class="gwrapper">
<div class="configurator-beton">    
    <div class="container-sm p-4 shadow-sm bg-light">
    
<div class="progress-bar-container">
    <div class="progress-bar">
        <div class="progress-fill" id="progressFill"></div> <!-- Folosește progress-fill -->
    </div>
    <div class="step-labels">
        <span class="step-label">Detalii proiect</span>
        <span class="step-label">Selectează adresa</span>
        <span class="step-label">Detalii livrare</span>
        <span class="step-label">Selectează adresa</span>
    </div>
</div>
    <!--<img src="https://gomos.ro/wp-content/uploads/2024/11/discount-scaled.jpg" class="img-fluid" alt="Responsive image">-->

<?php
$tipuri_beton = [
    [
        'clasa_beton' => 'C8/10 (B150)-S3-CEM II/A-LL 42,5R/0-31; X0 ',
        'infrastructura' => ['Egalizare'],
        'pompabil' => false 
    ],
    [
        'clasa_beton' => 'C8/10 (B150)-S3-CEM II/A-LL 42,5R/0-16; X0 ( pompabil)',
        'infrastructura' => ['Egalizare'],
        'pompabil' => true
    ],
    [
        'clasa_beton' => 'C8/10 (B150)-S3-CEM II/A-LL 42,5R/0-16; X0',
        'infrastructura' => ['Egalizare'],
        'pompabil' => false 
    ],
    [
        'clasa_beton' => 'C12/15 (B200)-S3-CEM II/A-LL 42,5R/0-31; X0',
        'infrastructura' => ['Egalizare', 'Alei Pavate'],
        'pompabil' => false 
    ],
    [
        'clasa_beton' => 'C12/15 (B200)-S3-CEM II/A-LL 42,5R/0-22 X0 ( pompabil)',
        'infrastructura' => ['Egalizare', 'Alei Pavate'],
        'pompabil' => true
    ],
    [
        'clasa_beton' => 'C12/15 (B200)-S3-CEM II/A-LL 42,5R/0-16; X0 ( pompabil)',
        'infrastructura' => ['Egalizare', 'Alei Pavate'],
        'pompabil' => true 
    ],
    [
        'clasa_beton' => 'C12/15 (B200)-S3-CEM II/A-LL 42,5R/0-16; X0 ',
        'infrastructura' => ['Egalizare', 'Alei Pavate'],
        'pompabil' => false 
    ],
    [
        'clasa_beton' => 'C16/20 (B250)-S3-CEM II/A-LL 42,5R/0-31; XC1÷XC2',
        'infrastructura' => [' Radiere cu grosimi >0,8m ( masive )', 'Pereți diafragmă/Plăci/Grinzi' , 'Pardoseli' , 'Terase', 'Alei Pavate'],
        'pompabil' => false 
    ],
    [
        'clasa_beton' => 'C16/20 (B250)-S3-CEM II/A-LL 42,5R/0-16; XC1÷XC2 ( pompabil)',
        'infrastructura' => ['Fundații/ Radiere cu grosimi <0,8m', 'Pereți diafragmă/Plăci/Grinzi' , 'Stalpi', 'Pardoseli', 'Terase', 'Alei Pavate'],
        'pompabil' => true 
    ],
    [
        'clasa_beton' => 'C16/20 (B250)-S3-CEM II/A-LL 42,5R/0-22; XC1÷XC2 ( pompabil)',
        'infrastructura' => [' Fundații/ Radiere cu grosimi <0,8m', 'Pereți diafragmă/Plăci/Grinzi', 'Pardoseli', 'Terase', 'Alei Pavate'],
        'pompabil' => true
    ],
    [
        'clasa_beton' => 'C16/20 (B250)-S3-CEM II/A-LL 42,5R/0-16; XC1÷XC2',
        'infrastructura' => ['Fundații/ Radiere cu grosimi <0,8m','Pereți diafragmă/Plăci/Grinzi', 'Pardoseli', 'Terase', 'Alei Pavate'],
        'pompabil' => false 
    ],
    [
        'clasa_beton' => 'C16/20 (B250)/P8-S3-CEM II/A-LL 42,5R/0-16; XC1÷XC2 ( pompabil)',
        'infrastructura' => ['Elemente subsoluri ( betoane cu permebilitate redusă)', 'Pereți diafragmă/Plăci/Grinzi', 'Terase','Elemente piscine ( betoane cu permebilitate redusă)'],
        'pompabil' => true 
    ],
    [
        'clasa_beton' => 'C18/22,5 (B300)-S3-CEM II/A-LL 42,5R/0-31; XC1÷XC2',
        'infrastructura' => ['Fundații/ Radiere cu grosimi <0,8m','Pereți diafragmă/Plăci/Grinzi','Pardoseli', 'Terase', 'Alei Pavate'],
        'pompabil' => false 
    ],
    [
        'clasa_beton' => 'C18/22,5 (B300)-S3-CEM II/A-LL 42,5R/0-22; XC1÷XC2 ( pompabil)',
        'infrastructura' => ['Fundații/ Radiere cu grosimi <0,8m','Pereți diafragmă/Plăci/Grinzi', 'Stâlpi', 'Pardoseli', 'Terase', 'Alei Pavate'],
        'pompabil' => true 
    ],
    [
        'clasa_beton' => 'C18/22,5 (B300)-S3-CEM II/A-LL 42,5R/0-16; XC1÷XC2 ( pompabil)',
        'infrastructura' => ['Fundații/ Radiere cu grosimi <0,8m', 'Pereți diafragmă/Plăci/Grinzi', 'Stâlpi', 'Pardoseli', 'Terase', 'Alei Pavate'],
        'pompabil' => true 
    ],
    [
        'clasa_beton' => 'C18/22,5 (B300)/P8-S3-CEM II/A-LL 42,5R/0-16; XC1÷XC2 ( pompabil)',
        'infrastructura' => ['Elemente subsoluri ( betoane cu permebilitate redusă)', 'Elemente piscine ( betoane cu permebilitate redusă)'],
        'pompabil' => true
    ],
    [
        'clasa_beton' => 'C20/25 (B350)-S3-CEM II/A-LL 42,5R/0-31; XC1÷XC3',
        'infrastructura' => ['Fundații/ Radiere cu grosimi <0,8m', 'Pereți diafragmă/Plăci/Grinzi', 'Pardoseli', 'Terase', 'Alei Pavate'],
        'pompabil' => false 
    ],
    [
        'clasa_beton' => 'C20/25 (B350)-S3-CEM II/A-LL 42,5R/0-22; XC1÷XC3 ( pompabil)',
        'infrastructura' => ['Fundații/ Radiere cu grosimi <0,8m','Pereți diafragmă/Plăci/Grinzi', 'Stâlpi', 'Pardoseli', 'Terase', 'Alei Pavate'],
        'pompabil' => true
    ],
    [
        'clasa_beton' => 'C20/25 (B350)-S3-CEM II/A-LL 42,5R/0-16; XC1÷XC3 ( pompabil)',
        'infrastructura' => ['Fundații/ Radiere cu grosimi <0,8m','Pereți diafragmă/Plăci/Grinzi', 'Stâlpi', 'Pardoseli', 'Terase', 'Alei Pavate'],
        'pompabil' => true 
    ],
    [
        'clasa_beton' => 'C20/25 (B350)/P8-S3-CEM II/A-LL 42,5R/0-16; XC1÷XC3 ( pompabil)',
        'infrastructura' => ['Elemente subsoluri ( betoane cu permebilitate redusă)', 'Pereți diafragmă/Plăci/Grinzi', 'Pardoseli','Terase', 'Alei Pavate'],
        'pompabil' => true 
    ],
    [
        'clasa_beton' => 'C25/30 (B400)-S3-CEM II/A-LL 42,5R/0-31; XC1÷XC4, XF1, XA1',
        'infrastructura' => ['Fundații/ Radiere cu grosimi <0,8m','Pereți diafragmă/Plăci/Grinzi', 'Pardoseli', 'Terase'],
        'pompabil' => false 
    ],
    [
        'clasa_beton' => 'C25/30 (B400)-S3-CEM II/A-LL 42,5R/0-22; XC1÷XC4, XF1, XA1 ( pompabil)',
        'infrastructura' => ['Fundații/ Radiere cu grosimi <0,8m', 'Pereți diafragmă/Plăci/Grinzi', 'Stâlpi', 'Pardoseli', 'Terase'],
        'pompabil' => true
    ],
    [
        'clasa_beton' => 'C25/30 (B400)-S3-CEM II/A-LL 42,5R/0-16; XC1÷XC4, XF1, XA1 ( pompabil)',
        'infrastructura' => ['Fundații/ Radiere cu grosimi <0,8m', 'Pereți diafragmă/Plăci/Grinzi', 'Stâlpi', 'Pardoseli', 'Terase'],
        'pompabil' => true 
    ],
    [
        'clasa_beton' => 'C25/30 (B400)/P8-S3-CEM II/A-LL 42,5R/0-16; XC1÷XC4, XF1, XA1 ( pompabil)',
        'infrastructura' => ['Fundații/ Radiere cu grosimi <0,8m', 'Elemente subsoluri ( betoane cu permebilitate redusă)','Pereți diafragmă/Plăci/Grinzi', 'Elemente piscine ( betoane cu permebilitate redusă)'],
        'pompabil' => true
    ],
    [
        'clasa_beton' => 'C25/30 (B400)-S3-CEM I 42,5R/0-16; XC1÷XC4, XF1÷XF3, XA1 ( pompabil)',
        'infrastructura' => ['Pereți diafragmă/Plăci/Grinzi', 'Pardoseli', 'Terase', 'Alei betonate/ Drumuri acces'],
        'pompabil' => true
    ],
    [
        'clasa_beton' => 'C25/30 (B400)/P8-S3-CEM II/A-LL 42,5R/0-8; XC1÷XC4, XF1, XA1 ( torcret)',
        'infrastructura' => ['Pereți diafragmă/Plăci/Grinzi', 'Pardoseli', 'Terase', 'Reparatii/consolidari/cămășuiri'],
        'pompabil' => false 
    ],
    [
        'clasa_beton' => 'C25/30 (B400)-S4-CEM II/A-LL 42,5R/0-16; XC1÷XC4, XF1, XA1 ( pompabil)',
        'infrastructura' => ['Fundații/ Radiere cu grosimi <0,8m', 'Fundații speciale ( pereți mulați, coloane forate )','Pereți diafragmă/Plăci/Grinzi', 'Stâlpi', 'Pardoseli', 'Terase'],
        'pompabil' => true
    ],
    [
        'clasa_beton' => 'C25/30 (B400)-S5-CEM II/A-LL 42,5R/0-16; XC1÷XC4, XF1, XA1 ( pompabil)',
        'infrastructura' => ['Fundații/ Radiere cu grosimi <0,8m', 'Fundații speciale ( pereți mulați, coloane forate )','Pereți diafragmă/Plăci/Grinzi', 'Pardoseli', 'Terase'],
        'pompabil' => true 
    ],
    [
        'clasa_beton' => 'C30/37* (~B450)-S3-CEM II/A-LL 42,5R/0-31; XC1÷XC4, XD1, XF1, XM1 XA1',
        'infrastructura' => ['Fundații/ Radiere cu grosimi <0,8m','Pereți diafragmă/Plăci/Grinzi', 'Pardoseli', 'Terase'],
        'pompabil' => false 
    ],
    [
        'clasa_beton' => 'C30/37* (~B450)-S3-CEM II/A-LL 42,5R/0-22; XC1÷XC4, XD1, XF1, XM1, XA1 ( pompabil)',
        'infrastructura' => ['Fundații/ Radiere cu grosimi <0,8m','Pereți diafragmă/Plăci/Grinzi', 'Stâlpi', 'Pardoseli', 'Terase'],
        'pompabil' => true 
    ],
    [
        'clasa_beton' => 'C30/37* (~B450)-S3-CEM II/A-LL 42,5R/0-16; XC1÷XC4, XD1, XF1, XM1, XA1 ( pompabil)',
        'infrastructura' => ['Fundații/ Radiere cu grosimi <0,8m','Pereți diafragmă/Plăci/Grinzi', 'Stâlpi', 'Pardoseli', 'Terase'],
        'pompabil' => true 
    ],
    [
        'clasa_beton' => 'C30/37* (~B450)/P8-S3-CEM II/A-LL 42,5R/0-16; XC1÷XC4, XD1, XF1, XA1 ( pompabil)',
        'infrastructura' => ['Fundații/ Radiere cu grosimi <0,8m', 'Elemente subsoluri ( betoane cu permebilitate redusă)','Pereți diafragmă/Plăci/Grinzi', 'Pardoseli', 'Terase', 'Elemente piscine ( betoane cu permebilitate redusă)'],
        'pompabil' => true 
    ],
    [
        'clasa_beton' => 'C30/37* (~B450)-S3-CEM I 42,5R/0-16; XC1÷XC4, XD1, XF1÷XF4, XA1 ( pompabil)',
        'infrastructura' => ['Pereți diafragmă/Plăci/Grinzi', 'Pardoseli', 'Terase', 'Alei betonate/ Drumuri acces'],
        'pompabil' => true 
    ],
    [
        'clasa_beton' => 'C30/37* (~B450)-S3-CEM II/A-LL 42,5R/0-16; XC1÷XC4, XD1, XF1,XM1, XA1 ( pompabil)',
        'infrastructura' => ['Fundații/ Radiere cu grosimi <0,8m','Pereți diafragmă/Plăci/Grinzi', 'Stâlpi', 'Pardoseli', 'Terase'],
        'pompabil' => true 
    ],
    [
        'clasa_beton' => 'C30/37* (~B450)-S3-CEM II/B-M(S-V)42,5N/0-16; XC1÷XC4, XF1, XA1 ( pompabil)',
        'infrastructura' => ['Radiere cu grosimi >0,8m ( masive )'],
        'pompabil' => true 
    ],
    [
        'clasa_beton' => 'C30/37* (~B450)-S4-CEM II/A-LL 42,5R/0-31; XC1÷XC4, XD1, XF1, XM1 XA1',
        'infrastructura' => ['Fundații/ Radiere cu grosimi <0,8m', 'Fundații speciale ( pereți mulați, coloane forate )','Pereți diafragmă/Plăci/Grinzi', 'Pardoseli', 'Terase'],
        'pompabil' => false 
    ],
    [
        'clasa_beton' => 'C30/37* (~B450)-S4-CEM II/A-LL 42,5R/0-16; XC1÷XC4, XD1, XF1, XM1, XA1 ( pompabil)',
        'infrastructura' => ['Fundații/ Radiere cu grosimi <0,8m', 'Fundații speciale ( pereți mulați, coloane forate )','Pereți diafragmă/Plăci/Grinzi', 'Pardoseli', 'Terase'],
        'pompabil' => true 
    ],
    [
        'clasa_beton' => 'C30/37* (~B450)-S4-CEM II/A-LL 42,5R/0-16; XC1÷XC4, XD1, XF1÷XF3, XA1, XM1( pompabil)',
        'infrastructura' => ['Fundații/ Radiere cu grosimi <0,8m', 'Fundații speciale ( pereți mulați, coloane forate )','Pereți diafragmă/Plăci/Grinzi', 'Pardoseli', 'Terase'],
        'pompabil' => true 
    ],
    [
        'clasa_beton' => 'C35/45* (~B500)-S3-CEM II/A-LL 42,5R/0-31; XC1÷XC4, XD1, XF1÷XF3, XA1, XM1÷XM3',
        'infrastructura' => ['Pereți diafragmă/Plăci/Grinzi', 'Betoane de înaltă rezistența ( BIR ) ( proiecte speciale )'],
        'pompabil' => false 
    ],
    [
        'clasa_beton' => 'C35/45* (~B500)-S3-CEM II/A-LL 42,5R/0-16; XC1÷XC4, XD1, XF1÷XF3, XA1, XM1÷XM3 ( pompabil)',
        'infrastructura' => ['Pereți diafragmă/Plăci/Grinzi', 'Stâlpi', 'Betoane de înaltă rezistența ( BIR ) ( proiecte speciale )'],
        'pompabil' => true 
    ],
    [
        'clasa_beton' => 'C35/45* (~B500)/P8-S3-CEM I 42,5R/0-16; XC1÷XC4, XD1, XF1÷XF3, XA1 ( pompabil)',
        'infrastructura' => ['Pereți diafragmă/Plăci/Grinzi', 'Betoane de înaltă rezistența ( BIR ) ( proiecte speciale )'],
        'pompabil' => true 
    ],
    [
        'clasa_beton' => 'C35/45* (~B500)/-S3-CEM I 42,5R/0-16; XC1÷XC4, XD1, XF1÷XF3, XA1 ( pompabil)',
        'infrastructura' => ['Pereți diafragmă/Plăci/Grinzi', 'Betoane de înaltă rezistența ( BIR ) ( proiecte speciale )'],
        'pompabil' => true
    ],
    [
        'clasa_beton' => 'C35/45* (~B500)P8-S3-CEM II/A-LL 42,5R/0-16; XC1÷XC4, XD1, XF1÷XF3, XA1, XM1÷XM3 ( pompabil)',
        'infrastructura' => ['Elemente subsoluri ( betoane cu permebilitate redusă)', 'Pereți diafragmă/Plăci/Grinzi',
'Elemente piscine ( betoane cu permebilitate redusă)', 'Betoane de înaltă rezistența ( BIR ) ( proiecte speciale )'],
        'pompabil' => true
    ],
    [
        'clasa_beton' => 'C35/45* (~B500)-S3-CEM II/B-M(S-V)42.5N/0-31; XC1÷XC4, XD1÷XD3, XS1÷XS3, XA1, XF1, XM1÷XM3 ( pompabil)',
        'infrastructura' => ['Radiere cu grosimi >0,8m ( masive )', 'Betoane de înaltă rezistența ( BIR ) ( proiecte speciale )'],
        'pompabil' => true
    ],
    [
        'clasa_beton' => 'C35/45* (~B500)-S3-CEM II/B-M(S-V)42,5N/0-16; XC1÷XC4, XD1÷XD3, XS1÷XS3, XA1, XF1, XM1÷XM3 ( pompabil)',
        'infrastructura' => ['Pereți diafragmă/Plăci/Grinzi', 'Betoane de înaltă rezistența ( BIR ) ( proiecte speciale )'],
        'pompabil' => true
    ],
    [
        'clasa_beton' => 'C40/50 (B600)-S3-CEM I 52,5R/0-31; XC1÷XC4, XD1, XF1÷XF4, XA1, XM1÷XM3 ( pompabil)',
        'infrastructura' => ['Betoane de înaltă rezistența ( BIR ) ( proiecte speciale )'],
        'pompabil' => true 
    ],
    [
        'clasa_beton' => 'C40/50 (B600)-S4-CEM I 52,5R/0-31; XC1÷XC4, XD1, XF1÷XF4, XA1, XM1÷XM3 ( pompabil)',
        'infrastructura' => ['Betoane de înaltă rezistența ( BIR ) ( proiecte speciale )'],
        'pompabil' => true 
    ],
    [
        'clasa_beton' => 'C40/50 (B600)-S3-CEM I 52,5R/0-16; XC1÷XC4, XD1, XF1÷XF4, XA1, XM1÷XM3 ( pompabil)',
        'infrastructura' => ['Betoane de înaltă rezistența ( BIR ) ( proiecte speciale )'],
        'pompabil' => true 
    ],
    [
        'clasa_beton' => 'C40/50 (B600)-S3-CEM II/A-LL 52,5R/0-31; XC1÷XC4, XD1÷XD3, XF1÷XF4, XA1, XM1÷XM3, XS1-XS3 ( pompabil)',
        'infrastructura' => ['Betoane de înaltă rezistența ( BIR ) ( proiecte speciale )'],
        'pompabil' => true
    ],
    [
        'clasa_beton' => 'C40/50 (B600)-S4-CEM II/A-LL 52,5R/0-31; XC1÷XC4, XD1÷XD3, XF1÷XF4, XA1, XM1÷XM3, XS1-XS3 ( pompabil)',
        'infrastructura' => ['Betoane de înaltă rezistența ( BIR ) ( proiecte speciale )'],
        'pompabil' => true 
    ],
    [
        'clasa_beton' => 'C40/50 (B600)-S3-CEM II/A-LL 52,5R/0-16; XC1÷XC4, XD1÷XD3, XF1÷XF4, XA1, XM1÷XM3, XS1-XS3 ( pompabil)',
        'infrastructura' => ['Betoane de înaltă rezistența ( BIR ) ( proiecte speciale )'],
        'pompabil' => true 
    ],
    [
        'clasa_beton' => 'C40/50 (B600)-S4-CEM II/A-LL 52,5R/0-16; XC1÷XC4, XD1÷XD3, XF1÷XF4, XA1, XM1÷XM3, XS1-XS3 ( pompabil)',
        'infrastructura' => ['Betoane de înaltă rezistența ( BIR ) ( proiecte speciale )'],
        'pompabil' => true 
    ],
    [
        'clasa_beton' => 'C50/60 (B700)-S3-CEM I 52,5R/0-31; XC1÷XC4, XD1, XF1÷XF4, XA1, XM1÷XM3 ( pompabil)',
        'infrastructura' => ['Betoane de înaltă rezistența ( BIR ) ( proiecte speciale )'],
        'pompabil' => true
    ],
    [
        'clasa_beton' => 'C50/60 (B700)-S3-CEM II/A-LL 52,5R/0-31; XC1÷XC4, XD1÷XD3, XF1÷XF4, XA1, XM1÷XM3, XS1-XS3 ( pompabil)',
        'infrastructura' => ['Betoane de înaltă rezistența ( BIR ) ( proiecte speciale )'],
        'pompabil' => false 
    ],
    [
        'clasa_beton' => 'BcR 3,5 CEM I 42,5R/0-25 (S2)',
        'infrastructura' => [' Alei betonate/ Drumuri acces'],
        'pompabil' => false 
    ],
    [
        'clasa_beton' => 'BcR 4,0 CEM I 42,5R/0-25 (S2)',
        'infrastructura' => ['Alei betonate/ Drumuri acces'],
        'pompabil' => false 
    ],
    [
        'clasa_beton' => 'BcR 4,5 CEM I 42,5R/0-25 (S2)',
        'infrastructura' => [' Alei betonate/ Drumuri acces'],
        'pompabil' => false 
    ],
    [
        'clasa_beton' => 'BcR 5,0 CEM I 42,5R/0-25 (S2)',
        'infrastructura' => ['Alei betonate/ Drumuri acces'],
        'pompabil' => false 
    ],
    [
        'clasa_beton' => 'BcR 5,0 CEM I 42,5R/0-25 (S1)',
        'infrastructura' => [' Alei betonate/ Drumuri acces'],
        'pompabil' => false 
    ]
  
  
];

/**
 * Array asociativ unde infrastructura este cheia,
 * iar valorile sunt clasele de beton aferente conform fisier Excel.
 */
function grupareBetonPeInfrastructura($betons) {
    $result = [];

    foreach ($betons as $beton) {
        if (!isset($beton['infrastructura']) || !is_array($beton['infrastructura'])) {
            error_log('Infrastructura lipsă sau invalidă: ' . print_r($beton, true));
            continue;
        }

        foreach ($beton['infrastructura'] as $infra) {
            if (!isset($result[$infra])) {
                $result[$infra] = [];
            }

            $result[$infra][] = [
                'clasa_beton' => $beton['clasa_beton'],
                'pompabil' => $beton['pompabil'],
            ];
        }
    }

    return $result;
}

$beton_pe_infrastructura = grupareBetonPeInfrastructura($tipuri_beton);?>

<form id="beton-config-form">
    <!-- Pasul 1 -->
    <div class="step" id="step1">
		<p class="h4">Alege tipul de lucrare</p>
		<div class="row g-3">
				<div class="mb-3 col-md-6">           
				<label for="infrastructura" class="col-form-label">Infrastructură:</label>
				<select id="infrastructura" class="form-select" name="infrastructura" onchange="updateClaseBeton()">
					<option value="" disabled selected>Selectează infrastructura</option>
					<?php foreach ($beton_pe_infrastructura as $infra => $clase): ?>
						<option value="<?php echo htmlspecialchars($infra); ?>">
							<?php echo htmlspecialchars($infra); ?>
						</option>
					<?php endforeach; ?>
				</select>
			</div>

			<div class="mb-3 col-md-6">     
			
				<!-- Dropdown pentru clasele de beton -->
				<label for="clase_beton" class="col-form-label">Clasa de beton:</label>
				<select id="clase_beton" class="col-form-select" name="clase_beton">
					<option value="" disabled selected>Selectează clasa de beton</option>
				</select>
			</div>	
		</div>
        
        <div class="row g-3">
            <div class="mb-3 col-md-6">
                <label for="cantitate" class="col-form-label">Cantitate (m³)</label>                
                <input type="number" id="cantitate" name="cantitate" class="form-control rounded"  required min="1" step="0.01">
                
            </div>
            <div class="mb-3 col-md-6">
            <label for="transport" class="col-form-label">Transport</label>            
                <select id="transport" name="transport" class="form-select" required>
                    <option value="" selected disabled>Selectează metoda de transport</option>
                </select>
          
        </div>
        </div>
		  <button type="button" class="btn-beton-primary" onclick="nextStep(2)">Următorul</button>
    </div>    
  

    <!-- Restul pașilor -->
    <div class="step" id="step2" style="display:none;">
		<p class="h4">Alege locația de turnare</p>
            <div class="mb-3">
            <input type="text" id="location" name="location" placeholder="Introdu adresa în județul Dolj" />
<button id="getLocation">Obține locația</button>
<div id="map" style="height: 400px;"></div>

                
            </div>
        <button type="button" class="btn-beton-secondary" onclick="nextStep(1)">Înapoi</button>
        <button type="button" class="btn-beton-primary" onclick="nextStep(3)">Următorul</button>
    </div>

    <!-- Continuă cu ceilalți pași -->
    
    
        <!-- Restul pașilor -->


    <!-- Continuă cu ceilalți pași -->
    
        <!-- Restul pașilor -->
    <div class="step" id="step3" style="display:none;">
		<p class="h4">Alege data și ora</p>
        <div class="mb-3">

<!--        <label for="delivery_date">Data livrării:</label>-->
<!--<input type="date" id="delivery_date" name="delivery_date">-->

<!--<label for="delivery_time">Ora livrării:</label>-->
<!--<input type="time" id="delivery_time" name="delivery_time">-->

<label for="delivery_date">Data livrării:</label>
<input type="hidden" id="delivery_date" name="delivery_date">

<label for="delivery_time">Ora livrării:</label>
<input type="hidden" id="delivery_time" name="delivery_time">

<table id="delivery_schedule">
    <thead>
        <tr>
            <th>Interval orar</th>
        </tr>
    </thead>
    <tbody>
        <!-- Tabelul va fi populat dinamic de JavaScript -->
    </tbody>
</table>
         
        </div> 
        <button type="button" class="btn-beton-secondary" onclick="nextStep(2)">Înapoi</button>
        <button type="button" class="btn-beton-primary" onclick="nextStep(4)">Următorul</button>
    </div>
    <!-- Continuă cu ceilalți pași -->
    
    
        <div class="step" id="step4" style="display:none;">
				<p class="h4">Care este locația proiectului?</p>
                <div class="mb-3">

            <!--<div class="row mb-3">-->
            <!--    <div class="col-md-3"></div>-->
            <!--    <div class="col-md-9">-->
            <!--        <button type="submit" class="btn btn-primary">Adaugă în coș</button>-->
            <!--    </div>-->
            <!--</div>-->

        <div id="message" class="alert alert-info" style="display: none;"></div>

        <button type="button" class="btn-beton-secondary" onclick="nextStep(3)">Înapoi</button>
        <button type="submit" class="btn-beton-primary">Comandă Beton</button>
    </div>
</form>
</div>
</div>
</div>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/awesomplete/1.1.5/awesomplete.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/awesomplete/1.1.5/awesomplete.min.js"></script>

<script>

// JavaScript pentru schimbarea pașilor
let currentStep = 1;
const totalSteps = 4;

function nextStep(step) {
    // Ascunde pasul curent
    document.getElementById(`step${currentStep}`).style.display = 'none';

    // Setează noul pas activ
    currentStep = step;

    // Arată noul pas
    document.getElementById(`step${currentStep}`).style.display = 'block';

    // Actualizează progress bar
    updateProgressBar();
}

function updateProgressBar() {
    const progressPercentage = (currentStep - 1) / (totalSteps - 1) * 100;
    document.getElementById("progressFill").style.width = `${progressPercentage}%`;

    // Actualizează etichetele pasului
    const stepLabels = document.querySelectorAll(".step-label");
    stepLabels.forEach((label, index) => {
        label.classList.toggle("active", index === currentStep - 1);
    });
}

document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('beton-config-form');
    const messageBox = document.getElementById('message');
    const locationInput = document.getElementById('location');

    
    // Asigură că formularul nu este trimis în mod implicit
document.getElementById("beton-config-form").addEventListener("submit", function(event) {
    event.preventDefault();
    // Poți include aici funcția de submit sau altă logică finală
    
        // Obține valorile din formular
        const tipLucrare = document.getElementById('infrastructura').value;
	    const retetaBeton = document.getElementById('clase_beton').value;
        const cantitate = parseFloat(document.getElementById('cantitate').value);
        const transport = document.getElementById('transport').value;
        const location = document.getElementById('location').value;
      

        // Creează un obiect FormData și adaugă datele suplimentare
        const formData = new FormData(form);
        formData.append('action', 'add_custom_beton_to_cart');
        formData.append('nonce', '<?php echo wp_create_nonce("produse_beton_nonce_action"); ?>');
        // Eliminăm custom_price din formData, deoarece prețul este calculat pe server
        formData.append('location', location); // Adresa
     

        fetch('<?php echo admin_url("admin-ajax.php"); ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log(data); // Afișează răspunsul serverului în consola browserului
            if (data.success) {
                messageBox.style.display = 'block';
                messageBox.textContent = 'Produsul a fost adăugat în coș! Detalii: ' + 
                    'Tip lucrare: ' + data.data.infrastructura + 
                    ', Cantitate: ' + data.data.cantitate +
                    ', Rețetă: ' + data.data.clase_beton + 
                    ', Transport: ' + data.data.transport + 
                    ', Adresa: ' + data.data.location + 
                    // Afișează detaliile

                // Redirectează la pagina de checkout
                setTimeout(() => {
                    window.location.href = '<?php echo wc_get_checkout_url(); ?>';
                }, 2000);
            } else {
                alert('Eroare: ' + data.data);
            }
        })
        .catch(error => {
            console.error('Eroare:', error);
        });
});

    // form.addEventListener('submit', function (e) {
    //     e.preventDefault(); // Previne trimiterea standard a formularului

    // });
});
</script>


<!-- Actualizare metoda descarcare in functie de clasele selectate -->

<script>
    const betonPeInfrastructura = <?php echo json_encode($beton_pe_infrastructura); ?>;

    function updateClaseBeton() {
        const infrastructura = document.getElementById('infrastructura').value;
        const claseDropdown = document.getElementById('clase_beton');
        
        claseDropdown.innerHTML = '<option value="" disabled selected>Selectează clasa de beton</option>';

        if (betonPeInfrastructura[infrastructura]) {
            betonPeInfrastructura[infrastructura].forEach(beton => {
                const option = document.createElement('option');
                option.value = beton.clasa_beton;
                option.textContent = beton.clasa_beton;
                option.dataset.pompabil = beton.pompabil; // Atribuim atributul pompabil
                claseDropdown.appendChild(option);
            });
        }
    }

    function updateMetodaDescărcare() {
        const claseDropdown = document.getElementById('clase_beton');
        const transportDropdown = document.getElementById('transport');
        const clasaSelectată = claseDropdown.options[claseDropdown.selectedIndex];
        const pompabil = clasaSelectată ? clasaSelectată.dataset.pompabil === 'true' : false;

        transportDropdown.innerHTML = '<option value="" disabled selected>Selectează metoda de transport</option>';

        if (pompabil) {
            const optPompa = document.createElement('option');
            optPompa.value = 'pompa';
            optPompa.textContent = 'Pompa';
            transportDropdown.appendChild(optPompa);
        }

        const optTurnare = document.createElement('option');
        optTurnare.value = 'turnare_directa';
        optTurnare.textContent = 'Turnare Directă';
        transportDropdown.appendChild(optTurnare);
    }

    document.getElementById('clase_beton').addEventListener('change', updateMetodaDescărcare);
</script>

    <script>
        let map;
        let marker;
        let geocoder;

        function initMap() {
            // Coordonatele Craiovei
            const craiovaBounds = new google.maps.LatLngBounds(
                { lat: 44.2804, lng: 23.7467 }, // Sud-Vest
                { lat: 44.3604, lng: 23.9004 }  // Nord-Est
            );

            // Inițializăm harta
            map = new google.maps.Map(document.getElementById("map"), {
                center: { lat: 44.3189, lng: 23.8003 }, // Centru în Craiova
                zoom: 14,
            });

            geocoder = new google.maps.Geocoder();

            // Marker inițial
            marker = new google.maps.Marker({
                position: { lat: 44.3189, lng: 23.8003 },
                map: map,
                draggable: true,
            });

            // Autocomplete configurat cu limitare la Craiova
            const input = document.getElementById("location");
            const autocomplete = new google.maps.places.Autocomplete(input, {
                bounds: craiovaBounds, // Limităm căutarea la Craiova
                strictBounds: true,   // Rezultatele trebuie să fie în interiorul acestor limite
                types: ["geocode"],
            });

            // Când utilizatorul selectează o locație
            autocomplete.addListener("place_changed", () => {
                const place = autocomplete.getPlace();
                if (place.geometry && place.geometry.location) {
                    const location = place.geometry.location;

                    // Verificăm dacă locația se află în Craiova
                    const isInCraiova = place.address_components.some(component =>
                        component.long_name.toLowerCase() === "craiova"
                    );

                    if (isInCraiova) {
                        map.setCenter(location);
                        marker.setPosition(location);
                    } else {
                        alert("Adresa selectată nu este în Craiova!");
                    }
                }
            });

            // Eveniment pentru mutarea markerului
            marker.addListener("dragend", function () {
                const position = marker.getPosition();
                updateAddress(position.lat(), position.lng());
            });
        }

        // Funcție pentru a actualiza adresa când markerul este mutat
        function updateAddress(lat, lng) {
            const latlng = { lat: parseFloat(lat), lng: parseFloat(lng) };

            geocoder.geocode({ location: latlng }, (results, status) => {
                if (status === "OK" && results[0]) {
                    const formattedAddress = results[0].formatted_address;

                    // Verificăm dacă locația este în Craiova
                    const isInCraiova = results[0].address_components.some(component =>
                        component.long_name.toLowerCase() === "craiova"
                    );

                    if (isInCraiova) {
                        document.getElementById("location").value = formattedAddress; // Setăm adresa în input
                        console.log(`Adresa: ${formattedAddress}`);
                    } else {
                        alert("Locația nu este în Craiova!");
                    }
                } else {
                    console.error("Reverse geocoding failed: " + status);
                }
            });
        }
    </script>
    
<script>
document.addEventListener('DOMContentLoaded', function() {
    const daysOfWeek = ['Luni', 'Marți', 'Miercuri', 'Joi', 'Vineri'];
    const timeSlots = ['07:00-09:00', '09:00-16:00', '16:00-18:00'];
    const tableHead = document.querySelector('#delivery_schedule thead tr');
    const tableBody = document.querySelector('#delivery_schedule tbody');

    // Funcție pentru a obține următoarele 5 zile lucrătoare
    function getNextWorkingDays() {
        const workingDays = [];
        const today = new Date();
        let currentDate = new Date(today);

        while (workingDays.length < 5) {
            const dayOfWeek = currentDate.getDay();
            if (dayOfWeek !== 0 && dayOfWeek !== 6) { // Exclude weekend
                workingDays.push(new Date(currentDate));
            }
            currentDate.setDate(currentDate.getDate() + 1);
        }
        return workingDays;
    }

    // Obținem următoarele 5 zile lucrătoare
    const workingDays = getNextWorkingDays();

    // Adăugăm zilele în antetul tabelului
    workingDays.forEach(date => {
        const th = document.createElement('th');
        const dateString = date.toISOString().split('T')[0]; // Obținem data în format YYYY-MM-DD
        const dayName = daysOfWeek[date.getDay() - 1];
        th.textContent = `${dayName} (${dateString})`;
        tableHead.appendChild(th);
    });

    // Funcție pentru verificarea disponibilității slotului
    function checkSlotAvailability(dateString, timeSlot, cell) {
        cell.textContent = 'Verificare...';

        const nonce = '<?php echo wp_create_nonce("produse_beton_nonce_action"); ?>';

        fetch('<?php echo admin_url("admin-ajax.php"); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                action: 'check_slot_availability',
                nonce: nonce,
                delivery_date: dateString,
                delivery_time: timeSlot
            })
        })
        .then(response => {
            console.log(`Received response for ${dateString} ${timeSlot}`);
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            cell.innerHTML = '';

            if (data.success) {
                const radioInput = document.createElement('input');
                radioInput.type = 'radio';
                radioInput.name = 'delivery_slot';
                radioInput.dataset.date = dateString;
                radioInput.dataset.time = timeSlot;
                cell.appendChild(radioInput);
            } else {
                const unavailableMessage = document.createElement('span');
                unavailableMessage.textContent = 'Indisponibil';
                cell.appendChild(unavailableMessage);
            }
        })
        .catch(error => {
            console.error(`Eroare la ${dateString} ${timeSlot}:`, error);
            cell.textContent = 'Eroare'; // Afișează eroarea în celulă
        });
    }

    // Adăugăm intervalele orare în corpul tabelului
    timeSlots.forEach((timeSlot) => {
        const row = document.createElement('tr');
        const timeCell = document.createElement('td');
        timeCell.textContent = timeSlot;
        row.appendChild(timeCell);

        workingDays.forEach(date => {
            const dateString = date.toISOString().split('T')[0]; // Obținem data în format YYYY-MM-DD

            const cell = document.createElement('td');
            cell.textContent = 'Verificare...'; // Mesaj temporar
            checkSlotAvailability(dateString, timeSlot, cell);
            row.appendChild(cell);
        });

        tableBody.appendChild(row);
    });

    // Adăugăm event listener pentru input-urile radio
    tableBody.addEventListener('change', function(event) {
        if (event.target.name === 'delivery_slot') {
            const selectedDate = event.target.getAttribute('data-date');
            const selectedTime = event.target.getAttribute('data-time');
            document.getElementById('delivery_date').value = selectedDate;
            document.getElementById('delivery_time').value = selectedTime;
        }
    });
});
</script>
    
    
<?php get_footer(); ?>