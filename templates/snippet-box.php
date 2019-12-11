<?php
	$oec_page_url = get_permalink( get_page_by_path( 'editors-comment' ) ) . "?pid=".$_GET['pid'];
?>
<div class="row oec-snippet-box">
	<div class="orbit-oec-wrapper" >
		<div class="colo-sm-12 text-center">
			<h4 class="oec-title">Youth Ki Awaaz Editor Notes</h4>	
		</div>
		<div class="col-sm-12">
			<ul class="orbit-oec-comments"> <?php
				if(is_array($comments)) :
					if( count($comments) ): 
						//grab the last comment
						$comment = end($comments);
						$user = get_userdata($comment['commented_by'])->data;
	 					?>
						<li class="comment"> 
							<div class="comment-item">
								<div class="truncate-overflow">
								<?php _e($comment['comment']); ?>
								</div>
								<div class="comment-meta oec-mt-2">
									<p>Last Comment by:</p>
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
						<li class="text-center oec-mt-5"><a href="<?php _e($oec_page_url ); ?>" class="btn btn-primary">Comment/View More</a></li><?php
					else: ?>
						<li class="text-center oec-mt-5"><a href="<?php _e($oec_page_url ); ?>" class="text-center">Interact with YKA Team</a></li><?php
					endif;
				endif;?>	
			</ul>
		</div>
	</div>
</div>

