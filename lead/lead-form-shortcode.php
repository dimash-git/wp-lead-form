<?php 

function display_lead_form( $atts ) {
  $attributes = shortcode_atts( array(
    'title' => false,
    'limit' => 4,
  ), $atts );
  
  ob_start();

  // include template with the arguments (The $args parameter was added in v5.5.0)
  get_template_part( 'lead/lead-form', null, $attributes );

  return ob_get_clean();
}

add_shortcode( 'lead-form', 'display_lead_form' );

?>