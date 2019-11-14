<!DOCTYPE html>
<html lang="en">

<head>

	  <meta charset="utf-8">
	  <meta http-equiv="X-UA-Compatible" content="IE=edge">
	  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	  <meta name="description" content="">
	  <meta name="author" content="">

	  <title>TimeTap</title>

	 <link rel="shortcut icon" href="<?= base_url('assets/img/favicon.ico') ?>" type="image/x-icon">
	 <link rel="icon" href="<?= base_url('assets/img/favicon.ico') ?>" type="image/x-icon">
	 <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">

	 <script src="<?= base_url('assets/vendor/jquery/jquery.min.js') ?>"></script>
	 <script src="<?= base_url('assets/js/sweetalert.min.js') ?>"></script>
	 <script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>	  
	 <script src="<?= base_url('assets/js/loadingoverlay.min.js') ?>"></script>

 </head>

<body id="page-top" data-urlbase="<?= base_url() ?>"> 

	<div class="container">
		<div class="row" style="margin-top: 7%;">
			<div class="col-3">
			</div>
	        <div class="col-6">
	        	<div style="width:300px; height: 500px; float:left">
	          		<img id="studentPhotoPreview" style="width: 100%; height: 100%;">
	      		</div>
	      		<div style="margin-left: 60%;">
	      			<span id="student"></span>
	      			<span id="time"></span>
	      			<span id="date"></span>
	      			<input type="text" id="scanner" class="form-control" autocomplete="off" style="opacity: -1">
	      			<br>
		        	<div id="fetcherElem" style="width:220px; height: 200px; float:left">
		        		<h4>Fetcher</h4>
		          		<img id="fetcherPhotoPreview" style="width: 100%; height: 100%;">
		      		</div>
	      		</div>
	        </div>
			<div class="col-3">
			</div>
		</div>
	</div>

</body>

<script>
	
	let base_url = $('body').data('urlbase');

	$('#scanner').focus();
	$('#fetcherElem').hide();

	$('#scanner').focusout(function(){
		$(this).focus();
	});

	$('#scanner').bind("enterKey",function(e) {
	   

		let identifierTag = $(this).val();
		let smsGateway = '<?= $this->config->item('sms_gateway1') ?>';
		
		let data = {
			identifierTag:identifierTag,
			smsGateway:smsGateway
		}

		setTimeout (function() {
			$.ajax({
			url: base_url+'Timelog/timeIn',
			type:'POST',
			data:data,
			beforeSend:function() {

				$.LoadingOverlay('show');
				$('#scanner').prop('disabled',true);
			},
			error: function(jqXHR, textStatus, errorThrown) {

				$('#scanner').prop('disabled',false);
				$('#scanner').val('');
				$('#scanner').focus();					
			},
			success:function(result) {
				
				$.LoadingOverlay('hide');

				let res = JSON.parse(result);

				if(res.status == 'success') {

					$('#student').html('<h4><b>'+res.student+'</b></h4>');
					$('#studentPhotoPreview').attr('src',base_url+'uploads/photoID/'+res.photo);
					$('#time').html('<h4><span style="color:#ff0000">'+res.tap+'</span>: '+res.time+'</h4>');
					$('#date').html('<h4>'+res.date+'</h4>');
					$('#scanner').prop('disabled',false);
					$('#scanner').focus();
				
					if(res.tap == 'OUT') {
						if(res.fetcher != '') {
							$('#fetcherElem').show();
							$('#fetcherPhotoPreview').attr('src',base_url+'uploads/fetcher/'+res.fetcher);
						}else {
							$('#fetcherElem').hide();
						}
					}else {
						$('#fetcherElem').hide();
					}

				}else {
					swal('Ooops!',res.message,'error');
				}

				$('#scanner').val('');
			}
		})

		},500);

	});
	$('#scanner').keyup(function(e){
	    if(e.keyCode == 13)
	    {
	        $(this).trigger("enterKey");
	    }
	});

</script>

</html>