<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * PF Footer — editable footer block for Elementor / Elementor Canvas pages.
 * It can mirror Appearance → Customize → Footer or use widget-local content.
 */
class PFW_Footer extends \Elementor\Widget_Base {

	public function get_name()      { return 'pfw_footer'; }
	public function get_title()     { return __( 'PF Footer', 'pfw' ); }
	public function get_icon()      { return 'eicon-footer'; }
	public function get_categories(){ return [ 'purple-folio' ]; }
	public function get_keywords()  { return [ 'footer', 'copyright', 'social', 'menu', 'widgets' ]; }

	private function menu_options() {
		$options = [ '' => __( '— Theme footer menu / fallback —', 'pfw' ) ];
		foreach ( wp_get_nav_menus() as $menu ) {
			$options[ $menu->term_id ] = $menu->name;
		}
		return $options;
	}

	protected function register_controls() {
		$this->start_controls_section( 'sec_content', [ 'label' => __( 'Footer content', 'pfw' ) ] );

		$this->add_control( 'source', [
			'label'   => __( 'Content source', 'pfw' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'customizer',
			'options' => [
				'customizer' => __( 'Use Customize → Footer', 'pfw' ),
				'custom'     => __( 'Custom for this widget', 'pfw' ),
			],
		] );

		$this->add_control( 'logo', [
			'label'     => __( 'Footer logo / image', 'pfw' ),
			'type'      => \Elementor\Controls_Manager::MEDIA,
			'condition' => [ 'source' => 'custom' ],
		] );
		$this->add_control( 'brand_primary', [
			'label'     => __( 'Brand text (gradient part)', 'pfw' ),
			'type'      => \Elementor\Controls_Manager::TEXT,
			'default'   => 'Yousuf',
			'condition' => [ 'source' => 'custom' ],
		] );
		$this->add_control( 'brand_secondary', [
			'label'     => __( 'Brand text (suffix)', 'pfw' ),
			'type'      => \Elementor\Controls_Manager::TEXT,
			'default'   => '.Developer',
			'condition' => [ 'source' => 'custom' ],
		] );
		$this->add_control( 'background_image', [
			'label'     => __( 'Footer background image', 'pfw' ),
			'type'      => \Elementor\Controls_Manager::MEDIA,
			'condition' => [ 'source' => 'custom' ],
		] );
		$this->add_control( 'intro', [
			'label'     => __( 'Intro text', 'pfw' ),
			'type'      => \Elementor\Controls_Manager::TEXTAREA,
			'default'   => __( 'Modern WordPress portfolio theme built for Elementor editing, responsive layouts and polished motion.', 'pfw' ),
			'condition' => [ 'source' => 'custom' ],
		] );
		$this->add_control( 'copyright', [
			'label'     => __( 'Copyright text', 'pfw' ),
			'type'      => \Elementor\Controls_Manager::TEXTAREA,
			'default'   => '© ' . gmdate( 'Y' ) . ' Yousuf Zai — Crafted with WordPress magic.',
			'condition' => [ 'source' => 'custom' ],
		] );

		$rep = new \Elementor\Repeater();
		$rep->add_control( 'label', [ 'label' => __( 'Label', 'pfw' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'GitHub' ] );
		$rep->add_control( 'url', [ 'label' => __( 'URL', 'pfw' ), 'type' => \Elementor\Controls_Manager::URL, 'default' => [ 'url' => '#' ] ] );
		$this->add_control( 'socials', [
			'label'       => __( 'Social links', 'pfw' ),
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $rep->get_controls(),
			'title_field' => '{{{ label }}}',
			'default'     => [
				[ 'label' => 'Twitter',  'url' => [ 'url' => '#' ] ],
				[ 'label' => 'GitHub',   'url' => [ 'url' => '#' ] ],
				[ 'label' => 'Dribbble', 'url' => [ 'url' => '#' ] ],
			],
			'condition'   => [ 'source' => 'custom' ],
		] );

		$this->add_control( 'show_menu', [
			'label'   => __( 'Show footer menu', 'pfw' ),
			'type'    => \Elementor\Controls_Manager::SWITCHER,
			'default' => 'yes',
		] );
		$this->add_control( 'menu_id', [
			'label'   => __( 'Menu', 'pfw' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => '',
			'options' => $this->menu_options(),
			'condition' => [ 'show_menu' => 'yes' ],
		] );
		$this->add_control( 'show_widgets', [
			'label'   => __( 'Show Footer Widgets sidebar', 'pfw' ),
			'type'    => \Elementor\Controls_Manager::SWITCHER,
			'default' => 'yes',
		] );
		$this->end_controls_section();

		$this->start_controls_section( 'sec_style', [ 'label' => __( 'Style', 'pfw' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ] );
		$this->add_responsive_control( 'align', [
			'label' => __( 'Text alignment', 'pfw' ),
			'type' => \Elementor\Controls_Manager::CHOOSE,
			'options' => [
				'left' => [ 'title' => __( 'Left', 'pfw' ), 'icon' => 'eicon-text-align-left' ],
				'center' => [ 'title' => __( 'Center', 'pfw' ), 'icon' => 'eicon-text-align-center' ],
				'right' => [ 'title' => __( 'Right', 'pfw' ), 'icon' => 'eicon-text-align-right' ],
			],
			'default' => 'left',
			'selectors' => [ '{{WRAPPER}} .pfw-footer' => 'text-align: {{VALUE}};' ],
		] );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name' => 'brand_typo', 'label' => __( 'Brand typography', 'pfw' ), 'selector' => '{{WRAPPER}} .footer-brand',
		] );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name' => 'intro_typo', 'label' => __( 'Intro typography', 'pfw' ), 'selector' => '{{WRAPPER}} .footer-intro',
		] );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name' => 'widget_title_typo', 'label' => __( 'Widget title typography', 'pfw' ), 'selector' => '{{WRAPPER}} .footer-widget .widget-title',
		] );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name' => 'link_typo', 'label' => __( 'Menu/social typography', 'pfw' ), 'selector' => '{{WRAPPER}} .footer-nav a, {{WRAPPER}} .socials a',
		] );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name' => 'copyright_typo', 'label' => __( 'Copyright typography', 'pfw' ), 'selector' => '{{WRAPPER}} .footer-copyright',
		] );
		$this->add_responsive_control( 'logo_width', [
			'label' => __( 'Logo width', 'pfw' ),
			'type' => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'range' => [ 'px' => [ 'min' => 60, 'max' => 320 ], '%' => [ 'min' => 10, 'max' => 100 ] ],
			'selectors' => [ '{{WRAPPER}} .footer-logo' => 'max-width: {{SIZE}}{{UNIT}};' ],
		] );
		$this->add_responsive_control( 'logo_radius', [
			'label' => __( 'Logo/image radius', 'pfw' ),
			'type' => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'selectors' => [ '{{WRAPPER}} .footer-logo' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );
		$this->add_responsive_control( 'footer_padding', [
			'label' => __( 'Footer padding', 'pfw' ),
			'type' => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em', '%' ],
			'selectors' => [ '{{WRAPPER}} .pfw-footer' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );
		foreach ( [
			'bg' => [ 'label' => __( 'Background', 'pfw' ), 'var' => '--pf-footer-bg' ],
			'text' => [ 'label' => __( 'Text color', 'pfw' ), 'var' => '--pf-footer-text' ],
			'link' => [ 'label' => __( 'Link color', 'pfw' ), 'var' => '--pf-footer-link' ],
			'hover' => [ 'label' => __( 'Hover color', 'pfw' ), 'var' => '--pf-footer-link-hover' ],
			'border' => [ 'label' => __( 'Border color', 'pfw' ), 'var' => '--pf-footer-border' ],
			'widget_title' => [ 'label' => __( 'Widget title color', 'pfw' ), 'var' => '--pf-footer-widget-title' ],
		] as $key => $data ) {
			$this->add_control( $key . '_color', [
				'label' => $data['label'],
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [ '{{WRAPPER}} .pfw-footer' => $data['var'] . ': {{VALUE}};' ],
			] );
		}
		$this->end_controls_section();
	}

	private function local_socials( $settings ) {
		$socials = array();
		foreach ( (array) ( $settings['socials'] ?? array() ) as $row ) {
			$label = isset( $row['label'] ) ? sanitize_text_field( $row['label'] ) : '';
			$url   = ! empty( $row['url']['url'] ) ? esc_url_raw( $row['url']['url'] ) : '#';
			if ( $label ) $socials[] = array( 'label' => $label, 'url' => $url );
		}
		return $socials;
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		$use_customizer = ( $s['source'] ?? 'customizer' ) === 'customizer';
		$show_menu = ( $s['show_menu'] ?? 'yes' ) === 'yes';

		if ( $use_customizer ) {
			$logo      = get_theme_mod( 'customtheme_footer_logo', '' );
			$brand_primary = get_theme_mod( 'customtheme_footer_brand_primary', get_theme_mod( 'customtheme_brand_primary', get_bloginfo( 'name' ) ) );
			$brand_secondary = get_theme_mod( 'customtheme_footer_brand_secondary', get_theme_mod( 'customtheme_brand_secondary', '' ) );
			$intro     = get_theme_mod( 'customtheme_footer_intro', function_exists( 'customtheme_default_footer_intro' ) ? customtheme_default_footer_intro() : '' );
			$copyright = get_theme_mod( 'customtheme_footer_copyright', function_exists( 'customtheme_default_footer_copyright' ) ? customtheme_default_footer_copyright() : '© ' . gmdate( 'Y' ) . ' ' . get_bloginfo( 'name' ) );
			$default   = function_exists( 'customtheme_default_footer_socials_json' ) ? customtheme_default_footer_socials_json() : '[]';
			$raw       = get_theme_mod( 'customtheme_footer_socials', $default );
			$socials   = function_exists( 'customtheme_sanitize_socials' ) ? customtheme_sanitize_socials( $raw ) : array();
			$style     = function_exists( 'customtheme_footer_css_vars' ) ? customtheme_footer_css_vars() : '';
			if ( function_exists( 'customtheme_footer_menu_enabled' ) ) {
				$show_menu = $show_menu && customtheme_footer_menu_enabled();
			}
		} else {
			$logo      = ! empty( $s['logo']['url'] ) ? $s['logo']['url'] : '';
			$brand_primary = $s['brand_primary'] ?? get_bloginfo( 'name' );
			$brand_secondary = $s['brand_secondary'] ?? '';
			$intro     = $s['intro'] ?? '';
			$copyright = $s['copyright'] ?? '';
			$socials   = $this->local_socials( $s );
			$style     = '';
			if ( ! empty( $s['background_image']['url'] ) ) {
				$style = 'background-image:linear-gradient(rgba(8,2,26,.9),rgba(8,2,26,.9)),url(' . esc_url( $s['background_image']['url'] ) . ');background-size:cover;background-position:center';
			}
		}
		?>
		<footer class="site-footer pfw-footer"<?php echo $style ? ' style="' . esc_attr( $style ) . '"' : ''; ?>>
			<div class="container footer-main">
				<div class="footer-brand-block">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="footer-brand">
						<?php if ( $logo ) : ?>
							<img class="footer-logo" src="<?php echo esc_url( $logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
						<?php else : ?>
							<span class="gradient-text"><?php echo esc_html( $brand_primary ); ?></span><?php echo esc_html( $brand_secondary ); ?>
						<?php endif; ?>
					</a>
					<?php if ( $intro ) : ?><p class="footer-intro"><?php echo wp_kses_post( $intro ); ?></p><?php endif; ?>
				</div>

				<?php if ( ( $s['show_widgets'] ?? 'yes' ) === 'yes' && is_active_sidebar( 'footer-widgets' ) ) : ?>
					<div class="footer-widgets"><?php dynamic_sidebar( 'footer-widgets' ); ?></div>
				<?php endif; ?>
			</div>

			<div class="container footer-inner">
				<div class="footer-copyright"><?php echo wp_kses_post( $copyright ); ?></div>
				<?php
				if ( $show_menu ) {
					if ( ! empty( $s['menu_id'] ) ) {
						wp_nav_menu( [ 'menu' => (int) $s['menu_id'], 'container' => 'nav', 'container_class' => 'footer-nav', 'menu_class' => 'footer-menu', 'depth' => 1 ] );
					} elseif ( has_nav_menu( 'footer' ) ) {
						wp_nav_menu( [ 'theme_location' => 'footer', 'container' => 'nav', 'container_class' => 'footer-nav', 'menu_class' => 'footer-menu', 'depth' => 1 ] );
					}
				}
				?>
				<?php if ( ! empty( $socials ) ) : ?>
					<div class="socials">
						<?php foreach ( $socials as $social ) : ?>
							<a href="<?php echo esc_url( $social['url'] ); ?>" rel="noopener"><?php echo esc_html( $social['label'] ); ?></a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</footer>
		<?php
	}
}