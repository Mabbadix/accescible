<?php
include 'SignalementManager.php';
include 'Signalement.php';
include 'connData.php';
    $id = $_GET['id'];
    $sm = new SignalementManager($bdd);
    $soutien = 32;
    $sm->updateSignalement($soutien, $id);


?>