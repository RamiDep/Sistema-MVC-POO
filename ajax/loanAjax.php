<?php

    $ajaxRequest = true;
    require_once "../config/App.php";
    
    if(isset($_POST["add_loan"]) ){
       

    

    }else{
        session_start(["name" => 'Error']);
        session_unset();
        session_destroy();
        header('Location: '.serverUrl."login/");
        exit();
    }