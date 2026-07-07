<?php
/**
 * Purfolio — one-click page installer.
 *
 * Creates real WordPress Pages (Home, Work, About, Blog, Contact) that are
 * pre-built with Elementor sections using the Purfolio widgets, so
 * every heading, paragraph, image, project card and contact row is
 * immediately editable in Elementor.
 *
 * Runs automatically on theme activation, and can be re-run manually from
 * Appearance → Purfolio Setup.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

/* ---------------------------------------------------------------------
 * Helpers to build Elementor data
 * ------------------------------------------------------------------- */

function pf_el_id() {
	return substr( md5( uniqid( '', true ) ), 0, 7 );
}

function pf_el_widget( $type, $settings = array() ) {
	return array(
		'id'         => pf_el_id(),
		'elType'     => 'widget',
		'settings'   => $settings,
		'elements'   => array(),
		'widgetType' => $type,
	);
}

function pf_el_section( $widgets = array(), $section_settings = array() ) {
	return array(
		'id'       => pf_el_id(),
		'elType'   => 'section',
		'settings' => $section_settings,
		'elements' => array(
			array(
				'id'       => pf_el_id(),
				'elType'   => 'column',
				'settings' => array( '_column_size' => 100, '_inline_size' => null ),
				'elements' => $widgets,
				'isInner'  => false,
			),
		),
		'isInner'  => false,
	);
}

/* ---------------------------------------------------------------------
 * Page definitions — Elementor data trees
 * ------------------------------------------------------------------- */

function pf_installer_home_data() {
	return array(
		pf_el_section( array(
			pf_el_widget( 'pfw_hero', array(
				'eyebrow'         => 'WordPress Developer',
				'chip_text'       => 'Available',
				'title_before'    => 'Crafting',
				'title_highlight' => 'WordPress',
				'title_after'     => 'experiences that feel unreal.',
				'lead'            => "I'm Yousuf Zai — building custom themes, headless WordPress stacks and blazing-fast websites for founders and studios worldwide.",
				'primary_label'   => 'View Work',
				'primary_link'    => array( 'url' => '/work', 'is_external' => '', 'nofollow' => '' ),
				'ghost_label'     => 'Start a Project',
				'ghost_link'      => array( 'url' => '/contact', 'is_external' => '', 'nofollow' => '' ),
				'image'           => array( 'url' => customtheme_asset( 'hero-wordpress.jpg' ) ),
			) ),
			pf_el_widget( 'pfw_stats', array(
				'items' => array(
					array( '_id' => pf_el_id(), 'number' => '80',  'suffix' => '+', 'label' => 'Sites shipped' ),
					array( '_id' => pf_el_id(), 'number' => '9',   'suffix' => 'y', 'label' => 'In WordPress' ),
					array( '_id' => pf_el_id(), 'number' => '100', 'suffix' => '',  'label' => 'Lighthouse avg' ),
				),
			) ),
		) ),
		pf_el_section( array(
			pf_el_widget( 'pfw_services', array(
				'eyebrow'         => 'What I do',
				'title_before'    => 'Services built for',
				'title_highlight' => 'modern WordPress',
				'title_after'     => '.',
				'columns'         => '3',
				'items' => array(
					array( '_id' => pf_el_id(), 'icon' => '◇', 'title' => 'Custom Themes',      'desc' => 'Bespoke, block-based themes engineered around your brand — no bloat.' ),
					array( '_id' => pf_el_id(), 'icon' => '⚡', 'title' => 'Headless WordPress', 'desc' => 'Decoupled architectures with Next.js or Astro powered by WP REST & GraphQL.' ),
					array( '_id' => pf_el_id(), 'icon' => '◉', 'title' => 'WooCommerce',        'desc' => 'Fast, conversion-focused stores with custom checkout flows.' ),
				),
			) ),
		) ),
		pf_el_section( array(
			pf_el_widget( 'pfw_cta', array(
				'title_before'    => 'Ready to build something',
				'title_highlight' => 'extraordinary?',
				'desc'            => "Let's turn your idea into a fast, beautiful WordPress site.",
				'btn_label'       => 'Get in touch →',
				'btn_link'        => array( 'url' => '/contact', 'is_external' => '', 'nofollow' => '' ),
			) ),
		) ),
	);
}

