


function ClicBouton(){
  var mapcanvas = document.getElementById("mapcanvas");

  function showPosition(position) {
    var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

    var myOptions = {
      zoom: 15,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
  var map = new google.maps.Map(mapcanvas, myOptions);
  var majMap = map.panTo(new google.maps.LatLng(position.coords.latitude, position.coords.longitude));
  var marker = new google.maps.Marker({
      position: latlng,
      map: map,
      draggable:true,
      icon: "img/maker.svg",
      animation:google.maps.Animation.BOUNCE,
      title:"Vous êtes ici ! (à +/- "+position.coords.accuracy+" mètres à la ronde)"

    });
  google.maps.event.addListener(marker, 'click', function() {
  alert("Le marqueur a été cliqué.");//message d'alerte
  });
}
  function showError(error) {
    switch(error.code) {
        case error.PERMISSION_DENIED:
            x.innerHTML = "User denied the request for Geolocation."
            break;
        case error.POSITION_UNAVAILABLE:
            x.innerHTML = "Location information is unavailable."
            break;
        case error.TIMEOUT:
            x.innerHTML = "The request to get user location timed out."
            break;
        case error.UNKNOWN_ERROR:
            x.innerHTML = "An unknown error occurred."
            break;
    }
  }

  if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError);
    } else {
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}
