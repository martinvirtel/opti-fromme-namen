<?php
/**
 * Search results
 *
 * @package Opti
 */

get_header();
?>
<section class="row">
	<div class="eightcol full-width">
		<h1 class="pagetitle">
			<?php _e( 'Search results for', 'opti' ); ?> &#8216;<em><?php the_search_query(); ?></em>&#8217;
		</h1>
		<?php
		if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();
				get_template_part( 'content', 'search' );
			}

			opti_numeric_pagination();
		} else {
			?>
			<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'opti' ); ?></p>
			<?php
		}
		?>
	</div>      
</section>
<?php
get_footer();
?>