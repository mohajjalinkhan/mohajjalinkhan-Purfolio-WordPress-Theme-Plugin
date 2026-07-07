<?php
/**
 * Plugin Name: Purfolio Addon Plugin
 * Description: Professional Elementor widgets for Purfolio Theme 2026 — Hero, Services, Projects, Blog Posts, Timeline, Tools, Stats, CTA, Footer and Contact Info.
 * Version:     0.0.1
 * Author:      Yousuf Zai Md Ab Mohajjalin Khan
 * Text Domain: pfw
 * Requires at least: 5.9
 * Requires PHP: 7.4
 * Elementor tested up to: 3.23
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'PFW_VERSION', '0.0.1' );
define( 'PFW_PATH', plugin_dir_path( __FILE__ ) );
define( 'PFW_URL',  plugin_dir_url( __FILE__ ) );

/**
 * Bail if Elementor isn't active, and show an admin notice.
 */
function pfw_check_elementor() {
	if ( ! did_action( 'elementor/loaded' ) ) {
		add_action( 'admin_notices', function () {
			 echo '<div class="notice notice-warning"><p><strong>Purfolio Addon Plugin</strong> requires the Elementor plugin to be installed and active.</p></div>';
		} );
		return false;
	}
	return true;
}

/**
 * Register widget category so all our widgets live under "Purfolio".
 */
add_action( 'elementor/elements/categories_registered', function ( $mgr ) {
	$mgr->add_category( 'purple-folio', [
		'title' => __( 'Purfolio', 'pfw' ),
		'icon'  => 'fa fa-star',
	] );
} );

/**
 * Enqueue the theme's stylesheet inside Elementor editor + frontend so widgets
 * inherit the .glass / .gradient-text / .btn styling exactly like the theme.
 */
add_action( 'wp_enqueue_scripts', function () {
	// Load the widget helper CSS on the frontend so image radius / card
	// shape are preserved even if the active theme is not Purfolio.
	wp_enqueue_style( 'pfw-frontend', PFW_URL . 'assets/editor.css', [], PFW_VERSION );
	wp_enqueue_script( 'pfw-frontend', PFW_URL . 'assets/frontend.js', [], PFW_VERSION, true );
}, 20 );

add_action( 'elementor/editor/after_enqueue_styles', function () {
	// Editor preview iframe pulls the active theme's stylesheet, so the widgets
	// look identical in the editor. If the active theme is not Purfolio,
	// we still enqueue our own tiny helper sheet so previews don't look broken.
	wp_enqueue_style( 'pfw-editor', PFW_URL . 'assets/editor.css', [], PFW_VERSION );
} );

/**
 * Register widgets.
 */
add_action( 'elementor/widgets/register', function ( $widgets_manager ) {
	if ( ! pfw_check_elementor() ) return;

	require_once PFW_PATH . 'widgets/class-pfw-hero.php';
	require_once PFW_PATH . 'widgets/class-pfw-services.php';
	require_once PFW_PATH . 'widgets/class-pfw-projects.php';
	require_once PFW_PATH . 'widgets/class-pfw-stats.php';
	require_once PFW_PATH . 'widgets/class-pfw-cta.php';
	require_once PFW_PATH . 'widgets/class-pfw-contact-info.php';
	require_once PFW_PATH . 'widgets/class-pfw-site-nav.php';
	require_once PFW_PATH . 'widgets/class-pfw-tools.php';
	require_once PFW_PATH . 'widgets/class-pfw-timeline.php';
	require_once PFW_PATH . 'widgets/class-pfw-posts.php';
	require_once PFW_PATH . 'widgets/class-pfw-footer.php';

	$widgets_manager->register( new \PFW_Hero() );
	$widgets_manager->register( new \PFW_Services() );
	$widgets_manager->register( new \PFW_Projects() );
	$widgets_manager->register( new \PFW_Stats() );
	$widgets_manager->register( new \PFW_CTA() );
	$widgets_manager->register( new \PFW_Contact_Info() );
	$widgets_manager->register( new \PFW_Site_Nav() );
	$widgets_manager->register( new \PFW_Tools() );
	$widgets_manager->register( new \PFW_Timeline() );
	$widgets_manager->register( new \PFW_Posts() );
	$widgets_manager->register( new \PFW_Footer() );
} );
