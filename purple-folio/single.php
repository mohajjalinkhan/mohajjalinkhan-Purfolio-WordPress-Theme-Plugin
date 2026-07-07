<?php
/**
 * Single post template — also calls the_content() so Elementor works
 * on individual posts.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header(); ?>

<main class="site-main">
	<?php
	while ( have_posts() ) :
		the_post();
		$is_elementor_post = function_exists( 'customtheme_is_elementor_document' ) && customtheme_is_elementor_document( get_the_ID() );
		$container_class    = $is_elementor_post ? 'pf-page-shell pf-page-shell-elementor' : 'container pf-page-shell';
		?>
		<div class="<?php echo esc_attr( $container_class ); ?>">
			<article <?php post_class( $is_elementor_post ? 'pf-post pf-post-elementor' : 'pf-post' ); ?>>
				<?php if ( ! $is_elementor_post ) : ?>
					<header class="pf-page-header" data-anim="fade-up">
						<div class="eyebrow"><?php echo esc_html( get_the_date() ); ?></div>
						<h1 class="display"><?php the_title(); ?></h1>
					</header>
				<?php endif; ?>

				<div class="pf-page-content entry-content">
					<?php the_content(); ?>
				</div>
			</article>
		</div>
		<?php
	endwhile;
	?>
</main>

<?php get_footer(); ?>
