<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class PFW_Hero extends \Elementor\Widget_Base {

	public function get_name()      { return 'pfw_hero'; }
	public function get_title()     { return __( 'PF Hero', 'pfw' ); }
	public function get_icon()      { return 'eicon-banner'; }
	public function get_categories(){ return [ 'purple-folio' ]; }
	public function get_keywords()  { return [ 'hero', 'banner', 'purfolio', 'portfolio' ]; }

	protected function register_controls() {

		/* ================= CONTENT ================= */
		$this->start_controls_section( 'sec_content', [ 'label' => __( 'Content', 'pfw' ) ] );

		$this->add_control( 'eyebrow',         [ 'label' => 'Eyebrow text',            'type' => \Elementor\Controls_Manager::TEXT,     'default' => 'WordPress Developer' ] );
		$this->add_control( 'typing_phrases', [
			'label'       => 'Typing phrases (| separated)',
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'Yousuf Zai | WordPress Developer | Elementor Expert',
			'description' => 'Separate rotating phrases with a pipe "|". Leave blank to disable typing.',
		] );
		$this->add_control( 'chip_text',       [ 'label' => 'Availability chip',       'type' => \Elementor\Controls_Manager::TEXT,     'default' => 'Available' ] );
		$this->add_control( 'title_before',    [ 'label' => 'Title (before highlight)','type' => \Elementor\Controls_Manager::TEXT,     'default' => 'Crafting' ] );
		$this->add_control( 'title_highlight', [ 'label' => 'Highlighted word',        'type' => \Elementor\Controls_Manager::TEXT,     'default' => 'WordPress' ] );
		$this->add_control( 'title_after',     [ 'label' => 'Title (after highlight)', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'experiences that feel unreal.' ] );
		$this->add_control( 'lead',            [ 'label' => 'Lead paragraph',          'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => "I'm building custom themes, headless WordPress stacks and blazing-fast websites for founders and studios worldwide." ] );
		$this->add_control( 'primary_label',   [ 'label' => 'Primary button',          'type' => \Elementor\Controls_Manager::TEXT,     'default' => 'View Work' ] );
		$this->add_control( 'primary_link',    [ 'label' => 'Primary link',            'type' => \Elementor\Controls_Manager::URL,      'default' => [ 'url' => '/work' ] ] );
		$this->add_control( 'ghost_label',     [ 'label' => 'Ghost button',            'type' => \Elementor\Controls_Manager::TEXT,     'default' => 'Start a Project' ] );
		$this->add_control( 'ghost_link',      [ 'label' => 'Ghost link',              'type' => \Elementor\Controls_Manager::URL,      'default' => [ 'url' => '/contact' ] ] );

		$this->add_control( 'image', [
			'label'   => 'Hero image',
			'type'    => \Elementor\Controls_Manager::MEDIA,
			'default' => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ],
		] );

		$this->end_controls_section();

		/* ================= STYLE: Typography ================= */
		$this->start_controls_section( 'sec_style_type', [
			'label' => __( 'Typography', 'pfw' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'text_align', [
			'label'   => 'Text alignment',
			'type'    => \Elementor\Controls_Manager::CHOOSE,
			'options' => [
				'left'   => [ 'title' => 'Left',   'icon' => 'eicon-text-align-left' ],
				'center' => [ 'title' => 'Center', 'icon' => 'eicon-text-align-center' ],
				'right'  => [ 'title' => 'Right',  'icon' => 'eicon-text-align-right' ],
			],
			'default'   => 'left',
			'prefix_class' => 'pfw-align-',
			'selectors' => [ '{{WRAPPER}} .hero-copy' => 'text-align: {{VALUE}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'title_typo',
			'label'    => 'Title typography',
			'selector' => '{{WRAPPER}} .hero .display',
		] );

		$this->add_control( 'title_color', [
			'label'     => 'Title color',
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .hero .display' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'lead_typo',
			'label'    => 'Lead typography',
			'selector' => '{{WRAPPER}} .hero .lead',
		] );

		$this->add_control( 'lead_color', [
			'label'     => 'Lead color',
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .hero .lead' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'eyebrow_typo',
			'label'    => 'Eyebrow typography',
			'selector' => '{{WRAPPER}} .hero-eyebrow .typing',
		] );

		$this->add_control( 'eyebrow_color', [
			'label'     => 'Eyebrow color',
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .hero-eyebrow .typing' => 'color: {{VALUE}}; background: none; -webkit-text-fill-color: {{VALUE}};' ],
		] );

		$this->add_control( 'chip_color', [
			'label'     => 'Chip text color',
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .hero .chip' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'button_typo',
			'label'    => 'Button typography',
			'selector' => '{{WRAPPER}} .hero .btn',
		] );

		$this->end_controls_section();

		/* ================= STYLE: Layout & spacing ================= */
		$this->start_controls_section( 'sec_style_layout', [
			'label' => __( 'Layout & Spacing', 'pfw' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'hero_padding', [
			'label'      => 'Hero padding',
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em', '%' ],
			'selectors'  => [ '{{WRAPPER}} .hero' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'hero_margin', [
			'label'      => 'Hero margin',
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em', '%' ],
			'selectors'  => [ '{{WRAPPER}} .hero' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'hero_gap', [
			'label'      => 'Column gap',
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 160 ], 'em' => [ 'min' => 0, 'max' => 10 ] ],
			'selectors'  => [ '{{WRAPPER}} .hero' => 'gap: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'content_max_width', [
			'label'      => 'Text max width',
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'range'      => [ 'px' => [ 'min' => 240, 'max' => 900 ], '%' => [ 'min' => 30, 'max' => 100 ] ],
			'selectors'  => [ '{{WRAPPER}} .hero-copy' => 'max-width: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'title_margin', [
			'label'      => 'Title margin',
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em', '%' ],
			'selectors'  => [ '{{WRAPPER}} .hero .display' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'lead_margin', [
			'label'      => 'Lead margin',
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em', '%' ],
			'selectors'  => [ '{{WRAPPER}} .hero .lead' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'button_gap', [
			'label'      => 'Button gap',
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 80 ], 'em' => [ 'min' => 0, 'max' => 5 ] ],
			'selectors'  => [ '{{WRAPPER}} .hero-cta' => 'gap: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'button_padding', [
			'label'      => 'Button padding',
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em' ],
			'selectors'  => [ '{{WRAPPER}} .hero .btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->end_controls_section();

		/* ================= STYLE: Image ================= */
		$this->start_controls_section( 'sec_style_img', [
			'label' => __( 'Image', 'pfw' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_group_control( \Elementor\Group_Control_Image_Size::get_type(), [
			'name'    => 'image', // matches control name → uses image[url]/image[id]
			'default' => 'large',
		] );

		$this->add_responsive_control( 'img_width', [
			'label'      => 'Max width',
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'range'      => [ 'px' => [ 'min' => 120, 'max' => 900 ], '%' => [ 'min' => 20, 'max' => 100 ] ],
			'selectors'  => [ '{{WRAPPER}} .hero-art img' => 'max-width: {{SIZE}}{{UNIT}}; width: 100%;' ],
		] );

		$this->add_responsive_control( 'img_radius', [
			'label'      => 'Border radius',
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'default'    => [ 'top' => 20, 'right' => 20, 'bottom' => 20, 'left' => 20, 'unit' => 'px', 'isLinked' => true ],
			'selectors'  => [ '{{WRAPPER}} .hero-art img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), [
			'name'     => 'img_shadow',
			'selector' => '{{WRAPPER}} .hero-art img',
		] );

		$this->add_control( 'show_glow', [
			'label'   => 'Show glow orb',
			'type'    => \Elementor\Controls_Manager::SWITCHER,
			'default' => 'yes',
			'selectors' => [ '{{WRAPPER}} .hero-art .glow-orb' => 'display: block;' ],
			'selectors_dictionary' => [ '' => 'display: none;' ],
		] );

		$this->end_controls_section();
	}

	protected function render() {
		$s = $this->get_settings_for_display();

		$primary_url = ! empty( $s['primary_link']['url'] ) ? $s['primary_link']['url'] : '#';
		$ghost_url   = ! empty( $s['ghost_link']['url'] )   ? $s['ghost_link']['url']   : '#';

		// Use the Image_Size group so users can pick a WP size.
		$img_html = '';
		if ( ! empty( $s['image']['url'] ) ) {
			$img_html = \Elementor\Group_Control_Image_Size::get_attachment_image_html( $s, 'image', 'image' );
			if ( ! $img_html ) {
				$img_html = '<img src="' . esc_url( $s['image']['url'] ) . '" alt="' . esc_attr( $s['title_highlight'] ) . '" />';
			}
		}
		?>
		<div class="hero pfw-hero">
			<div class="hero-copy pfw-animate">
				<div class="hero-eyebrow">
					<?php
					$phrases = trim( (string) ( $s['typing_phrases'] ?? '' ) );
					if ( '' !== $phrases ) : ?>
						<span class="typing gradient-text" data-phrases="<?php echo esc_attr( $phrases ); ?>"><?php echo esc_html( $s['eyebrow'] ); ?></span>
					<?php else : ?>
						<span class="typing gradient-text"><?php echo esc_html( $s['eyebrow'] ); ?></span>
					<?php endif; ?>
					<?php if ( $s['chip_text'] ) : ?>
						<span class="chip glass"><i class="dot"></i><?php echo esc_html( $s['chip_text'] ); ?></span>
					<?php endif; ?>
				</div>
				<h1 class="display">
					<?php echo esc_html( $s['title_before'] ); ?>
					<span class="gradient-text"> <?php echo esc_html( $s['title_highlight'] ); ?> </span>
					<?php echo esc_html( $s['title_after'] ); ?>
				</h1>
				<p class="lead"><?php echo esc_html( $s['lead'] ); ?></p>
				<div class="hero-cta">
					<a href="<?php echo esc_url( $primary_url ); ?>" class="btn btn-primary"><?php echo esc_html( $s['primary_label'] ); ?> <span class="arrow">→</span></a>
					<a href="<?php echo esc_url( $ghost_url ); ?>"   class="btn btn-ghost"><?php echo esc_html( $s['ghost_label'] ); ?></a>
				</div>
			</div>
			<?php if ( $img_html ) : ?>
			<div class="hero-art pfw-animate">
				<div class="glow-orb"></div>
				<?php
				// Ensure the img has our .float class for the animation.
				echo str_replace( '<img ', '<img class="float pfw-hero-img" ', $img_html );
				?>
			</div>
			<?php endif; ?>
		</div>
		<?php
	}
}
