<?php
if ( ! defined( 'ABSPATH' ) ) exit; // No direct access.

// One-click page + menu installer (Appearance → Purfolio Setup).
require_once get_template_directory() . '/inc/page-installer.php';


/**
 * Theme setup
 */
function customtheme_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'menus' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );

	// Custom logo (Appearance > Customize > Site Identity)
	add_theme_support( 'custom-logo', array(
		'height'               => 80,
		'width'                => 240,
		'flex-height'          => true,
		'flex-width'           => true,
		'header-text'          => array( 'brand-text-primary', 'brand-text-secondary' ),
		'unlink-homepage-logo' => false,
	) );

	register_nav_menus( array(
		'primary'        => __( 'Primary Menu (Desktop)', 'customtheme' ),
		'primary_mobile' => __( 'Primary Menu (Mobile)', 'customtheme' ),
		'footer'         => __( 'Footer Menu', 'customtheme' ),
	) );
}
add_action( 'after_setup_theme', 'customtheme_setup' );

/**
 * Register Elementor Pro theme locations so users can build the header
 * and footer visually. Falls back to the theme's header.php/footer.php
 * when no Elementor template targets the location.
 */
add_action( 'elementor/theme/register_locations', function ( $manager ) {
	$manager->register_location( 'header' );
	$manager->register_location( 'footer' );
} );

/**
 * Helper: build a URL into the theme's /assets folder
 */
function customtheme_asset( $path ) {
	return get_template_directory_uri() . '/assets/' . ltrim( $path, '/' );
}

/**
 * Enqueue fonts, style.css and scripts.js
 */
function customtheme_enqueue_assets() {
	wp_enqueue_style(
		'customtheme-fonts',
		'https://fonts.googleapis.com/css2?family=Boldonse&family=Inter:wght@300;400;500;600;700&display=swap',
		array(),
		null
	);

	wp_enqueue_style(
		'customtheme-style',
		get_stylesheet_uri(),
		array( 'customtheme-fonts' ),
		wp_get_theme()->get( 'Version' )
	);

	wp_enqueue_script(
		'customtheme-scripts',
		get_template_directory_uri() . '/js/scripts.js',
		array(),
		wp_get_theme()->get( 'Version' ),
		true
	);
}
add_action( 'wp_enqueue_scripts', 'customtheme_enqueue_assets' );

/**
 * Detect whether a page/post is built with Elementor. Used by templates to
 * keep the global header visible while letting Elementor control section width.
 */
function customtheme_is_elementor_document( $post_id = null ) {
	$post_id = $post_id ? (int) $post_id : get_the_ID();
	if ( ! $post_id || ! did_action( 'elementor/loaded' ) || ! class_exists( '\Elementor\Plugin' ) ) {
		return false;
	}

	$document = \Elementor\Plugin::$instance->documents->get( $post_id );
	return $document && $document->is_built_with_elementor();
}

/**
 * Add predictable body classes for Customizer and Elementor QA/styling.
 */
function customtheme_body_classes( $classes ) {
	if ( is_customize_preview() ) {
		$classes[] = 'purfolio-customizer-preview';
	}
	if ( is_singular() && customtheme_is_elementor_document( get_queried_object_id() ) ) {
		$classes[] = 'purfolio-elementor-page';
	}
	return $classes;
}
add_filter( 'body_class', 'customtheme_body_classes' );

/**
 * Widget area
 */
function customtheme_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'customtheme' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<div class="widget">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer Widgets', 'customtheme' ),
		'id'            => 'footer-widgets',
		'description'   => __( 'Widgets shown above the footer copyright row.', 'customtheme' ),
		'before_widget' => '<div class="widget footer-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
}
add_action( 'widgets_init', 'customtheme_widgets_init' );

/**
 * Footer defaults, sanitizers and inline CSS variables.
 */
function customtheme_default_footer_socials() {
	return array(
		array( 'label' => 'Twitter',  'url' => '#' ),
		array( 'label' => 'GitHub',   'url' => '#' ),
		array( 'label' => 'Dribbble', 'url' => '#' ),
	);
}

function customtheme_default_footer_socials_json() {
	return wp_json_encode( customtheme_default_footer_socials() );
}

