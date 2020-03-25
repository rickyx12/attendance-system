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


	 <style>
	 	body {
	 		background-image: url(<?= base_url("assets/img/bg2.jpg") ?>);
	 		/*background-repeat: repeat-x;*/
	 	}
	 </style>

 </head>
<nav class="navbar navbar-expand-lg" style="background-color:#00217E;">
  <a class="navbar-brand" href="#" style="color:#FFFFFF; font-weight: bold;">TECH-GUARDIAN</a>
  <!-- <img src="<?= base_url("assets/img/favicon.ico") ?>" width="40" height="40"> -->
</nav>

<?php if($this->config->item('branded')): ?>
	<body 
		data-urlbase="<?= base_url() ?>" 
		data-smsgateway="<?= $this->config->item('sms_gateway') ?>" 
		data-apikey="<?= $this->config->item('apikey') ?>" 
		data-senderid="<?= $this->config->item('senderID') ?>" 
		data-smsheader="<?= $this->config->item('sms_header') ?>"
	>  	
<?php else: ?>
	<body data-urlbase="<?= base_url() ?>" data-smsgateway="<?= $this->config->item('sms_gateway') ?>"> 
<?php endif; ?>

	<div class="container">
		<div class="row">
			<div class="col-md-4 jumbotron mt-3" style="height: 621px; background-color: #00217E;">
				
				<img id="latestStudentPhoto" class="studentPhotoPreview" style="width: 100%; height: 100%;">
			
			</div>
			<div class="col-md-4 jumbotron mt-3" style="padding-top: 10%; background-color: #00217E;">

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
					<div class="col-md-12" style="height: 200px; margin-top: 5%; border: 1px solid black; margin-left: 5%; background-color: #00217E;">
						
						<img id="photo1" class="studentPhotoPreview" style="width: 40%; height: 100%; float:left;">

		      			<div style="margin-left: 45%; margin-top: 10%;">
			      			<span id="name1" class="student-list"></span>
			      			<span id="time1" class="time-list"></span>
			      			<span id="date1" class="date-list"></span>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12 mt-2" style="height: 200px; border: 1px solid black; margin-left: 5%; background-color: #00217E;">
						
						<img id="photo2" class="studentPhotoPreview" style="width: 40%; height: 100%; float:left;">

		      			<div style="margin-left: 45%; margin-top: 10%;">
			      			<span id="name2" class="student-list"></span>
			      			<span id="time2" class="time-list"></span>
			      			<span id="date2" class="date-list"></span>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12 mt-2" style="height: 200px; border:1px solid black; margin-left: 5%; background-color:#00217E;">
						
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
	let branded = $('body').data('branded');
	let apikey = $('body').data('apikey');
	let senderID = $('body').data('senderid');
	let smsHeader = $('body').data('smsheader');

	$('#scanner').focus();
	$('#fetcherElem').hide();

	$.LoadingOverlaySetup({
	    background      : "rgba(0, 0, 0, 0.5)",
	    image           : base_url+"assets/img/tech-guardian.PNG",
	    imageAnimation  : "1.5s fadein",
	    imageColor      : "#ffcc00"
	});


	<?php if($this->config->item('branded')): ?>

		function sendSMS(cpNumber, adviserCpNumber, studentName, typeMessage, timeFrontEnd, dateFrontEnd) {

			let data = {
				key: apikey,
				type:'text',
				senderid:senderID,
				contacts:cpNumber+','+adviserCpNumber,
				msg:decodeURI(encodeURI(smsHeader+"\n"+studentName+"\n"+typeMessage+": "+timeFrontEnd+"\n"+dateFrontEnd))
			}

			$.ajax({
				url: sms_gateway,
				type:'GET',
				data: data,
				complete:function(result) {

					if(result != "") {
						$.LoadingOverlay('hide');
					}
				}
			});
		}

	<?php else: ?>
		
		function sendAdviserSMS(gradeLevelId, cpNumber, message) {
			$.ajax({
				url: sms_gateway,
				type:'GET',
				data: { gradeLevelId: gradeLevelId, cpNumber: cpNumber, message: message },
				complete:function(result) {

					if(result != "") {
						$.LoadingOverlay('hide');
					}
				}
			});
		}

		function sendSMS(gradeLevelId, cpNumber, adviserCpNumber, message) {
			$.ajax({
				url: sms_gateway,
				type:'GET',
				data: { gradeLevelId: gradeLevelId, cpNumber: cpNumber, message: message },
				complete:function(result) {

					if(result != "") {
						if(adviserCpNumber != "") {
							sendAdviserSMS(gradeLevelId,adviserCpNumber,message);
						}else {
							$.LoadingOverlay('hide');
						}
					}
				}
			});
		}
	<?php endif; ?>


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

				if(res.status == 'success') {

					<?php if($this->config->item('branded')): ?>
						sendSMS(res.cpNumber, res.adviserCpNumber, res.student, res.tap, res.time, res.date);
					<?php else: ?>
						sendSMS(res.gradeLevelId, res.cpNumber, res.adviserCpNumber, res.message);
					<?php endif; ?>

					$('#student').html('<h4><b><span style="color:#FFFFFF;">'+res.student+'</span></b></h4>');
					$('#latestStudentPhoto').attr('src',base_url+'uploads/photoID/'+res.photo);
					$('#time').html('<h4><span style="color:#FFFFFF;">'+res.tap+': '+res.time+'</span></h4>');
					$('#date').html('<h4><span style="color:#FFFFFF;">'+res.date+'</span></h4>');
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
						$('#name1').html('<h6><b><span style="color:#FFFFFF">'+res.latestTimelog[1].student+'</span></b></h6>');
						$('#time1').html('<h6><span style="color:#FFFFFF">'+res.latestTimelog[1].type.toUpperCase()+': '+formatTime(res.latestTimelog[1].timeTap)+'</span></h6>');
						$('#date1').html('<h6><span style="color:#FFFFFF">'+formatDate(res.latestTimelog[1].dateTap)+'</span></h6>');
						$('#photo1').attr('src',base_url+'uploads/photoID/'+res.latestTimelog[1].photo);
					}
					
					if(typeof res.latestTimelog[2] !== 'undefined') {
						$('#name2').html('<h6><b><span style="color:#FFFFFF">'+res.latestTimelog[2].student+'</span></b></h6>');
						$('#time2').html('<h6><span style="color:#FFFFFF">'+res.latestTimelog[2].type.toUpperCase()+': '+formatTime(res.latestTimelog[2].timeTap)+'</span></h6>');
						$('#date2').html('<h6><span style="color:#FFFFFF">'+formatDate(res.latestTimelog[2].dateTap)+'</span></h6>');
						$('#photo2').attr('src',base_url+'uploads/photoID/'+res.latestTimelog[2].photo);

					}

					if(typeof res.latestTimelog[3] !== 'undefined') {
						$('#name3').html('<h6><b><span style="color:#FFFFFF">'+res.latestTimelog[3].student+'</span></b></h6>');
						$('#time3').html('<h6><span style="color:#FFFFFF">'+res.latestTimelog[3].type.toUpperCase()+': '+formatTime(res.latestTimelog[3].timeTap)+'</span></h6>');
						$('#date3').html('<h6><span style="color:#FFFFFF">'+formatDate(res.latestTimelog[3].dateTap)+'</span></h6>');
						$('#photo3').attr('src',base_url+'uploads/photoID/'+res.latestTimelog[3].photo);
					}

				}else {
					$.LoadingOverlay('hide');
					
					swal(res.message, {
						buttons:false,
						timer: 1500	
					});

					$('#scanner').prop('disabled',false);
					$('#scanner').val('');
					$('#scanner').focus();					
					
												
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