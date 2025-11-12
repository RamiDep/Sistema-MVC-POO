<?php

    $ajaxRequest = true;
    require_once "../config/App.php";

    
    if(isset($_POST["add_item"])){
        //----------------INSTANCIA AL CONTROLADOR 
    
        require_once "../controllers/itemController.php";
        $objItemController = new ItemController();

    //AGREGAR UN ITEM
        if(isset($_POST["add_item"])){
            echo $objItemController->add_item_controller();
        }

    }else{
        session_start(["name" => 'Error']);
        session_unset();
        session_destroy();
        header('Location: '.serverUrl."login/");
        exit();
    }