<?php
include 'SignalementManager.php';
include 'Signalement.php';
include 'connData.php';
    $id = $_GET['id'];
    echo $id;
    $sm = new SignalementManager($bdd);
    $si = $sm->getSignal($id);
    $nbsoutiens = $si->getNSoutienS();
    $soutien = $nbsoutiens + 1;
    $sm->updateSignalement($soutien, $id);

    $lat = $sm->getLat();
    $lng = $sm_>getLng();

?>
<script async defer type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTFqUmefn5-fJ2E20dOfyH-0-jVbZx5Lc"></script>
<script>
// Geolocation + Marker
//Récuperation de la Div "mapcanvas" du html
var mapcanvas = document.getElementById("mapcanvas");
var x = document.getElementById("mapcanvas");//utilisée pour l'affichage des erreurs uniquement
//Geolocation sur map

var latlngUnique = new google.maps.LatLng(<?php echo $lat ?>, <?php echo $lng ?>);

var myOptions = {
zoom: 12
, center: latlngUnique
, mapTypeId: google.maps.MapTypeId.ROADMAP
};
// generation de la map
var map = new google.maps.Map(mapcanvas, myOptions);
//MAJ de la map en focntion des new Latlng
var majMap = map.panTo(new google.maps.LatLng(position.coords.latitude, position.coords.longitude));

marker = new google.maps.Marker({
    position: latlngUnique,
map: map,
icon: "img/maker.svg",
animation:google.maps.Animation.DROP,
    });
});
</script>
