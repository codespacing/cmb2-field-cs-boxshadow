<?php

/**
 * Plugin Name: CMB2 CS Box-Shadow Field
 * Plugin URI: 
 * Description: Box-Shadow field type for CMB2
 * Version: 1.0
 * Author: Hicham Radi (CodeSpacing)
 * Author URI: https://www.codespacing.com/
 */

function cmb2_init_cs_box_shadow_field() {
	
	require_once dirname( __FILE__ ) . '/cmb2-cs-box-shadow.php';

}

add_action('cmb2_init', 'cmb2_init_cs_box_shadow_field');
