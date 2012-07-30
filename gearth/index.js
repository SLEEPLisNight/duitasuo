	var ge;
    //var t = 0;
	var priority = 0;
	var oldPriority = 0;
	var placemarkArray = [];
	var placemark;
	var addPlacemark = null;
	var addPlacemarkEventListenerActive = null;
	var addPlacemarkSwitch = false;
	
function init() {
      google.earth.createInstance('map3d', initCallback, failureCallback);
     }
    
function initCallback(instance) {
      ge = instance;
      ge.getWindow().setVisibility(true);
    
      // add a navigation control
      ge.getNavigationControl().setVisibility(ge.VISIBILITY_AUTO);
    
      // add some layers
      ge.getLayerRoot().enableLayerById(ge.LAYER_BORDERS, true);
      ge.getLayerRoot().enableLayerById(ge.LAYER_ROADS, true);
	
	  // Get the current view
	  //var lookAt = ge.getView().copyAsLookAt(ge.ALTITUDE_RELATIVE_TO_GROUND);

	  // Zoom out to twice the current range
	  //lookAt.setRange(lookAt.getRange() * 2.0);

	  // Update the view in Google Earth
      //ge.getView().setAbstractView(lookAt);
    
	  refresh_words(0);
	  
	  enableAddPlacemarkEventListener();
	  
}
	
	function updateCameraRange(){
	
	var la = ge.getView().copyAsLookAt(ge.ALTITUDE_RELATIVE_TO_GROUND);
    var CameraRange = la.getRange();
	document.getElementById('camaraRange').value = CameraRange;
	
	if (CameraRange > 40000000){
	priority = 0;
	} else if (CameraRange > 10000000 && CameraRange <= 40000000){
	priority = 1;
	} else if (CameraRange > 6000000 && CameraRange <= 10000000){
	priority = 2;
	} else if (CameraRange > 2000000 && CameraRange <= 6000000){
	priority = 3;
	} else if (CameraRange > 500000 && CameraRange <= 2000000){
	priority = 4;
	} else if (CameraRange > 100000 && CameraRange <= 500000){
	priority = 5;
	} else if (CameraRange > 20000 && CameraRange <= 100000){
	priority = 6;
	} else if (CameraRange > 5000 && CameraRange <= 20000){
	priority = 7;
	} else if (CameraRange > 1000 && CameraRange <= 5000){
	priority = 8;
	} else if (CameraRange > 200 && CameraRange <= 1000){
	priority = 9;
	} else {
	priority = 10;
	} 
	
	if (priority == 0){
	document.getElementById('priorityview').value = "you are too far!";
	} else {
	document.getElementById('priorityview').value = priority + " level";
	}
	
	}
    
    function failureCallback(errorCode) {
    }
	
	function refresh_words(id){
	
	updateCameraRange();
	
	if (oldPriority != priority){
	oldPriority = priority;
	id = 0;
	
	//remove all the placemarks
	if (placemarkArray) {
    for (i in placemarkArray) {
      ge.getFeatures().removeChild(placemarkArray[i]);;
    }
    placemarkArray.length = 0;
	}
	
	}
	
	if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp_refresh_words=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
		xmlhttp_refresh_words=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp_refresh_words.onreadystatechange=function()
		{
		if (xmlhttp_refresh_words.readyState==4 && xmlhttp_refresh_words.status==200)
			{	
			if (xmlhttp_refresh_words.responseText != ""){
			//clearInterval(t);
			var refresh_one_word = new Array();
			refresh_one_word = xmlhttp_refresh_words.responseText.split("|");
			refresh_words_display(refresh_one_word[0],refresh_one_word[1],parseFloat(refresh_one_word[2]),parseFloat(refresh_one_word[3]),parseFloat(refresh_one_word[5]));
			refresh_words(refresh_one_word[4]);
			} else {
			refresh_words(id);
			}
			
			}
		}
		xmlhttp_refresh_words.open("GET","server_refresh_words.php?id="+id+"&priority="+priority,true);
		xmlhttp_refresh_words.send();
    }
	
	function refresh_words_display(title,descr,la,lo,placemarkPriority) {
      placemark = ge.createPlacemark('');
      placemark.setName(title);
      // Create style map for placemark
      var icon = ge.createIcon('');
	  icon.setHref('http://maps.google.com/mapfiles/kml/paddle/red-circle.png');
      var style = ge.createStyle('');
      style.getIconStyle().setIcon(icon);
	  if (placemarkPriority == 0){
	  style.getIconStyle().setScale(0.0);
	  } else if (placemarkPriority == 1){
	  style.getIconStyle().setScale(4.0);
	  } else if (placemarkPriority == 2){
	  style.getIconStyle().setScale(3.0);
	  } else if (placemarkPriority == 3){
	  style.getIconStyle().setScale(2.0);
	  } else if (placemarkPriority == 4){
	  style.getIconStyle().setScale(1.6);
	  } else if (placemarkPriority == 5){
	  style.getIconStyle().setScale(1.3);
	  } else {
	  style.getIconStyle().setScale(1.1);
	  }
      placemark.setStyleSelector(style);
    
      // Create point
      //var la = ge.getView().copyAsLookAt(ge.ALTITUDE_RELATIVE_TO_GROUND);
      var point = ge.createPoint('');
      point.setLatitude(la);
      point.setLongitude(lo);
      placemark.setGeometry(point);
	  //ge.getView().setAbstractView(la);
		
	  //counter++;
	  //say_words_database(words,Latitude,Longitude);
	  ge.getFeatures().appendChild(placemark);
	 
	google.earth.addEventListener(placemark, 'click', function(event) {
    // prevent the default balloon from popping up
    event.preventDefault();

    var balloon = ge.createHtmlStringBalloon('');
    balloon.setFeature(event.getTarget());
    balloon.setMaxWidth(400);

    // Google logo.
    balloon.setContentString('<div class=\"display_words\">Title: <b><font size=4>' + title + '</font></b></br></br> Description: <font color=red>' + descr + '</font></div>');
    ge.setBalloon(balloon);
	
	//remove addPlacemark
	ge.getFeatures().removeChild(addPlacemark);
	});
	
	google.earth.addEventListener(placemark, 'mouseover', function(event) {
	//disable AddPlacemarkEventListener
	disableAddPlacemarkEventListener();
	});
	
	google.earth.addEventListener(placemark, 'mouseout', function(event) {
	//enable AddPlacemarkEventListener
	enableAddPlacemarkEventListener()
	});
  
	  placemarkArray.push(placemark);
	}
    
    function say_words(la,lo) {
	  var title = document.getElementById('title').value;
	  var descr = document.getElementById('descr').value;
	  title = encodeURIComponent(title);
	  descr = encodeURIComponent(descr);
	
	  var e = document.getElementById("priority");
	  var priority = e.options[e.selectedIndex].value;
	  say_words_database(title,descr,la,lo,priority);
		
	}
	
	function say_words_database(title,descr,la,lo,priority){
	
	if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp_say_words=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
		xmlhttp_say_words=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp_say_words.onreadystatechange=function()
		{
		if (xmlhttp_say_words.readyState==4 && xmlhttp_say_words.status==200)
			{
			document.getElementById('title').value = "";
			document.getElementById('descr').value = "";
			ge.getFeatures().removeChild(addPlacemark);
			ge.setBalloon(null);
			document.getElementById("priority").selectedIndex = 0;
			}
		}
		xmlhttp_say_words.open("GET","server_say_words.php?title="+title+"&descr="+descr+"&la="+la+"&lo="+lo+"&priority="+priority,true);
		xmlhttp_say_words.send();
    }
	
