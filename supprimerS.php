<?php
/** Importation de l'autoloader **/

require 'Autoloader.php';
$autoload = new Autoloader;
$autoload->register();

include 'connData.php';

$id = $_GET['id'];
echo $id;
$sm = new SignalementManager($bdd);
$sm->delete($id);
header("Location: monCompteBis.php");
 ?>
