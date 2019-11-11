var express = require('express');
const request = require('request');
const http = require('http')

var app = express();

var sms = [];

function sendSms() {

	request("http://192.168.1.92/action_page?cpNumber="+sms[0]["cpNumber"]+"&message="+sms[0]["message"], { json: false }, (err, res, body) => {
		
		if (err) { 
			return console.log(err); 
		}

		if(res.body != "") {
			sms.shift();

			if(sms.length > 0) {
				sendSms();
			}
		}

	});	
}

app.get('/', function (req, res) {

	sms.push(req.query);

	// console.table(sms);
	sendSms();
	// console.log(sms[0]["cpNumber"]);
   res.send('Hello World');


})


var server = app.listen(8081, function () {
   var host = "localhost";
   var port = server.address().port
  
   console.log("Example app listening at http://%s:%s", host, port)
})