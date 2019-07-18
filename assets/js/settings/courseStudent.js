$(function(){

	var base_url = $('body').data('urlbase');

	$('#reportBtn').click(function() {
	 
		let courseVal = $('#courseSelect').val();
		let courseText = $('#courseSelect option:selected').text();
		let schoolYear = $('#schoolYearSelect').val();

		if ( $.fn.DataTable.isDataTable( '#courseTable' ) ) {
		  $('#courseTable').DataTable().destroy();
		}

		var studentsTable =	$('#courseTable').DataTable({
								processing:true,
								serverSide:true,
								retrieve:true,								
								ajax:{
									url: base_url+'Students/studentsPerCourseJSON',
									data:{ 
										course: courseVal,
										schoolYear:schoolYear 
									}
								},
								columns:[
									{
										data:null,
										render:function(data,type,row) {
											return data.last_name+', '+data.first_name
										}
									},
									{
										data:'section'
									}
								],
								dom: '<"row"<"col-sm-6"l><"col-sm-6 text-right"B>>trip',
						        buttons: [
						        	{
						        		extend:'excelHtml5',
						        		filename:courseText+' ('+today+')',
						        		className:'btn btn-success mb-1'
						        	},
						        	{
						        		extend:'pdfHtml5',
						        		filename:courseText+' ('+today+')',
						        		className:'btn btn-danger mb-1'
						        	}
						        ]																
							});

	});	

});