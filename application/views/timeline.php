<!DOCTYPE html>
<html>
<head>
    <title>Facebook Login JavaScript Example</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
* {
    box-sizing: border-box ;
}

body {
    background-color: #474e5d;
    font-family: Helvetica, sans-serif;
}

/* The actual timeline (the vertical ruler) */
.mytimeline {
    position: relative;
    max-width: 1200px;
    margin: 0 auto;
}

/* The actual timeline (the vertical ruler) */
.mytimeline::after {
    content: '';
    position: absolute;
    width: 6px;
    background-color: white;
    top: 0;
    bottom: 0;
    left: 50%;
    margin-left: -3px;
}

/* Container around content */
.mycontainer {
    padding: 10px 40px;
    position: relative;
    background-color: inherit;
    width: 50%;
}

/* The circles on the timeline */
.mycontainer::after {
    content: '';
    position: absolute;
    width: 25px;
    height: 25px;
    right: -17px;
    background-color: white;
    border: 4px solid #FF9F55;
    top: 15px;
    border-radius: 50%;
    z-index: 1;
}

/* Place the container to the left */
.myleft {
    left: 0;
}

/* Place the container to the right */
.myright {
    left: 50%;
}

/* Add arrows to the left container (pointing right) */
.myleft::before {
    content: " ";
    height: 0;
    position: absolute;
    top: 22px;
    width: 0;
    z-index: 1;
    right: 30px;
    border: medium solid white;
    border-width: 10px 0 10px 10px;
    border-color: transparent transparent transparent white;
}

/* Add arrows to the right container (pointing left) */
.myright::before {
    content: " ";
    height: 0;
    position: absolute;
    top: 22px;
    width: 0;
    z-index: 1;
    left: 30px;
    border: medium solid white;
    border-width: 10px 10px 10px 0;
    border-color: transparent white transparent transparent;
}

/* Fix the circle for containers on the right side */
.myright::after {
    left: -16px;
}

/* The actual content */
.mycontent {
    padding: 20px 30px;
    background-color: white;
    position: relative;
    border-radius: 6px;
}
.affix {
      
      z-index: 9999 !important;
  }

/* Media queries - Responsive timeline on screens less than 600px wide */
@media screen and (max-width: 600px) {
  /* Place the timelime to the left */
  .mytimeline::after {
    left: 31px;
  }
  
  /* Full-width containers */
  .mycontainer {
    width: 100%;
    padding-left: 70px;
    padding-right: 25px;
  }
  
  /* Make sure that all arrows are pointing leftwards */
  .mycontainer::before {
    left: 60px;
    border: medium solid white;
    border-width: 10px 10px 10px 0;
    border-color: transparent white transparent transparent;
  }

  /* Make sure all circles are at the same spot */
  .myleft::after, .myright::after {
    left: 15px;
  }
  
  /* Make all right containers behave like the left ones */
  .myright {
    left: 0%;
  }
  .black-ribbon {  position: fixed;  z-index: 9999;  width: 70px;}@media only all and (min-width: 768px) {  .black-ribbon {    width: auto;  }}.stick-left { left: 0; }.stick-right { right: 0; }.stick-top { top: 0; }.stick-bottom { bottom: 0; }
  .selecttimeline{
    background-color: white;
    padding: 10px;
    color:white;

  }
}
</style>
</head>
<body>

<?php require("template/menu.php") ?>
<div style="border-radius: 6px;padding: 20px;background-color: white;position: fixed;top: 160px ;left: 0;">
  <li style="z-index: 1;" id="timeline-dropdown" class="dropdown"><a class="dropdown-toggle " data-toggle="dropdown" href="#">timeline<span class="caret"></span></a>
        <ul id="timeline-dropdown-list" class="dropdown-menu">
          <li onclick="switchtimeline(1)"><a href="#">Page 1-1</a></li>
          <li><a href="#">Page 1-2</a></li>
          <li><a href="#">Page 1-3</a></li>
        </ul>
      </li>
</div>
<div style="z-index: 1;border-radius: 6px;padding: 20px;background-color: white;position: fixed;top: 60px ;left: 0;">
  <li id="createtimeline" onclick="createtimeline()"><a>createtimeline</a></li>
</div>
<div id="inner">
  <div id="mytimeline" class="mytimeline">
    <h1 style="margin-left: 100px;color: white">Plese select your timeline .</h1>
  </div> 
</div>
<div class="" style="border-radius: 6px;padding: 20px;background-color: white;position: fixed;bottom: 0 ;left: 0;">
title : <input id=title type="text"><br>
article : <input id=article type="text"><br>
time : <input id=date type="date"><br>
<button onclick="addtext()">add text<button>
</div>
<div id="timeline_name" style="border-radius: 6px;padding: 20px;background-color: white;position: fixed;bottom:200px;left:0;">

