$(function(){
	
	var base_url = $('body').data('urlbase');

	var sectionTable = $('#sectionTable').DataTable({
	 					processing:true,
						serverSide:true,								
						ajax:{
							url: base_url+'Settings/sectionJSON',
						},
						columns:[
							{
								data:null,
								render:function(data,type,row) {
									return data.section;
								}
							},
							{
								data:null,
								render:function(data,type,row) {
									return data.grade_level
								}
							},
							{
								data:null,
								width:"11%",
								render:function(data,type,row) {

									$(document).on('click','#edit-btn'+data.id,function(){

										let id = $(this).data('id');
										let section = $(this).data('section');
										let gradeLevel = $(this).data('gradelevel');								

										$('#sectionId').val(id);
										$('#editSection').val(section);
										$('#editGradeLevel option:contains("'+gradeLevel+'")').prop('selected',true);

									});


									$(document).on('click','#delete-btn'+data.id,function(){

										let id = $(this).data('id');
										let section = $(this).data('section');

										$('#sectionId').val(id);
										$('#deleteSection').html('<b>'+section+'</b>');

									});

									let buttons = "";
									buttons += "<button type='button' id='edit-btn"+data.id+"' data-id='"+data.id+"' data-section='"+data.section+"' data-gradelevel='"+data.grade_level+"' class='btn btn-primary' data-toggle='modal' data-target='#editModal'><i class='fa fa-pen'></i></button>";
									buttons += " <button type='button' id='delete-btn"+data.id+"' class='btn btn-danger' data-id='"+data.id+"' data-section='"+data.section+"' data-toggle='modal' data-target='#deleteModal'><i class='fa fa-trash'></i></button>";

									return buttons;
								}
							}
						],
						dom: 'Bfrtip',
				        buttons: [
				        	{
				        		extend:'excelHtml5',
				        		filename:'Sections ('+today+')'
				        	},
				        	{
				        		extend:'pdfHtml5',
				        		filename:'Sections ('+today+')'
				        	}
				        ]						
					});


	$('#newModalBtn').click(function() {

		$('#newModalBtn').attr('disabled',true);

		let section = $('#section').val();
		let gradeLevel = $('#gradeLevel').val();

		let data = {
			section:section,
			gradeLevel:gradeLevel
		};

		console.log(data);

		$.ajax({
			url: base_url+'Settings/createSection',
			type:'POST',
			data:data,
			success:function(result) {

				let res = JSON.parse(result);

				if(res.status == 'success') {

					swal("Good job!",res.message, "success");
					$('#newModal').modal('hide');
					$('#newModalBtn').attr('disabled',false);
					sectionTable.ajax.reload(null,false);

					$('#section').val('');
				}else {
					swal("Ooopss!",res.message, "error");
				}
			}
		});
	});


	$('#editModalBtn').click(function() {

		$('#editModalBtn').attr('disabled',true);

		let sectionId = $('#sectionId').val();
		let section = $('#editSection').val();
		let gradeLevel = $('#editGradeLevel').val();

		let data = {
			sectionId:sectionId,
			section:section,
			gradeLevel:gradeLevel
		};

		$.ajax({
			url: base_url+'Settings/updateSection',
			type:'POST',
			data:data,
			success:function(result) {

				let res = JSON.parse(result);

				if(res.status == 'success') {

					swal("Good job!",res.message, "success");
					$('#editModal').modal('hide');
					$('#editModalBtn').attr('disabled',false);
					sectionTable.ajax.reload(null,false);

					$('#editGradeLevel').val('');					
				}else {

					swal("Ooopss!",res.message, "error");					
				}
			}
		});
 	});


	$('#deleteModalBtn').click(function(){

		$('#deleteModalBtn').attr('disabled',true);

		let sectionId = $('#sectionId').val();

		let data = {
			sectionId:sectionId
		};

		$.ajax({
			url: base_url+'Settings/deleteSection',
			type:'POST',
			data:data,
			success:function(result) {

				let res = JSON.parse(result);

				if(res.status == 'success') {

					swal("Good job!",res.message, "success");
					$('#deleteModal').modal('hide');
					$('#deleteModalBtn').attr('disabled',false);
					sectionTable.ajax.reload(null,false);

				}else {

					swal("Ooopss!","Error!", "error");	
				}
			}
		});
	});

});