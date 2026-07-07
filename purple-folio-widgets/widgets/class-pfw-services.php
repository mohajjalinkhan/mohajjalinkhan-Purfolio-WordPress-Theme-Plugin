<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class PFW_Services extends \Elementor\Widget_Base {

	public function get_name()      { return 'pfw_services'; }
	public function get_title()     { return __( 'PF Services', 'pfw' ); }
	public function get_icon()      { return 'eicon-icon-box'; }
	public function get_categories(){ return [ 'purple-folio' ]; }

	protected function register_controls() {
		/* ---------- Content ---------- */
		$this->start_controls_section( 'sec_head', [ 'label' => __( 'Heading', 'pfw' ) ] );
		$this->add_control( 'eyebrow',         [ 'label' => 'Eyebrow',           'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'What I do' ] );
		$this->add_control( 'title_before',    [ 'label' => 'Title (start)',     'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Services built for' ] );
		$this->add_control( 'title_highlight', [ 'label' => 'Highlighted words', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'modern WordPress' ] );
		$this->add_control( 'title_after',     [ 'label' => 'Title (end)',       'type' => \Elementor\Controls_Manager::TEXT, 'default' => '.' ] );
		$this->add_control( 'columns', [
			'label' => 'Columns', 'type' => \Elementor\Controls_Manager::SELECT,
			'default' => '3', 'options' => [ '2' => '2', '3' => '3', '4' => '4' ],
		] );
		$this->end_controls_section();

		$this->start_controls_section( 'sec_items', [ 'label' => __( 'Services', 'pfw' ) ] );
		$rep = new \Elementor\Repeater();
		$rep->add_control( 'icon',  [ 'label' => 'Icon (emoji/char)', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '◇' ] );
		$rep->add_control( 'image', [ 'label' => 'Icon image (optional)', 'type' => \Elementor\Controls_Manager::MEDIA ] );
		$rep->add_control( 'title', [ 'label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Custom Themes' ] );
		$rep->add_control( 'desc',  [ 'label' => 'Description', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Bespoke, block-based themes engineered around your brand.' ] );

		$this->add_control( 'items', [
			'label'       => __( 'Service cards', 'pfw' ),
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $rep->get_controls(),
			'title_field' => '{{{ title }}}',
			'default'     => [
				[ 'icon' => '◇', 'title' => 'Custom Themes',      'desc' => 'Bespoke, block-based themes engineered around your brand — no bloat.' ],
				[ 'icon' => '⚡', 'title' => 'Headless WordPress', 'desc' => 'Decoupled architectures with Next.js or Astro powered by WP REST & GraphQL.' ],
				[ 'icon' => '◉', 'title' => 'WooCommerce',        'desc' => 'Fast, conversion-focused stores with custom checkout flows.' ],
			],
		] );
		$this->end_controls_section();

		/* ---------- Style ---------- */
		$this->start_controls_section( 'sec_style', [ 'label' => 'Style', 'tab' => \Elementor\Controls_Manager::TAB_STYLE ] );

		$this->add_control( 'text_align', [
			'label' => 'Text alignment', 'type' => \Elementor\Controls_Manager::CHOOSE,
			'options' => [
				'left' => [ 'title' => 'Left', 'icon' => 'eicon-text-align-left' ],
				'center' => [ 'title' => 'Center', 'icon' => 'eicon-text-align-center' ],
				'right' => [ 'title' => 'Right', 'icon' => 'eicon-text-align-right' ],
			],
			'default' => 'left',
			'selectors' => [ '{{WRAPPER}} .section-head, {{WRAPPER}} .card' => 'text-align: {{VALUE}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name' => 'eyebrow_typo', 'label' => 'Eyebrow', 'selector' => '{{WRAPPER}} .section-head .eyebrow',
		] );
		$this->add_control( 'eyebrow_color', [ 'label' => 'Eyebrow color', 'type' => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .section-head .eyebrow' => 'color: {{VALUE}};' ] ] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name' => 'title_typo', 'label' => 'Section title', 'selector' => '{{WRAPPER}} .section-head h2',
		] );
		$this->add_control( 'title_color', [ 'label' => 'Title color', 'type' => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .section-head h2' => 'color: {{VALUE}};' ] ] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name' => 'card_title_typo', 'label' => 'Card title', 'selector' => '{{WRAPPER}} .card h3',
		] );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name' => 'card_body_typo', 'label' => 'Card body', 'selector' => '{{WRAPPER}} .card p',
		] );

		$this->add_responsive_control( 'card_radius', [
			'label' => 'Card radius', 'type' => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'default' => [ 'top' => 20, 'right' => 20, 'bottom' => 20, 'left' => 20, 'unit' => 'px', 'isLinked' => true ],
			'selectors' => [ '{{WRAPPER}} .card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'icon_size', [
			'label' => 'Icon size', 'type' => \Elementor\Controls_Manager::SLIDER,
			'range' => [ 'px' => [ 'min' => 24, 'max' => 120 ] ],
			'selectors' => [
				'{{WRAPPER}} .icon-badge' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; font-size: calc({{SIZE}}{{UNIT}} * .5);',
			],
		] );

		$this->end_controls_section();
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		$col_class = 'grid-' . ( in_array( $s['columns'], [ '2', '3', '4' ], true ) ? $s['columns'] : '3' );
		?>
		<section class="section pfw-services">
			<div class="section-head pfw-animate">
				<div class="eyebrow"><?php echo esc_html( $s['eyebrow'] ); ?></div>
				<h2>
					<?php echo esc_html( $s['title_before'] ); ?>
					<span class="gradient-text"> <?php echo esc_html( $s['title_highlight'] ); ?> </span><?php echo esc_html( $s['title_after'] ); ?>
				</h2>
			</div>
			<div class="grid <?php echo esc_attr( $col_class ); ?>">
				<?php foreach ( (array) $s['items'] as $i => $item ) : ?>
					<article class="card glass pfw-animate" style="transition-delay:<?php echo (int) ( $i * 90 ); ?>ms;">
						<div class="icon-badge">
							<?php if ( ! empty( $item['image']['url'] ) ) : ?>
								<img src="<?php echo esc_url( $item['image']['url'] ); ?>" alt="" style="width:60%;height:60%;object-fit:contain;" />
							<?php else : ?>
								<?php echo esc_html( $item['icon'] ); ?>
							<?php endif; ?>
						</div>
						<h3><?php echo esc_html( $item['title'] ); ?></h3>
						<p><?php echo esc_html( $item['desc'] ); ?></p>
					</article>
				<?php endforeach; ?>
			</div>
		</section>
		<?php
	}
}
