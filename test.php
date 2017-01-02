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

        	//tableau contenant tous les marqueurs que nous créerons
        	var tabMarqueurs = new Array();

        	//notez la présence de l'argument "event" entre les parenthèses de "function()"
        	google.maps.event.addListener(carte, 'click', function(event) {
        		tabMarqueurs.push(new google.maps.Marker({
        			position: event.latLng,//coordonnée de la position du clic sur la carte
        			map: carte//la carte sur laquelle le marqueur doit être affiché
        		}));
        	});

        	/********************************************/
        }
        </script>

    </head>


    <body onload="initialiser()">

        <div id="carte" style="width:100%; height:100%"></div>

    </body>

</html>
