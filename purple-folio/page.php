<?php
/**
 * Default page template — required for Elementor & the block editor.
 * Any Page created in WP admin will render through here and call
 * the_content(), which is what Elementor hooks into.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header(); ?>

<main class="site-main">
	<?php
	while ( have_posts() ) :
		the_post();
		$is_elementor_page = function_exists( 'customtheme_is_elementor_document' ) && customtheme_is_elementor_document( get_the_ID() );
		$container_class    = $is_elementor_page ? 'pf-page-shell pf-page-shell-elementor' : 'container pf-page-shell';
		?>
		<div class="<?php echo esc_attr( $container_class ); ?>">
			<article <?php post_class( $is_elementor_page ? 'pf-page pf-page-elementor' : 'pf-page' ); ?>>
				<?php if ( ! $is_elementor_page && ! is_page_template() && get_the_title() && ! post_password_required() ) : ?>
					<header class="pf-page-header" data-anim="fade-up">
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
