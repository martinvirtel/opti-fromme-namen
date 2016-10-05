<?php

    //Loads the translation file
    load_child_theme_textdomain('opti', get_stylesheet_directory() . '/languages');

    /* This function deactivats the Headline, beacause it was hard coded in the styles.css (#logo) */
    /* path to the files:
       desktop: images/banner.jpg
       mobile: images/banner_mobile.jpg
    */
    add_action('after_setup_theme', 'remove_custom_header', 11);
    if (function_exists('remove_theme_support')) {
        function remove_custom_header(){
            remove_theme_support('custom-header');
        }
    }

    /* Disables HTML in the comment area */
    function disable_html_in_comments()
    {
        global $allowedtags;
        $allowedtags = array();
    }
    disable_html_in_comments();

    /* Image Templates */
    add_image_size("full-width", 756);
    add_image_size("sidebar-image", 275);
    add_image_size("sidebar-image-full-width", 285);

    add_action( 'after_setup_theme', 'remove_parent_theme_features', 10 );

    function remove_parent_theme_features() {

        add_filter( 'intermediate_image_sizes_advanced', 'remove_parent_image_sizes' );

        function remove_parent_image_sizes( $sizes ) {
            unset( $sizes['post-loop'] );
            return $sizes;
        }

        if ( function_exists( 'add_image_size' ) ) {
            add_image_size( 'post-loop-big', 160, 130, true );
        }

    }

    /* Filter to replace the [caption] shortcode text */
    add_filter('img_caption_shortcode', 'my_img_caption_shortcode_filter',10,3);
    function my_img_caption_shortcode_filter($val, $attr, $content = null)
    {
        extract(shortcode_atts(array(
            'id'	=> '',
            'align'	=> '',
            'width'	=> '',
            'caption' => ''
        ), $attr));

        if ( 1 > (int) $width || empty($caption) )
            return $val;

        $capid = '$id';
        if ( $id ) {
            $id = esc_attr($id);
            $capid = 'id="figcaption_'. $id . '" ';
            $id = 'id="' . $id . '" aria-labelledby="figcaption_' . $id . '" ';
        }

        $copyright = '';
        if (function_exists('thisismyurl_has_custom_media_field')) {
            $copyright = generate_copyright(str_replace('attachment_','', $attr['id']));
        }

        return '<div ' . $id . 'class="wp-caption ' . esc_attr($align) . '" style="width: '
        . (10 + (int) $width) . 'px">' . do_shortcode( $content ) . '<p ' . $capid
        . 'class="wp-caption-text">' . $caption . '</p>' . $copyright . '</div>';
    }

    add_action('after_setup_theme', 'remove_admin_bar');

    function remove_admin_bar() {
      if (!current_user_can('manage_options') && !is_admin()) {
      show_admin_bar(false);
     }
    }

    function generate_copyright($imgId) {
        $imageAttr   = thisismyurl_get_custom_media_field($imgId, 'image_copyright' );
        $imageAttrCC    = thisismyurl_get_custom_media_field($imgId, 'image_cc_by' );
        $imageAttrCCUrl = thisismyurl_get_custom_media_field($imgId, 'image_cc_url' );

        if ($imageAttrCC != '') {
            return '&copy;&nbsp;<a href="https://creativecommons.org/licenses/by/4.0/legalcode" target="_blank">CC</a> by <a href="' . $imageAttrCCUrl . '" target="_blank">' . $imageAttrCC . '</a>';
        } elseif (!empty($imageAttr)){
            return $imageAttr;
        }

        return false;
    }

    /* Static excerpt after every article */
    function new_excerpt_more() {
        return "";
    }
    add_filter('excerpt_more', 'new_excerpt_more');

    function opti_replace_excerpt( $content ) {
        global $post;
        // find first closing </p> - add the readmore link to it. and cut anything else....
        return substr($content,0, strpos($content, "</p>")) . sprintf( __( '... <a href="%s" class="read-more">Read More &rsaquo;</a>', 'opti' ), esc_url( get_permalink() ) );
    }
    add_filter( 'the_excerpt', 'opti_replace_excerpt' );

    /* Function for shortcodes in excerpts */
    remove_filter( 'get_the_excerpt', 'wp_trim_excerpt'  ); // Remove the filter
    remove_filter( 'get_the_excerpt', 'wp_trim_words'  ); // Remove the filter

    /* excerpt trim function */
    function wp_custom_trim_excerpt($text = '') {

        $raw_excerpt = $text;
        if ( '' == $text ) {
            $text = get_the_content('');
            $text = do_shortcode($text);
            $text = apply_filters( 'the_content', $text );
            $text = str_replace(']]>', ']]&gt;', $text);
            $excerpt_length = apply_filters( 'excerpt_length', 80 );
            $excerpt_more = apply_filters( 'excerpt_more', ' ' . '[&hellip;]' );
            $text = wp_custom_trim_words( $text, $excerpt_length, $excerpt_more );
        }
        return apply_filters( 'wp_custom_trim_excerpts', $text, $raw_excerpt );

    }

    /* custom trim words function */
    function wp_custom_trim_words( $text, $num_words = 80, $more = null ) {

        if ( null === $more )
            $more = __( '&hellip;' );
            $original_text = $text;
            $text = do_shortcode( $text );
        if ( 'characters' == _x( 'words', 'word count: words or characters?' ) && preg_match( '/^utf\-?8$/i', get_option( 'blog_charset' ) ) ) {
            $text = trim( preg_replace( "/[\n\r\t ]+/", ' ', $text ), ' ' );
            preg_match_all( '/./u', $text, $words_array );
            $words_array = array_slice( $words_array[0], 0, $num_words + 1 );
            $sep = '';
        } else {
            $words_array = preg_split( "/[\n\r\t ]+/", $text, $num_words + 1, PREG_SPLIT_NO_EMPTY );
            $sep = ' ';
        }
        if ( count( $words_array ) > $num_words ) {
            array_pop( $words_array );
            $text = implode( $sep, $words_array );
            $text = $text . $more;
        } else {
            $text = implode( $sep, $words_array );
        }
        return apply_filters( 'wp_custom_trim_words', $text, $num_words, $more, $original_text );

    }
    add_filter( 'get_the_excerpt', 'wp_custom_trim_excerpt' );
    add_filter( 'get_the_excerpt', 'wp_custom_trim_words' );
    add_filter( 'the_excerpt', 'do_shortcode' ); // Make sure shortcodes get processed

    /* Special Case for Search Results */

    function my_search_excerpt_highlight() {

        $excerpt = get_the_content();
        $keys = implode( '|', explode( ' ', get_search_query() ) );
        $excerpt = apply_filters( 'the_content', $excerpt);
        $excerpt = preg_replace( '/(' . $keys . ')/iu', '<strong class="search-highlight">\0</strong>', $excerpt );
        $excerpt = opti_replace_excerpt( $excerpt );

        echo $excerpt;

    }

    /* ------------ Adds a box to the main column ------------ */

    /* Define the custom box */
    add_action( 'add_meta_boxes', 'wpse_61041_add_custom_box' );

    /* Do something with the data entered */
    add_action( 'save_post', 'wpse_61041_save_postdata' );

    /* Adds a box to the main column on the Post and Page edit screens */
    function wpse_61041_add_custom_box() {
        add_meta_box(
            'wpse_61041_sectionid',
            'Top News Beitragsbild',
            'wpse_61041_inner_custom_box',
            'post',
            'side',
            'default'
        );
    }

    add_filter('posts_orderby','my_sort_custom',10,2);
	function my_sort_custom( $orderby, $query ){
	    global $wpdb;

	    if(!is_admin() && is_search())
	        $orderby =  "{$wpdb->prefix}posts.post_date DESC";

	    return  $orderby;
	}

    /* Prints the box content */
    function wpse_61041_inner_custom_box($post)
    {
        // Use nonce for verification
        wp_nonce_field( 'wpse_61041_wpse_61041_field_nonce', 'wpse_61041_noncename' );

        // Get saved value, if none exists, "default" is selected
        $saved = get_post_meta( $post->ID, 'title_image_width', true);
        if( !$saved )
            $saved = 'default';

        $fields = array(
            'default'   => __('Standard', 'wpse'),
            'full-width'      => __('Volle breite', 'wpse')
        );

        foreach($fields as $key => $label)
        {
            printf(
                '<input type="radio" name="title_image_width" value="%1$s" id="title_image_width[%1$s]" %3$s />'.
                '<label for="title_image_width[%1$s]"> %2$s ' .
                '</label><br>',
                esc_attr($key),
                esc_html($label),
                checked($saved, $key, false)
            );
        }
    }

    /* When the post is saved, saves our custom data */
    function wpse_61041_save_postdata( $post_id )
    {
        // verify if this is an auto save routine.
        // If it is our form has not been submitted, so we dont want to do anything
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
            return;

        // verify this came from the our screen and with proper authorization,
        // because save_post can be triggered at other times
        if ( !wp_verify_nonce( $_POST['wpse_61041_noncename'], 'wpse_61041_wpse_61041_field_nonce' ) )
            return;

        if ( isset($_POST['title_image_width']) && $_POST['title_image_width'] != "" ){
            update_post_meta( $post_id, 'title_image_width', $_POST['title_image_width'] );
        }
    }

    /* Add new post type for newsletter archive */
    add_action( 'init', 'create_post_type' );
    function create_post_type() {
        register_post_type( 'newsletter_archive',
            array(
                'labels' => array(
                    'name' => __( 'Newsletter Archiv' ),
                    'singular_name' => __( 'Newsletter Archiv' )
                ),
                'public' => true,
                'has_archive' => true,
                'taxonomies' => array('category'),
                'supports' => array('title', 'author', 'editor', 'excerpt', 'thumbnail'),
            )
        );
    }

    /* Exclude a Category from Search Results */
    add_filter( 'pre_get_posts' , 'search_exc_cats' );
    function search_exc_cats( $query ) {
        if( $query->is_admin )
            return $query;

        if( $query->is_search ) {
            $query->set( 'category__not_in' , array( 2425 ) ); // Cat ID from newsletter_archive
        }
        return $query;
    }

    // exclude categories from main loop at homepage
    add_filter( 'pre_get_posts', function ( $query ) {
        if ( $query->is_home() && $query->is_main_query()) {
            $term_shortnews = get_term_by( 'name', 'kurznachrichten', 'category' );
            $term_featured = get_term_by( 'name', 'short-news', 'category' );
            $query->set( 'category__not_in', $term_shortnews->term_id, $term_featured->term_id );
        }
    });

    ### Function: Display Print Link
    function print_link_custom($print_post_text = '', $print_page_text = '', $echo = true, $custom = true)
    {
        $postType = get_post_type();
        $polyglot_append = '';
        if (function_exists('polyglot_get_lang')) {
            global $polyglot_settings;
            $polyglot_append = $polyglot_settings['uri_helpers']['lang_view'] . '/' . polyglot_get_lang() . '/';
        }
        $output          = '';
        $using_permalink = get_option('permalink_structure');
        $print_options   = get_option('print_options');
        $print_style     = intval($print_options['print_style']);
        if (empty($print_post_text)) {
            $print_text = stripslashes($print_options['post_text']);
        } else {
            $print_text = $print_post_text;
        }
        $print_icon = plugins_url('wp-print/images/' . $print_options['print_icon']);
        $print_link = get_permalink();
        $print_html = stripslashes($print_options['print_html']);
        // Fix For Static Page
        if (get_option('show_on_front') == 'page' && is_page()) {
            if (intval(get_option('page_on_front')) > 0) {
                $print_link = _get_page_link();
            }
        }
        if ($postType === 'newsletter_archive') {
            $print_link = $print_link . '?print=1';
        } else if(!empty($using_permalink)) {
            if (substr($print_link, -1, 1) != '/') {
                $print_link = $print_link . '/';
            }
            if (is_page()) {
                if (empty($print_page_text)) {
                    $print_text = stripslashes($print_options['page_text']);
                } else {
                    $print_text = $print_page_text;
                }
                $print_link = $print_link . 'printpage/' . $polyglot_append;
            } else {
                $print_link = $print_link . 'print/' . $polyglot_append;
            }
        } else {
            if (is_page()) {
                if (empty($print_page_text)) {
                    $print_text = stripslashes($print_options['page_text']);
                } else {
                    $print_text = $print_page_text;
                }
            }
            $print_link = $print_link . '&amp;print=1';
        }
        unset($print_options);
        switch ($print_style) {
            // Icon + Text Link
            case 1:
                $output = '<a href="' . $print_link . '" title="' . $print_text . '" rel="nofollow"><img class="WP-PrintIcon" src="' . $print_icon . '" alt="' . $print_text . '" title="' . $print_text . '" style="border: 0px;" /></a>&nbsp;<a href="' . $print_link . '" title="' . $print_text . '" rel="nofollow">' . $print_text . '</a>';
                break;
            // Icon Only
            case 2:
                $output = '<a href="' . $print_link . '" title="' . $print_text . '" rel="nofollow"><img class="WP-PrintIcon" src="' . $print_icon . '" alt="' . $print_text . '" title="' . $print_text . '" style="border: 0px;" /></a>';
                break;
            // Text Link Only
            case 3:
                $output = '<a href="' . $print_link . '" title="' . $print_text . '" rel="nofollow">' . $print_text . '</a>';
                break;
            case 4:
                $print_html = str_replace("%PRINT_URL%", $print_link, $print_html);
                $print_html = str_replace("%PRINT_TEXT%", $print_text, $print_html);
                $print_html = str_replace("%PRINT_ICON_URL%", $print_icon, $print_html);
                $output     = $print_html;
                break;
        }
        if ($echo) {
            echo $output . "\n";
        } else {
            return $output;
        }
    }

