<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class PFW_Posts extends \Elementor\Widget_Base {
	public function get_name()      { return 'pfw_posts'; }
	public function get_title()     { return __( 'PF Blog Posts', 'pfw' ); }
	public function get_icon()      { return 'eicon-post-list'; }
	public function get_categories(){ return [ 'purple-folio' ]; }
	public function get_keywords()  { return [ 'blog', 'posts', 'articles', 'purfolio' ]; }

	protected function register_controls() {
		$this->start_controls_section( 'sec_content', [ 'label' => __( 'Content', 'pfw' ) ] );
		$this->add_control( 'eyebrow', [ 'label' => 'Eyebrow', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Latest posts' ] );
		$this->add_control( 'title', [ 'label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'From the blog' ] );
		$this->add_control( 'show_date', [ 'label' => 'Show date', 'type' => \Elementor\Controls_Manager::SWITCHER, 'default' => 'yes' ] );
		$this->add_control( 'show_excerpt', [ 'label' => 'Show excerpt', 'type' => \Elementor\Controls_Manager::SWITCHER, 'default' => 'yes' ] );
		$this->add_control( 'read_more_label', [ 'label' => 'Read-more label', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Read article →' ] );
		$this->add_control( 'empty_text', [ 'label' => 'Empty state text', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'No posts published yet.' ] );
		$this->add_control( 'per_page', [
			'label' => 'Posts to show',
			'type' => \Elementor\Controls_Manager::NUMBER,
			'default' => 6,
			'min' => 1,
			'max' => 12,
		] );
		$this->add_control( 'columns', [
			'label' => 'Columns',
			'type' => \Elementor\Controls_Manager::SELECT,
			'default' => '3',
			'options' => [ '1' => '1', '2' => '2', '3' => '3' ],
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
			'selectors' => [ '{{WRAPPER}} .section-head-row > div' => 'text-align: {{VALUE}};' ],
		] );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name' => 'eyebrow_typo', 'label' => 'Eyebrow', 'selector' => '{{WRAPPER}} .pfw-posts .eyebrow',
		] );
		$this->add_control( 'eyebrow_color', [ 'label' => 'Eyebrow color', 'type' => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .pfw-posts .eyebrow' => 'color: {{VALUE}};' ] ] );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name' => 'title_typo', 'label' => 'Section title', 'selector' => '{{WRAPPER}} .pfw-posts h2',
		] );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name' => 'post_title_typo', 'label' => 'Post title', 'selector' => '{{WRAPPER}} .pfw-post-card h3',
		] );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name' => 'excerpt_typo', 'label' => 'Excerpt', 'selector' => '{{WRAPPER}} .pfw-post-card p',
		] );
		$this->add_responsive_control( 'card_padding', [
			'label' => 'Card padding', 'type' => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em', '%' ],
			'selectors' => [ '{{WRAPPER}} .pfw-post-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );
		$this->add_responsive_control( 'card_radius', [
			'label' => 'Card radius', 'type' => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'default' => [ 'top' => 20, 'right' => 20, 'bottom' => 20, 'left' => 20, 'unit' => 'px', 'isLinked' => true ],
			'selectors' => [ '{{WRAPPER}} .pfw-post-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );
		$this->end_controls_section();
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		$columns = in_array( (string) $s['columns'], [ '1', '2', '3' ], true ) ? (string) $s['columns'] : '3';
		$q = new \WP_Query( [
			'post_type' => 'post',
			'post_status' => 'publish',
			'posts_per_page' => max( 1, min( 12, (int) $s['per_page'] ) ),
			'ignore_sticky_posts' => true,
		] );
		?>
		<section class="section pfw-posts" id="latest-posts">
			<div class="section-head-row">
				<div>
					<?php if ( $s['eyebrow'] ) : ?><div class="eyebrow"><?php echo esc_html( $s['eyebrow'] ); ?></div><?php endif; ?>
					<?php if ( $s['title'] ) : ?><h2><?php echo esc_html( $s['title'] ); ?></h2><?php endif; ?>
				</div>
			</div>
			<div class="pfw-post-grid pfw-post-grid-<?php echo esc_attr( $columns ); ?>">
				<?php if ( $q->have_posts() ) : while ( $q->have_posts() ) : $q->the_post(); ?>
					<article class="pfw-post-card glass pfw-animate">
						<a href="<?php the_permalink(); ?>">
							<?php if ( 'yes' === $s['show_date'] ) : ?><div class="eyebrow sm"><?php echo esc_html( get_the_date() ); ?></div><?php endif; ?>
							<h3><?php the_title(); ?></h3>
							<?php if ( 'yes' === $s['show_excerpt'] ) : ?><p><?php echo esc_html( wp_trim_words( get_the_excerpt() ?: wp_strip_all_tags( get_the_content() ), 22 ) ); ?></p><?php endif; ?>
							<?php if ( ! empty( $s['read_more_label'] ) ) : ?><span class="see-all"><?php echo esc_html( $s['read_more_label'] ); ?></span><?php endif; ?>
						</a>
					</article>
				<?php endwhile; wp_reset_postdata(); else : ?>
					<p><?php echo esc_html( $s['empty_text'] ); ?></p>
				<?php endif; ?>
			</div>
		</section>
		<?php
	}
}