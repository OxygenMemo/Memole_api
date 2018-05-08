var http = require('http');

//create a server object:
http.createServer(function (req, res) {
  res.write('Hello World!'); //write a response to the client
  res.end(); //end the response
}).listen(8080);
//$ docker run --name some-mysql -e MYSQL_ROOT_PASSWORD=p@ssw0rd -d mysql