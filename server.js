var express = require('express');
var app = express();
var MySql = require('sync-mysql');
const bodyParser = require('body-parser')
var cors = require('cors')
var fs = require('fs');

var https = require('https');

const options = {
    cert: fs.readFileSync('./sslcert/cert.pem'),
    key: fs.readFileSync('./sslcert/key.pem'),
    passphrase: '273110'
};
app.use(express.static('static'));



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
app.post("/testpost",(req,res) => {
    res.json(req.body)
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
    connection.query(`DELETE FROM text WHERE timeline_id = ${timeline_id}`)
    const result = connection.query(`DELETE FROM timeline WHERE timeline_id = ${timeline_id}`);
    res.status(204).json()
})
//---------------------- text ----------------------

//get text by timeline id
app.get('/timeline/:timelineid/text',(req,res) => {
    let timeline_id = req.params.timelineid
    const result = connection.query(`SELECT * FROM text WHERE timeline_id =${timeline_id} ORDER BY text_date DESC`);
    //
    res.status(200).json(result)
})
//insert text 
app.post('/timeline/:timelineid/text',(req,res) => {
    let newtext = req.body;
    let timeline_id = req.params.timelineid
    console.log(newtext)
    const result = connection.query(`INSERT INTO text(text_title, text_article, text_date, timeline_id) VALUES ('${newtext.text_title}', '${newtext.text_article}','${newtext.text_date}','${timeline_id}')`);
    
    newtext.timeline_id = timeline_id
    
    res.status(201).json(newtext)

})
app.delete('/text/:textid',(req,res) => {
    let textid = req.params.textid
    const result = connection.query(`DELETE FROM text WHERE text_id = ${textid}`);
    res.status(204).json()
})
app.listen(8081);
https.createServer(options, app).listen(8082);