function customtheme_default_footer_intro() {
	return __( 'Modern WordPress portfolio theme built for Elementor editing, responsive layouts and polished motion.', 'customtheme' );
}

function customtheme_default_footer_copyright() {
	return sprintf(
		/* translators: 1: current year, 2: site name. */
		__( '© %1$s %2$s — Crafted with WordPress magic.', 'customtheme' ),
		gmdate( 'Y' ),
		get_bloginfo( 'name' )
	);
}

function customtheme_sanitize_socials( $value ) {
	if ( is_string( $value ) ) {
		$value = trim( wp_unslash( $value ) );
		if ( '' === $value ) {
			return array();
		}

		$decoded = json_decode( $value, true );
		if ( is_array( $decoded ) ) {
			$value = $decoded;
		} else {
			// Friendly fallback: allow one link per line as "Label | URL" if the JSON is malformed.
			$rows = preg_split( '/\r\n|\r|\n/', $value );
			$value = array();
			foreach ( $rows as $row ) {
				$parts = array_map( 'trim', explode( '|', $row, 2 ) );
				if ( empty( $parts[0] ) ) continue;
				$value[] = array(
					'label' => $parts[0],
					'url'   => isset( $parts[1] ) ? $parts[1] : '#',
				);
			}
		}
	}
	if ( ! is_array( $value ) ) return customtheme_default_footer_socials();
	$clean = array();
	foreach ( $value as $row ) {
		if ( ! is_array( $row ) ) continue;
		$label = isset( $row['label'] ) ? sanitize_text_field( $row['label'] ) : '';
		$url   = isset( $row['url'] )   ? esc_url_raw( $row['url'] )           : '';
		if ( $label ) $clean[] = array( 'label' => $label, 'url' => $url ? $url : '#' );
	}
	return $clean;
}
function customtheme_sanitize_socials_json( $value ) {
	return wp_json_encode( customtheme_sanitize_socials( $value ) );
}

function customtheme_sanitize_footer_size( $value ) {
	$value = is_numeric( $value ) ? (float) $value : 0;
	if ( $value <= 0 ) {
		return '';
	}
	return (string) min( 3, max( 0.5, $value ) );
}

function customtheme_sanitize_checkbox( $checked ) {
	return in_array( $checked, array( true, 1, '1', 'yes', 'on' ), true ) ? 1 : 0;
}

function customtheme_footer_css_vars() {
	$map = array(
		'--pf-footer-bg'           => array( 'mod' => 'customtheme_footer_bg',                 'default' => '#08021a' ),
		'--pf-footer-text'         => array( 'mod' => 'customtheme_footer_text_color',         'default' => '#cbb8e6' ),
		'--pf-footer-link'         => array( 'mod' => 'customtheme_footer_link_color',         'default' => '#f6efff' ),
		'--pf-footer-link-hover'   => array( 'mod' => 'customtheme_footer_hover_color',        'default' => '#ff5ec4' ),
		'--pf-footer-border'       => array( 'mod' => 'customtheme_footer_border_color',       'default' => '#332054' ),
		'--pf-footer-widget-title' => array( 'mod' => 'customtheme_footer_widget_title_color', 'default' => '#f6efff' ),
	);

	$vars = array();
	foreach ( $map as $css_var => $data ) {
		$value = sanitize_hex_color( get_theme_mod( $data['mod'], $data['default'] ) );
		if ( $value ) {
			$vars[] = $css_var . ':' . $value;
		}
	}

	$size_map = array(
		'--pf-footer-brand-size'        => array( 'mod' => 'customtheme_footer_brand_size',        'default' => '1' ),
		'--pf-footer-intro-size'        => array( 'mod' => 'customtheme_footer_intro_size',        'default' => '0.9' ),
		'--pf-footer-link-size'         => array( 'mod' => 'customtheme_footer_link_size',         'default' => '0.82' ),
		'--pf-footer-copyright-size'    => array( 'mod' => 'customtheme_footer_copyright_size',    'default' => '0.82' ),
		'--pf-footer-widget-title-size' => array( 'mod' => 'customtheme_footer_widget_title_size', 'default' => '0.95' ),
	);
	foreach ( $size_map as $css_var => $data ) {
		$value = customtheme_sanitize_footer_size( get_theme_mod( $data['mod'], $data['default'] ) );
		if ( $value ) {
			$vars[] = $css_var . ':' . $value . 'rem';
		}
	}

	return implode( ';', $vars );
}

