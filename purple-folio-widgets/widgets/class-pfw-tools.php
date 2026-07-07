<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class PFW_Tools extends \Elementor\Widget_Base {
	public function get_name()      { return 'pfw_tools'; }
	public function get_title()     { return __( 'PF Tools', 'pfw' ); }
	public function get_icon()      { return 'eicon-tools'; }
	public function get_categories(){ return [ 'purple-folio' ]; }
	public function get_keywords()  { return [ 'tools', 'stack', 'chips', 'tags' ]; }

	protected function register_controls() {
		$this->start_controls_section( 'sec_head', [ 'label' => 'Heading' ] );
		$this->add_control( 'eyebrow', [ 'label' => 'Eyebrow', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'The stack' ] );
		$this->add_control( 'title',   [ 'label' => 'Title',   'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Tools of the trade.' ] );
		$this->end_controls_section();

		$this->start_controls_section( 'sec_items', [ 'label' => 'Chips' ] );
		$rep = new \Elementor\Repeater();
		$rep->add_control( 'label', [ 'label' => 'Label', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'WordPress' ] );
		$this->add_control( 'items', [
			'label' => 'Chips', 'type' => \Elementor\Controls_Manager::REPEATER,
			'fields' => $rep->get_controls(), 'title_field' => '{{{ label }}}',
			'default' => [
				[ 'label' => 'WordPress' ], [ 'label' => 'PHP 8+' ], [ 'label' => 'WPGraphQL' ],
				[ 'label' => 'ACF Pro' ],   [ 'label' => 'Next.js' ], [ 'label' => 'React' ],
				[ 'label' => 'TypeScript' ],[ 'label' => 'Tailwind' ],[ 'label' => 'WooCommerce' ],
				[ 'label' => 'MySQL' ],     [ 'label' => 'Docker' ],  [ 'label' => 'Cloudflare' ],
			],
		] );
		$this->end_controls_section();

		$this->start_controls_section( 'sec_style', [ 'label' => 'Style', 'tab' => \Elementor\Controls_Manager::TAB_STYLE ] );
		$this->add_control( 'text_align', [
			'label' => 'Text alignment', 'type' => \Elementor\Controls_Manager::CHOOSE,
			'options' => [
				'left' => [ 'title' => 'Left', 'icon' => 'eicon-text-align-left' ],
				'center' => [ 'title' => 'Center', 'icon' => 'eicon-text-align-center' ],
				'right' => [ 'title' => 'Right', 'icon' => 'eicon-text-align-right' ],
			],
			'default' => 'left',
			'selectors' => [ '{{WRAPPER}} .pfw-tools' => 'text-align: {{VALUE}};' ],
		] );
		$this->add_responsive_control( 'chips_justify', [
			'label' => 'Chips alignment', 'type' => \Elementor\Controls_Manager::CHOOSE,
			'options' => [
				'flex-start' => [ 'title' => 'Left', 'icon' => 'eicon-h-align-left' ],
				'center' => [ 'title' => 'Center', 'icon' => 'eicon-h-align-center' ],
				'flex-end' => [ 'title' => 'Right', 'icon' => 'eicon-h-align-right' ],
			],
			'default' => 'flex-start',
			'selectors' => [ '{{WRAPPER}} .pfw-chips' => 'justify-content: {{VALUE}};' ],
		] );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name' => 'eyebrow_typo', 'label' => 'Eyebrow', 'selector' => '{{WRAPPER}} .pfw-tools .eyebrow',
		] );
		$this->add_control( 'eyebrow_color', [ 'label' => 'Eyebrow color', 'type' => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .pfw-tools .eyebrow' => 'color: {{VALUE}};' ] ] );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name' => 'title_typo', 'selector' => '{{WRAPPER}} .pfw-tools h2',
		] );
		$this->add_control( 'chip_bg', [
			'label' => 'Chip background', 'type' => \Elementor\Controls_Manager::COLOR,
			'default' => 'rgba(255,255,255,0.05)',
			'selectors' => [ '{{WRAPPER}} .pfw-chip' => 'background: {{VALUE}};' ],
		] );
		$this->add_control( 'chip_color', [
			'label' => 'Chip text', 'type' => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .pfw-chip' => 'color: {{VALUE}};' ],
		] );
		$this->add_responsive_control( 'chip_radius', [
			'label' => 'Chip radius', 'type' => \Elementor\Controls_Manager::SLIDER,
			'range' => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
			'default' => [ 'size' => 999, 'unit' => 'px' ],
			'selectors' => [ '{{WRAPPER}} .pfw-chip' => 'border-radius: {{SIZE}}{{UNIT}};' ],
		] );
		$this->end_controls_section();
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		?>
		<section class="section pfw-tools">
			<?php if ( $s['eyebrow'] ) : ?><div class="eyebrow"><?php echo esc_html( $s['eyebrow'] ); ?></div><?php endif; ?>
			<?php if ( $s['title'] ) : ?><h2 class="display"><?php echo esc_html( $s['title'] ); ?></h2><?php endif; ?>
			<div class="pfw-chips" style="display:flex;flex-wrap:wrap;gap:10px;margin-top:24px;">
				<?php foreach ( (array) $s['items'] as $i => $item ) : ?>
					<span class="pfw-chip pfw-fade-up" style="display:inline-flex;align-items:center;padding:10px 18px;border:1px solid rgba(255,255,255,0.1);font-size:14px;transition-delay: <?php echo (int)($i*45); ?>ms;">
						<?php echo esc_html( $item['label'] ); ?>
					</span>
				<?php endforeach; ?>
			</div>
		</section>
		<?php
	}
}
