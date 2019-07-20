$(function(){
	
	var base_url = $('body').data('urlbase');


	var usersTable = $('#usersTable').DataTable({
	 					processing:true,
						serverSide:true,								
						ajax:{
							url: base_url+'Account/resultJSON',
						},
						columns:[
							{
								data:null,
								render:function(data,type,row) {
									return data.username;
								}
							},
							{
								data:null,
								width:"11%",
								render:function(data,type,row) {


									$(document).on('click','#delete-btn'+data.id,function(){

										let id = $(this).data('id');
										let username = $(this).data('username');

										$('#userId').val(id);
										$('#deleteUser').html('<b>'+username+'</b>');

									});

									let buttons = "";					
									buttons += " <button type='button' id='delete-btn"+data.id+"' class='btn btn-danger' data-id='"+data.id+"' data-username='"+data.username+"' data-toggle='modal' data-target='#deleteModal'><i class='fa fa-trash'></i></button>";

									return buttons;
								}
							}
						]
					});


	$('#newModalBtn').click(function() {

		$('#newModalBtn').attr('disabled',true);
		$('.closeModalBtn').attr('disabled',true);

		let username = $('#username').val();
		let password = $('#password').val();

		let data = {
			username:username,
			password:password
		};

		$.ajax({
			url: base_url+'Account/registerNow',
			type:'POST',
			data:data,
			success:function(result) {

				let res = JSON.parse(result);

				if(res.status == 'success') {

					swal("Good job!",res.message, "success");
					$('#newModal').modal('hide');
					usersTable.ajax.reload(null,false);

					$('#username').val('');
					$('#password').val('');

				}else {
					swal("Ooopss!",res.message, "error");
				}

				$('#newModalBtn').attr('disabled',false);
				$('.closeModalBtn').attr('disabled',false);
			}
		});
	});



	$('#deleteModalBtn').click(function() {

		$('#deleteModalBtn').attr('disabled',true);
		$('.closeModalBtn').attr('disabled',true);

		let	userId = $('#userId').val();

		let data = {
			id:userId
		};

		$.ajax({
			url: base_url+'Account/delete',
			type:'POST',
			data:data,
			success:function(result) {

				let res = JSON.parse(result);

				if(res.status == 'success') {

					swal("Good job!",res.message, "success");
					$('#deleteModal').modal('hide');
					usersTable.ajax.reload(null,false);

				}else {

					swal("Ooopss!","Error!", "error");	
				}

				$('#deleteModalBtn').attr('disabled',false);
				$('.closeModalBtn').attr('disabled',false);				
			}
		});
	});

});