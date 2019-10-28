<?php
/*
* Template Name: Editor-Comment
*/


get_header();?>

<div class="container">
	<div class="row">
		<div class="col-md-12"> 
			<h1 class="text-capitalize text-center title-font"><a href="<?php _e(get_permalink($_GET['pid'])); ?>"><?php _e(get_the_title($_GET['pid']));?></a></h1>
			<?php
			$shortcode = "[orbit_ec_form_loader post_id=". $_GET['pid'] ."]"; 
			echo do_shortcode($shortcode); ?>
		</div>
	</div>
</div>

<?php get_footer();?>
