$(function(){

	var base_url = $('body').data('urlbase');

	$('#sectionSelect').on('change', function() {
	 
		let sectionId = this.value;
		let section = $('#sectionSelect option:selected').text();

		if ( $.fn.DataTable.isDataTable( '#studentsTable' ) ) {
		  $('#studentsTable').DataTable().destroy();
		}

		var studentsTable =	$('#studentsTable').DataTable({
								processing:true,
								serverSide:true,
								retrieve:true,								
								ajax:{
									url: base_url+'Students/studentsPerSectionJSON',
									data:{ section: sectionId }
								},
								columns:[
									{
										data:null,
										render:function(data,type,row) {
											return data.last_name+', '+data.first_name
										}
									}
								],
								dom: 'Bfrtip',
						        buttons: [
						        	{
						        		extend:'excelHtml5',
						        		filename:section+' ('+today+')'
						        	},
						        	{
						        		extend:'pdfHtml5',
						        		filename:section+' ('+today+')'
						        	}
						        ]																
							});

	});	

});