$(function(){
	
	var base_url = $('body').data('urlbase');

	$('#changePasswordBtn').click(function(e){

		e.preventDefault();

		$.LoadingOverlay('show');

		let username = $('#username').val();
		let currentPassword = $('#currentPassword').val();
		let newPassword = $('#newPassword').val();

		let data = {
			username: username,
			currentPassword: currentPassword,
			newPassword: newPassword
		}

		$.ajax({
			url: base_url+'Account/changePasswordNow',
			type:'POST',
			data:data,
			success:function(result) {

				$.LoadingOverlay('hide');

				let res = JSON.parse(result);

				if(res.status == "success") {
					swal("Good job!", res.message, "success");
				}else {
					swal("Ooopss!",res.message, "error");
				}

				$('#currentPassword').val('');
				$('#newPassword').val('');
			}
		});
	});
});