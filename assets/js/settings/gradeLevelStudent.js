$(function(){

	var base_url = $('body').data('urlbase');

	$('#gradeLevelSelect').on('change', function() {
	 
		let gradeLevel = this.value;
		let grade = $('#gradeLevelSelect option:selected').text();

		if ( $.fn.DataTable.isDataTable( '#studentsTable' ) ) {
		  $('#studentsTable').DataTable().destroy();
		}

		var studentsTable =	$('#studentsTable').DataTable({
								processing:true,
								serverSide:true,
								retrieve:true,								
								ajax:{
									url: base_url+'Students/studentsPerGradeLevelJSON',
									data:{ gradeLevel: gradeLevel }
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
								dom: 'Bfrtip',
						        buttons: [
						        	{
						        		extend:'excelHtml5',
						        		filename:grade+' ('+today+')'
						        	},
						        	{
						        		extend:'pdfHtml5',
						        		filename:grade+' ('+today+')'
						        	}
						        ]																
							});

	});	

});