</div>
<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
<script>
  $("#timeline_name").hide()
  // This is called with the results from from FB.getLoginStatus().
  let user_id ="";
  function statusChangeCallback(response) {
    console.log('statusChangeCallback');
    console.log(response);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
      $('#timelinelink').show();
      
      testAPI();
    } else {
      // The person is not logged into your app or we are unable to tell.
      
      $('#timelinelink').hide();
    }
  }

  // This function is called when someone finishes with the Login
  // Button.  See the onlogin handler attached to it in the sample
  // code below.
  function checkLoginState() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }

  window.fbAsyncInit = function() {
    FB.init({
      appId      : '2165660407050761',
      cookie     : true,  // enable cookies to allow the server to access 
                          // the session
      xfbml      : true,  // parse social plugins on this page
      version    : 'v2.8' // use graph api version 2.8
    });

    // Now that we've initialized the JavaScript SDK, we call 
    // FB.getLoginStatus().  This function gets the state of the
    // person visiting this page and can return one of three states to
    // the callback you provide.  They can be:
    //
    // 1. Logged into your app ('connected')
    // 2. Logged into Facebook, but not your app ('not_authorized')
    // 3. Not logged into Facebook and can't tell if they are logged into
    //    your app or not.
    //
    // These three cases are handled in the callback function.

    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });

  };

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "https://connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  // Here we run a very simple test of the Graph API after login is
  // successful.  See statusChangeCallback() for when this call is made.
  function testAPI() {
    console.log('Welcome!  Fetching your information.... ');
    FB.api('/me', function(response) {
      console.log('Successful login for: ' + response.name);
      getTimelineByUserId(response.id)
     
    });
  }
  function getTimelineByUserId(userid){
    console.log(userid)
    $.get(`https://localhost:8082/user/${userid}/timeline`, function(data, status){
      let html=""
        for(let i =0 ;i<data.length;i++){
          html +=`<li style="z-index:1;" onclick="switchtimeline(${data[i].timeline_id},'${data[i].timeline_name}')"><a>${data[i].timeline_name}</a></li>`
        }
        $('#timeline-dropdown-list').html(html)
        $("#timeline-dropdown").show()
    });
  }
  function createtimeline(){
    let timeline_name = window.prompt("name timeline.", "Name");
    if(timeline_name !=null){
    FB.api('/me?fields=id,name', function(response) {
      let datax = {
        timeline_name: timeline_name,
        timeline_userid: response.id
      }
      console.log(response.id)
      $.ajax({
            type: "POST",
            url: "https://localhost:8082/timeline",
            data: JSON.stringify(datax),
            contentType: "application/json; charset=utf-8", // this
            dataType: "json", // and this
            success: function (msg) {
               console.log(msg)
               getTimelineByUserId(response.id)
            },
            error: function (errormessage) {
                //do something else
                console.log("error")
                console.log(errormessage)
            }
        });
    });
    }
   
  }
  let timeline_id = ""
  
  function switchtimeline(id,name){
    let x=`timeline : ${name} <span style="cursor: pointer;" onclick='deletetimeline(${id})' class='glyphicon glyphicon-trash'></span>`;
    $("#timeline_name").html(x)
    $("#timeline_name").show();

    timeline_id = id 
    $.get(`https://localhost:8082/timeline/${id}/text`, function(data, status){
      let html=""
      if(data.length == 0){
        let html = "<h1 style='margin-left:100px;color:white'>No text</h1>"
        $('#mytimeline').html(html)
      }else{
        
        for(let i =0 ;i<data.length;i++){
          
          if(i%2==0){
          html +=`<div class="mycontainer myleft">`
          }else{
            html +=`<div class="mycontainer myright">`
          }
          
          html += `
      <div class="mycontent">
        
        <h2>${data[i].text_title}</h2>
        <p>${data[i].text_article}</p>
        <p>${data[i].text_date}</p>
        
        <span onclick="deletetext(${data[i].text_id})" class="glyphicon glyphicon-trash"></span>
      </div>
    </div>`
          
        }
        $('#mytimeline').html(html)
      }
    });
    
  }
  function deletetext(id){
    $.ajax({
    url: `https://localhost:8082/text/${id}`,
    type: 'DELETE',
    success: function(result) {
      alert('delete complete')
      switchtimeline(timeline_id);

    }
});
  }
  function deletetimeline(id){
    $.ajax({
      url: `https://localhost:8082/timeline/${id}`,
      type: 'DELETE',
      success: function(result) {
        alert('delete complete')
        location.reload();

      }
    });
  }
  function addtext(){
    let datax = {
      text_title: $("#title").val(),
      text_article: $("#article").val(),
      text_date: $('#date').val()
    }
    console.log(timeline_id)
    $.ajax({
            type: "POST",
            url: `https://localhost:8082/timeline/${timeline_id}/text`,
            data: JSON.stringify(datax),
            contentType: "application/json; charset=utf-8", // this
            dataType: "json", // and this
            success: function (msg) {
               alert('add text complete');
               $("#title").val(''),
               $("#article").val('')
               $('#date').val('')
               switchtimeline(timeline_id)

            },
            error: function (errormessage) {
                //do something else
                console.log("error")
                console.log(errormessage)
                alert('error');
                
            }
        });
  }
 
  
</script>

</body>
</html>