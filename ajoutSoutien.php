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


?>