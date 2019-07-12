$(function(){
	
	var base_url = $('body').data('urlbase');

	$('input[name="dates"]').daterangepicker({
		opens:'left'
	},function(start,end,label) {

		let from = start.format('YYYY-MM-DD');
		let to = end.format('YYYY-MM-DD');


		if ( $.fn.DataTable.isDataTable( '#latesTable' ) ) {
		  $('#latesTable').DataTable().destroy();
		}


		var latesTable =	$('#latesTable').DataTable({
								processing:true,
								serverSide:true,
								retrieve:true,	
								"lengthMenu": [ 10, 25, 50, 75, 100, 300, 500],							
								ajax:{
									url: base_url+'Settings/getLateByDateJSON',
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
											return data.schedule_timein
										}
									},
									{
										data:null,
										render:function(data,type,row) {
											return data.timeTap
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
										render:function(data,type,row) {
											return data.dateTap
										}
									}
								],
								dom: '<"row"<"col-sm-6"l><"col-sm-6 text-right"B>>trip',
						        buttons: [
						        	{
						        		extend:'excelHtml5',
						        		filename:'Lates ('+from+' to '+to+')',
						        		className:'btn btn-success mb-1'
						        	},
						        	{
						        		extend:'pdfHtml5',
						        		filename:'Lates ('+from+' to '+to+')',
						        		className:'btn btn-danger mb-1'
						        	}
						        ]																
							});



	});

});