$(function(){
	
	var base_url = $('body').data('urlbase');

	 var gradeLevelTable = $('#gradeLevelTable').DataTable({
	 					processing:true,
						serverSide:true,								
						ajax:{
							url: base_url+'GradeLevel/gradeLevelJSON',
						},
						columns:[
							{
								data:null,
								render:function(data,type,row) {
									return data.last_name+', '+data.first_name;
								}
							},
							{
								data:null,
								render:function(data,type,row) {
									return data.grade_level+" - "+data.section
								}
							},
							{
								data:null,
								render:function(data,type,row) {
									return data.schedule_timein+' - '+data.schedule_timeout
								} 
							},
							{
								data:'school_year'
							},
							{
								data:null,
								render:function(data,type,row) {

									$(document).on('click','#edit-btn'+data.gradeLevelId,function(e) {

										let id = $(this).data('id');							
										let studentName = $(this).data('studentname');
										let settingsGradeLevelId = $(this).data('settingsgradelevelid');
										let gradeLevel = $(this).data('gradelevel');
										let sectionId = $(this).data('sectionId');
										let section = $(this).data('section');
										let timeIn = $(this).data('timein');
										let timeOut = $(this).data('timeout');
										let schoolYear = $(this).data('schoolyear');
										let photo = $(this).data('photo');
										let guardian = $(this).data('guardian');
										let guardianContact = $(this).data('guardiancontact');
										let rfCard = $(this).data('rfcard');

										console.log(gradeLevel);

										$('#gradeLevelId').val(id);
										$('#edit-students-list').html('<option value="'+studentId+'" selected="selected">'+studentName+'</option>');
										$('#editGradeLevelSelect option:contains("'+gradeLevel+'")').prop('selected',true);
										$('#editSection').html("<option value='"+data.sectionId+"' selected='selected'>"+section+"</option>");
										$('#editScheduleFrom1').val(timeIn);
										$('#editScheduleTo1').val(timeOut);
										$('#editSchoolYear').val(schoolYear);
										$('#editStudentPhotoPreview').attr('src',base_url+'uploads/photoID/'+photo);
										$('#editGuardian').val(guardian);
										$('#editGuardianContact').val(guardianContact);
										$('#editRFCard').val(rfCard);

									});

									$(document).on('click','#delete-btn'+data.gradeLevelId,function() {
										
										let id = $(this).data('id');
										let student = $(this).data('student');
										let gradeLevel = $(this).data('gradelevel');

										$('#gradeLevelId').val(id);
										$('#deleteGradeLevel').html("<b>"+gradeLevel+"</b>");
										$('#deleteGradeLevelStudent').html("<b>"+student+"</b>");
									});

									let buttons = "";
									buttons += "<button type='button' id='edit-btn"+data.gradeLevelId+"' data-id='"+data.gradeLevelId+"' data-studentname='"+data.last_name+", "+data.first_name+"' data-settingsgradelevelid='"+data.settingsGradeLevelId+"' data-gradelevel='"+data.grade_level+"' data-sectionid='"+data.sectionId+"' data-section='"+data.section+"' data-timein='"+data.schedule_timein+"' data-timeout='"+data.schedule_timeout+"' data-schoolyear='"+data.school_year+"' data-photo='"+data.photo+"' data-guardian='"+data.guardian+"' data-guardiancontact='"+data.guardian_contact+"' data-rfcard='"+data.identifierTag+"' class='btn btn-primary' data-toggle='modal' data-target='#editGradeLevelModal'><i class='fa fa-pen'></i></button>";
									buttons += " <button type='button' id='delete-btn"+data.gradeLevelId+"' data-gradelevel='"+data.grade_level+"' data-student='"+data.last_name+", "+data.first_name+"' class='btn btn-danger' data-id='"+data.gradeLevelId+"' data-toggle='modal' data-target='#deleteGradeLevelModal'><i class='fa fa-trash'></i></button>";

									return buttons;
								}
							}
						]
					});



	$('#newGradeLevelBtn').click(function() {

		$('#newGradeLevelBtn').attr('disabled',true);

		let studentId = $('#students-list').val();
		let gradeLevel = $('#gradeLevelSelect').val();
		let section = $('#section').val();
		let schedTimein = $('#timein').val();
		let schedTimeout = $('#timeout').val();
		let schoolYear = $('#schoolYear').val();
		let guardian = $('#guardian').val();
		let guardianContact = $('#guardianContact').val();
		let rfCard = $('#rfCard').val();

		let form = $('#uploadStudentPhoto')[0];
		let formData = new FormData(form);

		formData.append('studentId',studentId);
		formData.append('gradeLevel',gradeLevel);
		formData.append('section',section);
		formData.append('schedTimein',schedTimein);
		formData.append('schedTimeout',schedTimeout);
		formData.append('schoolYear',schoolYear);
		formData.append('guardian',guardian);
		formData.append('guardianContact',guardianContact);
		formData.append('rfCard',rfCard);

		$.ajax({
			url:base_url+'gradeLevel/create',
			type:'POST',
			enctype:'multipart/form-data',
	        processData: false,
	        contentType: false,
	        cache: false,
	        timeout: 600000,			
			data:formData,
			success:function(result) {

				let res = JSON.parse(result);

				if(res.status == 'success') {

					swal("Good job!", res.message, "success");
					$('#newGradeLevelModal').modal('hide');
					gradeLevelTable.ajax.reload(null,false);
					$('#newGradeLevelBtn').attr('disabled',false);

				}else {

					swal("Ooopss!",res.message, "error");
				}

			}
		});


	});


	$('#editGradeLevelBtn').click(function() {

		$('#editGradeLevelBtn').attr('disabled',true);

		let form = $('#editUploadStudentPhoto')[0];
		let formData = new FormData(form);

		let gradeLevelId = $('#gradeLevelId').val();
		let gradeLevel = $('#editGradeLevelSelect').val();
		let section = $('#editSection').val();
		let scheduleTimein = $('#editScheduleFrom1').val();
		let scheduleTimeout = $('#editScheduleTo1').val();
		let schoolYear = $('#editSchoolYear').val();
		let guardian = $('#editGuardian').val();
		let guardianContact = $('#editGuardianContact').val();
		let rfCard = $('#editRFCard').val();

		formData.append('gradeLevelId',gradeLevelId);
		formData.append('gradeLevel',gradeLevel);
		formData.append('section',section);
		formData.append('scheduleTimein',scheduleTimein);
		formData.append('scheduleTimeout',scheduleTimeout);
		formData.append('schoolYear',schoolYear);
		formData.append('guardian',guardian);
		formData.append('guardianContact',guardianContact);
		formData.append('rfCard',rfCard);

		$.ajax({
			url:base_url+'GradeLevel/update',
			type:'POST',
			enctype:'multipart/form-data',
	        processData: false,
	        contentType: false,
	        cache: false,
	        timeout: 600000,			
			data:formData,
			success:function(result) {

				let res = JSON.parse(result);

				if(res.status == 'success') {

					swal("Good job!", res.message, "success");
					$('#editGradeLevelModal').modal('hide');
					gradeLevelTable.ajax.reload(null,false);
					$('#editGradeLevelBtn').attr('disabled',false);					
				}else {

					swal("Ooopss!",res.message, "error");					
				}				

			}
		});

	});


	$('#deleteGradeLevelBtn').click(function(){

		$('#deleteGradeLevelBtn').attr('disabled',true);

		let id = $('#gradeLevelId').val();

		let data = {
			id:id
		};

		$.ajax({
			url:base_url+'GradeLevel/delete',
			type:'POST',
			data:data,
			success:function(result) {

				let res = JSON.parse(result);

				swal("Good job!", res.message, "success");
				gradeLevelTable.ajax.reload(null,false);
				$('#deleteGradeLevelModal').modal('hide');	
				$('#deleteGradeLevelBtn').attr('disabled',false);
			}
		});

	});


	$('#students-list').select2({
		placeholder: 'Search Student',
		ajax:{
			url:base_url+'Students/searchViaSelect2',
			dataType:'json',
			delay:250
		},
		width:'resolve'
	});

	$('#gradeLevelSelect').change(function(e) {

		let gradeLevel = $('#gradeLevelSelect').val();

		let data = {
			gradeLevel:gradeLevel
		}

		$.ajax({
			url: base_url+'Settings/sectionByGradeJSON',
			type:'POST',
			data:data,
			success:function(result) {

				let res = JSON.parse(result);
				let html = "";

				$.each(res,function(index,val) {

					html += "<option value='"+val.id+"'>"+val.section+"</option>"
				});

				$('.sectionSelect').html(html);

			}
		});
	});



	$('#editGradeLevelSelect').change(function() {

		let gradeLevel = $('#editGradeLevelSelect').val();

		let data = {
			gradeLevel:gradeLevel
		}

		$.ajax({
			url: base_url+'Settings/sectionByGradeJSON',
			type:'POST',
			data:data,
			success:function(result) {

				let res = JSON.parse(result);
				let html = "";

				$.each(res,function(index,val) {

					html += "<option value='"+val.id+"'>"+val.section+"</option>"
				});

				$('.sectionSelect').html(html);

			}
		});
	});

	$('#scheduleFrom').datetimepicker({
		format:'LT'
	});

	$('#scheduleTo').datetimepicker({
		format:'LT'
	});

	$('#editScheduleFrom').datetimepicker({
		format:'LT'
	});

	$('#editScheduleTo').datetimepicker({
		format:'LT'
	});

	function readURL(input,imgElem) {

	  if (input.files && input.files[0]) {
	    var reader = new FileReader();

	    reader.onload = function(e) {
	      $('#'+imgElem).attr('src', e.target.result);
	    }

	    reader.readAsDataURL(input.files[0]);
	  }
	}

	$("#studentPhotoInput").change(function() {
	  readURL(this,'studentPhotoPreview');
	});

	$("#editStudentPhotoInput").change(function() {
	  readURL(this,'editStudentPhotoPreview');
	});

});