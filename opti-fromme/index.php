<?php
/**
 * Homepage template
 *
 * @package Opti
 */

get_header();

$display_categories = opti_get_homepage_categories();
$showposts = (int) opti_option( 'featured-posts' );

$recent_colwidth = 'ninecol';
if ( empty( $display_categories ) ) {
	$recent_colwidth = 'twelvecol';
}

?>
<section class="row">
	<div class="<?php opti_content_class(); ?>">
<?php
		$paged = get_query_var( 'paged' ) ? (int) get_query_var( 'paged' ) : 1;
		$page_title = __( 'Recent Posts', 'opti' );
		$ignore_post = -1;

		if ( $paged == 1 ) {

			$args = array(
				'paged' => $paged,
				'posts_per_page' => 1,
				'ignore_sticky_posts' => 1,
                'cat' => 67
			);
			$query = new WP_Query( $args );

			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) {
					$ignore_post = $query->post->ID;
					$query->the_post();
?>
			<section id="lead-story">
<?php
				if ( get_the_post_thumbnail( $query->post->ID, 'featured' ) ) {
				
					$copyright = '';
					if (function_exists('thisismyurl_has_custom_media_field')) {
                        $copyright = generate_copyright(str_replace('attachment_','', $attr['id']));
					}
?>
                    <?php $title_image_width = get_post_meta( get_the_ID(), 'title_image_width', true); ?>

                    <?php if($copyright != ''){ ?>
                    	<div class="wp-copy-caption<?php echo ($title_image_width == "full-width")?" full-width":""; ?>">
                    <?php } ?>
							<a class="noborder<?php echo ($title_image_width == "full-width")?" full-width":""; ?>" id="lead-image" href="<?php the_permalink(); ?>" rel="bookmark" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'opti' ), the_title_attribute( 'echo=0' ) ) ); ?>">
								<?php
									if($title_image_width == "full-width"){
										the_post_thumbnail('full-width');
									} else {
										the_post_thumbnail('featured');
								    }
								?>
							</a>
					<?php if($copyright != ''){ ?>
							<p class="copyright"><?php echo $copyright; ?></p>
                    	</div>
                    <?php } ?>
<?php
				}
?>
					<h2 class="posttitle">
						<a class="dark" href="<?php the_permalink(); ?>" rel="bookmark" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'opti' ), the_title_attribute( 'echo=0' ) ) ); ?>"><?php the_title(); ?></a>
					</h2>
<?php
					get_template_part( '/includes/postmetadata' );
					the_excerpt();
?>
			</section><!--/LEAD STORY-->

<?php
				}
			}
			wp_reset_postdata();

		} else {
			$page_title = sprintf( __( 'Recent Posts - page %d', 'opti' ), $paged );
		}
?>

        <?php

        // shortnews loop
        $shortNewsQuery = new WP_Query('category_name=kurznachrichten');
        if ( $shortNewsQuery->have_posts() and $paged == 1 ) :
            set_query_var('shortNewsQuery', $shortNewsQuery);
            get_template_part('content-shortnews');

        endif;
        wp_reset_postdata();
        ?>


        <div id="recent-posts" class="<?php echo $recent_colwidth; ?>">
            <h3><?php echo $page_title; ?></h3>
            <ul id="recent-excerpts">
                <?php
                while( have_posts() ) {
                    the_post();

                    if ( $post->ID != $ignore_post ) {
                        get_template_part( 'content', 'home-loop' );
                    }
                }
                ?>
            </ul>
            <?php

            get_template_part( 'includes/pagination' );
            ?>
        </div><!--END RECENT/OLDER POSTS-->

<?php
		if ( $display_categories && is_array( $display_categories ) ) {
?>
			<section id="featured-cats" class="threecol">
				<h3><?php _e( 'Featured Categories', 'opti' ); ?></h3>
<?php
				$exclude = array();
				foreach ( (array) $display_categories as $category ) {
					$args = array(
						'posts_per_page' => $showposts,
						'cat' => (int) $category,
						'post__not_in' => $exclude
					);
					$cat_query = new WP_Query( $args );
					if ( $cat_query->have_posts() ) {
						?>
						<h5><a class="dark" href="<?php echo get_category_link( $category ); ?>"><?php echo get_the_category_by_ID( $category ); ?> &raquo;</a></h5>
						<ul class="headlines">
							<?php
							while ( $cat_query->have_posts() ) {
								$cat_query->the_post();
								$exclude[] = $cat_query->post->ID;
								?>
								<li>
									<a class="dark" href="<?php the_permalink(); ?>" rel="bookmark" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'opti' ), the_title_attribute( 'echo=0' ) ) ); ?>"><?php the_title(); ?></a>
									<div class="date"><?php the_time( get_option( 'date_format' ) ); ?></div>
								</li>
								<?php
							}
							?>
						</ul>
						<?php
					}
					wp_reset_postdata();
				}
?>
			</section><!--END FEATURED CATS-->
			<?php
		}
		?>
		
		<section id="sidebar-bookmarks" class="threecol">
		    <?php
		        $bookmarkOptions = array(
		        	'title_before' => '<h3>',
		        	'title_after' => '</h3>',
		            'category' => '2175',
		            'class' => 'headlines'
		        );
		        wp_list_bookmarks($bookmarkOptions);
		    ?>
		</section>
	</div>
	<?php get_sidebar(); ?>
</section>
<?php get_footer(); ?>
