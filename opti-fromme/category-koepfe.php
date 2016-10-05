<?php
/**
 * Display Köpfe information
 *
 * @package Opti-Fromme
 */

get_header();
?>
<section class="row">
	<div class="eightcol">		
<?php
			global $wp_query;
			$curterm = $wp_query->get_queried_object();
?>
		<h1 class="pagetitle">
			<?php echo $curterm->name; ?>
		</h1>
		<p>
In dieser Rubrik stellen wir Ihnen die Führungskräfte der Branche vor. Wir beginnen mit den Vorständen der großen deutschen Versicherer und bauen die Datenbank sukzessive aus. Die Personendatenbank ist Teil des Premium-Angebots des Versicherungsmonitors, der Zugriff ist den zahlenden Abonnenten vorbehalten. Bei Fragen wenden Sie sich bitte an <a href="mailto:redaktion@versicherungsmonitor.de" target="_blank">redaktion@versicherungsmonitor.de</a>.
		</p>


<?php
		if ( have_posts() ) {
			echo '<ul id="recent-excerpts">';
			while ( have_posts() ) {
				the_post();
				get_template_part( 'content', 'koepfe' );
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
