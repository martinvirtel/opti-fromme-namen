<?php
/**
 * Template Name: Newsletter-Archiv
 * Description: Template for the custom_post_type "newsletter_archiv"
 *
 * @package Opti-Fromme
 */

get_header(); ?>
    <section class="row">
        <div class="eightcol full-width">
            <?php
            the_post();
            get_template_part( 'content', 'page' );
            ?>

            <div class="masonry">
                <?php
                    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                    $args = array(
                        'post_type' => 'newsletter_archive',
                        'posts_per_page' => 30,
                        'paged' => $paged,
                        'orderby' => 'date'
                    );
                    $loop = new WP_Query( $args );

                while ( $loop->have_posts() ) : $loop->the_post();
                    get_template_part( 'content', 'archive' );
                endwhile; ?>
            </div>

            <?php
            opti_numeric_pagination(9, $loop);
            ?>
        </div>
    </section>
<?php get_footer(); ?>