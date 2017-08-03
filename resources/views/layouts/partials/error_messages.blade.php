@if (session('success'))
	<script>
		$( document ).ready(function() {
		    //show message if any
		    //alertify.success("{{ session('success') }}");

		    $.toast().reset('all');
				$("body").removeAttr('class');
				$.toast({
		            heading: 'Success',
		            text: '{!! session('success') !!}',
		            position: 'top-right',
		            loaderBg:'#fec107',
		            icon: 'success',
		            hideAfter: 7500, 
		            stack: 6
		        });
				return false;
		});
	</script>
@endif

@if (session('error'))
	<script>
		$( document ).ready(function() {
		    //show message if any
		    //alertify.error("{{ session('error') }}");

		    //dialog
		    //define a new errorAlert base on alert
			/*if(!alertify.errorAlert){
				alertify.dialog('errorAlert',function factory(){
				    return{
				            build:function(){
				                var errorHeader = '<span class="fa fa-times-circle fa-2x" '
				                +    'style="vertical-align:middle;color:#e10000;">'
				                + '</span> &nbsp;&nbsp;&nbsp;&nbsp;<span class="text-danger"> Error Occured</span>';
				                this.setHeader(errorHeader);
				            }
				        };
				},true,'alert');
			}*/

			//show the error
			/*alertify
			    .errorAlert("{!! session('error') !!} ");*/


			$.toast().reset('all');
				$("body").removeAttr('class');
				$.toast({
		            heading: 'An Error Occured',
		            text: '{!! session('error') !!}',
		            position: 'top-right',
		            loaderBg:'#fec107',
		            icon: 'error',
		            hideAfter: 7500, 
		            stack: 6
		        });
				return false;

		});
	</script>
@endif