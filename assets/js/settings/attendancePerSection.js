$(function(){
	
	var base_url = $('body').data('urlbase');

	$('input[name="dates"]').daterangepicker({
		opens:'left'
	},function(start,end,label) {

		let sectionVal = $('#section').val();
		let sectionText = $('#section option:selected').text();
		let from = start.format('YYYY-MM-DD');
		let to = end.format('YYYY-MM-DD');

		if ( $.fn.DataTable.isDataTable( '#attendanceTable' ) ) {
		  $('#attendanceTable').DataTable().destroy();
		}

		let attendanceTable =	$('#attendanceTable').DataTable({
								processing:true,
								serverSide:true,
								retrieve:true,
								ordering:false,							
								ajax:{
									url: base_url+'Settings/getSectionAttendanceByDate',
									data:{ from: from, to: to, section: sectionVal }
								},
								columns:[
									{
										data:"date",
										render:function(data,type,row) {
											if(row.date != null) {
												return formatDate(row.date);
											}else {
												return "";
											}

										}
									},
									{
										data:"student",
										render:function(data,type,row){
											return row.student;
										}
									},
									{
										data:"day",
										render:function(data,type,row) {
											if(row.date != null && row.type == 'in') {
												return row.day;
											}else {
												return "";
											}	
										}
									},
									{
										data:"schedule",
										render:function(data,type,row) {

											if(row.type == "in") {
												return formatTime(row.sched_timein);
											}else if(row.type == "out") {
												return formatTime(row.sched_timeout);
											}else {
												return "";
											}
										}
									},
									{
										data:"time",
										render:function(data,type,row) {

											if(row.timeTap != null) {
												return formatTime(row.timeTap);
											}else {
												return "";
											}
										
										}
									},
									{
										data:"type",
										render:function(data,type,row) {
											
											if(row.type == "in") {
												return "IN";
											}else if(row.type == "out") {
												return "OUT";
											}else {
												return "";
											}

										}
									},
									{
										data:"note",
										render:function(data,type,row) {

											let timein = row.sched_timein;
											let timeout = row.sched_timeout;

											if((row.timeTap > timein) && row.type == 'in') {
												return "LATE";
											}else if((row.timeTap < timeout) && row.type == 'out') {
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
						        		filename:sectionText+' Attendance ('+from+' to '+to+')',
						        		className:'btn btn-success mb-1'
						        	},
						        	{
						        		extend:'pdfHtml5',
						        		filename:sectionText+' Attendace ('+from+' to '+to+')',
						        		className:'btn btn-danger mb-1'
						        	}
						        ]																
							});	
	});
});