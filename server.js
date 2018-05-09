var express = require('express');
var app = express();
var MySql = require('sync-mysql');
const bodyParser = require('body-parser')
var cors = require('cors')



var connection = new MySql({
    host: "localhost",
    user: "root",
    password: "p@ssw0rd",
    database: "myapp"
});

var corsOptions = {
    origin: '*',
    optionsSuccessStatus: 200 // some legacy browsers (IE11, various SmartTVs) choke on 204
}

app.use(cors(corsOptions))
app.use(bodyParser.urlencoded({ extended: false }))
app.use(bodyParser.json())

app.get('/', function (req, res) {
   res.send('Helslo Wsorld');
   con.connect(function(err) {
    if (err) throw err;
    console.log("Connected!");
  });
  
})
//---------------------- user timeline ----------------
app.get('/user/:userid/timeline',(req,res) => {
    let user_id = req.params.userid
    const result = connection.query(`SELECT * FROM timeline WHERE timeline_userid = ${user_id}`);
    res.status(200).json(result)
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
app.get('/timeline/:timelineid/text',(req,res) => {
    let timeline_id = req.params.timelineid
    const result = connection.query(`SELECT * FROM text WHERE timeline_id = ${timeline_id}`);
    res.status(200).json(result)
})
//insert text 
app.post('/timeline/:timelineid/text',(req,res) => {
    let newtext = req.body;
    let timeline_id = req.params.timelineid
    const result = connection.query(`INSERT INTO text (text_title, text_article, timeline_id) VALUES ('${newtext.text_title}', '${newtext.text_article}','${timeline_id}')`);
    newtext.timeline_id = timeline_id
    res.status(201).json(newtext)

})



var server = app.listen(8082, function () {
   var host = server.address().address
   var port = server.address().port
   
   console.log("Example app listening at http://%s:%s", host, port)
})