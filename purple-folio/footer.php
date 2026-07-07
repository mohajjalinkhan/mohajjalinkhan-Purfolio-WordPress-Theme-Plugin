<?php
/**
 * Footer template
 *
 * Everything here is editable from WP admin:
 *  - Appearance > Customize > Footer  (copyright text + social links)
 *  - Appearance > Menus                (Footer Menu)
 *  - Appearance > Widgets              (Footer Widgets sidebar)
 *  - Elementor Pro users: Templates > Theme Builder > Footer (uses the
 *    registered `footer` theme location and replaces this markup entirely).
 */
if ( ! defined( 'ABSPATH' ) ) exit;

// If Elementor Pro's theme builder handles the footer location, render that
// instead of the theme's default footer markup.
$elementor_footer_done = false;
if ( function_exists( 'elementor_theme_do_location' ) ) {
	$elementor_footer_done = elementor_theme_do_location( 'footer' );
}

if ( ! $elementor_footer_done && function_exists( 'customtheme_render_default_footer' ) ) {
	customtheme_render_default_footer();
}
?>

<?php wp_footer(); ?>
</body>
</html>
