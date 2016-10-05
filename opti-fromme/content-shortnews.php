
<div class="short-posts"><!-- SHORT NEWS -->
    <h3>Kurznachrichten</h3>
    <ul>
        <?php
        $count = 0;
        while( $shortNewsQuery->have_posts() ) : $shortNewsQuery->the_post();
            $count++;
            if ($count <= 6) :
                ?>
                <li><a href="<?php the_permalink(); ?>"  title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'opti' ), the_title_attribute( 'echo=0' ) ) ); ?>"><?php the_title(); ?></a></li>
            <?php
            endif;
        endwhile;
        ?>
    </ul>
</div><!-- END SHORT NEWS -->
