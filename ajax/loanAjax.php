<?php

    $ajaxRequest = true;
    require_once "../config/App.php";
    //video 84
    if(isset($_POST["search_client"]) || isset($_POST["id_client_reservation"]) ){
        require_once "../controllers/loanController.php";
        $objLoanController = new LoanController();
        
        if(isset($_POST["search_client"])){
            echo $objLoanController->search_client_loan_controller(); 
        }
        
        if(isset($_POST["id_client_loan"])){
            echo $objLoanController->search_client_loan_controller(); 
        }

    }else{
        session_start(["name" => 'Error']);
        session_unset();
        session_destroy();
        header('Location: '.serverUrl."login/");
        exit();
    }