<?php
/**
 * Header template
 *
 * Logo, primary menu and CTA are editable from the WP admin:
 *  - Appearance > Customize > Site Identity  (logo + brand text)
 *  - Appearance > Menus                       (Primary Menu / Primary Menu Mobile)
 *  - Appearance > Customize > Header CTA      (button label + link)
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
	<meta name="description" content="<?php bloginfo( 'description' ); ?>">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
	<div class="container header-inner">

		<?php customtheme_render_brand(); ?>

		<?php
		wp_nav_menu( array(
			'theme_location' => 'primary',
			'container'      => 'nav',
			'container_id'   => 'nav',
			'container_class'=> 'nav-desktop',
			'menu_class'     => 'nav-desktop-menu',
			'depth'          => 1,
			'fallback_cb'    => 'customtheme_default_menu',
		) );
		?>

		<?php
		$cta_label = get_theme_mod( 'customtheme_cta_label', "Let's Talk" );
		$cta_url   = get_theme_mod( 'customtheme_cta_url', '/contact' );
		if ( $cta_label ) :
			// Derive data-nav from the URL so the click handler + active state
			// follow the actual link the user configured in the Customizer.
			$cta_nav = '';
			if ( strpos( $cta_url, '#' ) === 0 ) {
				$cta_nav = trim( substr( $cta_url, 1 ) );
			} else {
				$parsed = wp_parse_url( $cta_url );
				if ( ! empty( $parsed['path'] ) ) {
					$slug = trim( $parsed['path'], '/' );
					if ( $slug ) {
						$parts   = explode( '/', $slug );
						$cta_nav = end( $parts );
					}
				}
			}
			?>
			<a href="<?php echo esc_url( $cta_url ); ?>" class="btn btn-primary btn-sm nav-cta"<?php echo $cta_nav ? ' data-nav="' . esc_attr( $cta_nav ) . '"' : ''; ?>>
				<?php echo esc_html( $cta_label ); ?>
			</a>
		<?php endif; ?>

		<button class="menu-toggle" id="menuToggle" aria-controls="navMobile" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle menu', 'customtheme' ); ?>">
			<span></span><span></span><span></span>
		</button>
	</div>

	<?php
	wp_nav_menu( array(
		'theme_location' => 'primary_mobile',
		'container'      => 'nav',
		'container_id'   => 'navMobile',
		'container_class'=> 'nav-mobile glass',
		'menu_class'     => 'nav-mobile-menu',
		'depth'          => 1,
		'fallback_cb'    => 'customtheme_default_menu',
	) );
	?>
</header>
