<div class="row">
	<div class="orbit-oec-wrapper" >
	<div class="colo-sm-12 text-center">
		<h4>Youth Ki Awaaz Editor Notes</h4>	
	</div>
	<div class="col-sm-8 col-sm-offset-2">
		<ul class="orbit-oec-comments">
			<?php
				if(is_array($comments) && count($comments) ) : 
					foreach ($comments as $key => $comment) : 
						$user = get_userdata($comment['commented_by'])->data;
	 					?>
						<li class="comment"> 
							<div class="comment-item <?php $this->is_me((int)$comment['commented_by']) ? _e('comment-strong'):''; ?>">
								<?php _e(stripslashes($comment['comment'])); ?>

								<div class="comment-meta">
									<a href="<?php _e( get_author_posts_url( $user->ID )); ?>"> <?php
										if(function_exists('yka_get_avatar')){ 
											echo yka_get_avatar($user->ID, 30);
											echo "&nbsp;&nbsp;";    
										}  
										_e($user->display_name); 
									?>
									</a> on <?php _e($comment['commented_on'])?>
								</div>
							</div>
						</li>
					<?php endforeach;
				endif; ?>	
		</ul>
	</div>
	<div class="col-sm-8 col-sm-offset-2">
		<form class="oec-form form-inline input-group input-group-lg" data-url="<?php _e(admin_url('admin-ajax.php').'?action=orbit_oec_post_comment' );?>">
			<input type="text" name="comment"class="text form-control input-lg">
			<span class="input-group-btn">
				<button class="oec-comment-btn btn btn-primary" disabled="true">Send &nbsp;<i class="fas fa-sync fa-spin" style="display: none;"></i></button>
			</span>
		</form>
	</div>
</div>
</div>
