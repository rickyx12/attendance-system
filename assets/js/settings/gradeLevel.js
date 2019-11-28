$(function(){
	
	var base_url = $('body').data('urlbase');


	var gradeLevelTable = $('#gradeLevelTable').DataTable({
	 					processing:true,
						serverSide:true,								
						ajax:{
							url: base_url+'Settings/gradeLevelJSON',
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
									return data.grade_level;
								}
							},
							{
								data:null,
								width:"11%",
								render:function(data,type,row) {

									$(document).on('click','#edit-btn'+data.id,function(){

										let id = $(this).data('id');
										let gradeLevel = $(this).data('gradelevel');								

										$('#gradeLevelId').val(id);
										$('#editGradeLevel').val(gradeLevel);

									});


									$(document).on('click','#delete-btn'+data.id,function(){

										let id = $(this).data('id');
										let gradeLevel = $(this).data('gradelevel');

										$('#gradeLevelId').val(id);
										$('#deleteGradeLevel').html('<b>'+gradeLevel+'</b>');

									});

									let buttons = "";
									buttons += "<button type='button' id='edit-btn"+data.id+"' data-id='"+data.id+"' data-gradelevel='"+data.grade_level+"' class='btn btn-primary' data-toggle='modal' data-target='#editModal'><i class='fa fa-pen'></i></button>";
									buttons += " <button type='button' id='delete-btn"+data.id+"' class='btn btn-danger' data-id='"+data.id+"' data-gradelevel='"+data.grade_level+"' data-toggle='modal' data-target='#deleteModal'><i class='fa fa-trash'></i></button>";

									return buttons;
								}
							}
						]
					});


	$('#newModalBtn').click(function() {

		$('#newModalBtn').attr('disabled',true);
		$('.closeModalBtn').attr('disabled',true);

		let gradeLevel = $('#gradeLevel').val();

		let data = {
			gradeLevel:gradeLevel
		};

		$.ajax({
			url: base_url+'Settings/createGradeLevel',
			type:'POST',
			data:data,
			success:function(result) {

				let res = JSON.parse(result);

				if(res.status == 'success') {

					swal("Good job!",res.message, "success");
					$('#newModal').modal('hide');
					gradeLevelTable.ajax.reload(null,false);
					
					$('#gradeLevel').val('');
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

		let gradeLevelId = $('#gradeLevelId').val();
		let gradeLevel = $('#editGradeLevel').val();

		let data = {
			gradeLevelId:gradeLevelId,
			gradeLevel:gradeLevel
		};

		$.ajax({
			url: base_url+'Settings/updateGradeLevel',
			type:'POST',
			data:data,
			success:function(result) {

				let res = JSON.parse(result);

				if(res.status == 'success') {

					swal("Good job!",res.message, "success");
					$('#editModal').modal('hide');
					gradeLevelTable.ajax.reload(null,false);

					$('#editGradeLevel').val('');					
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

		let gradeLevelId = $('#gradeLevelId').val();

		let data = {
			gradeLevelId:gradeLevelId
		};

		$.ajax({
			url: base_url+'Settings/deleteGradeLevel',
			type:'POST',
			data:data,
			success:function(result) {

				let res = JSON.parse(result);

				if(res.status == 'success') {

					swal("Good job!",res.message, "success");
					$('#deleteModal').modal('hide');
					$('#deleteModalBtn').attr('disabled',false);
					gradeLevelTable.ajax.reload(null,false);

				}else {

					swal("Ooopss!","Error!", "error");	
				}
			}
		});
	});

});