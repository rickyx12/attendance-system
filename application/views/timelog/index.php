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
	 <script src="<?= base_url('assets/js/misc.js') ?>"></script>

 </head>

<body data-urlbase="<?= base_url() ?>" data-smsgateway="<?= $this->config->item('sms_gateway') ?>"> 

	<div class="container">
		<div class="row">
			<div class="col-md-4 jumbotron" style="height: 655px;">
				
				<img id="latestStudentPhoto" class="studentPhotoPreview" style="width: 100%; height: 100%;">
			
			</div>
			<div class="col-md-4 jumbotron" style="padding-top: 10%;">

				<input type="text" id="scanner" class="form-control" autocomplete="off" style="opacity: -1">
      			<span id="student"></span>
      			<span id="time"></span>
      			<span id="date"></span>
      			<br>
	        	<div id="fetcherElem" style="width:220px; height: 200px; float:left">
	        		<h4>Fetcher</h4>
	          		<img id="fetcherPhotoPreview" style="width: 100%; height: 100%;">
	      		</div>				

			</div>
			<div class="col-md-4" style="height: 655px;">
				<div class="row">
					<div class="col-md-12" style="height: 200px; margin-top: 5%; border: 1px solid black; margin-left: 5%;">
						
						<img id="photo1" class="studentPhotoPreview" style="width: 40%; height: 100%; float:left;">

		      			<div style="margin-left: 45%; margin-top: 10%;">
			      			<span id="name1" class="student-list"></span>
			      			<span id="time1" class="time-list"></span>
			      			<span id="date1" class="date-list"></span>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12 mt-2" style="height: 200px; border: 1px solid black; margin-left: 5%;">
						
						<img id="photo2" class="studentPhotoPreview" style="width: 40%; height: 100%; float:left;">

		      			<div style="margin-left: 45%; margin-top: 10%;">
			      			<span id="name2" class="student-list"></span>
			      			<span id="time2" class="time-list"></span>
			      			<span id="date2" class="date-list"></span>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12 mt-2" style="height: 200px; border:1px solid black; margin-left: 5%;">
						
						<img id="photo3" class="studentPhotoPreview" style="width: 40%; height: 100%; float:left;">

		      			<div style="margin-left: 45%; margin-top: 10%;">
			      			<span id="name3" class="student-list"></span>
			      			<span id="time3" class="time-list"></span>
			      			<span id="date3" class="date-list"></span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</body>

<script>
	
	let base_url = $('body').data('urlbase');
	let sms_gateway = $('body').data('smsgateway');

	$('#scanner').focus();
	$('#fetcherElem').hide();

	function sendSMS(cpNumber, message) {
		$.ajax({
			url: sms_gateway,
			type:'GET',
			data: { cpNumber: cpNumber, message: message },
			complete:function(result) {
				$.LoadingOverlay('hide');
			}
		});
	}

	$('#scanner').focusout(function(){
		$(this).focus();
	});

	$('#scanner').bind("enterKey",function(e) {
	   

		let identifierTag = $(this).val();
		
		let data = {
			identifierTag:identifierTag
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
				

				let res = JSON.parse(result);

				// if(res.status == 'success') {

					sendSMS(res.cpNumber, res.message);

					$('#student').html('<h4><b>'+res.student+'</b></h4>');
					$('#latestStudentPhoto').attr('src',base_url+'uploads/photoID/'+res.photo);
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


					// $('.student-list').html('<h6><b>'+res.student+'</b></h6>');
					// $('.time-list').html('<h6><span style="color:#ff0000">'+res.tap+'</span>: '+res.time+'</h6>');
					// $('.date-list').html('<h6>'+res.date+'</h6>');

					if(typeof res.latestTimelog[1] !== 'undefined') {
						$('#name1').html('<h6><b>'+res.latestTimelog[1].student+'</b></h6>');
						$('#time1').html('<h6><span style="color:#ff0000">'+res.latestTimelog[1].type.toUpperCase()+'</span>: '+formatTime(res.latestTimelog[1].timeTap)+'</h6>');
						$('#date1').html('<h6>'+formatDate(res.latestTimelog[1].dateTap)+'</h6>');
						$('#photo1').attr('src',base_url+'uploads/photoID/'+res.latestTimelog[1].photo);
					}
					
					if(typeof res.latestTimelog[2] !== 'undefined') {
						$('#name2').html('<h6><b>'+res.latestTimelog[2].student+'</b></h6>');
						$('#time2').html('<h6><span style="color:#ff0000">'+res.latestTimelog[2].type.toUpperCase()+'</span>: '+formatTime(res.latestTimelog[2].timeTap)+'</h6>');
						$('#date2').html('<h6>'+formatDate(res.latestTimelog[2].dateTap)+'</h6>');
						$('#photo2').attr('src',base_url+'uploads/photoID/'+res.latestTimelog[2].photo);

					}

					if(typeof res.latestTimelog[3] !== 'undefined') {
						$('#name3').html('<h6><b>'+res.latestTimelog[3].student+'</b></h6>');
						$('#time3').html('<h6><span style="color:#ff0000">'+res.latestTimelog[3].type.toUpperCase()+'</span>: '+formatTime(res.latestTimelog[3].timeTap)+'</h6>');
						$('#date3').html('<h6>'+formatDate(res.latestTimelog[3].dateTap)+'</h6>');
						$('#photo3').attr('src',base_url+'uploads/photoID/'+res.latestTimelog[3].photo);
					}

				// }else {
					// swal('Ooops!',res.message,'error');
				// }

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