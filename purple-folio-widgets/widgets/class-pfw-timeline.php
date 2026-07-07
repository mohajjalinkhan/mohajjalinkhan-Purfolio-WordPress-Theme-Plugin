<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class PFW_Timeline extends \Elementor\Widget_Base {
	public function get_name()      { return 'pfw_timeline'; }
	public function get_title()     { return __( 'PF Timeline (Short story)', 'pfw' ); }
	public function get_icon()      { return 'eicon-time-line'; }
	public function get_categories(){ return [ 'purple-folio' ]; }
	public function get_keywords()  { return [ 'timeline', 'story', 'history' ]; }

	protected function register_controls() {
		$this->start_controls_section( 'sec_head', [ 'label' => 'Heading' ] );
		$this->add_control( 'eyebrow', [ 'label' => 'Eyebrow', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Timeline' ] );
		$this->add_control( 'title',   [ 'label' => 'Title',   'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'A short story.' ] );
		$this->end_controls_section();

		$this->start_controls_section( 'sec_items', [ 'label' => 'Milestones' ] );
		$rep = new \Elementor\Repeater();
		$rep->add_control( 'year',  [ 'label' => 'Year',        'type' => \Elementor\Controls_Manager::TEXT, 'default' => '2026' ] );
		$rep->add_control( 'title', [ 'label' => 'Title',       'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Independent Studio' ] );
		$rep->add_control( 'desc',  [ 'label' => 'Description', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Full-time freelance work with founders, agencies and studios across 12 countries.' ] );

		$this->add_control( 'items', [
			'label' => 'Milestones', 'type' => \Elementor\Controls_Manager::REPEATER,
			'fields' => $rep->get_controls(), 'title_field' => '{{{ year }}} — {{{ title }}}',
			'default' => [
				[ 'year' => '2026', 'title' => 'Independent Studio',  'desc' => 'Full-time freelance work with founders, agencies and studios across 12 countries.' ],
				[ 'year' => '2023', 'title' => 'Headless WordPress',  'desc' => 'Started shipping decoupled builds with Next.js + WPGraphQL as a default stack.' ],
				[ 'year' => '2020', 'title' => 'Senior WP Engineer',  'desc' => 'Led theme + plugin engineering at a boutique digital agency in Berlin.' ],
				[ 'year' => '2017', 'title' => 'First Custom Theme',  'desc' => 'Fell into WordPress development, never looked back.' ],
			],
		] );
		$this->end_controls_section();

		$this->start_controls_section( 'sec_style', [ 'label' => 'Style', 'tab' => \Elementor\Controls_Manager::TAB_STYLE ] );
		$this->add_control( 'heading_align', [
			'label' => 'Heading alignment', 'type' => \Elementor\Controls_Manager::CHOOSE,
			'options' => [
				'left' => [ 'title' => 'Left', 'icon' => 'eicon-text-align-left' ],
				'center' => [ 'title' => 'Center', 'icon' => 'eicon-text-align-center' ],
				'right' => [ 'title' => 'Right', 'icon' => 'eicon-text-align-right' ],
			],
			'default' => 'left',
			'selectors' => [ '{{WRAPPER}} .pfw-timeline > .eyebrow, {{WRAPPER}} .pfw-timeline > h2' => 'text-align: {{VALUE}};' ],
		] );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name' => 'eyebrow_typo', 'label' => 'Eyebrow', 'selector' => '{{WRAPPER}} .pfw-timeline > .eyebrow',
		] );
		$this->add_control( 'eyebrow_color', [ 'label' => 'Eyebrow color', 'type' => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .pfw-timeline > .eyebrow' => 'color: {{VALUE}};' ] ] );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name' => 'heading_typo', 'label' => 'Heading typography', 'selector' => '{{WRAPPER}} .pfw-timeline > h2',
		] );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name' => 'item_title_typo', 'label' => 'Milestone title', 'selector' => '{{WRAPPER}} .pfw-tl-card h3',
		] );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name' => 'item_desc_typo', 'label' => 'Milestone text', 'selector' => '{{WRAPPER}} .pfw-tl-card p',
		] );
		$this->add_control( 'year_color', [
			'label' => 'Year color', 'type' => \Elementor\Controls_Manager::COLOR,
			'default' => '#e879f9',
			'selectors' => [ '{{WRAPPER}} .pfw-tl-year' => 'color: {{VALUE}};' ],
		] );
		$this->add_control( 'line_color', [
			'label' => 'Line color', 'type' => \Elementor\Controls_Manager::COLOR,
			'default' => '#a855f7',
			'selectors' => [ '{{WRAPPER}} .pfw-tl-rail' => 'background: {{VALUE}};', '{{WRAPPER}} .pfw-tl-dot' => 'background: {{VALUE}};' ],
		] );
		$this->add_responsive_control( 'card_gap', [
			'label' => 'Row gap', 'type' => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em' ],
			'range' => [ 'px' => [ 'min' => 8, 'max' => 120 ], 'em' => [ 'min' => 1, 'max' => 8 ] ],
			'selectors' => [ '{{WRAPPER}} .pfw-tl-row' => 'margin-bottom: {{SIZE}}{{UNIT}};' ],
		] );
		$this->add_responsive_control( 'section_padding', [
			'label' => 'Section padding', 'type' => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em', '%' ],
			'selectors' => [ '{{WRAPPER}} .pfw-timeline' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );
		$this->end_controls_section();
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		?>
		<section class="section pfw-timeline">
			<?php if ( $s['eyebrow'] ) : ?><div class="eyebrow"><?php echo esc_html( $s['eyebrow'] ); ?></div><?php endif; ?>
			<?php if ( $s['title'] ) : ?><h2 class="display"><?php echo esc_html( $s['title'] ); ?></h2><?php endif; ?>

			<div class="pfw-tl">
				<div class="pfw-tl-rail"></div>
				<?php foreach ( (array) $s['items'] as $i => $item ) :
					$side = ( $i % 2 === 0 ) ? 'left' : 'right'; ?>
					<div class="pfw-tl-row pfw-tl-<?php echo esc_attr( $side ); ?> pfw-animate" style="transition-delay:<?php echo (int) ( $i * 120 ); ?>ms;">
						<?php if ( $side === 'left' ) : ?>
							<div class="pfw-tl-card">
								<div class="pfw-tl-year gradient-text"><?php echo esc_html( $item['year'] ); ?></div>
								<h3><?php echo esc_html( $item['title'] ); ?></h3>
								<p><?php echo esc_html( $item['desc'] ); ?></p>
							</div>
							<div class="pfw-tl-mid"><span class="pfw-tl-dot"></span></div>
							<div></div>
						<?php else : ?>
							<div></div>
							<div class="pfw-tl-mid"><span class="pfw-tl-dot"></span></div>
							<div class="pfw-tl-card">
								<div class="pfw-tl-year gradient-text"><?php echo esc_html( $item['year'] ); ?></div>
								<h3><?php echo esc_html( $item['title'] ); ?></h3>
								<p><?php echo esc_html( $item['desc'] ); ?></p>
							</div>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
		</section>
		<?php
	}
}
