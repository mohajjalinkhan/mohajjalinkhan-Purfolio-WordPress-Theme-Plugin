<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class PFW_Stats extends \Elementor\Widget_Base {

	public function get_name()      { return 'pfw_stats'; }
	public function get_title()     { return __( 'PF Stats', 'pfw' ); }
	public function get_icon()      { return 'eicon-counter'; }
	public function get_categories(){ return [ 'purple-folio' ]; }

	protected function register_controls() {
		$this->start_controls_section( 'sec', [ 'label' => 'Stats' ] );

		$rep = new \Elementor\Repeater();
		$rep->add_control( 'number', [ 'label' => 'Number', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '80' ] );
		$rep->add_control( 'suffix', [ 'label' => 'Suffix', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '+' ] );
		$rep->add_control( 'label',  [ 'label' => 'Label',  'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Sites shipped' ] );

		$this->add_control( 'items', [
			'label' => 'Stat items', 'type' => \Elementor\Controls_Manager::REPEATER,
			'fields' => $rep->get_controls(),
			'title_field' => '{{{ number }}}{{{ suffix }}} — {{{ label }}}',
			'default' => [
				[ 'number' => '80',  'suffix' => '+', 'label' => 'Sites shipped' ],
				[ 'number' => '9',   'suffix' => 'y', 'label' => 'In WordPress' ],
				[ 'number' => '100', 'suffix' => '',  'label' => 'Lighthouse avg' ],
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
			'selectors' => [ '{{WRAPPER}} .pfw-stats' => 'text-align: {{VALUE}};' ],
		] );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name' => 'num_typo', 'label' => 'Number', 'selector' => '{{WRAPPER}} .stat-num',
		] );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name' => 'label_typo', 'label' => 'Label', 'selector' => '{{WRAPPER}} .stat-label',
		] );
		$this->add_control( 'label_color', [ 'label' => 'Label color', 'type' => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .stat-label' => 'color: {{VALUE}};' ] ] );
		$this->end_controls_section();
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		?>
		<div class="stats pfw-stats">
			<?php foreach ( (array) $s['items'] as $it ) : ?>
				<div class="stat">
					<div class="stat-num gradient-text" data-count="<?php echo esc_attr( $it['number'] ); ?>" data-suffix="<?php echo esc_attr( $it['suffix'] ); ?>">0</div>
					<div class="stat-label"><?php echo esc_html( $it['label'] ); ?></div>
				</div>
			<?php endforeach; ?>
		</div>
		<?php
	}
}
