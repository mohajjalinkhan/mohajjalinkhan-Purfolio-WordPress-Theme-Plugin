<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class PFW_Projects extends \Elementor\Widget_Base {

	public function get_name()      { return 'pfw_projects'; }
	public function get_title()     { return __( 'PF Projects', 'pfw' ); }
	public function get_icon()      { return 'eicon-gallery-grid'; }
	public function get_categories(){ return [ 'purple-folio' ]; }

	protected function register_controls() {
		$this->start_controls_section( 'sec_head', [ 'label' => 'Heading' ] );
		$this->add_control( 'eyebrow',       [ 'label' => 'Eyebrow', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Selected work' ] );
		$this->add_control( 'title',         [ 'label' => 'Title',   'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Recent projects' ] );
		$this->add_control( 'see_all_label', [ 'label' => 'See-all label', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'See all →' ] );
		$this->add_control( 'see_all_link',  [ 'label' => 'See-all link',  'type' => \Elementor\Controls_Manager::URL,  'default' => [ 'url' => '/work' ] ] );
		$this->add_control( 'columns', [
			'label' => 'Columns', 'type' => \Elementor\Controls_Manager::SELECT,
			'default' => '3', 'options' => [ '2' => '2', '3' => '3', '4' => '4' ],
		] );
		$this->end_controls_section();

		$this->start_controls_section( 'sec_items', [ 'label' => 'Projects' ] );
		$rep = new \Elementor\Repeater();
		$rep->add_control( 'image', [ 'label' => 'Image', 'type' => \Elementor\Controls_Manager::MEDIA, 'default' => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ] ] );
		$rep->add_control( 'category', [ 'label' => 'Category', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Custom Theme' ] );
		$rep->add_control( 'title',    [ 'label' => 'Title',    'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Halcyon Studio' ] );
		$rep->add_control( 'link',     [ 'label' => 'Link',     'type' => \Elementor\Controls_Manager::URL,  'default' => [ 'url' => '#' ] ] );

		$this->add_control( 'items', [
			'label' => 'Projects', 'type' => \Elementor\Controls_Manager::REPEATER,
			'fields' => $rep->get_controls(), 'title_field' => '{{{ title }}}',
			'default' => [
				[ 'category' => 'Custom Theme', 'title' => 'Halcyon Studio' ],
				[ 'category' => 'Headless WP',  'title' => 'Ribbon FM' ],
				[ 'category' => 'WooCommerce',  'title' => 'Orbit Commerce' ],
			],
		] );
		$this->end_controls_section();

		/* ---------- Style ---------- */
		$this->start_controls_section( 'sec_style', [ 'label' => 'Style', 'tab' => \Elementor\Controls_Manager::TAB_STYLE ] );

		$this->add_control( 'heading_align', [
			'label' => 'Heading alignment', 'type' => \Elementor\Controls_Manager::CHOOSE,
			'options' => [
				'left' => [ 'title' => 'Left', 'icon' => 'eicon-text-align-left' ],
				'center' => [ 'title' => 'Center', 'icon' => 'eicon-text-align-center' ],
				'right' => [ 'title' => 'Right', 'icon' => 'eicon-text-align-right' ],
			],
			'default' => 'left',
			'selectors' => [ '{{WRAPPER}} .section-head-row > div' => 'text-align: {{VALUE}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name' => 'eyebrow_typo', 'label' => 'Eyebrow', 'selector' => '{{WRAPPER}} .section-head-row .eyebrow, {{WRAPPER}} .project-meta .eyebrow',
		] );
		$this->add_control( 'eyebrow_color', [ 'label' => 'Eyebrow color', 'type' => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .section-head-row .eyebrow, {{WRAPPER}} .project-meta .eyebrow' => 'color: {{VALUE}};' ] ] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name' => 'title_typo', 'label' => 'Section title', 'selector' => '{{WRAPPER}} .section-head-row h2',
		] );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name' => 'proj_title_typo', 'label' => 'Project title', 'selector' => '{{WRAPPER}} .project-title',
		] );

		$this->add_group_control( \Elementor\Group_Control_Image_Size::get_type(), [
			'name' => 'thumb_size', 'default' => 'large',
		] );

		$this->add_responsive_control( 'card_radius', [
			'label' => 'Card radius', 'type' => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'default' => [ 'top' => 20, 'right' => 20, 'bottom' => 20, 'left' => 20, 'unit' => 'px', 'isLinked' => true ],
			'selectors' => [ '{{WRAPPER}} .project' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'card_ratio', [
			'label' => 'Card ratio (w/h)', 'type' => \Elementor\Controls_Manager::SLIDER,
			'range' => [ 'px' => [ 'min' => 0.5, 'max' => 2, 'step' => 0.05 ] ],
			'default' => [ 'size' => 0.8, 'unit' => 'px' ],
			'selectors' => [ '{{WRAPPER}} .project' => 'aspect-ratio: {{SIZE}} / 1;' ],
		] );

		$this->end_controls_section();
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		$col_class = 'grid-' . ( in_array( $s['columns'], [ '2', '3', '4' ], true ) ? $s['columns'] : '3' );
		$see_url = ! empty( $s['see_all_link']['url'] ) ? $s['see_all_link']['url'] : '#';
		?>
		<section class="section pfw-projects">
			<div class="section-head-row pfw-animate">
				<div>
					<div class="eyebrow"><?php echo esc_html( $s['eyebrow'] ); ?></div>
					<h2><?php echo esc_html( $s['title'] ); ?></h2>
				</div>
				<?php if ( $s['see_all_label'] ) : ?>
					<a href="<?php echo esc_url( $see_url ); ?>" class="see-all"><?php echo esc_html( $s['see_all_label'] ); ?></a>
				<?php endif; ?>
			</div>
			<div class="grid <?php echo esc_attr( $col_class ); ?>">
				<?php foreach ( (array) $s['items'] as $index => $item ) :
					$url = ! empty( $item['link']['url'] ) ? $item['link']['url'] : '#';
					// Build image via Image_Size group control per-item
					$img_html = '';
					if ( ! empty( $item['image']['url'] ) ) {
						$scope = $s;
						$scope['thumb_size_size'] = isset( $s['thumb_size_size'] ) ? $s['thumb_size_size'] : 'large';
						$scope['image'] = $item['image'];
						$img_html = \Elementor\Group_Control_Image_Size::get_attachment_image_html( $scope, 'thumb_size', 'image' );
						if ( ! $img_html ) {
							$img_html = '<img src="' . esc_url( $item['image']['url'] ) . '" alt="' . esc_attr( $item['title'] ) . '" />';
						}
					}
				?>
					<a href="<?php echo esc_url( $url ); ?>" class="project glass pfw-animate" style="transition-delay:<?php echo (int) ( $index * 90 ); ?>ms;">
						<?php echo $img_html; // already escaped ?>
						<div class="project-meta">
							<span class="eyebrow"><?php echo esc_html( $item['category'] ); ?></span>
							<span class="project-title"><?php echo esc_html( $item['title'] ); ?></span>
						</div>
					</a>
				<?php endforeach; ?>
			</div>
		</section>
		<?php
	}
}