function customtheme_footer_inline_style() {
	$styles = customtheme_footer_css_vars();
	$bg_img = esc_url_raw( get_theme_mod( 'customtheme_footer_bg_image', '' ) );
	if ( $bg_img ) {
		$styles .= ';background-image:linear-gradient(rgba(8,2,26,.9),rgba(8,2,26,.9)),url(' . $bg_img . ');background-size:cover;background-position:center';
	}
	return trim( $styles, ';' );
}

function customtheme_footer_menu_enabled() {
	return (bool) get_theme_mod( 'customtheme_footer_show_menu', 0 );
}

function customtheme_default_footer_menu() {
	$links = array(
		'home'    => __( 'Home',    'customtheme' ),
		'work'    => __( 'Work',    'customtheme' ),
		'about'   => __( 'About',   'customtheme' ),
		'blog'    => __( 'Blog',    'customtheme' ),
		'contact' => __( 'Contact', 'customtheme' ),
	);

	echo '<nav class="footer-nav" aria-label="' . esc_attr__( 'Footer menu', 'customtheme' ) . '"><ul class="footer-menu">';
	foreach ( $links as $slug => $label ) {
		printf(
			'<li><a href="%s" data-nav="%s">%s</a></li>',
			esc_url( customtheme_page_url( $slug ) ),
			esc_attr( $slug ),
			esc_html( $label )
		);
	}
	echo '</ul></nav>';
}

function customtheme_footer_brand_enabled() {
	return (bool) get_theme_mod( 'customtheme_footer_show_brand', 0 );
}

function customtheme_footer_widgets_enabled() {
	return (bool) get_theme_mod( 'customtheme_footer_show_widgets', 0 );
}

function customtheme_render_default_footer() {
	$footer_logo = get_theme_mod( 'customtheme_footer_logo', '' );
	$footer_intro = get_theme_mod( 'customtheme_footer_intro', customtheme_default_footer_intro() );
	$copyright = get_theme_mod( 'customtheme_footer_copyright', customtheme_default_footer_copyright() );
	$socials = get_theme_mod( 'customtheme_footer_socials', customtheme_default_footer_socials_json() );
	$socials = customtheme_sanitize_socials( $socials );
	$style_vars = customtheme_footer_inline_style();
	$brand_primary = get_theme_mod( 'customtheme_footer_brand_primary', get_theme_mod( 'customtheme_brand_primary', 'Yousuf' ) );
	$brand_secondary = get_theme_mod( 'customtheme_footer_brand_secondary', get_theme_mod( 'customtheme_brand_secondary', '.Developer' ) );
	$show_brand   = customtheme_footer_brand_enabled();
	$show_widgets = customtheme_footer_widgets_enabled() && is_active_sidebar( 'footer-widgets' );
	$show_menu    = customtheme_footer_menu_enabled() && has_nav_menu( 'footer' );
	?>
	<footer class="site-footer"<?php echo $style_vars ? ' style="' . esc_attr( $style_vars ) . '"' : ''; ?>>
		<?php if ( $show_brand || $show_widgets ) : ?>
		<div class="container footer-main">
			<?php if ( $show_brand ) : ?>
			<div class="footer-brand-block">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="footer-brand" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
					<?php if ( $footer_logo ) : ?>
						<img class="footer-logo" src="<?php echo esc_url( $footer_logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
					<?php else : ?>
						<span class="gradient-text"><?php echo esc_html( $brand_primary ); ?></span><?php echo esc_html( $brand_secondary ); ?>
					<?php endif; ?>
				</a>
				<?php if ( $footer_intro ) : ?>
					<p class="footer-intro"><?php echo wp_kses_post( $footer_intro ); ?></p>
				<?php endif; ?>
			</div>
			<?php endif; ?>

			<?php if ( $show_widgets ) : ?>
				<div class="footer-widgets">
					<?php dynamic_sidebar( 'footer-widgets' ); ?>
				</div>
			<?php endif; ?>
		</div>
		<?php endif; ?>

		<div class="container footer-inner">
			<div class="footer-copyright"><?php echo wp_kses_post( $copyright ); ?></div>

			<?php if ( $show_menu ) : ?>
				<?php
				wp_nav_menu( array(
					'theme_location'       => 'footer',
					'container'            => 'nav',
					'container_class'      => 'footer-nav',
					'container_aria_label' => __( 'Footer menu', 'customtheme' ),
					'menu_class'           => 'footer-menu',
					'depth'                => 1,
				) );
				?>
			<?php endif; ?>

			<?php if ( ! empty( $socials ) && is_array( $socials ) ) : ?>
				<div class="socials" aria-label="<?php esc_attr_e( 'Social links', 'customtheme' ); ?>">
					<?php foreach ( $socials as $social ) :
						if ( empty( $social['label'] ) ) continue;
						$url = ! empty( $social['url'] ) ? esc_url( $social['url'] ) : '#';
						?>
						<a href="<?php echo $url; ?>" rel="noopener"><?php echo esc_html( $social['label'] ); ?></a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</footer>
	<?php
}

