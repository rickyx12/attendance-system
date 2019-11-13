var express = require('express');
const request = require('request');
const http = require('http')

var app = express();


var sms = [];
var toSend = [];

function sendSms() {

	if(typeof sms[0] !== 'undefined') {

		request("http://192.168.1.92/action_page?cpNumber="+sms[0]['cpNumber']+"&message="+sms[0]['message'], { json: false }, (err, res, body) => {
			
			if (err) { 
				return console.log("TECH-GUARDIAN DEVICE IS OFF"); 
			}

			sms.shift();

		});
	}
	console.table(sms);	

	// console.log(sms[0]["cpNumber"].includes("9508341565"));
}

setInterval(function() {
	sendSms();
},10000);

app.get('/', function (req, res) {

	sms.push(req.query);

	// console.log(req.query['gradeLevelId']);
	// console.table(sms);
	// sendSms();

 	res.send("Success");

})


var server = app.listen(8081, function () {
   var host = "localhost";
   var port = server.address().port
  
   console.log("SMS Connected. listening at http://%s:%s", host, port)
})