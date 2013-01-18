<?php

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action']) && $_GET['action'] == 'doLogout') {

    include_once 'connection.php';
    include_once 'vo/User.php';
    include_once 'SessionStorage.php';
    include_once 'includes/Login.php';
    
    $l = new Login($conn);
    $u = new User;
    $l->setUser($u);
    $l->setOperation(Login::OUT);
    $ss = new SessionStorage();
    $l->attach($ss);
    $l->setData($_POST);
    $l->notify();
}
?>
