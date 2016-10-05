<?php
/*
 * WordPress Plugin: WP-Print
 * Copyright (c) 2012 Lester "GaMerZ" Chan
 *
 * File Written By:
 * - Lester "GaMerZ" Chan
 * - http://lesterchan.net
 *
 * File Information:
 * - Printer Friendly Post/Page Template
 * - wp-content/plugins/wp-print/print-posts.php
 */

$post_timestamp = get_post_time('U', true);
$date_limit = 1367359200; //01.05.2013

?>

<?php global $text_direction; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
    <title><?php bloginfo('name'); ?> <?php wp_title(); ?></title>
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    <meta name="Robots" content="noindex, nofollow" />
    <?php if(@file_exists(STYLESHEETPATH.'/print-css.css')): ?>
        <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/print-css.css" type="text/css" media="screen, print" />
    <?php else: ?>
        <link rel="stylesheet" href="<?php echo plugins_url('wp-print/print-css.css'); ?>" type="text/css" media="screen, print" />
    <?php endif; ?>
    <?php if('rtl' == $text_direction): ?>
        <?php if(@file_exists(STYLESHEETPATH.'/print-css-rtl.css')): ?>
            <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/print-css-rtl.css" type="text/css" media="screen, print" />
        <?php else: ?>
            <link rel="stylesheet" href="<?php echo plugins_url('wp-print/print-css-rtl.css'); ?>" type="text/css" media="screen, print" />
        <?php endif; ?>
    <?php endif; ?>
    <link rel="canonical" href="<?php the_permalink(); ?>" />
</head>
<body>
<!-- <p style="text-align: center;"><strong>- <?php bloginfo('name'); ?> - <span dir="ltr"><?php bloginfo('url')?></span> -</strong></p> -->
<div class="Center">
    <div id="Outline">
        <h1 id="logo"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/banner_print.jpg"></h1>
        <div id="abobox">
            <h4>Abo <?php echo $_SESSION['wpsg']['checkout']['vname'],' ', $_SESSION['wpsg']['checkout']['name']; ?></h4>
            <p><?php echo stripslashes($print_options['disclaimer']); ?></p>
            <?php if($post_timestamp > $date_limit){ ?>
                <p><?php _e('Copyright © ' . date('Y') . ' Versicherungsmonitor. All rights reserved.', 'opti' ); ?></p>
            <?php } ?>
        </div>
        <br clear="all" />
        <?php if (have_posts()): ?>
            <?php while (have_posts()): the_post(); ?>
                <h1 id="BlogTitle"><?php the_title(); ?></h1>
                <p id="BlogDate"><?php _e('Posted By', 'wp-print'); ?> <u><?php echo coauthors( null, sprintf( ' und '), null, null, false ); ?></u> <?php _e('On', 'wp-print'); ?> <?php the_time(sprintf(__('%s', 'wp-print'), get_option('date_format'))); ?> <?php _e('In', 'wp-print'); ?> <?php print_categories('<u>', '</u>'); ?> | <u><a href='#comments_controls'><?php print_comments_number(); ?></a></u> | <u><a href="#Print" onclick="window.print(); return false;" title="Drucken">Drucken</a></u></p>
                <div id="BlogContent"><?php print_content(); ?></div>
            <?php endwhile; ?>
            <hr class="Divider" style="text-align: center;" />
            <?php if(print_can('comments')): ?>
                <?php comments_template(); ?>
            <?php endif; ?>
            <p><?php _e('Article printed from', 'wp-print'); ?> <?php bloginfo('name'); ?>: <strong dir="ltr"><?php bloginfo('url'); ?></strong></p>
            <p><?php _e('URL to article', 'wp-print'); ?>: <strong dir="ltr"><?php the_permalink(); ?></strong></p>
            <?php if(print_can('links')): ?>
                <p><?php print_links(); ?></p>
            <?php endif; ?>
        <?php else: ?>
            <p><?php _e('No posts matched your criteria.', 'wp-print'); ?></p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