function fly_to() {
  var geocodeLocation = document.getElementById('location').value;
  var geocoder = new google.maps.ClientGeocoder();
  geocoder.getLatLng(geocodeLocation, function(point) {
    if (point) {
      var lookAt = ge.createLookAt('');
      lookAt.set(point.y, point.x, 10, ge.ALTITUDE_RELATIVE_TO_GROUND,
                 0, 0, 1000);
      ge.getView().setAbstractView(lookAt);
    }
  });
}


function enableAddPlacemarkEventListener() {
  if (!addPlacemarkEventListenerActive) {
    google.earth.addEventListener(ge.getGlobe(), 'click', addPlacemarkEventHandler);
    addPlacemarkEventListenerActive = true;
  }
}

function disableAddPlacemarkEventListener() {
  if (addPlacemarkEventListenerActive) {
    google.earth.removeEventListener(ge.getGlobe(), 'click', addPlacemarkEventHandler);
    addPlacemarkEventListenerActive = false;
  }
}

function addPlacemarkEventHandler(event) {

		// prevent the default balloon from popping up
		event.preventDefault();
		if (event.getButton() != 0){
			return;
		}
		// remove old placemarks
		if (addPlacemark){
			ge.getFeatures().removeChild(addPlacemark);
		}
		
		if (addPlacemarkSwitch){
		// hit test and create new placemarks
		var hitTestResult = ge.getView().hitTest(event.getClientX(), ge.UNITS_PIXELS, event.getClientY(), ge.UNITS_PIXELS, ge.HIT_TEST_GLOBE);
		if (hitTestResult) {
		addPlacemark = makePlacemark(parseFloat(hitTestResult.getLatitude()), parseFloat(hitTestResult.getLongitude()));
		ge.getFeatures().appendChild(addPlacemark);
		}
		
		// prevent the default balloon from popping up
		event.preventDefault();
		
		var balloon = ge.createHtmlStringBalloon('');
		balloon.setFeature(addPlacemark);
		balloon.setMaxWidth(500);
		
		var location = "Can not find location."
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp_getLocationInfo=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
		xmlhttp_getLocationInfo=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp_getLocationInfo.onreadystatechange=function()
		{
		if (xmlhttp_getLocationInfo.readyState==4 && xmlhttp_getLocationInfo.status==200)
			{
				location = xmlhttp_getLocationInfo.responseText;
				
				balloon.setContentString("<table class=\"tell_world\">"+
				"<tr><td>Location: </td><td>"+ location +"</td></tr>"+
				"<tr><td><label >Title: </label></td><td><input type=\"text\" id=\"title\"></td></tr>"+
				"<tr><td><label >Description: </label></td><td><textarea id=\"descr\" ></textarea></td></tr>"+
				"<tr><td><label >Priority: </label></td>"+
				"<td><select id=\"priority\" >"+      
				"<option value=\"1\">1 level</option>"+   
				"<option value=\"2\">2 level</option>"+
				"<option value=\"3\">3 level</option>"+
				"<option value=\"4\">4 level</option>"+      
				"<option value=\"5\">5 level</option>"+     
				"<option value=\"6\">6 level</option>"+  
				"<option value=\"7\">7 level</option>"+       
				"<option value=\"8\">8 level</option>"+     
				"<option value=\"9\">9 level</option>"+ 
				"<option value=\"10\">10 level</option>"+  		
				"</select></td></tr>"+
				"<tr><td><input type=\"button\" value=\"tell the world\" onclick=\"say_words("+hitTestResult.getLatitude()+","+hitTestResult.getLongitude()+")\"></td></tr>"+
				"</table>");
		
				ge.setBalloon(balloon);
			}
		}
		xmlhttp_getLocationInfo.open("GET","server_get_location_info.php?la="+parseFloat(hitTestResult.getLatitude())+"&lo="+parseFloat(hitTestResult.getLongitude()),true);
		xmlhttp_getLocationInfo.send();
		
		}
		
}

