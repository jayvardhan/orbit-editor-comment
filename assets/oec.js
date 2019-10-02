jQuery.fn.orbit_editor_comment_form = function(){

	return this.each(function(){
		console.log('oec loaded!');
	});
};

jQuery( document ).ready( function(){
	jQuery('[data-behaviour~=orbit-editor-comment]').orbit_editor_comment_form();
});