function pf_installer_work_data() {
	$placeholder = class_exists( '\Elementor\Utils' )
		? \Elementor\Utils::get_placeholder_image_src()
		: '';
	return array(
		// Hero-style intro matching reference /work page.
		pf_el_section( array(
			pf_el_widget( 'pfw_hero', array(
				'eyebrow'         => 'Case studies',
				'chip_text'       => '',
				'title_before'    => 'Work that',
				'title_highlight' => 'ships',
				'title_after'     => '.',
				'lead'            => 'A selection of WordPress builds across editorial, commerce and product-marketing surfaces.',
				'primary_label'   => 'Start a project',
				'primary_link'    => array( 'url' => '/contact', 'is_external' => '', 'nofollow' => '' ),
				'ghost_label'     => 'About me',
				'ghost_link'      => array( 'url' => '/about', 'is_external' => '', 'nofollow' => '' ),
				'image'           => array( 'url' => $placeholder ),
			) ),
		) ),
		// Projects grid.
		pf_el_section( array(
			pf_el_widget( 'pfw_projects', array(
				'eyebrow'       => 'Selected work',
				'title'         => 'Recent projects',
				'see_all_label' => '',
				'columns'       => '3',
				'items' => array(
					array( '_id' => pf_el_id(), 'image' => array( 'url' => $placeholder ), 'category' => 'Custom Theme', 'title' => 'Halcyon Studio',  'link' => array( 'url' => '#', 'is_external' => '', 'nofollow' => '' ) ),
					array( '_id' => pf_el_id(), 'image' => array( 'url' => $placeholder ), 'category' => 'Headless WP',  'title' => 'Ribbon FM',       'link' => array( 'url' => '#', 'is_external' => '', 'nofollow' => '' ) ),
					array( '_id' => pf_el_id(), 'image' => array( 'url' => $placeholder ), 'category' => 'WooCommerce',  'title' => 'Orbit Commerce',  'link' => array( 'url' => '#', 'is_external' => '', 'nofollow' => '' ) ),
					array( '_id' => pf_el_id(), 'image' => array( 'url' => $placeholder ), 'category' => 'Editorial',    'title' => 'Meridian Press',  'link' => array( 'url' => '#', 'is_external' => '', 'nofollow' => '' ) ),
					array( '_id' => pf_el_id(), 'image' => array( 'url' => $placeholder ), 'category' => 'Product Site', 'title' => 'North Field',     'link' => array( 'url' => '#', 'is_external' => '', 'nofollow' => '' ) ),
					array( '_id' => pf_el_id(), 'image' => array( 'url' => $placeholder ), 'category' => 'Portfolio',    'title' => 'Studio Nomad',    'link' => array( 'url' => '#', 'is_external' => '', 'nofollow' => '' ) ),
				),
			) ),
		) ),
		pf_el_section( array(
			pf_el_widget( 'pfw_cta', array(
				'title_before'    => 'Have a project in mind?',
				'title_highlight' => "Let's talk.",
				'desc'            => 'Tell me about your project, timeline and budget — I typically reply within 24 hours.',
				'btn_label'       => 'Start a project →',
				'btn_link'        => array( 'url' => '/contact', 'is_external' => '', 'nofollow' => '' ),
			) ),
		) ),
	);
}

