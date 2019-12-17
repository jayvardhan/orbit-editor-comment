<?php
	$oec_page_url = get_permalink( get_page_by_path( 'editors-comment' ) ) . "?pid=".$_GET['pid'];
?>
<div class="row oec-snippet-box">
	<div class="orbit-oec-wrapper" >
		<div class="colo-sm-12 text-center">
			<h4 class="oec-title">Youth Ki Awaaz Editor Notes</h4>	
		</div>
		<div class="col-sm-12">
			<ul class="orbit-oec-comments">
				<li class="text-center oec-mt-5"><a href="<?php _e($oec_page_url ); ?>" class="text-center">Add Note</a></li>	
			</ul>
		</div>
	</div>
</div>

