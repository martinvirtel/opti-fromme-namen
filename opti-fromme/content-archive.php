<?php
/**
 * Display the loop for archive pages
 *
 * @package Opti
 */
 
	$copyright = '';
	if (function_exists('thisismyurl_has_custom_media_field')) {
        $copyright = generate_copyright(str_replace('attachment_','', $attr['id']));
	}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="thumb-wrap">
        <?php if ( get_the_post_thumbnail( get_the_ID(), 'post-loop-big' ) ) { ?>
            <?php if($copyright != ''){ ?>
                <div class="wp-copy-caption">
                    <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_post_thumbnail( 'post-loop-big' ); ?></a>
                    <p class="copyright copyright-archive"><?php echo $copyright; ?></p>
                </div>
            <?php } else { ?>
                <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_post_thumbnail('thumbnail'); ?></a>
            <?php } ?>
        <?php } ?>
	</div>
	<div class="excerpt-wrap">
		<h2 class="posttitle">
			<a class="dark" href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
		</h2>
			<?php get_template_part( '/includes/postmetadata' ); ?>
		<section class="entry">
			<?php the_excerpt(); ?>
		</section>
	</div>
</article>
