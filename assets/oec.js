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
			},
			error: function(response) {
				$el.html("<p>Request Cannot Be Proccessed!</p>")
			}

		});
	});
};


jQuery.fn.orbit_oec_post_comment = function(event){
	
	event.preventDefault();
	
	var $form = $(this).closest("form");
	var comment = $form.find('input[name="comment"]').val();
	var ajaxUrl = $form.data('url'); 
	
	var $masterContainer = $(this).closest('.orbit-editor-comment');
	var pid = $masterContainer.data('pid');
	var uid = $masterContainer.data('uid')
	
	var commentsContainer = $masterContainer.find('.orbit-oec-comments');
	commentsContainer.append('<li class="comment">'+comment+'</li>');
	
	$.ajax({
		type:"post",
		data: {
			comment: comment,
			pid: pid,
			uid: uid
		},
		url: ajaxUrl,
		success: function(response) {
			console.log('OEC Comment Posted');
		},
		error: function(response) {
			console.log("<p>OEC Comment Cannot Be Posted!</p>")
		}

	});
	
};


jQuery( document ).ready( function(){
	jQuery('[data-behaviour~=orbit-oec-form]').orbit_oec_comment_form();
	jQuery('[data-behaviour~=orbit-oec-form]').on('click', 'button', jQuery.fn.orbit_oec_post_comment );
});
