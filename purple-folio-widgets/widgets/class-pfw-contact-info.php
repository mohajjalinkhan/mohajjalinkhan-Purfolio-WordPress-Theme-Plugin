<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class PFW_Contact_Info extends \Elementor\Widget_Base {

	public function get_name()      { return 'pfw_contact_info'; }
	public function get_title()     { return __( 'PF Contact Info', 'pfw' ); }
	public function get_icon()      { return 'eicon-info-box'; }
	public function get_categories(){ return [ 'purple-folio' ]; }

	protected function register_controls() {
		$this->start_controls_section( 'sec', [ 'label' => 'Contact items' ] );

		$rep = new \Elementor\Repeater();
		$rep->add_control( 'icon',  [ 'label' => 'Icon (emoji/char)', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '✉' ] );
		$rep->add_control( 'label', [ 'label' => 'Label',             'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Email' ] );
		$rep->add_control( 'value', [ 'label' => 'Value',             'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'hello@site.com' ] );
		$rep->add_control( 'link',  [ 'label' => 'Link (optional)',   'type' => \Elementor\Controls_Manager::URL,  'default' => [ 'url' => '' ] ] );

		$this->add_control( 'items', [
			'label' => 'Items', 'type' => \Elementor\Controls_Manager::REPEATER,
			'fields' => $rep->get_controls(),
			'title_field' => '{{{ label }}}: {{{ value }}}',
			'default' => [
				[ 'icon' => '✉',  'label' => 'Email',    'value' => 'hello@yousufzai.dev' ],
				[ 'icon' => '💬', 'label' => 'Discord',  'value' => '@yousufzai' ],
				[ 'icon' => '📍', 'label' => 'Based in', 'value' => 'Lisbon, Portugal' ],
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
			'selectors' => [ '{{WRAPPER}} .contact-item' => 'text-align: {{VALUE}};' ],
		] );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name' => 'label_typo', 'label' => 'Label', 'selector' => '{{WRAPPER}} .contact-item .eyebrow',
		] );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name' => 'value_typo', 'label' => 'Value', 'selector' => '{{WRAPPER}} .contact-item > div > div:last-child',
		] );
		$this->add_responsive_control( 'item_radius', [
			'label' => 'Item radius', 'type' => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'default' => [ 'top' => 15, 'right' => 15, 'bottom' => 15, 'left' => 15, 'unit' => 'px', 'isLinked' => true ],
			'selectors' => [ '{{WRAPPER}} .contact-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );
		$this->end_controls_section();
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		?>
		<div class="contact-list pfw-contact">
			<?php foreach ( (array) $s['items'] as $i => $it ) :
				$url = ! empty( $it['link']['url'] ) ? $it['link']['url'] : '';
				$inner = '<div class="icon-badge sm">' . esc_html( $it['icon'] ) . '</div>'
					. '<div><div class="eyebrow sm">' . esc_html( $it['label'] ) . '</div>'
					. '<div>' . esc_html( $it['value'] ) . '</div></div>';
				if ( $url ) {
					printf( '<a class="contact-item glass pfw-animate" style="transition-delay:%dms" href="%s">%s</a>', (int) ( $i * 80 ), esc_url( $url ), $inner );
				} else {
					printf( '<div class="contact-item glass pfw-animate" style="transition-delay:%dms">%s</div>', (int) ( $i * 80 ), $inner );
				}
			endforeach; ?>
		</div>
		<?php
	}
}
