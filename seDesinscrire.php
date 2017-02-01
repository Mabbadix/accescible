<?php
/** Importation de l'autoloader **/

require 'Autoloader.php';
$autoload = new Autoloader;
$autoload->register();

include 'connData.php';

$emailU = $_GET['emailU'];
$sm = new UtilisateurManager($bdd);
$sm->delete($emailU);
include( 'deconn.php');

?>

<?php
/** Importation de l'autoloader **/

/*require 'Autoloader.php';
$autoload = new Autoloader;
$autoload->register();

include 'connData.php';

$emailU = $_GET['email'];
echo $emailU;
$su = new UtilisateurManager($bdd);
$su->delete($emailU);
echo "<script language='JavaScript' type='text/javascript'>";
echo 'alert("Aucun compte ne correspond à ces données ! Inscrivez-vous ou verifiez votre saise. Merci");';
echo 'history.back(-1)';
echo '</script>';*/
?>
