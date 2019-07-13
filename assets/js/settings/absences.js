$(function(){
	
	var base_url = $('body').data('urlbase');

	$('input[name="dates"]').daterangepicker({
		opens:'left'
	},function(start,end,label) {

		let from = start.format('YYYY-MM-DD');
		let to = end.format('YYYY-MM-DD');


		if ( $.fn.DataTable.isDataTable( '#absencesTable' ) ) {
		  $('#absencesTable').DataTable().destroy();
		}


		var latesTable =	$('#absencesTable').DataTable({
								processing:true,
								serverSide:true,
								retrieve:true,							
								ajax:{
									url: base_url+'Settings/getAbsentByDateJSON',
									data:{ from: from, to: to }
								},
								columns:[
									{
										data:null,
										render:function(data,type,row) {
											return data.last_name+', '+data.first_name
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
										render:function(data,type,row) {
											return data.section
										}
									},
									{
										data:null,
										render:function(data,type,row){
											return formatDate(data.date)
										}
									}
								],
								dom: '<"row"<"col-sm-6"><"col-sm-6 text-right"B>>tr',
						        buttons: [
						        	{
						        		extend:'excelHtml5',
						        		filename:'Absent ('+from+' to '+to+')',
						        		className:'btn btn-success mb-1'
						        	},
						        	{
						        		extend:'pdfHtml5',
						        		filename:'Absent ('+from+' to '+to+')',
						        		className:'btn btn-danger mb-1'
						        	}
						        ]																
							});



	});

});