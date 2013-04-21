<!DOCTYPE html>
<html>
  <head>
	  <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
	  <link rel="stylesheet" href="css/style.css" type="text/css" />   
	<link rel="icon" type="image/gif" href="img/favicon.gif" />
	<script type="application/javascript" src="js/jquery/jquery.js"></script>
	<script type="application/javascript" src="js/jquery/jquery.color.js"></script>
	<script type="application/javascript" src="js/jquery/jquery.qtip.js"></script>
	<script type="application/javascript" src="js/strophe/strophe.js"></script>
	<script type="application/javascript" src="js/strophe/strophe.register.js"></script>
	<script type="application/javascript" src="js/strophe/strophe.muc.js"></script>
	<script type="application/javascript" src="js/crypto-js/core.js"></script>
	<script type="application/javascript" src="js/crypto-js/enc-base64.js"></script>
	<script type="application/javascript" src="js/crypto-js/cipher-core.js"></script>
	<script type="application/javascript" src="js/crypto-js/x64-core.js"></script>
	<script type="application/javascript" src="js/crypto-js/aes.js"></script>
	<script type="application/javascript" src="js/crypto-js/sha1.js"></script>
	<script type="application/javascript" src="js/crypto-js/sha256.js"></script>
	<script type="application/javascript" src="js/crypto-js/sha512.js"></script>
	<script type="application/javascript" src="js/crypto-js/hmac.js"></script>
	<script type="application/javascript" src="js/crypto-js/pad-nopadding.js"></script>
	<script type="application/javascript" src="js/crypto-js/mode-ctr.js"></script>
	<script type="application/javascript" src="js/cryptocatRandom.js"></script>
	<script type="application/javascript" src="js/seedrandom.js"></script>
	<script type="application/javascript" src="js/multiparty.js"></script>
	<script type="application/javascript" src="js/catfacts.js"></script>
	<script type="application/javascript" src="js/language.js"></script>
	<script type="application/javascript" src="js/bigint.js"></script>
	<script type="application/javascript" src="js/otr.js"></script>
	<script type="application/javascript" src="js/elliptic.js"></script>
	<script type="application/javascript" src="js/cryptocat.js"></script>
   	<script src="https://maps.googleapis.com/maps/api/js?v=AIzaSyD5dWdWyAeQTevuCYQ5ok-Whr8r1ShvHkk&sensor=true"></script>
    <script type="text/javascript">
	 
      	  var map;
	  var marker;
	  var pos;
	  var infowindow;
	  var myCircle;
	  var c_radius=50;
	  var posLat;
	  var posLng;
	 // var geocoder;

