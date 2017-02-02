<?php
/*
*Autoloader Perso servant a importer dynamiquement les classe
*ce fichier a besoin d'etre appelé a l'aide d'un require ou d'une iclude
*/
class Autoloader{
/*
*Fonction a appelé a chaque page html elle permettra d'apeller nos classe dynamiquement a l'aide de la fonction suivante
*/
public static function register(){
    spl_autoload_register(array(__CLASS__, 'autoload'));
  }
/*
*$var string
*cet fonction est appelé par la fonction ci dessus
*/
public static function autoload($class_name){
    require 'class/'.$class_name.'.php';
  }
}
?>