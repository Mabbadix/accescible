<?php
require 'connData.php';
/*fonction qui recherche toute seule la classe à require*/
function chargerClass($classe)
{
  require $classe.'.php';
}
spl_autoload_register('chargerClass');
$Courriel = 'yyy'/*htmlspecialchars($_POST['Courriel'])*/;
$Mdp = "hy"/*sha1($_POST['Mot_de_passe'])*/;

/*on crée un Objet utilisateur, qu'on hydrate ac les données récupérées*/
$utilisateur = new Utilisateur ([
  'emailU'=>$Courriel,
  'mdpU'=>$Mdp,
  'nomU'=>'Nom',
  'prenomU'=>'Prenom',
  'adresseU'=>'adresse',
  'villeU'=>'ville',
  'cpU'=>'00000',
  'telU'=>'0606060606',
  'dateU'=>'1',
  'signalU'=>'1',
  'valide'=>'0'
]);
/*on crée un objet pour manager utilisateur pour gerer l'utilisateur et BDD*/
$manageU = new UtilisateurManager ($bdd);
/*on appelle la fonction ajout avec en param l'objet utilisateur*/
$manageU->add($utilisateur);

/*$insertInscription = $this->_db->prepare("INSERT INTO utilisateurs (emailU, mdpU)
VALUES (:emailU, :mdpU)");

$insertInscription->bindValue(':emailU', $ut->getEmailU(), PDO::PARAM_STR);
$insertInscription->bindValue(':mdpU', $ut->getMdpU());
    print_r($insertInscription->execute());
//Si il y a une erreur
if (!$insertInscription) {
    print($insertInscription->errorInfo());
  }*/

?>
