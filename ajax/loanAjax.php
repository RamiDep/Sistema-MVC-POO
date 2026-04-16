<?php

    $ajaxRequest = true;
    require_once "../config/App.php";
    //video 84
    if(isset($_POST["search_client"]) || isset($_POST["id_client_loan"]) || isset($_POST['id_delete_session']) 
        || isset($_POST['search_item'])){
        require_once "../controllers/loanController.php";
        $objLoanController = new LoanController();
        
        if(isset($_POST["search_client"])){
            echo $objLoanController->search_client_loan_controller(); 
        }
        
        if(isset($_POST["id_client_loan"])){
            echo $objLoanController->add_client_loan_controller(); 
        }

        if(isset($_POST["id_delete_session"])){
            echo $objLoanController->destroy_session_client_controller(); 
        }

        if(isset($_POST["search_item"])){
            echo $objLoanController->search_item_loan_controller(); 
        }


    }else{
        session_start(["name" => 'Error']);
        session_unset();
        session_destroy();
        header('Location: '.serverUrl."login/");
        exit();
    }