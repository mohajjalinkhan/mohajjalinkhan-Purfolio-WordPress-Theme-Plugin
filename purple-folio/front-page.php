<?php
/**
 * Front page template. If the site's front page is set to "Your latest posts"
 * OR set to a static Page WITHOUT an Elementor layout / custom content, we
 * render the hard-coded landing markup from index.php so a fresh install
 * still looks correct out of the box.
 *
 * If the user has assigned a static front page AND that page has content
 * (Elementor or classic editor), we defer to page.php so their edits win.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

// If a static front page is set and it has real content, use page.php.
if ( 'page' === get_option( 'show_on_front' ) ) {
	$front_id = (int) get_option( 'page_on_front' );
	if ( $front_id ) {
		$has_elementor = false;
		if ( did_action( 'elementor/loaded' ) && class_exists( '\Elementor\Plugin' ) ) {
			$front_doc = \Elementor\Plugin::$instance->documents->get( $front_id );
			$has_elementor = $front_doc && $front_doc->is_built_with_elementor();
		}
		$has_content = trim( (string) get_post_field( 'post_content', $front_id ) ) !== '';

		if ( $has_elementor || $has_content ) {
			include get_template_directory() . '/page.php';
			return;
		}
	}
}

// Otherwise fall back to the theme's built-in landing page.
include get_template_directory() . '/index.php';
