<?php
/**
 * Display author posts and author information
 *
 * @package Opti
 */

get_header();
?>
<section class="row">
<?php if (is_tax('firmen')) { echo("Ja!"); } ?>
	<div class="eightcol">		
<?php
			global $wp_query;
			$curterm = $wp_query->get_queried_object();
?>
		<h1 class="pagetitle">
			<?php echo $curterm->name; ?>
		</h1>
		<p>Diese Übersicht ist Teil unserer Serie <a href="/category/koepfe">Köpfe der Branche</a>.</p>

<?php
		if ( have_posts() ) {
			echo '<ul id="recent-excerpts">';
			while ( have_posts() ) {
				the_post();
				get_template_part( 'content', 'firmen' );
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
