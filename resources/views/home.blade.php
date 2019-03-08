@extends('layouts.body')

@section('content')

<style>
.modal-full {
    min-width: 100%;
    margin: 0;
}

.modal-full .modal-content {
    min-height: 100vh;
}
</style>

<script>
function newDocument(){



	 var options = {
        "type": "post",
        "url": "./saveDocument",
        "dataType": "json",
        "beforeSerialize": function () {},
        "beforeSubmit": function () {

            dialog.setMessage($("#preloaders").html());
            dialog.setTitle("Data upload");
            dialog.setButtons([{
                    label: "Close",
                    action: function () {
                        dialog.hide();
                    }
                }]);

            dialog.show();
        },
        "success": function (data) {

			
            if (data.st == 1)
            {

                dialog.setMessage('Document successfully uploaded');

                var buttons = [{
                        label: "Close",
                        action: function () {
							window.location.reload();
                            dialog.hide();
                        }
                    }];


                dialog.setButtons(buttons);

                

            } else
            {
                dialog.setMessage('Error, please try again later.');

            }



        }
    };


	var $form = $("<form></form>").attr("enctype","multipart/form-data");

	$form.append('<input type="hidden" name="csrf-token" value="{{ csrf_token() }}"/>');
	$form.append('<input type="file" name="filedata"/>');
	$form.append('<br/><em></em>');

	dialog.setMessage($form);

	
	dialog.getBody().find('form').validate({
		"submitHandler": function (form) {
			$(form).ajaxSubmit(options);
		},
		"rules": {
			"filedata": {"required": true, 'accept': "image/*"}

		},
		"errorPlacement": function (error, element) {

			error.appendTo(element.parent().find("em"));
		}
	});




	dialog.setTitle('File upload');

	var buttons = [
		{
			"label":"Upload",
			"action":function(){
				dialog.getBody().find('form').submit()
			},
			"cssClass":"btn-primary"
		},
		{
			"label":"Close",
			"action":function(){
				dialog.hide();
			},
			
		}

	];
	
	dialog.setButtons(buttons);
	dialog.getBody().find('.modal-dialog').removeClass('modal-full')
	dialog.show();
}

function showDocument(id){

	dialog.setTitle('Document viewer');
	
	﻿
﻿

	$.ajax({
        url: "./getDocument/"+id,
        data: {
            a: "i_go_pdf",
        },
        type: "POST",
		beforeSend:function(){
			
			dialog.setMessage($("#preloaders").html());
            dialog.setTitle("Data upload");
            dialog.setButtons([{
                    label: "Close",
                    action: function () {
                        dialog.hide();
                    }
                }]);

            dialog.show();
			
		},
        
        success: function(data){
			dialog.getBody().find('.modal-dialog').addClass('modal-full')
			dialog.setMessage(data);
        }
    });

	

}

</script>

<form>


</form>

<div class="row">
	<div class="col-md-6">
		<h1>Thumb list</h1>
	</div>
	
	<div class="col-md-6 text-right">

		<a class="btn btn-success" href="javascript:;" onclick="newDocument()">create</a>

	</div>
	
	@if(count($documents)>0)
		@foreach($documents as $document)
			<div class="col-md-3">
				<a href='javascript:;' onclick='showDocument({{$document->id}})'>
					<img class="img-fluid" src="{{asset('../storage/app/public/upload')}}/{{$document->thumbpath}}"/>
				</a>
				<br/>
				<br/>
			</div>
		@endforeach
		<div style="clear:both;"></div>
		
		<div class="col-md-12 text-center">
			<br/>
		<br/>
			{{$documents->links()}}	
		</div>
	@else
		<div class="col-md-12">
			<div class="alert alert-info">Nothing found</div>
		</div>
	@endif

	

</div>




@endsection