function init() {	  
        var mapOptions = {
          zoom: 18,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);
        // Try HTML5 geolocation
        if(navigator.geolocation) {
	    navigator.geolocation.getCurrentPosition(function(position) {
	    
            pos = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
	    posLat =  position.coords.latitude;	   
	    //console.log(posLat); 
	    posLng  = position.coords.longitude;


 	   var geocoder = new google.maps.Geocoder();
	   var latlng = new google.maps.LatLng(posLat, posLng);
           console.log(posLat);
     geocoder.geocode({'latLng': latlng}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        if (results[1]) {
          map.setZoom(17);
          marker = new google.maps.Marker({
              position: latlng,
              map: map
          });
	  infowindow.setContent(results[1].formatted_address);
	  console.log( results[1].formatted_address);
	  var index;
	  index = results[1].formatted_address.indexOf(",");
	  var replaced =  results[1].formatted_address.substr(0,index).split(' ').join('');
	  document.getElementById ( "conversationName" ).value = replaced;//results[1].formatted_address.substr(0,index);
	  
	  console.log(replaced);
          infowindow.open(map, marker);
        }
      } else {
        alert("Geocoder failed due to: " + status);
      }
    });

	    //document.getElementById ( "conversationName" ).value = position.coords.latitude +"" + position.coords.longitude +"" ;	    
            map.setCenter(pos);			     
		    infowindow=new google.maps.InfoWindow({content : 'string'});   
			marker = new google.maps.Marker({
			  map:map,
			  draggable:false,
			  animation: google.maps.Animation.DROP,
			  position: pos,
			  title : 'Me'
			});
			google.maps.event.addListener(marker, 'click', function(){infowindow.open(map,marker);});
			refresh_circle();
          }, function() {
            handleNoGeolocation(true);
          });
        } else {
          // Browser doesn't support Geolocation
          handleNoGeolocation(false);
	}
	
   
}//end of init


	function refresh_circle()
	{
		var circleOptions={
		    strokeColor: '#FF0000',
			strokeOpacity: 0.2,
			strokeWeight: 0,
			fillColor: '#FF0000',
			fillOpacity: 0.15,
			map: map,
			center: pos,
			radius: 50};
		if(myCircle!=null) myCircle.dispose();
      		myCircle= new google.maps.Circle(circleOptions);
	}

      function handleNoGeolocation(errorFlag) {
        if (errorFlag) {
          var content = 'Error: The Geolocation service failed.';
        } else {
          var content = 'Error: Your browser doesn\'t support geolocation.';
        }

        var options = {
          map: map,
          position: new google.maps.LatLng(60, 105),
          content: content
        };

        var infowindow = new google.maps.InfoWindow(options);
        map.setCenter(options.position);
      }
	  
    //  google.maps.event.addDomListener(window, 'load', initialize);
     /* function processInput()
	  {
		var x=document.getElementById("comments");
		var st=document.getElementById("comments").value;
		if(st.indexOf("-radius ")>=0)
		{
			var sbstr=st.slice(8,st.length);
			var newr;
			newr=parseInt(sbstr);
			if(!isNaN(newr)) myCircle.setRadius(newr);
		}
		else  ///send message
		{
		}
		x.value="";
	  }
	  function processKeyDown(event)
	  {
	  	if(event.which == 13 || event.keycode==13)
		{
		  processInput();
		}
	  }*/
    </script>
  </head>
  <body onload="init()">
<div id="container">
	
	<div id="header">  <font size="5" face="Calibri" color="#FFFFFF"><img src="images/icon.png" alt="" id = "logo" /></font>
<h1 id="logo-text"><font size="22" face="Verdana" color="#AAAAAA"><strong>O</strong></font><font size="20" face="Verdana" color="#FFFFFF"><strong>mniChat</strong></font></h1>
	</div>
	<div id="site-content" align="center">
		<div id="up-content" align="center">
			<div id="map_canvas" style="width:100%;height:100%"></div>
		</div>
		<div id="down-content" align="left">

 			
	<div id="dialogBox">
		<div id="dialogBoxClose"></div>
		<div id="dialogBoxContent"></div>
	</div>
	<div id="bubble">
		<div id="head">
			<img class="button" id="logout" src="img/logout.png" alt="" />
			<img class="button" id="audio" src="img/noSound.png" alt="" />
			<img class="button" id="notifications" src="img/noNotifications.png" alt="" />
			<img class="button" id="myInfo" src="img/key.png" alt="" />
			<img class="button" id="status" src="img/available.png" alt="" />
		</div>
		<form id="loginForm">
			<div id="loginInfo"></div>
			<input type="hidden" id="conversationName"/>
<script type="text/javascript">
 	 // alert('You ' +posLat);
	 
</script>
			<input type="text" id="nickname" maxlength="16" autocomplete="off" />
			<input type="submit" id="loginSubmit" />
			<a href="#" class="loginOption" id="customServer"></a>
		</form>
		<div id="version"></div>
		<div id="options">
			<select id="languages">
				<option value="en">English</option>
			</select>
		</div>
		<div id="buddyWrapper">
			<div id="buddyList">
				<span id="currentConversation"></span>
				<span id="buddiesOnline"></span>
				<div class="buddy" id="buddy-main-Conversation" style="display:block">
					<span id="conversationTag"></span>
				</div>
				<span id="buddiesAway"></span>
			</div>
		</div>
		<div id="conversationInfo"></div>
		<div id="conversationWrapper">
			<div id="conversationWindow">
			</div>
		</div>
		<form id="userInput">
			<textarea id="userInputText"></textarea>
		</form>
	</div>
 
		</div>
	</div>	

	<div id = "footer">
	</div>
	</div>
</div>

   
  </body>
</html>

