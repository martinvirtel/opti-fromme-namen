<?php
/**
 * Display the loop for search results
 *
 * @package Opti
 */

$copyright = '';
if (function_exists('thisismyurl_has_custom_media_field')) {
    $copyright = generate_copyright(str_replace('attachment_','', $attr['id']));
}

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php if($copyright != ''){ ?>
        <div class="wp-copy-caption">
            <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_post_thumbnail( 'post-loop-big' ); ?></a>
            <p class="copyright copyright-archive"><?php echo $copyright; ?></p>
        </div>
    <?php } else { ?>
	<div class="thumb-wrap">
		<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'opti' ), the_title_attribute( 'echo=0' ) ) ); ?>">
			<?php
			if ( get_the_post_thumbnail( get_the_ID(), 'archive' ) ) {
				the_post_thumbnail( 'archive' );
			}
			?>				 			
		</a>
	</div>
    <?php } ?>
	<div class="excerpt-wrap">
		<h2 class="posttitle">
			<a class="dark" href="<?php the_permalink(); ?>" rel="bookmark"><?php opti_search_title_highlight(); ?></a>
		</h2>
		<?php get_template_part( '/includes/postmetadata' ); ?>
		<section class="entry">
			<?php
				my_search_excerpt_highlight();
			?>
		</section>
	</div>
</article>
