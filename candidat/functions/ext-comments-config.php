<?php
/*------------------------------------*\
		Remove comments / author /
\*------------------------------------*/
/*
 * Remove comments from post and pages
 */
add_action('init', 'remove_comment_support', 100);
function remove_comment_support(){
  remove_post_type_support( 'post', 'comments' );
  remove_post_type_support( 'page', 'comments' );

  remove_post_type_support( 'post', 'author' );
  remove_post_type_support( 'page', 'author' );

  remove_post_type_support( 'post', 'trackbacks' );
  remove_post_type_support( 'page', 'trackbacks' );

  remove_post_type_support( 'post', 'thumbnail' );
  remove_post_type_support( 'page', 'thumbnail' );
}

/*
 * Threaded Comments
 */
add_action('get_header', 'enable_threaded_comments');
function enable_threaded_comments(){
  if (!is_admin()) {
    if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
      wp_enqueue_script('comment-reply');
    }
  }
}

/*
 * Custom Comments Callback
 */
function html5blankcomments($comment, $args, $depth){
  $GLOBALS['comment'] = $comment;
  extract($args, EXTR_SKIP);

  if ( 'div' == $args['style'] ) {
    $tag = 'div';
    $add_below = 'comment';
  } else {
    $tag = 'li';
    $add_below = 'div-comment';
  } ?>

  <!-- heads up: starting < for the html tag (li or div) in the next line: -->
  <<?= $tag ?> <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">

  <?php if ('div' != $args['style']): ?>
  <div id="div-comment-<?php comment_ID() ?>" class="comment-body">
  <?php endif; ?>

	  <div class="comment-author vcard">
	    <?php
	    if ($args['avatar_size'] != 0){
	      echo get_avatar( $comment, $args['avatar_size'] );
	    }
	    printf(__('<cite class="fn">%s</cite> <span class="says">dit&nbsp;:</span>'), get_comment_author_link());
	    ?>
	  </div>

	  <?php if( $comment->comment_approved == '0' ): ?>
	  <em class="comment-awaiting-moderation"><?php _e('Votre commentaire est en attente de modération.') ?></em>
	  <br />
	  <?php endif; ?>

	  <div class="comment-meta commentmetadata">
	  	<a href="<?= htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
	    <?php printf( -('%1$s à %2$s'), get_comment_date(), get_comment_time()); ?>
	    </a>
	    <?php edit_comment_link(__('(Editer)'),'  ','' ); ?>
	  </div>

	  <?php comment_text() ?>

	  <div class="reply">
	    <?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
	  </div>

  <?php if( 'div' != $args['style'] ): ?>
  </div>
  <?php endif; ?>

<?php } ?>
