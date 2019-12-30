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
	
	//remove the starting and trailing p tags added by wp_editor
	comment = comment.slice(3, comment.length - 4); 

	//trim any white spaces
	comment = comment.trim();

	//if empty return
	if( comment == '' ) {
		tinymce.get('oectinymce').setContent('');
		return;
	}

	var ajaxUrl = $form.data('url'); 
	
	var $masterContainer = $('.orbit-editor-comment');
	var pid = $masterContainer.data('pid');
	var uid = $masterContainer.data('uid');

	var recipients = $form.find('input:hidden').val();

	var loader = $form.find('.fa-sync');
	loader.css('display', 'inline-block');

	var $btn = $form.find('.oec-comment-btn');
	$btn.prop('disabled', true);
	
	var payload = {
		comment: comment,
		pid: pid,
		uid: uid,
		recipients: recipients
	};

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


jQuery.fn.orbit_oec_delete_comment = function(event){
	var $el = $(this),
		url = $el.data('url');

	$.ajax({
		url: url,
		success: function(response) {
			if(response == 'success') {
				$el.closest('li').hide();
			}
		}
	});
	
};


jQuery( document ).ready( function(){
	jQuery('[data-behaviour~=orbit-oec-form]').orbit_oec_comment_form();
	jQuery('.oec-comment-btn').on( 'click' , jQuery.fn.orbit_oec_post_comment );

	jQuery('.orbit-oec-container').on('click', '.oec-comment-delete', jQuery.fn.orbit_oec_delete_comment);

		
});
