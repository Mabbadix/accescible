<?php
/** Importation de l'autoloader **/

require 'class/Autoloader.php';
$autoload = new Autoloader;
$autoload->register();

include 'connData.php';

$id = $_GET['id'];
echo $id;
$sm = new SignalementManager($bdd);
$si = $sm->getSignal($id);
print_r($si);
$nbsoutiens = $si->getNSoutienS();
$soutien = $nbsoutiens + 1;
$sm->updateSignalement($soutien, $id);

?>