function pf_installer_about_data() {
	return array(
		pf_el_section( array(
			pf_el_widget( 'pfw_hero', array(
				'eyebrow'         => 'About',
				'chip_text'       => '',
				'title_before'    => "Hi, I'm",
				'title_highlight' => 'Yousuf Zai',
				'title_after'     => '— a WordPress developer.',
				'lead'            => 'Nine years of building WordPress sites for founders, studios and magazines — from tiny brochure sites to headless commerce stacks handling millions of pageviews. Performance, typography and smooth editing workflows guide every build.',
				'primary_label'   => 'View Work',
				'primary_link'    => array( 'url' => '/work', 'is_external' => '', 'nofollow' => '' ),
				'ghost_label'     => 'Contact',
				'ghost_link'      => array( 'url' => '/contact', 'is_external' => '', 'nofollow' => '' ),
				'image'           => array( 'url' => customtheme_asset( 'profile-yousuf-zai.png' ) ),
			) ),
			pf_el_widget( 'pfw_stats', array(
				'items' => array(
					array( '_id' => pf_el_id(), 'number' => '80',  'suffix' => '+', 'label' => 'Sites shipped' ),
					array( '_id' => pf_el_id(), 'number' => '9',   'suffix' => 'y', 'label' => 'In WordPress' ),
					array( '_id' => pf_el_id(), 'number' => '12',  'suffix' => '',  'label' => 'Countries' ),
				),
			) ),
		) ),
		pf_el_section( array(
			pf_el_widget( 'pfw_services', array(
				'eyebrow'         => 'How I work',
				'title_before'    => 'Small team.',
				'title_highlight' => 'Big output.',
				'title_after'     => '',
				'columns'         => '3',
				'items' => array(
					array( '_id' => pf_el_id(), 'icon' => '◇', 'title' => 'Discovery', 'desc' => 'A short kickoff to align on goals, scope and success metrics.' ),
					array( '_id' => pf_el_id(), 'icon' => '⚡', 'title' => 'Build',     'desc' => 'Weekly demos and a live staging site so you always see progress.' ),
					array( '_id' => pf_el_id(), 'icon' => '◉', 'title' => 'Launch',    'desc' => 'Performance-tuned launch with monitoring and 30 days of support.' ),
				),
			) ),
		) ),
		pf_el_section( array(
			pf_el_widget( 'pfw_tools', array(
				'eyebrow' => 'The stack',
				'title'   => 'Tools of the trade.',
				'items'   => array(
					array( '_id' => pf_el_id(), 'label' => 'WordPress' ),
					array( '_id' => pf_el_id(), 'label' => 'PHP 8+' ),
					array( '_id' => pf_el_id(), 'label' => 'WPGraphQL' ),
					array( '_id' => pf_el_id(), 'label' => 'ACF Pro' ),
					array( '_id' => pf_el_id(), 'label' => 'Next.js' ),
					array( '_id' => pf_el_id(), 'label' => 'React' ),
					array( '_id' => pf_el_id(), 'label' => 'TypeScript' ),
					array( '_id' => pf_el_id(), 'label' => 'Tailwind' ),
					array( '_id' => pf_el_id(), 'label' => 'WooCommerce' ),
					array( '_id' => pf_el_id(), 'label' => 'MySQL' ),
					array( '_id' => pf_el_id(), 'label' => 'Docker' ),
					array( '_id' => pf_el_id(), 'label' => 'Cloudflare' ),
				),
			) ),
		) ),
		pf_el_section( array(
			pf_el_widget( 'pfw_timeline', array(
				'eyebrow' => 'Timeline',
				'title'   => 'A short story.',
				'items'   => array(
					array( '_id' => pf_el_id(), 'year' => '2026', 'title' => 'Independent Studio', 'desc' => 'Full-time freelance work with founders, agencies and studios across 12 countries.' ),
					array( '_id' => pf_el_id(), 'year' => '2023', 'title' => 'Headless WordPress', 'desc' => 'Started shipping decoupled builds with Next.js + WPGraphQL as a default stack.' ),
					array( '_id' => pf_el_id(), 'year' => '2020', 'title' => 'Senior WP Engineer', 'desc' => 'Led theme + plugin engineering at a boutique digital agency in Berlin.' ),
					array( '_id' => pf_el_id(), 'year' => '2017', 'title' => 'First Custom Theme', 'desc' => 'Fell into WordPress development, never looked back.' ),
				),
			) ),
		) ),
	);
}

