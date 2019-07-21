$(function(){
	
	var base_url = $('body').data('urlbase');

	$('#reportBtn').click(function(){

		let course = $('#courseSelect').val();
		let courseText = $('#courseSelect option:selected').text();
		let gender = $('#genderSelect').val();
		let genderText = $('#genderSelect option:selected').text();
		let schoolYear = $('#schoolYearSelect').val();
		let schoolYearText = $('#schoolYearSelect option:selected').text();

		if ( $.fn.DataTable.isDataTable( '#courseTable' ) ) {
		  $('#courseTable').DataTable().destroy();
		}		


			let courseTable =	$('#courseTable').DataTable({
								processing:true,
								serverSide:true,
								retrieve:true,
								ordering:false,							
								ajax:{
									url: base_url+'Gender/courseJSON',
									data:{ 
										course: course,
										gender : gender, 
										schoolYear: schoolYear 
									}
								},
								columns:[
									{
										data:"date",
										render:function(data,type,row) {
											return row.student
										}
									},
									{
										data:"student",
										render:function(data,type,row){
											return row.section;
										}
									}
								],
								dom: '<"row"<"col-sm-6"><"col-sm-6 text-right"B>>tri',
						        buttons: [
						        	{
						        		extend:'excelHtml5',
						        		filename:courseText+' '+genderText+' '+schoolYearText,
						        		className:'btn btn-success mb-1'
						        	},
						        	{
						        		extend:'pdfHtml5',
						        		filename:courseText+' '+genderText+' '+schoolYearText,
						        		className:'btn btn-danger mb-1'
						        	}
						        ]																
							});


	});

});