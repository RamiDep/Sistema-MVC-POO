<?php
        
    $ajaxRequest = true;
    require_once "../config/App.php";


    if(isset($_POST['user']) && isset($_POST['token'])){     
        require_once "../controllers/loginController.php";
        $obj_close_sesion = new loginController();
        $obj_close_sesion->close_session_button();
    }else{
        session_start(["name" => 'Error']);
        session_unset();
        session_destroy();
        header('Location: '.serverUrl."login/");
        exit();
    }