function pf_installer_blog_data() {
	return array(
		pf_el_section( array(
			pf_el_widget( 'pfw_hero', array(
				'eyebrow'         => 'Blog',
				'chip_text'       => 'Notes',
				'title_before'    => 'Ideas for',
				'title_highlight' => 'better WordPress',
				'title_after'     => 'builds.',
				'lead'            => 'Field notes on custom themes, performance, Elementor workflows, WooCommerce and maintainable WordPress systems.',
				'primary_label'   => 'Read latest',
				'primary_link'    => array( 'url' => '#latest-posts', 'is_external' => '', 'nofollow' => '' ),
				'ghost_label'     => 'Start a Project',
				'ghost_link'      => array( 'url' => '/contact', 'is_external' => '', 'nofollow' => '' ),
				'image'           => array( 'url' => customtheme_asset( 'work-3d.jpg' ) ),
			) ),
		) ),
		pf_el_section( array(
			pf_el_widget( 'pfw_posts', array(
				'eyebrow'  => 'Latest posts',
				'title'    => 'From the blog',
				'per_page' => 6,
			) ),
		), array( 'css_classes' => 'latest-posts-section' ) ),
	);
}

function pf_installer_contact_data() {
	return array(
		pf_el_section( array(
			pf_el_widget( 'pfw_hero', array(
				'eyebrow'         => 'Contact',
				'chip_text'       => 'Available',
				'title_before'    => "Let's build",
				'title_highlight' => 'something',
				'title_after'     => 'together.',
				'lead'            => 'Tell me about your project, timeline and budget — I typically reply within 24 hours.',
				'primary_label'   => 'Email me',
				'primary_link'    => array( 'url' => 'mailto:hello@example.com', 'is_external' => '', 'nofollow' => '' ),
				'ghost_label'     => 'View Work',
				'ghost_link'      => array( 'url' => '/work', 'is_external' => '', 'nofollow' => '' ),
			) ),
		) ),
		pf_el_section( array(
			pf_el_widget( 'pfw_contact_info', array(
				'items' => array(
					array( '_id' => pf_el_id(), 'icon' => '✉',  'label' => 'Email',    'value' => 'hello@yousufzai.dev', 'link' => array( 'url' => 'mailto:hello@yousufzai.dev', 'is_external' => '', 'nofollow' => '' ) ),
					array( '_id' => pf_el_id(), 'icon' => '💬', 'label' => 'Discord',  'value' => '@yousufzai',          'link' => array( 'url' => '', 'is_external' => '', 'nofollow' => '' ) ),
					array( '_id' => pf_el_id(), 'icon' => '📍', 'label' => 'Based in', 'value' => 'Lisbon, Portugal',  'link' => array( 'url' => '', 'is_external' => '', 'nofollow' => '' ) ),
				),
			) ),
		) ),
	);
}

/**
 * Return the pages the theme wants to exist, keyed by unique meta slug.
 */
function pf_installer_pages() {
	return array(
		'home' => array(
			'title'          => 'Home',
			'slug'           => 'home',
			'content'        => "<!-- wp:heading {\"level\":1} --><h1>Crafting WordPress experiences that feel unreal.</h1><!-- /wp:heading -->\n<!-- wp:paragraph --><p>Edit this page with Elementor to unlock the pre-built Purfolio sections.</p><!-- /wp:paragraph -->",
			'elementor_data' => 'pf_installer_home_data',
		),
		'work' => array(
			'title'          => 'Work',
			'slug'           => 'work',
			'content'        => "<!-- wp:heading {\"level\":1} --><h1>Work that ships.</h1><!-- /wp:heading -->\n<!-- wp:paragraph --><p>A selection of WordPress builds.</p><!-- /wp:paragraph -->",
			'elementor_data' => 'pf_installer_work_data',
		),
		'about' => array(
			'title'          => 'About',
			'slug'           => 'about',
			'content'        => "<!-- wp:heading {\"level\":1} --><h1>Hi, I'm Yousuf Zai.</h1><!-- /wp:heading -->\n<!-- wp:paragraph --><p>Nine years of building WordPress sites.</p><!-- /wp:paragraph -->",
			'elementor_data' => 'pf_installer_about_data',
		),
		'blog' => array(
			'title'          => 'Blog',
			'slug'           => 'blog',
			'content'        => "<!-- wp:heading {\"level\":1} --><h1>Blog</h1><!-- /wp:heading -->\n<!-- wp:paragraph --><p>Notes on WordPress design, performance and development.</p><!-- /wp:paragraph -->",
			'elementor_data' => 'pf_installer_blog_data',
		),
		'contact' => array(
			'title'          => 'Contact',
			'slug'           => 'contact',
			'content'        => "<!-- wp:heading {\"level\":1} --><h1>Let's build together.</h1><!-- /wp:heading -->\n<!-- wp:paragraph --><p>Tell me about your project.</p><!-- /wp:paragraph -->",
			'elementor_data' => 'pf_installer_contact_data',
		),
	);
}

