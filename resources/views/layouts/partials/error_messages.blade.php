@if (session('success'))
	
	<script>

		$( document ).ready(function() {
		    //show message if any

		    $.toast().reset('all');
				$("body").removeAttr('class');
				$.toast({
		            heading: 'Success',
		            text: '{!! session('success') !!}',
		            position: 'top-right',
		            loaderBg:'#fec107',
		            icon: 'success',
		            hideAfter: 10500, 
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

			$.toast().reset('all');
				$("body").removeAttr('class');
				$.toast({
		            heading: 'An Error Occured',
		            text: '{!! session('error') !!}',
		            position: 'top-right',
		            loaderBg:'#fec107',
		            icon: 'error',
		            hideAfter: 10500, 
		            stack: 6
		        });
				return false;

		});

	</script>
	
@endif