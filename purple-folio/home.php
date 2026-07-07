<?php
/**
 * Posts page template.
 *
 * When WordPress is configured with a static Blog page, the posts index uses
 * home.php instead of page.php. This template renders the Blog page's Elementor
 * content first so the editable hero + PF Blog Posts widget remain visible.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();

$posts_page_id = (int) get_option( 'page_for_posts' );
?>

<main class="site-main">
	<?php if ( $posts_page_id ) :
		$blog_page = get_post( $posts_page_id );
		$is_elementor_page = function_exists( 'customtheme_is_elementor_document' ) && customtheme_is_elementor_document( $posts_page_id );
		if ( $blog_page ) :
			global $post;
			$post = $blog_page;
			setup_postdata( $post );
			?>
			<div class="<?php echo esc_attr( $is_elementor_page ? 'pf-page-shell pf-page-shell-elementor' : 'container pf-page-shell' ); ?>">
				<article <?php post_class( $is_elementor_page ? 'pf-page pf-page-elementor' : 'pf-page', $posts_page_id ); ?>>
					<?php if ( ! $is_elementor_page ) : ?>
						<header class="pf-page-header" data-anim="fade-up">
							<h1 class="display"><?php echo esc_html( get_the_title( $posts_page_id ) ); ?></h1>
						</header>
					<?php endif; ?>

					<div class="pf-page-content entry-content">
						<?php
						if ( $is_elementor_page && class_exists( '\Elementor\Plugin' ) ) {
							echo \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $posts_page_id );
						} else {
							echo apply_filters( 'the_content', $blog_page->post_content );
						}
						?>
					</div>
				</article>
			</div>
			<?php
			wp_reset_postdata();
		endif;
	else : ?>
		<div class="container pf-page-shell">
			<header class="pf-page-header" data-anim="fade-up">
				<div class="eyebrow"><?php esc_html_e( 'Blog', 'customtheme' ); ?></div>
				<h1 class="display"><?php esc_html_e( 'Latest posts', 'customtheme' ); ?></h1>
			</header>
			<?php if ( have_posts() ) : ?>
				<div class="blog-grid section">
					<?php while ( have_posts() ) : the_post(); ?>
						<article <?php post_class( 'blog-card glass' ); ?> data-anim="fade-up">
							<a href="<?php the_permalink(); ?>">
								<div class="eyebrow sm"><?php echo esc_html( get_the_date() ); ?></div>
								<h2><?php the_title(); ?></h2>
								<p><?php echo esc_html( wp_trim_words( get_the_excerpt() ?: wp_strip_all_tags( get_the_content() ), 24 ) ); ?></p>
								<span class="see-all"><?php esc_html_e( 'Read article →', 'customtheme' ); ?></span>
							</a>
						</article>
					<?php endwhile; ?>
				</div>
				<?php the_posts_pagination(); ?>
			<?php endif; ?>
		</div>
	<?php endif; ?>
</main>

<?php get_footer(); ?>