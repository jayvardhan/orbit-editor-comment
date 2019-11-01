<?php
/*
* Template Name: Editor-Comment
*/


get_header();?>

<div class="container">
	<div class="row">
		<div class="col-sm-8 col-sm-offset-2"> 
			<h1 class="text-capitalize text-center title-font"><a href="<?php _e(get_permalink($_GET['pid'])); ?>"><?php _e(get_the_title($_GET['pid']));?></a></h1>
			<?php
			$shortcode = "[orbit_ec_form_loader post_id=". $_GET['pid'] ."]"; 			
			echo do_shortcode($shortcode); ?>
		</div>
		<div class="col-sm-8 col-sm-offset-2">
			<form class="oec-form" data-url="<?php _e(admin_url('admin-ajax.php').'?action=orbit_oec_post_comment' );?>" type="POST"> <?php
				
				wp_editor(
					'',
					'oectinymce', 
					array( 
						'tinymce'       => array(
		        			'toolbar1'  => 'bold,italic,underline,separator,alignleft,aligncenter,alignright,separator,link,unlink,undo,redo',
		        			'toolbar2'  => '',
		      			),
		      			'quicktags' 	=> false,
		      			'media_buttons' => false,
		      			'wpautop' 		=> false,
		      			'textarea_rows' => 10,
					)
				); ?>
				<button class="oec-comment-btn btn btn-primary oec-mt-2" disabled="true">Send &nbsp;<i class="fas fa-sync fa-spin" style="display: none;"></i></button>
			</form>
		</div>
	</div>
</div>

<?php get_footer();?>
