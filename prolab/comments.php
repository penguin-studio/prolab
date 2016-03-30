<?php // Do not delete these lines
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
die ('Please do not load this page directly. Thanks!');
if (!empty($post->post_password)) { // if there's a password
if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
?>

<p class="nocomments">Защищено паролем. Введите пароль для просмотра.</p>

<?php
return;
}
}

if ('open' == $post->comment_status) : ?>
<div class="form-box-1">
<div class="container form-1-container box-padding">
<?php if ( get_option('comment_registration') && !$user_ID ) : ?>

<p>Пожалуйста, <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">зарегистрируйтесь </a> для комментирования.</p>

<?php else : ?>

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
<fieldset>
	<div class="col-xs-12">
		<h1>ЗАДАТЬ ВОПРОС</h1>
	</div>
<?php
$readonly = '';
if($user_ID){
	$readonly = 'readonly';
}
?>
<div class="col-xs-12 col-sm-3 comm-left-input">
<div>
<span class="required">*</span><input <?php echo $readonly;?> class="form1-inp comm-inp" type="text" name="author" id="author" value="<?php echo $comment_author; ?>" placeholder="Имя" tabindex="1" class="replytext" <?php if ($req) echo "aria-required='true'"; ?> />
</div>
<div>
<span class="required">*</span><input <?php echo $readonly;?> class="form1-inp comm-inp" type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" placeholder="Email" tabindex="2" class="replytext" <?php if ($req) echo "aria-required='true'"; ?> />
</div>
<input class="form1-inp comm-inp" type="text" name="phone" id="url" value="<?php echo $comment_author_url; ?>" placeholder="Телефон" tabindex="3" class="replytext" />


</div>
<div class="col-xs-12 col-sm-6">
<textarea name="comment" id="comment" class="form1-inp" tabindex="4" class="replyarea" placeholder="Комментарий"></textarea>
</div>
<div class="col-xs-12 col-sm-3">
<button name="submit" type="submit" class="comm-sbm" id="submit" tabindex="5"> Отправить </button>
<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
<p class="required-text"><span class="required">*</span>- обязательные поля для заполнения</p>
</div>
<?php do_action('comment_form', $post->ID); ?>

</fieldset>
</form>
</div>
</div>
<!-- End Leave a Reply Box -->

<?php endif; // If registration required and not logged in ?>

<!-- Begin Comments List -->
<?php if ($comments) : ?>
	<div class="container box-padding">

	<?php $comment_count = count($comments); ?>

	<h1 class="comments-count">Всего комментариев:<?php echo ' '.$comment_count;?></h1>
<ul class="commentlist">
<?php foreach ($comments as $comment) : ?>
<?php $comment_type = get_comment_type(); ?>
<?php if($comment_type == 'comment') { ?>
	<?php
		$reply_class = '';
		if($comment->comment_parent != 0){
				$reply_class = 'comment-reply';
		}
	?>
<li id="comment-<?php comment_ID() ?>" class="<?php echo $reply_class; ?>">



<div class="comment-single-box ">
	<div class="comment-single-row-1">
		<div class="comment-single-author"><?php comment_author_link() ?></div>
		<div class="comment-separ-line">|</div>
		<div class="comment-single-date"><?php comment_date('F j, Y'); ?></div>
			<?php edit_comment_link('изменить','&nbsp;&nbsp;',''); ?>
			<div class="comments-moderation">
				<?php if ($comment->comment_approved == '0') : ?>Спасибо! Ваш комментарий отправлен на модерацию.<?php endif; ?>
			</div>
			<div class="clear"></div>
	</div>
	<div class="comment-single-row-2">
		<div class="comment-single-text">
			<?php comment_text() ?>
		</div>
	</div>
	<div class="comment-single-row-3">
		<?php
		$args = array( 'reply_text' => "ответить на комментарий", 'depth' => 2);
		 echo comment_reply_link( $args );
		 ?>
	</div>
</div>
<div class="clear"></div>

</li>

<?php } /* End of is_comment statement */ ?>
<?php endforeach; ?>
</ul>
</div>
<!-- End Comments List -->

<?php endif; ?>

<?php endif; // if you delete this the sky will fall on your head ?>
