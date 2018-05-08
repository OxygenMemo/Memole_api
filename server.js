var express = require('express');
var app = express();
var mysql = require('mysql'); 
const bodyParser = require('body-parser')

var con = mysql.createConnection({
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

app.post('/timeline',(req,res) => {
    let newtimeline = req.body;

    try{
        con.connect(function(err) {
            if (err) throw err;
            console.log("Connected!");
            var sql = `INSERT INTO timeline (timeline_name, timeline_userid ) VALUES ('${newtimeline.timeline_name}', '${newtimeline.timeline_userid}')`;
            con.query(sql, function (err, result) {
            if (err) throw err;
            console.log("1 record inserted");

            res.status(201).json(newtimeline);
            });
        });
    }catch(err){
        console.log(err)
    }
})
var server = app.listen(8082, function () {
   var host = server.address().address
   var port = server.address().port
   
   console.log("Example app listening at http://%s:%s", host, port)
})