$(function(){
	
	var base_url = $('body').data('urlbase');

	$('#reportBtn').click(function(){

		let gradeLevel = $('#gradeLevelSelect').val();
		let gradeLevelText = $('#gradeLevelSelect option:selected').text();
		let gender = $('#genderSelect').val();
		let genderText = $('#genderSelect option:selected').text();
		let schoolYear = $('#schoolYearSelect').val();
		let schoolYearText = $('#schoolYearSelect option:selected').text();

		if ( $.fn.DataTable.isDataTable( '#sectionTable' ) ) {
		  $('#sectionTable').DataTable().destroy();
		}		


			let courseTable =	$('#sectionTable').DataTable({
								processing:true,
								serverSide:true,
								retrieve:true,
								ordering:false,							
								ajax:{
									url: base_url+'Gender/gradeLevelJSON',
									data:{ 
										gradeLevel: gradeLevel,
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
										data:"section",
										render:function(data,type,row) {
											return row.section
										}
									},
									{
										data:"course",
										render:function(data,type,row) {
											return row.course
										}
									}
								],
								dom: '<"row"<"col-sm-6"><"col-sm-6 text-right"B>>tri',
						        buttons: [
						        	{
						        		extend:'excelHtml5',
						        		filename:gradeLevelText+' '+genderText+' '+schoolYearText,
						        		className:'btn btn-success mb-1'
						        	},
						        	{
						        		extend:'pdfHtml5',
						        		filename:gradeLevelText+' '+genderText+' '+schoolYearText,
						        		className:'btn btn-danger mb-1'
						        	}
						        ]																
							});


	});

});