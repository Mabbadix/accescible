<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">


    <head>

        <title>Tutoriel Google Maps</title>

        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

        <!-- Elément Google Maps indiquant que la carte doit être affiché en plein écran et

        qu'elle ne peut pas être redimensionnée par l'utilisateur -->

        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />

        <!-- Inclusion de l'API Google MAPS -->

        <!-- Le paramètre "sensor" indique si cette application utilise détecteur pour déterminer la position de l'utilisateur -->

        <script type="text/javascript"src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTFqUmefn5-fJ2E20dOfyH-0-jVbZx5Lc"></script>

        <script type="text/javascript">

        function initialiser() {

    var latlng = new google.maps.LatLng(46.779231, 6.659431);



    var options = {

        center: latlng,

        zoom: 19,

        mapTypeId: google.maps.MapTypeId.ROADMAP

    };



    var carte = new google.maps.Map(document.getElementById("carte"), options);



    /****************Nouveau code****************/


    //redéfinition du centre de la carte

    carte.setCenter(new google.maps.LatLng(46.779872043155, 6.6497500934796));

    //redéfinition du zoom

    carte.setZoom(15);



    //chemin du tracé

    var parcoursBus = [

        new google.maps.LatLng(46.781367900048, 6.6401992834884),

        new google.maps.LatLng(46.780821285011, 6.6416348016222),

        new google.maps.LatLng(46.780496546047, 6.6421830461926),

        new google.maps.LatLng(46.779835306991, 6.6426765713417),

        new google.maps.LatLng(46.777748677169, 6.6518819126808),

        new google.maps.LatLng(46.778027878803, 6.6541349682533),

        new google.maps.LatLng(46.778484884759, 6.6557324922045),

        new google.maps.LatLng(46.778752327087, 6.6573654211838),

        new google.maps.LatLng(46.778605381016, 6.6588674582321)

    ];



    var traceParcoursBus = new google.maps.Polyline({

        path: parcoursBus,//chemin du tracé

        strokeColor: "#FF0000",//couleur du tracé

        strokeOpacity: 1.0,//opacité du tracé

        strokeWeight: 2//grosseur du tracé

    });



    //lier le tracé à la carte

    //ceci permet au tracé d'être affiché sur la carte

    traceParcoursBus.setMap(carte);


    /********************************************/

}
        </script>

    </head>


    <body onload="initialiser()">

        <div id="carte" style="width:100%; height:100%"></div>

    </body>

</html>
