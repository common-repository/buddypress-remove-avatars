jQuery(document).ready(function($){

	//finds the link to the avatar page
	//grabs the parent "li" and hides it
	$('a[href*=group-avatar]').parent().hide();

	//if the button block div is present but empty
	//we're on a page with only an avatar in the left column
	if( $('.button-block').size() > 0 ) {
		if(!jQuery.trim($('div.button-block').html())){
			$('#content div.left-menu').css('display','none');
			$('.internal-page .main-column').css('margin-left','10px');
		}
		
	}

});
