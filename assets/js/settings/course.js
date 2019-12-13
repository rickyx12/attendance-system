$(function(){
	
	var base_url = $('body').data('urlbase');


	var courseTable = $('#courseTable').DataTable({
	 					processing:true,
						serverSide:true,								
						ajax:{
							url: base_url+'Course/resultJSON',
						},
						columns:[
							{
								data:null,
								render:function(data,type,row) {
									return data.id;
								}
							},
							{
								data:null,
								render:function(data,type,row) {
									return data.course;
								}
							},
							{
								data:null,
								width:"11%",
								render:function(data,type,row) {

									$(document).on('click','#edit-btn'+data.id,function(){

										let id = $(this).data('id');
										let course = $(this).data('course');								

										$('#courseId').val(id);
										$('#editCourse').val(course);

									});


									$(document).on('click','#delete-btn'+data.id,function(){

										let id = $(this).data('id');
										let course = $(this).data('course');

										$('#courseId').val(id);
										$('#deleteCourse').html('<b>'+course+'</b>');

									});

									let buttons = "";
									buttons += "<button type='button' id='edit-btn"+data.id+"' data-id='"+data.id+"' data-course='"+data.course+"' class='btn btn-primary' data-toggle='modal' data-target='#editModal'><i class='fa fa-pen'></i></button>";
									buttons += " <button type='button' id='delete-btn"+data.id+"' class='btn btn-danger' data-id='"+data.id+"' data-course='"+data.course+"' data-toggle='modal' data-target='#deleteModal'><i class='fa fa-trash'></i></button>";

									return buttons;
								}
							}
						]
					});


	$('#newModalBtn').click(function() {

		$('#newModalBtn').attr('disabled',true);
		$('.closeModalBtn').attr('disabled',true);

		let course = $('#course').val();

		let data = {
			course:course
		};

		$.ajax({
			url: base_url+'Course/add',
			type:'POST',
			data:data,
			success:function(result) {

				let res = JSON.parse(result);

				if(res.status == 'success') {

					swal("Good job!",res.message, "success");
					$('#newModal').modal('hide');
					courseTable.ajax.reload(null,false);

					$('#course').val('');
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

		let courseId = $('#courseId').val();
		let course = $('#editCourse').val();

		let data = {
			courseId:courseId,
			course:course
		};

		$.ajax({
			url: base_url+'Course/update',
			type:'POST',
			data:data,
			success:function(result) {

				let res = JSON.parse(result);

				if(res.status == 'success') {

					swal("Good job!",res.message, "success");
					$('#editModal').modal('hide');
					courseTable.ajax.reload(null,false);

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

		let	courseId = $('#courseId').val();

		let data = {
			courseId:courseId
		};

		$.ajax({
			url: base_url+'Course/delete',
			type:'POST',
			data:data,
			success:function(result) {

				let res = JSON.parse(result);

				if(res.status == 'success') {

					swal("Good job!",res.message, "success");
					$('#deleteModal').modal('hide');
					courseTable.ajax.reload(null,false);

				}else {

					swal("Ooopss!","Error!", "error");	
				}

				$('#deleteModalBtn').attr('disabled',false);
				$('.closeModalBtn').attr('disabled',false);				
			}
		});
	});

});