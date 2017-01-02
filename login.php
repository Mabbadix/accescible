<?php
if (isset($_POST['login-form'])) {
    $mailconnect = htmlspecialchars($_POST['login-mail']);
    $mdpconnect = sha1($_POST['login-pass']);
    if (!empty($mailconnect) && !empty($mdpconnect)) {
        $requser = $bdd->prepare('SELECT * FROM user WHERE mail = ? AND pwd = ?');
        $requser->execute(array($mailconnect, $mdpconnect));
        $userexist = $requser->rowCount();
        if ($userexist == 1) {
            $userinfo = $requser->fetch();
            $_SESSION['id'] = $userinfo['id'];
            $_SESSION['pseudo'] = $userinfo['pseudo'];
            $_SESSION['mail'] = $userinfo['mail'];
            $_SESSION['isAdmin'] = $userinfo['isAdmin'];
            header('Location: accueil.php');
        } else {
            $erreur = 'Mauvais mail ou mot de passe !';
        }
    } else {
        $erreur = 'Tous les champs doivent être complétés !';
    }
}