function customtheme_render_footer_partial() {
	ob_start();
	customtheme_render_default_footer();
	return ob_get_clean();
}

/**
 * Customizer: brand text + header CTA
 *
 * Adds editable controls under Appearance > Customize > Site Identity
	 * for the two-part brand text ("Yousuf" gradient + ".Developer")
 * used when no custom logo image is uploaded, plus the header CTA button.
 */
function customtheme_customize_register( $wp_customize ) {
	// --- Brand text (fallback when no logo image uploaded) ---
	$wp_customize->add_setting( 'customtheme_brand_primary', array(
		'default'           => 'Yousuf',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'customtheme_brand_primary', array(
		'label'       => __( 'Brand text (gradient part)', 'customtheme' ),
		'description' => __( 'Shown in the header when no custom logo image is uploaded.', 'customtheme' ),
		'section'     => 'title_tagline',
		'type'        => 'text',
	) );

	$wp_customize->add_setting( 'customtheme_brand_secondary', array(
		'default'           => '.Developer',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'customtheme_brand_secondary', array(
		'label'       => __( 'Brand text (suffix)', 'customtheme' ),
		'section'     => 'title_tagline',
		'type'        => 'text',
	) );

	// --- Header CTA button ---
	$wp_customize->add_section( 'customtheme_header_cta', array(
		'title'    => __( 'Header CTA', 'customtheme' ),
		'priority' => 35,
	) );

	$wp_customize->add_setting( 'customtheme_cta_label', array(
		'default'           => "Let's Talk",
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'customtheme_cta_label', array(
		'label'   => __( 'Button label', 'customtheme' ),
		'section' => 'customtheme_header_cta',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'customtheme_cta_url', array(
		'default'           => '/contact',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'customtheme_cta_url', array(
		'label'       => __( 'Button link (URL or #anchor)', 'customtheme' ),
		'section'     => 'customtheme_header_cta',
		'type'        => 'text',
	) );

	// --- Footer section ---
	$wp_customize->add_section( 'customtheme_footer', array(
		'title'    => __( 'Footer', 'customtheme' ),
		'priority' => 40,
	) );

	$wp_customize->add_setting( 'customtheme_footer_brand_primary', array(
		'default'           => 'Yousuf',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'customtheme_footer_brand_primary', array(
		'label'       => __( 'Footer brand text (gradient part)', 'customtheme' ),
		'description' => __( 'Used only when no footer logo image is selected.', 'customtheme' ),
		'section'     => 'customtheme_footer',
		'type'        => 'text',
	) );

	$wp_customize->add_setting( 'customtheme_footer_brand_secondary', array(
		'default'           => '.Developer',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'customtheme_footer_brand_secondary', array(
		'label'   => __( 'Footer brand text (suffix)', 'customtheme' ),
		'section' => 'customtheme_footer',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'customtheme_footer_logo', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'customtheme_footer_logo', array(
		'label'       => __( 'Footer logo / image', 'customtheme' ),
		'description' => __( 'Optional image shown in the footer brand area.', 'customtheme' ),
		'section'     => 'customtheme_footer',
	) ) );

	$wp_customize->add_setting( 'customtheme_footer_bg_image', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'customtheme_footer_bg_image', array(
		'label'       => __( 'Footer background image', 'customtheme' ),
		'description' => __( 'Optional image behind the footer content.', 'customtheme' ),
		'section'     => 'customtheme_footer',
	) ) );

	$wp_customize->add_setting( 'customtheme_footer_intro', array(
		'default'           => customtheme_default_footer_intro(),
		'sanitize_callback' => 'wp_kses_post',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'customtheme_footer_intro', array(
		'label'   => __( 'Footer intro text', 'customtheme' ),
		'section' => 'customtheme_footer',
		'type'    => 'textarea',
	) );

	$wp_customize->add_setting( 'customtheme_footer_copyright', array(
		'default'           => customtheme_default_footer_copyright(),
		'sanitize_callback' => 'wp_kses_post',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'customtheme_footer_copyright', array(
		'label'   => __( 'Copyright text', 'customtheme' ),
		'section' => 'customtheme_footer',
		'type'    => 'textarea',
	) );

	$wp_customize->add_setting( 'customtheme_footer_socials', array(
		'default'           => customtheme_default_footer_socials_json(),
		'sanitize_callback' => 'customtheme_sanitize_socials_json',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'customtheme_footer_socials', array(
		'label'       => __( 'Social links', 'customtheme' ),
		'description' => __( 'Use JSON like [{"label":"Twitter","url":"https://x.com/..."}] or one “Label | URL” per line.', 'customtheme' ),
		'section'     => 'customtheme_footer',
		'type'        => 'textarea',
	) );

	$wp_customize->add_setting( 'customtheme_footer_show_menu', array(
		'default'           => 0,
		'sanitize_callback' => 'customtheme_sanitize_checkbox',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'customtheme_footer_show_menu', array(
		'label'       => __( 'Show footer menu', 'customtheme' ),
		'description' => __( 'Turn this on to display the footer navigation (Work, About, Blog, Contact).', 'customtheme' ),
		'section'     => 'customtheme_footer',
		'type'        => 'checkbox',
	) );

	$wp_customize->add_setting( 'customtheme_footer_show_brand', array(
		'default'           => 0,
		'sanitize_callback' => 'customtheme_sanitize_checkbox',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'customtheme_footer_show_brand', array(
		'label'       => __( 'Show footer brand block', 'customtheme' ),
		'description' => __( 'Show the large brand text/logo and intro paragraph in the footer.', 'customtheme' ),
		'section'     => 'customtheme_footer',
		'type'        => 'checkbox',
	) );

	$wp_customize->add_setting( 'customtheme_footer_show_widgets', array(
		'default'           => 0,
		'sanitize_callback' => 'customtheme_sanitize_checkbox',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'customtheme_footer_show_widgets', array(
		'label'       => __( 'Show footer widgets area', 'customtheme' ),
		'description' => __( 'Show the Footer Widgets sidebar (Appearance → Widgets).', 'customtheme' ),
		'section'     => 'customtheme_footer',
		'type'        => 'checkbox',
	) );

	$footer_colors = array(
		'customtheme_footer_bg' => array(
			'label'   => __( 'Footer background color', 'customtheme' ),
			'default' => '#08021a',
		),
		'customtheme_footer_text_color' => array(
			'label'   => __( 'Footer text color', 'customtheme' ),
			'default' => '#cbb8e6',
		),
		'customtheme_footer_link_color' => array(
			'label'   => __( 'Footer link color', 'customtheme' ),
			'default' => '#f6efff',
		),
		'customtheme_footer_hover_color' => array(
			'label'   => __( 'Footer hover color', 'customtheme' ),
			'default' => '#ff5ec4',
		),
		'customtheme_footer_border_color' => array(
			'label'   => __( 'Footer border color', 'customtheme' ),
			'default' => '#332054',
		),
		'customtheme_footer_widget_title_color' => array(
			'label'   => __( 'Footer widget title color', 'customtheme' ),
			'default' => '#f6efff',
		),
	);
	foreach ( $footer_colors as $setting_id => $setting ) {
		$wp_customize->add_setting( $setting_id, array(
			'default'           => $setting['default'],
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'refresh',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $setting_id, array(
			'label'   => $setting['label'],
			'section' => 'customtheme_footer',
		) ) );
	}

	$footer_typography = array(
		'customtheme_footer_brand_size' => array(
			'label'   => __( 'Footer brand font size (rem)', 'customtheme' ),
			'default' => '1',
		),
		'customtheme_footer_intro_size' => array(
			'label'   => __( 'Footer intro font size (rem)', 'customtheme' ),
			'default' => '0.9',
		),
		'customtheme_footer_link_size' => array(
			'label'   => __( 'Footer menu/social font size (rem)', 'customtheme' ),
			'default' => '0.82',
		),
		'customtheme_footer_copyright_size' => array(
			'label'   => __( 'Footer copyright font size (rem)', 'customtheme' ),
			'default' => '0.82',
		),
		'customtheme_footer_widget_title_size' => array(
			'label'   => __( 'Footer widget title font size (rem)', 'customtheme' ),
			'default' => '0.95',
		),
	);
	foreach ( $footer_typography as $setting_id => $setting ) {
		$wp_customize->add_setting( $setting_id, array(
			'default'           => $setting['default'],
			'sanitize_callback' => 'customtheme_sanitize_footer_size',
			'transport'         => 'refresh',
		) );
		$wp_customize->add_control( $setting_id, array(
			'label'       => $setting['label'],
			'section'     => 'customtheme_footer',
			'type'        => 'number',
			'input_attrs' => array( 'min' => '0.5', 'max' => '3', 'step' => '0.05' ),
		) );
	}

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'customtheme_footer_partial', array(
			'selector'            => '.site-footer',
			'settings'            => array(
				'customtheme_footer_brand_primary',
				'customtheme_footer_brand_secondary',
				'customtheme_footer_logo',
				'customtheme_footer_bg_image',
				'customtheme_footer_intro',
				'customtheme_footer_copyright',
				'customtheme_footer_socials',
				'customtheme_footer_show_menu',
				'customtheme_footer_show_brand',
				'customtheme_footer_show_widgets',
				'customtheme_footer_bg',
				'customtheme_footer_text_color',
				'customtheme_footer_link_color',
				'customtheme_footer_hover_color',
				'customtheme_footer_border_color',
				'customtheme_footer_widget_title_color',
				'customtheme_footer_brand_size',
				'customtheme_footer_intro_size',
				'customtheme_footer_link_size',
				'customtheme_footer_copyright_size',
				'customtheme_footer_widget_title_size',
			),
			'container_inclusive' => true,
			'render_callback'     => 'customtheme_render_footer_partial',
		) );
	}
}
add_action( 'customize_register', 'customtheme_customize_register' );

/**
 * Render the brand: uploaded custom logo if present, otherwise the
 * two-part gradient text from the Customizer.
 */
function customtheme_render_brand() {
	if ( has_custom_logo() ) {
		// WP wraps this in <a href="home_url"> automatically on non-front pages,
		// and in <span class="custom-logo-link"> on the front page.
		the_custom_logo();
		return;
	}

	$primary   = get_theme_mod( 'customtheme_brand_primary', 'Yousuf' );
	$secondary = get_theme_mod( 'customtheme_brand_secondary', '.Developer' );
	$home      = esc_url( home_url( '/' ) );
	?>
	<a href="<?php echo $home; ?>" class="brand" data-nav="home">
		<span class="gradient-text"><?php echo esc_html( $primary ); ?></span><?php echo esc_html( $secondary ); ?>
	</a>
	<?php
}

/**
 * Resolve installer-created page URLs for fallback navigation.
 */
function customtheme_page_url( $slug ) {
	if ( 'home' === $slug ) {
		return home_url( '/' );
	}

	$page = get_page_by_path( $slug );
	return $page ? get_permalink( $page ) : home_url( '/' . trim( $slug, '/' ) . '/' );
}

/**
 * Fallback for wp_nav_menu when no menu is assigned to a location:
 * render the original hard-coded anchor links so the theme still
 * looks correct on a fresh install.
 */
function customtheme_default_menu( $args ) {
	$theme_location = '';
	if ( is_array( $args ) && isset( $args['theme_location'] ) ) {
		$theme_location = $args['theme_location'];
	} elseif ( is_object( $args ) && isset( $args->theme_location ) ) {
		$theme_location = $args->theme_location;
	}
	$is_mobile = $theme_location === 'primary_mobile';
	$links = array(
		'home'    => __( 'Home',    'customtheme' ),
		'work'    => __( 'Work',    'customtheme' ),
		'about'   => __( 'About',   'customtheme' ),
		'blog'    => __( 'Blog',    'customtheme' ),
		'contact' => __( 'Contact', 'customtheme' ),
	);

	if ( $is_mobile ) {
		echo '<nav class="nav-mobile glass" id="navMobile"><ul class="nav-mobile-menu">';
		foreach ( $links as $slug => $label ) {
			$href = customtheme_page_url( $slug );
			printf(
				'<li><a href="%s" data-nav="%s">%s</a></li>',
				esc_url( $href ), esc_attr( $slug ), esc_html( $label )
			);
		}
		echo '</ul></nav>';
	} else {
		echo '<nav class="nav-desktop" id="nav"><ul class="nav-desktop-menu">';
		$current = trim( parse_url( home_url( add_query_arg( array(), $GLOBALS['wp']->request ?? '' ) ), PHP_URL_PATH ), '/' );
		foreach ( $links as $slug => $label ) {
			$href      = customtheme_page_url( $slug );
			$is_active = ( 'home' === $slug && ( is_front_page() || '' === $current ) ) || ( $slug === basename( $current ) );
			$li_class  = $is_active ? 'menu-item current-menu-item' : 'menu-item';
			$a_class   = 'nav-link' . ( $is_active ? ' active' : '' );
			printf(
				'<li class="%s"><a href="%s" class="%s" data-nav="%s"><span>%s</span></a></li>',
				esc_attr( $li_class ), esc_url( $href ), esc_attr( $a_class ), esc_attr( $slug ), esc_html( $label )
			);
		}
		echo '</ul></nav>';
	}

}

/**
 * Add `nav-link` class + `data-nav` attribute to <a> tags produced by
 * wp_nav_menu so they hook into the theme's pill styling AND the
 * scripts.js hash-based page router (which toggles `.active` on any
 * element with a matching [data-nav] value).
 *
 * If the menu item's URL is a hash (e.g. #home, #work), we forward
 * that anchor as data-nav. Otherwise we skip it and let the link
 * behave as a regular URL.
 */
function customtheme_nav_link_attrs( $atts, $item, $args ) {
	$is_primary = isset( $args->theme_location ) && $args->theme_location === 'primary';
	$is_mobile  = isset( $args->theme_location ) && $args->theme_location === 'primary_mobile';

	if ( $is_primary ) {
		$classes = isset( $atts['class'] ) ? $atts['class'] . ' nav-link' : 'nav-link';
		if ( in_array( 'current-menu-item', (array) $item->classes, true )
			|| in_array( 'current_page_item', (array) $item->classes, true ) ) {
			$classes .= ' active';
		}
		$atts['class'] = trim( $classes );
	}

	if ( $is_primary || $is_mobile ) {
		$url = isset( $atts['href'] ) ? $atts['href'] : '';
		// Match "#slug" or "https://site.tld/#slug".
		if ( preg_match( '~#([A-Za-z0-9_\-]+)$~', $url, $m ) ) {
			$atts['data-nav'] = $m[1];
		} else {
			$path = trim( (string) parse_url( $url, PHP_URL_PATH ), '/' );
			$slug = '' === $path ? 'home' : basename( $path );
			if ( in_array( $slug, array( 'home', 'work', 'about', 'blog', 'contact' ), true ) ) {
				$atts['data-nav'] = $slug;
			}
		}
	}
	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'customtheme_nav_link_attrs', 10, 3 );

/**
 * Wrap the desktop menu item label in <span> so the active-pill
 * ::before layer sits behind the text (matches the fallback markup).
 */
function customtheme_nav_link_title( $title, $item, $args, $depth ) {
	if ( isset( $args->theme_location ) && $args->theme_location === 'primary' ) {
		return '<span>' . $title . '</span>';
	}
	return $title;
}
add_filter( 'nav_menu_item_title', 'customtheme_nav_link_title', 10, 4 );
