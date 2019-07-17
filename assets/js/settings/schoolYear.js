$(function(){
	
	var base_url = $('body').data('urlbase');


	var schoolYearTable = $('#schoolYearTable').DataTable({
	 					processing:true,
						serverSide:true,								
						ajax:{
							url: base_url+'Settings/schoolYearJSON',
						},
						columns:[
							{
								data:null,
								render:function(data,type,row) {
									return data.school_year;
								}
							},
							{
								data:null,
								width:"11%",
								render:function(data,type,row) {

									$(document).on('click','#edit-btn'+data.id,function(){

										let id = $(this).data('id');
										let schoolYear = $(this).data('schoolyear');								

										$('#schoolYearId').val(id);
										$('#editSchoolYear').val(schoolYear);

									});


									$(document).on('click','#delete-btn'+data.id,function(){

										let id = $(this).data('id');
										let schoolYear = $(this).data('schoolyear');

										$('#schoolYearId').val(id);
										$('#deleteSchoolYear').html('<b>'+schoolYear+'</b>');

									});

									let buttons = "";
									buttons += "<button type='button' id='edit-btn"+data.id+"' data-id='"+data.id+"' data-schoolyear='"+data.school_year+"' class='btn btn-primary' data-toggle='modal' data-target='#editModal'><i class='fa fa-pen'></i></button>";
									buttons += " <button type='button' id='delete-btn"+data.id+"' class='btn btn-danger' data-id='"+data.id+"' data-schoolyear='"+data.school_year+"' data-toggle='modal' data-target='#deleteModal'><i class='fa fa-trash'></i></button>";

									return buttons;
								}
							}
						]
					});


	$('#newModalBtn').click(function() {

		$('#newModalBtn').attr('disabled',true);
		$('.closeModalBtn').attr('disabled',true);

		let schoolYear = $('#schoolYear').val();

		let data = {
			schoolYear:schoolYear
		};

		$.ajax({
			url: base_url+'Settings/createSchoolYear',
			type:'POST',
			data:data,
			success:function(result) {

				let res = JSON.parse(result);

				if(res.status == 'success') {

					swal("Good job!",res.message, "success");
					$('#newModal').modal('hide');
					schoolYearTable.ajax.reload(null,false);

					$('#schoolYear').val('');
				}else {
					swal("Ooopss!",res.message, "error");
				}

				$('#newModalBtn').attr('disabled',false);
				$('.closeModalBtn').attr('disabled',false);
			}
		});
	});


	$('#editModalBtn').click(function() {

		$('#editModalBtn').attr('disabled',true);
		$('.closeModalBtn').attr('disabled',true);

		let schoolYearId = $('#schoolYearId').val();
		let schoolYear = $('#editSchoolYear').val();

		let data = {
			schoolYearId:schoolYearId,
			schoolYear:schoolYear
		};

		$.ajax({
			url: base_url+'Settings/updateSchoolYear',
			type:'POST',
			data:data,
			success:function(result) {

				let res = JSON.parse(result);

				if(res.status == 'success') {

					swal("Good job!",res.message, "success");
					$('#editModal').modal('hide');
					schoolYearTable.ajax.reload(null,false);

					$('#editSchoolYear').val('');					
				}else {

					swal("Ooopss!",res.message, "error");					
				}

				$('#editModalBtn').attr('disabled',false);
				$('.closeModalBtn').attr('disabled',false);

			}
		});
 	});


	$('#deleteModalBtn').click(function(){

		$('#deleteModalBtn').attr('disabled',true);
		$('.closeModalBtn').attr('disabled',true);

		let schoolYearId = $('#schoolYearId').val();

		let data = {
			schoolYearId:schoolYearId
		};

		$.ajax({
			url: base_url+'Settings/deleteSchoolYear',
			type:'POST',
			data:data,
			success:function(result) {

				let res = JSON.parse(result);

				if(res.status == 'success') {

					swal("Good job!",res.message, "success");
					$('#deleteModal').modal('hide');
					schoolYearTable.ajax.reload(null,false);

				}else {

					swal("Ooopss!","Error!", "error");	
				}

				$('#deleteModalBtn').attr('disabled',false);
				$('.closeModalBtn').attr('disabled',false);				
			}
		});
	});

});