function makePlacemark(lat,lng) {
	  
	  var pm = ge.createPlacemark('');
	  
      // Create style map for placemark
      var icon = ge.createIcon('');
	  icon.setHref('http://maps.google.com/mapfiles/kml/paddle/red-circle.png');
      var style = ge.createStyle('');
      style.getIconStyle().setIcon(icon);
	  if (priority == 0){
	  style.getIconStyle().setScale(0.0);
	  } else if (priority == 1){
	  style.getIconStyle().setScale(4.0);
	  } else if (priority == 2){
	  style.getIconStyle().setScale(3.0);
	  } else if (priority == 3){
	  style.getIconStyle().setScale(2.0);
	  } else if (priority == 4){
	  style.getIconStyle().setScale(1.6);
	  } else if (priority == 5){
	  style.getIconStyle().setScale(1.3);
	  } else {
	  style.getIconStyle().setScale(1.1);
	  }
      pm.setStyleSelector(style);
    
      // Create point
      //var la = ge.getView().copyAsLookAt(ge.ALTITUDE_RELATIVE_TO_GROUND);
      var point = ge.createPoint('');
      point.setLatitude(lat);
      point.setLongitude(lng);
      pm.setGeometry(point);

	return pm;
}

function turnAddPlacemarkSwitch(){

	if(addPlacemarkSwitch){
	addPlacemarkSwitch = false;
	document.getElementById('addPlacemarkSwitchButton').value = "Turn On";
	if (addPlacemark){
			ge.getFeatures().removeChild(addPlacemark);
			ge.setBalloon(null);
	}
	} else {
	addPlacemarkSwitch = true;
	document.getElementById('addPlacemarkSwitchButton').value = "Turn Off";
	if (addPlacemark){
			ge.getFeatures().removeChild(addPlacemark);
			ge.setBalloon(null);
	}
	}

}

function getLocationInfo(la,lo){
	
	var location = "";
	if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp_getLocationInfo=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
		xmlhttp_getLocationInfo=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp_getLocationInfo.onreadystatechange=function()
		{
		if (xmlhttp_getLocationInfo.readyState==4 && xmlhttp_getLocationInfo.status==200)
			{
				location = "Can not find location."
				location = xmlhttp_getLocationInfo.responseText;
			}
		}
		xmlhttp_getLocationInfo.open("GET","server_get_location_info.php?la="+la+"&lo="+lo,true);
		xmlhttp_getLocationInfo.send();
	
	return location;

}



