<?php
session_start();

/** Importation de l'autoloader **/

require 'Autoloader.php';
$autoload = new Autoloader;
$autoload->register();

require'connData.php';
$manageU = new UtilisateurManager($bdd);
$mail = $_SESSION['emailU'];
$mdp = $_SESSION['mdpU'];
$nom = $_POST['nomU'];
$prenom = $_POST['prenomU'];
$adresse = $_POST['adresseU'];
$ville = $_POST['villeU'];
$cp = $_POST['cpU'];
$tel = $_POST['telU'];
print_r($_SESSION);
echo'ok';
$manageU->updateUtilisateur($mail, $nom, $prenom, $adresse, $ville, $cp, $tel);
<<<<<<< HEAD
header("Location: monCompteBis.php");
?>
