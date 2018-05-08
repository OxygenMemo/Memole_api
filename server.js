var express = require('express');
var app = express();
var MySql = require('sync-mysql');
const bodyParser = require('body-parser')


  var connection = new MySql({
    host: "localhost",
    user: "root",
    password: "p@ssw0rd",
    database: "myapp"
  });

app.use(bodyParser.urlencoded({ extended: false }))
app.use(bodyParser.json())

app.get('/', function (req, res) {
   res.send('Helslo Wsorld');
   con.connect(function(err) {
    if (err) throw err;
    console.log("Connected!");
  });
  
})
//---------------------- timeline ----------------------
//timeline by userid
app.get('/timeline/:timelineid',(req,res) => {
    let timeline_id = req.params.timelineid
    const result = connection.query(`SELECT * FROM timeline WHERE timeline_id = ${timeline_id}`);
    res.status(200).json(result)
})

//insert timeline
app.post('/timeline',(req,res) => {
    let newtimeline = req.body;
    const result = connection.query(`INSERT INTO timeline (timeline_name, timeline_userid ) VALUES ('${newtimeline.timeline_name}', '${newtimeline.timeline_userid}')`);
    res.status(201).json(newtimeline);
})
//delete
app.delete('/timeline/:timelineid',(req,res) => {
    let timeline_id = req.params.timelineid
    const result = connection.query(`DELETE FROM timeline WHERE timeline_id = ${timeline_id}`);
    res.status(204).json()
})
//---------------------- text ----------------------

//get text by timeline id
app.get('/timeline/:timelineid/text/',(req,res) => {
    let timeline_id = req.params.timelineid
    const result = connection.query(`SELECT * FROM timeline INNER JOIN text ON text.timeline_id = timeline.timeline_id WHERE timeline.timeline_id = ${timeline_id}`);
    res.status(200).json(result)
})




var server = app.listen(8082, function () {
   var host = server.address().address
   var port = server.address().port
   
   console.log("Example app listening at http://%s:%s", host, port)
})