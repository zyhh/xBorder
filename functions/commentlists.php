<?php

	add_filter('get_comments_number', 'comment_count', 0);function comment_count( $count ) {if ( ! is_admin() ) {global $id;$comments_by_type = &separate_comments(get_comments('status=approve&post_id=' . $id));return count($comments_by_type['comment']);} else {return $count;}}
	
	add_filter('smilies_src','custom_smilies_src',1,10);
function custom_smilies_src ($img_src, $img, $siteurl){
    return get_bloginfo('template_directory').'/images/smilies/'.$img;
}
	function devecomment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; 
   global $commentcount;
	if(!$commentcount) { //初始化楼层计数器
		$page = get_query_var('cpage')-1;
		$cpp=get_option('comments_per_page');//获取每页评论数
		$commentcount = $cpp * $page;
	}?>
   
   <div align="left"></div>
   <li <?php comment_class('clearfix'); ?><?php if( $depth > 2){ echo ' style="margin-left:-35px;"';} ?> id="comment-<?php comment_ID() ?>" >
   <div class="commentsgood">
	 <div class="avatarbg"><?php echo get_avatar($comment,$size='38'); ?></div>
     <div id="comment-<?php comment_ID(); ?>">
	  <div class="comment-meta">
	   <?php printf(__('<span class="name">%s</span>'), get_comment_author_link()) ?>
		<span class="comment_mete_time"><?php echo time_ago(); ?></span>
		<span class="reply"><?php comment_reply_link(array_merge( $args, array('reply_text' => '@Ta','depth' => $depth, 'max_depth' => $args['max_depth']))) ?></span>
	  </div>
	  
	  <?php if ($comment->comment_approved == '0') : ?>
         <em><span class="moderation"><?php _e('Your comment is awaiting moderation.') ?></span></em>
         <br />
      <?php endif; ?>
	  
      <div class="text">
		  <?php comment_text() ?>
	  </div>
	  
      
	  <span class="floor"><!-- 主评论楼层号 by zwwooooo -->
			<?php
if(!$parent_id = $comment->comment_parent){
	switch ($commentcount){
		case 0 :echo "<font style='color:#cc0000'>厉害，你是人中之龙！</font>";++$commentcount;break;
		case 1 :echo "<font style='color:#93BF20'>一人之下，万人之上！</font>";++$commentcount;break;
		case 2 :echo "<font style='color:#000000'>擦，3楼你也好意思出来混！</font>";++$commentcount;break;
		default:printf('%1$s楼', ++$commentcount);
	}
}
?>
		</span>
     </div></div>
  <?php
}
		////////嵌套ping
		function devepings($comment, $args, $depth) {
			   $GLOBALS['comment'] = $comment;
		?>
			<li id="comment-<?php comment_ID(); ?>">
				<div class="pingdiv">
					<?php comment_author_link(); ?>
				</div>
		<?php }
///////////////////// Commentlist结束////////////////////////
	
	
?>