<?php
/**
 * Display the loop for single post pages
 *
 * @package Opti
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <h1 class="posttitle">
        <?php the_title(); ?> <?php get_template_part( '/includes/edit' ); ?>
    </h1>
<?php if(function_exists('wp_print')) { echo('<span class="postmetadata print">'); print_link_custom(); echo('</span>'); } ?>

    <?php get_template_part( '/includes/postmetadata' ); ?>
    <section class="entry">
        <?php
        the_content();

        echo '<hr class="sep" />';

        // link pages together
        wp_link_pages( array(
            'before' => '<p id="archive-pagination">',
        ));

        if(function_exists('get_twoclick_buttons')) {
            get_twoclick_buttons(get_the_ID());
        }

        // article navigation
        previous_post_link( '<div class="postnav left">&laquo; %link</div>' );
        next_post_link( '<div class="postnav right">%link &raquo;</div>' );

        // categories
        echo '<p class="post-taxonomies">' . __( 'Categories: ', 'opti' );
        the_category( ', ' );
        echo '</p>';

        // tags && if is not Category 7 (Archiv)
        if(!in_category(7) && is_user_logged_in()){
            the_tags( '<p class="post-taxonomies">' . __( 'Tags: ', 'opti' ), ', ', '</p>' );
        }


        // related posts
        // -------------
        if ( is_single() && opti_option( 'display-related-posts' )) {

            global $post;
            $categories = get_the_category();
            $cat_list = array();
            foreach ( $categories as $c ) {
                $cat_list[] = $c->term_id;
            }

            $args = array(
                'cat' => implode( $cat_list, ',' ),
                'posts_per_page' => 6,
                'post__not_in' => array($post->ID),
            );

            $query = new WP_Query( $args );

            if ( $query->have_posts() ) {
                ?>
                <section id="related-posts">
                    <h5 class="widgettitle"><?php _e( 'Related Articles', 'opti' ); ?></h5>
                    <ul>
                        <?php
                        while ( $query->have_posts() ) {
                            $query->the_post();
                            ?>
                            <li>
                                <a class="dark" href="<?php the_permalink(); ?>">
                                    <?php
                                    if ( get_the_post_thumbnail( get_the_ID(), 'post-loop-big' ) ) {
                                        the_post_thumbnail( 'post-loop-big' );
                                    }
                                    the_title();
                                    ?>
                                </a>
                            </li>
                        <?php
                        }
                        ?>
                    </ul>
                </section>
            <?php
            }

            wp_reset_postdata();
        }
        ?>
    </section>
</article>