/**
 * Attach Elementor data to a page so it opens pre-built in Elementor.
 * Called for pages we just created AND when the user re-runs the installer
 * on an existing page that has no Elementor data yet.
 */
function pf_installer_attach_elementor( $page_id, $data_callback ) {
	if ( ! $page_id || ! is_callable( $data_callback ) ) return;
	// Don't overwrite existing Elementor content.
	$existing = get_post_meta( $page_id, '_elementor_data', true );
	if ( ! empty( $existing ) && $existing !== '[]' ) return;

	$data = call_user_func( $data_callback );
	// Elementor expects slash-escaped JSON in post meta.
	update_post_meta( $page_id, '_elementor_data', wp_slash( wp_json_encode( $data ) ) );
	update_post_meta( $page_id, '_elementor_edit_mode', 'builder' );
	update_post_meta( $page_id, '_elementor_template_type', 'wp-page' );
	update_post_meta( $page_id, '_elementor_version', defined( 'ELEMENTOR_VERSION' ) ? ELEMENTOR_VERSION : '3.0.0' );

	if ( did_action( 'elementor/loaded' ) && class_exists( '\Elementor\Plugin' ) ) {
		\Elementor\Plugin::$instance->files_manager->clear_cache();
	}
}

/**
 * Check whether a WordPress menu already contains a specific Page item.
 */
function pf_installer_menu_has_page( $menu_id, $page_id ) {
	$items = wp_get_nav_menu_items( $menu_id );
	if ( empty( $items ) || ! $page_id ) return false;

	foreach ( $items as $item ) {
		if ( 'post_type' === $item->type && 'page' === $item->object && (int) $item->object_id === (int) $page_id ) {
			return true;
		}
	}
	return false;
}

/**
 * Add a Page to a menu only when it is not already present.
 */
function pf_installer_add_page_to_menu( $menu_id, $page_id ) {
	if ( ! $menu_id || ! $page_id || pf_installer_menu_has_page( $menu_id, $page_id ) ) return;

	wp_update_nav_menu_item( $menu_id, 0, array(
		'menu-item-title'     => get_the_title( $page_id ),
		'menu-item-object'    => 'page',
		'menu-item-object-id' => (int) $page_id,
		'menu-item-type'      => 'post_type',
		'menu-item-status'    => 'publish',
	) );
}

/**
 * Create any missing pages, set Home as the static front page, wire the
 * primary menu, and pre-fill Elementor sections.
 */
