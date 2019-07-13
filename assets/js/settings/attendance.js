$(function(){
	
	var base_url = $('body').data('urlbase');

	$('#students-list').select2({
		placeholder: 'Search Student',
		ajax:{
			url:base_url+'Students/searchGradelevelStudentSelect2',
			dataType:'json',
			delay:250
		},
		width:'resolve'
	});

	$('input[name="dates"]').daterangepicker({
		opens:'left'
	},function(start,end,label) {

		let student = $('#students-list').select2('data')[0].id;
		let studentName = $('#students-list').select2('data')[0].text;
		let from = start.format('YYYY-MM-DD');
		let to = end.format('YYYY-MM-DD');

		if ( $.fn.DataTable.isDataTable( '#attendanceTable' ) ) {
		  $('#attendanceTable').DataTable().destroy();
		}


		var attendanceTable =	$('#attendanceTable').DataTable({
								processing:true,
								serverSide:true,
								retrieve:true,
								ordering:false,							
								ajax:{
									url: base_url+'Settings/test',
									data:{ from: from, to: to, student: student }
								},
								columns:[
									{
										data:null,
										render:function(data,type,row) {

											if(data.date != null) {
												return data.date;
											}else {
												return "";
											}

										}
									},
									{
										data:null,
										render:function(data,type,row) {

											if(data.date != null && data.type == 'in') {
												return data.day;
											}else {
												return "";
											}	
										}
									},
									{
										data:null,
										render:function(data,type,row) {

											if(data.type == "in") {
												return formatTime(data.sched_timein);
											}else if(data.type == "out") {
												return formatTime(data.sched_timeout);
											}else {
												return "";
											}
										}
									},
									{
										data:null,
										render:function(data,type,row) {

											if(data.timeTap != null) {
												return formatTime(data.timeTap);
											}else {
												return "";
											}
										
										}
									},
									{
										data:null,
										render:function(data,type,row) {
											
											if(data.type == "in") {
												return "IN";
											}else if(data.type == "out") {
												return "OUT";
											}else {
												return "";
											}

										}
									},
									{
										data:null,
										render:function(data,type,row) {

											let timein = data.sched_timein;
											let timeout = data.sched_timeout;

											if((data.timeTap > timein) && data.type == 'in') {
												return "LATE";
											}else if((data.timeTap < timeout) && data.type == 'out') {
												return "UNDERTIME";
											}else {
												return "";
											}

										}
									}
								],
								dom: '<"row"<"col-sm-6"><"col-sm-6 text-right"B>>tri',
						        buttons: [
						        	{
						        		extend:'excelHtml5',
						        		filename:studentName+' Attendance ('+from+' to '+to+')',
						        		className:'btn btn-success mb-1'
						        	},
						        	{
						        		extend:'pdfHtml5',
						        		filename:studentName+' Attendace ('+from+' to '+to+')',
						        		className:'btn btn-danger mb-1'
						        	}
						        ]																
							});		
	});
});