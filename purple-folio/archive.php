<?php
/**
 * Archive template for categories, tags and date archives.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header(); ?>

<main class="site-main">
	<div class="container" style="padding-top:120px; padding-bottom:80px;">
		<header class="pf-page-header" data-anim="fade-up">
			<div class="eyebrow"><?php esc_html_e( 'Archive', 'customtheme' ); ?></div>
			<h1 class="display"><?php the_archive_title(); ?></h1>
			<?php if ( get_the_archive_description() ) : ?>
				<div class="lead"><?php the_archive_description(); ?></div>
			<?php endif; ?>
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
		<?php else : ?>
			<p><?php esc_html_e( 'No posts found.', 'customtheme' ); ?></p>
		<?php endif; ?>
	</div>
</main>

<?php get_footer(); ?>