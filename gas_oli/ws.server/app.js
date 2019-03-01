
var fs = require('fs');
var express = require('express');
var app = express();
var bodyParser = require('body-parser');
app.set('view engine', 'ejs');
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({extended: false}));
app.use(express.static(__dirname+'/assets'));

var https = require('https');
var key = fs.readFileSync('./ssl/private.key');
var cert = fs.readFileSync('./ssl/certificate.crt');
var ca = fs.readFileSync('./ssl/ca_bundle.crt');

var https_options = {
    ca:ca,
    key: key,
    cert: cert,
    requestCert: false,
    rejectUnauthorized: false
};
server = https.createServer(https_options, app).listen(3000);


var io = require('socket.io').listen(server);

/*

var redis = require("redis"),
    client = redis.createClient(6379,'localhost');

client.on("error", function (err) {
    console.log("Error " + err);
});

client.on('connect', function() {
    console.log('Redis client connected');
});
*/

var crew_inf = {};
var admin_sock_id ;


io.on('connection', function(socket) {

     /* client.subscribe('filtered');

      client.on("message", function(channel, message) {
          console.log(JSON.parse(message));
          socket.emit('change_status',{'well_info':JSON.parse(message)});
      });
*/

    socket.on('crew_latlng',function (data) {


        socket.emit('crew_road',{'latlngs':{'lat':data['lat'],'lng':data['lng'],'well_lat':data['well_lat'],'well_lng':data['well_lng']}});
    });


    socket.on('new_admin_key',function (data) {

        admin_sock_id = data['admin_socket_id'];
    });

});

app.post('/crew_inf', function (req, res) {
    console.log(req.body);

    if(req.body.length == 0){

        return res.send({success:false});
    }

    io.emit('getData', req.body);

    res.send({success:true});

});

app.post('/removeUser', function (req, res) {
    console.log(req.body);

    if(req.body.length == 0){

        return res.send({success:false});
    }

    io.emit('removeUser', req.body);

    res.send({success:true});
});

io.on('delete',function (data) {

    socket.emit('asd', {true});
});

