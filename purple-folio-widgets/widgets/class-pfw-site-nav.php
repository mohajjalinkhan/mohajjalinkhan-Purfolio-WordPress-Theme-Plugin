<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
	 * PF Site Nav — drops the theme's header/nav (logo + primary menu + CTA)
 * anywhere in Elementor. Useful when a page uses Elementor Canvas.
 */
class PFW_Site_Nav extends \Elementor\Widget_Base {

	public function get_name()      { return 'pfw_site_nav'; }
	public function get_title()     { return __( 'PF Site Nav', 'pfw' ); }
	public function get_icon()      { return 'eicon-nav-menu'; }
	public function get_categories(){ return [ 'purple-folio' ]; }
	public function get_keywords()  { return [ 'nav', 'menu', 'header', 'navigation' ]; }

	protected function register_controls() {
		$this->start_controls_section( 'sec', [ 'label' => 'Menu' ] );

		$menus = wp_get_nav_menus();
		$opts  = [ '' => __( '— Use theme location —', 'pfw' ) ];
		foreach ( $menus as $m ) { $opts[ $m->term_id ] = $m->name; }

		$this->add_control( 'menu_id', [
			'label'   => __( 'Menu', 'pfw' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => '',
			'options' => $opts,
			'description' => __( 'Pick a menu, or leave empty to use whatever is assigned to the "Primary Menu" location.', 'pfw' ),
		] );

		$this->add_control( 'show_cta', [
			'label' => __( 'Show CTA button', 'pfw' ),
			'type'  => \Elementor\Controls_Manager::SWITCHER,
			'default' => 'yes',
		] );

		$this->add_control( 'cta_label', [ 'label' => 'CTA label', 'type' => \Elementor\Controls_Manager::TEXT,
			'default' => "Let's Talk", 'condition' => [ 'show_cta' => 'yes' ] ] );
		$this->add_control( 'cta_link', [ 'label' => 'CTA link', 'type' => \Elementor\Controls_Manager::URL,
			'default' => [ 'url' => '/contact' ], 'condition' => [ 'show_cta' => 'yes' ] ] );

		$this->end_controls_section();

		$this->start_controls_section( 'sec_style', [ 'label' => 'Style', 'tab' => \Elementor\Controls_Manager::TAB_STYLE ] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name' => 'link_typo', 'label' => 'Menu link typography',
			'selector' => '{{WRAPPER}} .nav-desktop-menu a, {{WRAPPER}} .nav-mobile-menu a',
		] );
		$this->add_control( 'link_color', [ 'label' => 'Menu link color', 'type' => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .nav-desktop-menu a, {{WRAPPER}} .nav-mobile-menu a' => 'color: {{VALUE}};' ] ] );

		$this->end_controls_section();
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		?>
		<header class="site-header pfw-site-nav" style="position:relative;padding:0;">
			<div class="container header-inner">
				<?php if ( function_exists( 'customtheme_render_brand' ) ) customtheme_render_brand(); ?>

				<?php
				$args = [
					'container'       => 'nav',
					'container_class' => 'nav-desktop',
					'menu_class'      => 'nav-desktop-menu',
					'depth'           => 1,
					'fallback_cb'     => function_exists( 'customtheme_default_menu' ) ? 'customtheme_default_menu' : false,
				];
				if ( ! empty( $s['menu_id'] ) ) {
					$args['menu'] = (int) $s['menu_id'];
				} else {
					$args['theme_location'] = 'primary';
				}
				wp_nav_menu( $args );
				?>

				<?php if ( $s['show_cta'] === 'yes' && ! empty( $s['cta_label'] ) ) :
					$url = ! empty( $s['cta_link']['url'] ) ? $s['cta_link']['url'] : '#';
				?>
					<a href="<?php echo esc_url( $url ); ?>" class="btn btn-primary btn-sm nav-cta">
						<?php echo esc_html( $s['cta_label'] ); ?>
					</a>
				<?php endif; ?>

				<button class="menu-toggle" aria-controls="pfwNavMobile-<?php echo esc_attr( $this->get_id() ); ?>" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle menu', 'pfw' ); ?>">
					<span></span><span></span><span></span>
				</button>
			</div>

			<?php
			$mobile_args = [
				'container'       => 'nav',
				'container_id'    => 'pfwNavMobile-' . $this->get_id(),
				'container_class' => 'nav-mobile glass',
				'menu_class'      => 'nav-mobile-menu',
				'depth'           => 1,
				'fallback_cb'     => function_exists( 'customtheme_default_menu' ) ? 'customtheme_default_menu' : false,
			];
			if ( ! empty( $s['menu_id'] ) ) {
				$mobile_args['menu'] = (int) $s['menu_id'];
			} else {
				$mobile_args['theme_location'] = 'primary_mobile';
			}
			wp_nav_menu( $mobile_args );
			?>
		</header>
		<?php
	}
}
