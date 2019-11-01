jQuery.fn.orbit_oec_comment_form = function(){

	return this.each(function(){
		var $el = $(this);
		var pid = $el.data('pid');
		var uid = $el.data('uid');
		var ajaxUrl = $el.data('url') + "&pid="+ pid + "&uid="+uid;

		$.ajax({
			type:"get",
			url: ajaxUrl,
			success: function(response) {
				$el.html(response);
				$('.oec-comment-btn').prop('disabled',false);
			},
			error: function(response) {
				$el.html("<p>OEC: Form Request Cannot Be Proccessed!</p>")
			}

		});
	});
};


jQuery.fn.orbit_oec_post_comment = function(event){
	
	event.preventDefault();
		
	var $form = $(this).closest("form");

	var comment = tinyMCE.get('oectinymce').getContent();
	comment = comment.trim();

	// this is not working as content is wrapped within p tags by tinymce
	if( comment == '' ) {
		return;
	}

	var ajaxUrl = $form.data('url'); 
	
	var $masterContainer = $('.orbit-editor-comment');
	var pid = $masterContainer.data('pid');
	var uid = $masterContainer.data('uid');

	var loader = $form.find('.fa-sync');
	loader.css('display', 'inline-block');

	var $btn = $form.find('.oec-comment-btn');
	$btn.prop('disabled', true);
	
	var payload = {
		comment: comment,
		pid: pid,
		uid: uid
	};	
	//console.log(payload);

	// set the content empty
	tinymce.get('oectinymce').setContent(''); 
	
	$.ajax({
		type:"post",
		data: payload,
		url: ajaxUrl,
		success: function(response) {
			loader.css('display', 'none');
			jQuery('[data-behaviour~=orbit-oec-form]').orbit_oec_comment_form();
		},
		error: function(response) {
			$btn.prop('disabled', false);
			loader.css('display', 'none');
			console.log("<p>OEC: Comment Cannot Be Posted!</p>")
		}

	});
	
};


jQuery( document ).ready( function(){
	jQuery('[data-behaviour~=orbit-oec-form]').orbit_oec_comment_form();
	//jQuery('[data-behaviour~=orbit-oec-form]').on('click', 'button', jQuery.fn.orbit_oec_post_comment );

	jQuery('.oec-comment-btn').on( 'click' ,jQuery.fn.orbit_oec_post_comment );	
	
});
