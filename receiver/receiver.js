var express = require('express');
const request = require('request');
const http = require('http')

var app = express();


var sms = [];
var statusResponse = "";
var smsIndex = 0;

function sendSms() {

	if(typeof sms[0] !== 'undefined') {

		request("http://192.168.1.92/action_page?cpNumber="+sms[0]['cpNumber']+"&message="+sms[0]['message'], { json: false }, (err, res, body) => {
			
			if (err) { 
				return console.log("TECH-GUARDIAN DEVICE IS OFF"); 
			}

			
			let isSent = res.body;

			if(isSent != "") {

				sms.shift();
				sendSms();
			} else {
				
				sendSms();	
			}
		});
	}
	console.table(sms);	
}


app.get('/', function (req, res) {

	sms.push(req.query);
	
	// console.table(sms);
	sendSms();

 	res.send("Success");

})


var server = app.listen(8081, function () {
   var host = "localhost";
   var port = server.address().port
  
   console.log("SMS Connected. listening at http://%s:%s", host, port)
})