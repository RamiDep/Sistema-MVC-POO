<?php
    $ajaxRequest = true;
    require_once "../config/App.php";
    
    if(isset($_POST['client_dni_add']) || isset($_POST['client_name_add']) || isset($_POST['id_client_delete'])){
        require_once("../controllers/clientController.php");
        $object_client = new ClientController();

        if (isset($_POST['client_dni_add']) && isset($_POST['client_name_add'])){
            echo $object_client -> add_client_controller();
        }

        /*Video 55: Eliminar cliente*/
        if (isset($_POST['id_client_delete'])){
            echo $object_client -> delete_client_controller();
        }
        /*Video 55: Eliminar cliente*/

    }else{
        session_start(["name" => 'Error']);
        session_unset();
        session_destroy();
        header('Location: '.serverUrl."login/");
        exit();
    }