/**
 * fill empty post thumbnails with images from the first attachment added to a post
 *
 * @param string $html
 * @param int $post_id
 * @param int $thumbnail_id
 * @param string $size
 * @return string
 */
function opti_fromme_post_thumbnail_html( $html, $post_id, $thumbnail_id, $size = '' ) {

    // no thumbnail given, no image to display
    if (!$thumbnail_id) {
        return '';
    }

    if ( empty( $html ) ) {

        $html = '';

        $values = get_children(
            array(
                'post_parent' => $post_id,
                'post_type' => 'attachment',
                'post_mime_type' => 'image',
                'order' => 'ASC',
                'orderby' => 'menu_order',
                'numberposts' => 1,
            )
        );

        if ( $values ) {
            foreach ( $values as $child_id => $attachment ) {
                $html = wp_get_attachment_image( $child_id, $size );
                break;
            }

            // add required image styles
            $html = str_replace( 'attachment-post-loop', 'attachment-post-loop wp-post-image', $html );
            $html = str_replace( 'attachment-featured', 'attachment-featured wp-post-image', $html );
            $html = str_replace( 'attachment-archive', 'attachment-archive wp-post-image', $html );
        }
    }

    return $html;
}
add_filter( 'post_thumbnail_html', 'opti_fromme_post_thumbnail_html', 11, 4 );

//Fix SSL on Post Thumbnail URLs
function ssl_post_thumbnail_urls($url, $post_id) {
    //Skip file attachments
    if( !wp_attachment_is_image($post_id) )
        return $url;

    //Correct protocol for https connections
    list($protocol, $uri) = explode('://', $url, 2);
//    if( is_ssl() ) {
    if( true ) {
        if( 'http' == $protocol )
            $protocol = 'https';
    } else {
        if( 'https' == $protocol )
            $protocol = 'http';
    }

    return $protocol.'://'.$uri;
}
add_filter('wp_get_attachment_url', 'ssl_post_thumbnail_urls', 10, 2);
?>
