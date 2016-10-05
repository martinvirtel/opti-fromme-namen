<?php
/**
 * Display data relevant to blog posts
 *
 * @package Opti
 */
?>
<p class="postmetadata">
    <?php

    if(function_exists('coauthors_posts_links')) {
        $author = coauthors_posts_links( null, sprintf( ' und '), null, null, false );
    } else {
        $author = '<span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>';
    }

    printf( __( '<span class="byline">' . sprintf( __( 'By', 'opti' )) . ' ' . $author . ' ' . sprintf( __( 'at', 'opti' )) . ' <a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a>', 'opti' ),
        esc_url( get_permalink() ),
        esc_attr( get_the_time() ),
        esc_attr( get_the_date( 'c' ) ),
        esc_html( get_the_date() ),
        esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
        esc_attr( sprintf( __( 'View all posts by %s', 'opti' ), get_the_author() ) ),
        get_the_author()
    );

    if ( $post->comment_status == 'open' ) {
        ?>
        <?php /* &bull; <span class="commentcount">( <?php comments_popup_link( '0', '1', '%', 'comments_link', '' ); ?> )</span> */ ?>
    <?php
    }
    ?>

</p>

