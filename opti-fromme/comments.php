<?php
/**
 * Comments template.
 *
 * @package Opti
 */

// Do not delete these lines
if ( !empty( $_SERVER['SCRIPT_FILENAME'] ) && 'comments.php' == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
	die( __( 'Please do not load this page directly. Thanks!', 'opti' ) );
}

// If article is placed in category 7 (Archiv)
if ( post_password_required() || in_category(7)) {
	return;
}
// Show the comments
if ( have_comments() ) {
?>
	<h3 id="comments">
<?php
		printf( _n( '1 reply', '%1$s replies', get_comments_number(), 'opti' ), number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
?>
		<a href="#respond" title="<?php esc_attr_e( 'Leave a comment', 'opti' ); ?>">&raquo;</a>
	</h3>
	<ol class="commentlist" id="singlecomments">
		<?php wp_list_comments( 'type=comment&callback=opti_comment' ); ?>
	</ol>
	<div id="pagination">
		<div class="older">
			<?php previous_comments_link( __( '&lsaquo; Older Comments', 'opti' ) ); ?>
		</div>
		<div class="newer">
			<?php next_comments_link( __( 'Newer Comments &rsaquo;', 'opti' ) ); ?>
		</div>
	</div>
	<?php
}

if ( 'open' == $post->comment_status ) {
	if ( opti_has_trackbacks() ) {
		?>
		<h3 id="trackbacks"><?php _e( 'Trackbacks', 'opti' ); ?></h3>
		<ol id="trackbacklist">
			<?php
			foreach ( $comments as $comment ) {
				if ( $comment->comment_type == "trackback" || $comment->comment_type == "pingback" || ereg( "<pingback />", $comment->comment_content ) || ereg( "<trackback />", $comment->comment_content ) ) {
					?>
					<li id="comment-<?php comment_ID(); ?>"> 
						<cite><?php comment_author_link(); ?></cite>
					</li>
					<?php
				}
			}
			?>
		</ol>
		<?php
	}
	?>
	<div id="respond">
		<?php
		comment_form(array(
            'title_reply' => sprintf( __( 'Discuss with us', 'opti' )),
            'comment_notes_after' => '',
            'must_log_in' => '<p class="must-log-in">' .  sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'opti'), wp_login_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>'
        ));
		?>
	</div>
	<?php
}
?>