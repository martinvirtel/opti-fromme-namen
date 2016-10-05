<?php
/**
 * Display author posts and author information
 *
 * @package Opti
 */

get_header();
?>
<section class="row">
	<div class="eightcol">		
		<h1 class="pagetitle">
			<?php _e( 'Author Archives', 'opti' ); ?>
		</h1>

		<div id="writer">
<?php
			global $wp_query;
			$curauth = $wp_query->get_queried_object();
			echo get_avatar( $curauth->user_email, '80' );
			echo wpautop( $curauth->user_description );
?>
		</div>
<?php
		if ( have_posts() ) {
			echo '<ul id="recent-excerpts">';
			while ( have_posts() ) {
				the_post();
				get_template_part( 'content', 'author' );
			}
			echo '</ul>';
			opti_numeric_pagination();
		}
?>
	</div>
	<?php get_sidebar(); ?>

</section>
<?php
get_footer();
?>