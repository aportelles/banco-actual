<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
// shortcode [directorio]
function Our_office_shortcode($atts) {
     $person_details="";
    extract(shortcode_atts(array(
                'direccion' =>'No especificado',
                'telefono' => 'No especificado',
                'mapa' => 'No especificado',
               
       ), $atts)); 
     
     $person_details= '<div>';
     $person_details .= '<div class="dleft"><a href="' .$mapa. '"><i class="fas fa-map-marker-alt " style="padding: 10px; font-size:16px; "></i></a>' .$direccion.'</div>';
     $person_details .= '<div class="dright"><i class="fas fa-phone-alt " style="padding: 10px; font-size:16px; "></i> ' .$telefono. '</div>';
     $person_details .= '</div> ';

    return   $person_details;
          
 }
  add_shortcode ('directorio', 'Our_office_shortcode');
  

function ATM_shortcode( $atts ) {
  $atm_details="";  
  extract( shortcode_atts( array(
      'direccion' =>'No especificado',
      'mapa' => 'No especificado',
      'ensucursal' => true, 
      'multifuncion' => false,
      'reciclador'=> false,
  ), $atts ) );
   $atm_details= '<div>';
   $atm_details .= '<div class="dleft"><a href="' .$mapa. '"><i class="fas fa-map-marker-alt " style="padding: 10px; font-size:16px; "></i></a>' .$direccion.'</div><div class="dright">';
  
   if ( trim($ensucursal) == 'false' ){
       $ensucursal = false; // just to be sure...
       $ensucursal = (bool) $ensucursal;
      $atm_details .= '<i class="fas fa-map-marked-alt" style="padding: 10px; font-size:16px;float: inline-end; "></i>';  
      
    
     }
     elseif(trim($ensucursal) == 'true' ){
       $ensucursal = true; // just to be sure...
       $ensucursal = (bool) $ensucursal;   
        $atm_details .= '<i class="fa fa-university"  style="padding: 10px; font-size:16px;float: inline-end; "></i>';   
     }
    
    if ( $multifuncion === 'true' ){
       $multifuncion = true; // just to be sure...
       $multifuncion = (bool) $multifuncion;
       $atm_details .= '<i class="fas fa-tasks" style="padding: 10px; font-size:16px;float: inline-end; "></i> ';    
   
     }
    if( $reciclador === 'true' ){
     $reciclador = true; // just to be sure...
     $reciclador = (bool) $reciclador;    
     $atm_details .= '<i class="fas fa-recycle" style="padding: 10px; font-size:16px;float: inline-end; "></i> ';
   }
    $atm_details .= '</div></div> '; 
    return   $atm_details;
}

 add_shortcode( 'atmdirectorio', 'ATM_shortcode' );

