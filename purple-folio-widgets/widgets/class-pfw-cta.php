<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class PFW_CTA extends \Elementor\Widget_Base {

	public function get_name()      { return 'pfw_cta'; }
	public function get_title()     { return __( 'PF CTA Banner', 'pfw' ); }
	public function get_icon()      { return 'eicon-call-to-action'; }
	public function get_categories(){ return [ 'purple-folio' ]; }

	protected function register_controls() {
		$this->start_controls_section( 'sec', [ 'label' => 'CTA' ] );
		$this->add_control( 'title_before',    [ 'label' => 'Title (start)',     'type' => \Elementor\Controls_Manager::TEXT,     'default' => 'Ready to build something' ] );
		$this->add_control( 'title_highlight', [ 'label' => 'Highlighted words', 'type' => \Elementor\Controls_Manager::TEXT,     'default' => 'extraordinary?' ] );
		$this->add_control( 'title_after',     [ 'label' => 'Title (end)',       'type' => \Elementor\Controls_Manager::TEXT,     'default' => '' ] );
		$this->add_control( 'desc',            [ 'label' => 'Description',       'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => "Let's turn your idea into a fast, beautiful WordPress site." ] );
		$this->add_control( 'btn_label',       [ 'label' => 'Button label',      'type' => \Elementor\Controls_Manager::TEXT,     'default' => 'Get in touch →' ] );
		$this->add_control( 'btn_link',        [ 'label' => 'Button link',       'type' => \Elementor\Controls_Manager::URL,      'default' => [ 'url' => '/contact' ] ] );
		$this->end_controls_section();

		$this->start_controls_section( 'sec_style', [ 'label' => 'Style', 'tab' => \Elementor\Controls_Manager::TAB_STYLE ] );

		$this->add_control( 'text_align', [
			'label' => 'Text alignment', 'type' => \Elementor\Controls_Manager::CHOOSE,
			'options' => [
				'left' => [ 'title' => 'Left', 'icon' => 'eicon-text-align-left' ],
				'center' => [ 'title' => 'Center', 'icon' => 'eicon-text-align-center' ],
				'right' => [ 'title' => 'Right', 'icon' => 'eicon-text-align-right' ],
			],
			'default' => 'center',
			'selectors' => [ '{{WRAPPER}} .cta' => 'text-align: {{VALUE}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name' => 'title_typo', 'label' => 'Title', 'selector' => '{{WRAPPER}} .cta h2',
		] );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name' => 'body_typo', 'label' => 'Body', 'selector' => '{{WRAPPER}} .cta p',
		] );

		$this->add_responsive_control( 'radius', [
			'label' => 'Border radius', 'type' => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'default' => [ 'top' => 32, 'right' => 32, 'bottom' => 32, 'left' => 32, 'unit' => 'px', 'isLinked' => true ],
			'selectors' => [ '{{WRAPPER}} .cta' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'padding', [
			'label' => 'Padding', 'type' => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em', '%' ],
			'selectors' => [ '{{WRAPPER}} .cta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->end_controls_section();
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		$url = ! empty( $s['btn_link']['url'] ) ? $s['btn_link']['url'] : '#';
		?>
		<section class="cta glass pfw-cta pfw-animate">
			<div class="cta-glow"></div>
			<div class="cta-inner">
				<h2>
					<?php echo esc_html( $s['title_before'] ); ?>
					<span class="gradient-text"> <?php echo esc_html( $s['title_highlight'] ); ?> </span>
					<?php echo esc_html( $s['title_after'] ); ?>
				</h2>
				<p><?php echo esc_html( $s['desc'] ); ?></p>
				<a href="<?php echo esc_url( $url ); ?>" class="btn btn-primary"><?php echo esc_html( $s['btn_label'] ); ?></a>
			</div>
		</section>
		<?php
	}
}
