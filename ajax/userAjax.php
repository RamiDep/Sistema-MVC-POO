<?php

    $ajaxRequest = true;
    require_once "../config/App.php";

    
    if(isset($_POST["user_dni_add"])){
         //----------------INSTANCIA AL CONTROLADOR 
       // echo "Hola";
        require_once "../controllers/userController.php";

        $objUserController = new UserController();

    //AGREGAR UN USUARIO 
        if(isset($_POST["user_dni_add"]) && isset($_POST["user_name_add"])){ //Formulario agregar ususario
            echo $objUserController->add_user_controller();
        }

    }else{
        session_start(["name" => 'Error']);
        session_unset();
        session_destroy();
        header('Location: '.serverUrl."login/");
        exit();
    }