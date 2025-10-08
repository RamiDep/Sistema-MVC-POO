<?php
    $ajaxRequest = true;
    require_once "../config/App.php";
    if (isset($_POST['add_company'])){
        if(isset($_POST["add_company"])){ //Formulario agregar empresa
            require_once "../controllers/companyController.php";
            $objCompanyController = new CompanyController();
            echo $objCompanyController->add_company_controller();
        }
    }else{
        session_start(["name" => 'Error']);
        session_unset();
        session_destroy();
        header('Location: '.serverUrl."login/");
        exit();
    }