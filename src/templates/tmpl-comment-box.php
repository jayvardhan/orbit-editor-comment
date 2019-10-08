<div class="orbit-oec-wrapper row">
	<div class="col-sm-12">
		<ul class="orbit-oec-comments">
			<?php
				if(is_array($comments) && count($comments) ) : 
					foreach ($comments as $key => $comment) : ?>
						<li class="comment">
							<?php _e(stripslashes($comment['comment'])); ?>
							<div class="comment-meta"><a href="<?php _e( get_author_posts_url( $user->ID )); ?>"><?php _e($user->display_name); ?></a> on <?php _e($comment['commented_on'])?></div>
						</li>
					<?php endforeach;
				endif; ?>	
		</ul>
	</div>
	<div class="col-sm-12">
		<form data-url="<?php _e(admin_url('admin-ajax.php').'?action=orbit_oec_post_comment' );?>">
			<input type="text" name="comment"class="text">
			<button class="oec-comment-btn">Send</button>	
		</form>
	</div>
</div>

