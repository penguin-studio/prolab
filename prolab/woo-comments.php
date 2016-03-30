<?php // Do not delete these lines
global $post;
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
global $current_user;

if ('open' == $post->comment_status) : ?>
<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<?php else :
        $readonly = '';
        if($user_ID){
            $readonly = 'readonly';
        }
?>
<form class="comment-form" action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" >
<input id="author" <?php echo $readonly; ?> name="author" type="text" value="<?php echo $current_user->user_login; ?>" placeholder="Как вас зовут?" required>
<input id="author" <?php echo $readonly; ?> name="email" type="email" value="<?php echo $current_user->user_email; ?>" placeholder="Електронный адрес?" required>
<textarea id="comment" name="comment" placeholder="Ваш комментарий" required></textarea>
<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
    <input id="button" type="submit" value="Добавить">
</form>
        <script>
            $ = jQuery;
            $(document).ready(function(){

            $('a#reply-button').bind('click', function(){

            var form = '<form id="comment-form-'+$(this).attr("comm-id")+'" class="comment-form" action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" >'
            +'<input id="author"  <?php echo $readonly; ?>  name="author" type="text" value="<?php echo $current_user->user_login; ?>" placeholder="Как вас зовут?" required>'
            +'<input id="author"  <?php echo $readonly; ?>  name="email" type="email" value="<?php echo $current_user->user_email; ?>"  placeholder="Електронный адрес?" required>'
            +'<textarea id="comment" name="comment" placeholder="Ваш комментарий" required></textarea>'
            +'<input type="hidden" name="comment_post_ID" value="'+$(this).attr("comm-post-id")+'" />'
            +'<input type="hidden" name="comment_parent" value="'+$(this).attr("comm-id")+'" />'
            +'<input id="cancel" comm-id="'+$(this).attr("comm-id")+'" type="button" value="Отмена">'
            +'<input id="button" type="submit" value="Добавить">'
            +'</form>';

            $('#comm-'+$(this).attr("comm-id")).after(form);

            $('input#cancel').bind('click',function(){
                $('#comment-form-'+$(this).attr("comm-id")).remove();
            });

            });
            });
        </script>
<!-- End Leave a Reply Box -->

<?php endif; // If registration required and not logged in ?>

<!-- Begin Comments List -->

<div id="commentBlock" class="comments">
<?php view_comments($post); ?>
</div>

<!-- End Comments List -->


<?php endif; // if you delete this the sky will fall on your head ?>