function pf_installer_run() {
	if ( ! current_user_can( 'manage_options' ) ) return;

	$created = get_option( 'pf_installer_created', array() );
	$ids     = array();

	foreach ( pf_installer_pages() as $key => $data ) {
		// Reuse if we already created it and it still exists.
		if ( ! empty( $created[ $key ] ) && get_post_status( $created[ $key ] ) ) {
			$ids[ $key ] = (int) $created[ $key ];
		} else {
			// Reuse any existing page with the same slug (idempotent).
			$existing = get_page_by_path( $data['slug'] );
			if ( $existing ) {
				$ids[ $key ] = (int) $existing->ID;
			} else {
				$id = wp_insert_post( array(
					'post_title'   => sanitize_text_field( $data['title'] ),
					'post_name'    => sanitize_title( $data['slug'] ),
					'post_status'  => 'publish',
					'post_type'    => 'page',
					'post_content' => wp_kses_post( $data['content'] ),
				), true );
				if ( ! is_wp_error( $id ) ) {
					$ids[ $key ] = (int) $id;
				}
			}
		}

		// Attach pre-built Elementor sections if the page has none yet.
		if ( ! empty( $ids[ $key ] ) && ! empty( $data['elementor_data'] ) ) {
			pf_installer_attach_elementor( $ids[ $key ], $data['elementor_data'] );
		}
	}

	update_option( 'pf_installer_created', $ids );

	// Set Home as the static front page.
	if ( ! empty( $ids['home'] ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', (int) $ids['home'] );
	}
	// IMPORTANT: do NOT set `page_for_posts` — WordPress replaces that page's
	// content with the blog archive loop, which prevents Elementor from
	// rendering. Blog page uses the pfw_posts widget to render posts, so it
	// stays fully editable in Elementor.
	if ( (int) get_option( 'page_for_posts' ) && ! empty( $ids['blog'] ) && (int) get_option( 'page_for_posts' ) === (int) $ids['blog'] ) {
		update_option( 'page_for_posts', 0 );
	}
	// Create one editable default blog post.
	$post_slug = 'professional-wordpress-portfolio-setup';
	$existing_post = get_page_by_path( $post_slug, OBJECT, 'post' );
	if ( ! $existing_post ) {
		wp_insert_post( array(
			'post_title'   => 'Building a Professional WordPress Portfolio in 2026',
			'post_name'    => $post_slug,
			'post_status'  => 'publish',
			'post_type'    => 'post',
			'post_author'  => get_current_user_id() ?: 1,
			'post_excerpt' => 'A practical starting point for turning a portfolio into a fast, editable WordPress presence.',
			'post_content' => "<!-- wp:paragraph --><p>A strong portfolio should load quickly, feel memorable, and stay easy to edit after launch. Purfolio Theme 2026 keeps the visual system polished while letting every key section be adjusted in WordPress and Elementor.</p><!-- /wp:paragraph -->\n<!-- wp:heading --><h2>Start with editable sections</h2><!-- /wp:heading -->\n<!-- wp:paragraph --><p>Hero copy, profile images, service cards, project grids, timeline milestones and calls to action should all be controlled from the editor so the site can grow without code changes.</p><!-- /wp:paragraph -->\n<!-- wp:heading --><h2>Keep performance in the design process</h2><!-- /wp:heading -->\n<!-- wp:paragraph --><p>Use optimized imagery, responsive layouts and purposeful animation. Motion should support the story, not slow the experience down.</p><!-- /wp:paragraph -->",
		) );
	}

	// Build / refresh a menu named "Purfolio Menu" and assign it to both
	// primary locations. The footer gets its own optional menu location so it
	// can be edited, unassigned, or hidden without changing the header menu.
	$menu_name = 'Purfolio Menu';
	$menu      = wp_get_nav_menu_object( $menu_name );
	$menu_id   = $menu ? (int) $menu->term_id : wp_create_nav_menu( $menu_name );
	if ( ! is_wp_error( $menu_id ) && $menu_id ) {
		foreach ( array( 'home', 'work', 'about', 'blog', 'contact' ) as $key ) {
			if ( empty( $ids[ $key ] ) ) continue;
			pf_installer_add_page_to_menu( $menu_id, $ids[ $key ] );
		}
		$locations = get_theme_mod( 'nav_menu_locations', array() );
		if ( empty( $locations['primary'] ) )        $locations['primary']        = $menu_id;
		if ( empty( $locations['primary_mobile'] ) ) $locations['primary_mobile'] = $menu_id;

		if ( empty( $locations['footer'] ) ) {
			$footer_menu_name = 'Purfolio Footer Menu';
			$footer_menu      = wp_get_nav_menu_object( $footer_menu_name );
			$footer_menu_id   = $footer_menu ? (int) $footer_menu->term_id : wp_create_nav_menu( $footer_menu_name );
			if ( ! is_wp_error( $footer_menu_id ) && $footer_menu_id ) {
				foreach ( array( 'home', 'work', 'about', 'blog', 'contact' ) as $key ) {
					if ( empty( $ids[ $key ] ) ) continue;
					pf_installer_add_page_to_menu( $footer_menu_id, $ids[ $key ] );
				}
				$locations['footer'] = $footer_menu_id;
			}
		}
		set_theme_mod( 'nav_menu_locations', $locations );

		// Repair header menus only. Footer menu items are intentionally not forced
		// back in, so users can remove or disable footer links freely.
		foreach ( array( 'primary', 'primary_mobile' ) as $location ) {
			$assigned = ! empty( $locations[ $location ] ) ? (int) $locations[ $location ] : 0;
			if ( ! $assigned ) continue;
			foreach ( array( 'home', 'work', 'about', 'blog', 'contact' ) as $key ) {
				if ( empty( $ids[ $key ] ) ) continue;
				pf_installer_add_page_to_menu( $assigned, $ids[ $key ] );
			}
		}
	}
}

/**
 * Auto-run on theme switch.
 */
add_action( 'after_switch_theme', 'pf_installer_run' );

/**
 * Manual re-run screen: Appearance → Purfolio Setup.
 */
add_action( 'admin_menu', function () {
	add_theme_page(
		__( 'Purfolio Setup', 'customtheme' ),
		__( 'Purfolio Setup', 'customtheme' ),
		'manage_options',
		'purfolio-setup',
		'pf_installer_render_screen'
	);
} );

function pf_installer_render_screen() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'You do not have permission to access this page.', 'customtheme' ) );
	}

	$ran = false;
	if ( isset( $_POST['pf_install_nonce'] )
		&& wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['pf_install_nonce'] ) ), 'pf_install' ) ) {
		pf_installer_run();
		$ran = true;
	}

	$created = get_option( 'pf_installer_created', array() );
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Purfolio Setup', 'customtheme' ); ?></h1>
		<?php if ( $ran ) : ?>
			<div class="notice notice-success"><p><?php esc_html_e( 'Pages, menu and Elementor sections installed.', 'customtheme' ); ?></p></div>
		<?php endif; ?>
		<p><?php esc_html_e( 'This creates real WordPress Pages (Home, Work, About, Blog, Contact) pre-built with Purfolio Elementor sections. Pages that already have Elementor content are never overwritten.', 'customtheme' ); ?></p>
		<h2><?php esc_html_e( 'Installed pages', 'customtheme' ); ?></h2>
		<ul style="list-style:disc;padding-left:20px;">
			<?php foreach ( pf_installer_pages() as $key => $data ) :
				$id = isset( $created[ $key ] ) ? (int) $created[ $key ] : 0;
				if ( ! $id ) {
					$page = get_page_by_path( $data['slug'] );
					$id   = $page ? (int) $page->ID : 0;
				}
				$elementor_edit_url = $id ? add_query_arg( array( 'post' => $id, 'action' => 'elementor' ), admin_url( 'post.php' ) ) : '';
				?>
				<li>
					<strong><?php echo esc_html( $data['title'] ); ?></strong> —
					<?php if ( $id ) : ?>
						<a href="<?php echo esc_url( get_edit_post_link( $id ) ); ?>"><?php esc_html_e( 'Edit', 'customtheme' ); ?></a> ·
						<a href="<?php echo esc_url( $elementor_edit_url ); ?>"><?php esc_html_e( 'Edit with Elementor', 'customtheme' ); ?></a> ·
						<a href="<?php echo esc_url( get_permalink( $id ) ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'View', 'customtheme' ); ?></a>
					<?php else : ?>
						<em><?php esc_html_e( 'not installed yet', 'customtheme' ); ?></em>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ul>
		<form method="post" style="margin-top:20px;">
			<?php wp_nonce_field( 'pf_install', 'pf_install_nonce' ); ?>
			<?php submit_button( __( 'Install / repair pages & menu', 'customtheme' ) ); ?>
			<p class="description"><?php esc_html_e( 'Safe to run multiple times. Only pages without Elementor content will get the pre-built sections.', 'customtheme' ); ?></p>
		</form>
		<h2><?php esc_html_e( 'Next steps', 'customtheme' ); ?></h2>
		<ol>
			<li><?php esc_html_e( 'Install & activate the Elementor plugin, then Purfolio Addon Plugin.', 'customtheme' ); ?></li>
			<li><?php esc_html_e( 'Click "Edit with Elementor" on any page above — every section is a PF widget you can edit in the Style tab (typography, image size, border radius, colors).', 'customtheme' ); ?></li>
			<li><?php esc_html_e( 'Page Layout: use "Default" or "Elementor Full Width" to keep the theme header. Use "Elementor Canvas" only if you drop a PF Site Nav widget yourself.', 'customtheme' ); ?></li>
		</ol>
	</div>
	<?php
}
