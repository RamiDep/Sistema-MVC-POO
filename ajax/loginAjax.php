<?php
        
    $ajaxRequest = true;
    require_once "../config/App.php";


    if(){     
  
    }else{
        session_start(["name" => 'Error']);
        session_unset();
        session_destroy();
        header('Location: '.serverUrl."login/");
        exit();
    }