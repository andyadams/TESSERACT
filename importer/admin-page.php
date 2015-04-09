<?php

function tesseract_add_admin_menu() {
	add_menu_page( 'Tesseract', 'Tesseract', 'manage_options', 'tesseract-importer', 'tesseract_display_admin_page' );
}

add_action( 'admin_menu', 'tesseract_add_admin_menu' );

function tesseract_display_admin_page() {
	load_template( dirname( __FILE__ ) . '/templates/admin-page.php' );
}