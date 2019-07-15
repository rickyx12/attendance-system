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

		let attendanceTable =	$('#attendanceTable').DataTable({
								processing:true,
								serverSide:true,
								retrieve:true,
								ordering:false,							
								ajax:{
									url: base_url+'Settings/getStudentAttendanceByDate',
									data:{ from: from, to: to, student: student }
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