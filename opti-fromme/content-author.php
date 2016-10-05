<?php
/**
 * Display the loop for the home page and other pages with lists of content
 *
 * @package Opti
 */
 
	$copyright = '';
	if (function_exists('thisismyurl_has_custom_media_field')) {
        $copyright = generate_copyright(str_replace('attachment_','', $attr['id']));
	}
?>
<li <?php post_class(); ?>>
    <h4><a class="dark" href="<?php the_permalink(); ?>" rel="bookmark" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'opti' ), the_title_attribute( 'echo=0' ) ) ); ?>"><?php the_title(); ?></a></h4>
    <?php
    get_template_part( '/includes/postmetadata' );
    ?>
    <div class="excerpt">
        <?php if ( get_the_post_thumbnail( get_the_ID(), 'post-loop-big' ) ) { ?>
            <?php if($copyright != ''){ ?>
                    <div class="wp-copy-caption">
                        <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_post_thumbnail( 'post-loop-big' ); ?></a>
                        <p class="copyright copyright-archive"><?php echo $copyright; ?></p>
                    </div>
            <?php } else { ?>
                <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_post_thumbnail( 'post-loop-big' ); ?></a>
            <?php } ?>
         <?php } ?>
        <?php the_excerpt(); ?>
    </div>
</li><!--/RECENT EXCERPTS-->
