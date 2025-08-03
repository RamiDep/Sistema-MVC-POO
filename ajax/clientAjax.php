<?php
    $ajaxRequest = true;
    require_once "../config/App.php";
    
    if(isset($_POST['client_dni_add']) && isset($_POST['client_name_add'])){
        require_once("../controllers/clientController.php");
        $object_client = new ClientController();

        if (isset($_POST['client_dni_add']) && isset($_POST['client_name_add'])){
            echo $object_client -> add_client_controller();
        }

    }else{
        session_start(["name" => 'Error']);
        session_unset();
        session_destroy();
        header('Location: '.serverUrl."login/");
        exit();
    }