
var dialog = {};


dialog.setMessage = function(text)
{
	$("#dialog .modal-body").html(text);
	
}

dialog.setTitle = function(text)
{
	$("#dialog .modal-title").html(text);
	
}


dialog.setButtons = function(buttons)
{
	var html = '';
	

	for(a in buttons)
	{
		var cls = 'btn-default';
	
		if(buttons[a].cssClass)
		{
			cls = buttons[a].cssClass;
		}
		
		html += '<button id="button_'+a+'" type="button" class="btn '+cls+'">'+buttons[a].label+'</button>';
	}
	
	$("#dialog .modal-footer").html(html);
	
	
	$("#dialog .modal-footer button").each(function(index){
		
		$(this).bind('click',function(){
			
			buttons[index].action();
			
		});
		
	})
	
}

dialog.show = function(){
	
	
	$('#dialog').find('.modal-dialog').removeClass('modal-lg')
	$('#dialog').modal('show')
}


dialog.hide = function(){
	
	
	$('#dialog').modal('hide')
}

dialog.getBody = function(){

	return $('#dialog');
}



