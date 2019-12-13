
$(function(){
	
	var base_url = $('body').data('urlbase');

	$('#newSuccess').hide();
	$('#newDenied').hide();
	$('#existingSuccess').hide();
	$('#existingDenied').hide();

	$('#importBtn').click(function(e) {

		e.preventDefault();

		let form = $('#csvUpload')[0];
		let formData = new FormData(form);

		$.ajax({
			url:base_url+'Import/personalInfo',
			type:'POST',
			enctype:'multipart/form-data',
	        processData: false,
	        contentType: false,
	        cache: false,
	        timeout: 600000,			
			data:formData,
			beforeSend: function() {
				$.LoadingOverlay('show');
			},
			success:function(result) {

				$.LoadingOverlay('hide');

				let res = JSON.parse(result);

				$('#newSuccess').show();
				$('#newDenied').show();

				$('#status').html("<h3>"+res.message+"</h3>");

				$.each(res.success, function(index, val) {
					$('#newSuccess').append("<p>"+val+"</p>");
				});

				$.each(res.denied, function(index, val) {
					$('#newDenied').append("<p>"+val+"</p>");
				});

			}
		});
	});


	$('#importGradeLevelBtn').click(function(e) {

		e.preventDefault();

		let form = $('#existingCsvUpload')[0];
		let formData = new FormData(form);

		$.ajax({
			url:base_url+'Import/gradeLevel',
			type:'POST',
			enctype:'multipart/form-data',
	        processData: false,
	        contentType: false,
	        cache: false,
	        timeout: 600000,			
			data:formData,
			beforeSend: function() {
				$.LoadingOverlay('show');
			},
			success:function(result) {

				$.LoadingOverlay('hide');

				let res = JSON.parse(result);

				$('#existingSuccess').show();
				$('#existingDenied').show();

				$('#status').html("<h3>"+res.message+"</h3>");

				$.each(res.success, function(index, val) {
					$('#existingSuccess').append("<p>"+val+"</p>");
				});

				$.each(res.denied, function(index, val) {
					$('#existingDenied').append("<p>"+val+"</p>");
				});
			}
		});
	});

});