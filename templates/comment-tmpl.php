<ul class="orbit-oec-comments"> <?php
	if(is_array($comments) && count($comments) ) : 
		foreach ($comments as $key => $comment) : 
			$user = get_userdata($comment['commented_by'])->data; ?>
			
			<li class="comment"> 
				<div class="comment-item <?php $this->is_me((int)$comment['commented_by']) ? _e('comment-strong'):''; ?>"> <?php 

					_e(stripslashes($comment['comment'])); ?>

					<div class="comment-meta">
						<a href="<?php _e( get_author_posts_url( $user->ID )); ?>"> <?php
							if(function_exists('yka_get_avatar')){ 
								echo yka_get_avatar($user->ID, 30);
								echo "&nbsp;&nbsp;";    
							}  
							_e($user->display_name); ?>
						</a> on <?php _e($comment['commented_on'])?>
					</div>
				</div>
			</li> <?php 
		endforeach;
	endif; ?>	
</ul>