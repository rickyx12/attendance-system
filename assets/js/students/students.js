$(function(){
	
	var base_url = $('body').data('urlbase');


	 var studentsTable = $('#studentsTable').DataTable({
	 					processing:true,
						serverSide:true,								
						ajax:{
							url: base_url+'Students/studentsJSON',
						},
						columns:[
							{
								data:null,
								render:function(data,type,row) {
									return data.last_name+" "+data.first_name+" "+data.middle_name;
								},
							},
							{
								data:null,
								render:function(data,type,row) {
									return getAge(data.birthdate);
								}
							},
							{
								data:null,
								render:function(data,type,row) {
									return formatDate(data.birthdate);
								}
							},
							{
								data:null,
								render:function(data,type,row) {
									return ucFirst(data.gender);
								}
							},
							{
								data:null,
								width:"11%",
								render:function(data,type,row) {

									$(document).on('click','#edit-btn'+data.id,function(){

										let id = $(this).data('id');
										let lastName = $(this).data('lastname');
										let firstName = $(this).data('firstname');
										let middleName = $(this).data('middlename');
										let birthdate = $(this).data('birthdate');
										let gender = $(this).data('gender');									

										$('#studentId').val(id);
										$('#editLastName').val(lastName);
										$('#editFirstName').val(firstName);
										$('#editMiddleName').val(middleName);
										$('#editBirthdate').val(birthdate);
										$('#editGender option:contains("'+gender+'")').prop('selected',true);

									});


									$(document).on('click','#delete-btn'+data.id,function(){

										let id = $(this).data('id');
										let student = $(this).data('student');

										$('#studentId').val(id);
										$('#deleteStudentName').html('<b>'+student+'</b>');

									});

									let buttons = "";
									buttons += "<button type='button' id='edit-btn"+data.id+"' data-id='"+data.id+"' data-lastname='"+data.last_name+"' data-firstname='"+data.first_name+"' data-middlename='"+data.middle_name+"' data-birthdate='"+data.birthdate+"' data-gender='"+data.gender+"' class='btn btn-primary' data-toggle='modal' data-target='#editStudentModal'><i class='fa fa-pen'></i></button>";
									buttons += " <button type='button' id='delete-btn"+data.id+"' data-student='"+data.last_name+", "+data.first_name+"' class='btn btn-danger' data-id='"+data.id+"' data-toggle='modal' data-target='#deleteStudentModal'><i class='fa fa-trash'></i></button>";

									return buttons;
								}
							}
						]
					});


$('input[name="dates"]').daterangepicker({
		opens:'left',
	    singleDatePicker: true,
	    showDropdowns: true,
	    minYear: 1901,		
	},function(start,end,label) {
		return	start.format('YYYY-MM-DD');
	});

	$('#newStudentBtn').click(function() {

		$('#newStudentBtn').attr('disabled',true);
		$('.closeModalBtn').attr('disabled',true);

		let lastName = $('#lastName').val();
		let firstName = $('#firstName').val();
		let middleName = $('#middleName').val();
		let birthdate = $('#birthdate').val().split("/");
		let gender = $('#gender').val();

		let data = {
			lastName:lastName,
			firstName:firstName,
			middleName:middleName,
			birthdate:birthdate[2]+'-'+birthdate[0]+'-'+birthdate[1],
			gender:gender
		};


		$.ajax({
			url:base_url+'Students/create',
			type:'POST',
			data:data,
			success:function(result) {

				let res = JSON.parse(result);
				
				if(res.status == 'success') {
					
					swal("Good job!", firstName+", "+lastName+" has been added", "success");
					$('#newStudentModal').modal('hide');
					studentsTable.ajax.reload(null,false);

					$('#lastName').val('');
					$('#firstName').val('');
					$('#middleName').val('');
				}else {
					swal("Ooopss!",res.message, "error");
				}

				$('#newStudentBtn').attr('disabled',false);
				$('.closeModalBtn').attr('disabled',false);
			}
		});
	});



	$('#editStudentBtn').click(function() {

		$('#editStudentBtn').attr('disabled',true);
		$('.closeModalBtn').attr('disabled',true);

		let id = $('#studentId').val();
		let lastName = $('#editLastName').val();
		let firstName = $('#editFirstName').val();
		let middleName = $('#editMiddleName').val();
		let gradeLevel = $('#editGradeLevel').val();
		let birthdate = $('#editBirthdate').val().split("/");
		let gender = $('#editGender').val();

		let data = {
			id:id,
			lastName:lastName,
			firstName:firstName,
			middleName:middleName,
			gradeLevel:gradeLevel,
			birthdate:birthdate[2]+'-'+birthdate[0]+'-'+birthdate[1],
			gender:gender
		};


		$.ajax({
			url:base_url+'Students/update',
			type:'POST',
			data:data,
			success:function(result) {

				let res = JSON.parse(result);
				
				if(res.status == 'success') {
					
					swal("Good job!", firstName+", "+lastName+" has been added", "success");
					$('#editStudentModal').modal('hide');
					studentsTable.ajax.reload(null,false);		
								
				}else {
					swal("Ooopss!",res.message, "error");
				}

				$('#editStudentBtn').attr('disabled',false);
				$('.closeModalBtn').attr('disabled',false);
			}
		});
	});


	$('#deleteStudentBtn').click(function(){

		$('#deleteStudentBtn').attr('disabled',true);
		$('.closeModalBtn').attr('disabled',true);

		let studentId = $('#studentId').val();

		let data = {
			studentId:studentId
		};

		$.ajax({
			url: base_url+'Students/delete',
			type:'POST',
			data:data,
			success:function(result) {

				let res = JSON.parse(result);

				swal('Deleted!',res.message,'success');
				studentsTable.ajax.reload(null,false);
				$('#deleteStudentModal').modal('hide');
				$('#deleteStudentBtn').attr('disabled',false);
				$('.closeModalBtn').attr('disabled',false);
			}
		});

	});

});