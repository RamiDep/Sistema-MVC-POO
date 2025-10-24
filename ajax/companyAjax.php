<?php
    $ajaxRequest = true;
    require_once "../config/App.php";
    if (isset($_POST['add_company']) || isset($_POST['id_company_update'])){
        require_once "../controllers/companyController.php";
        $objCompanyController = new CompanyController();
        
        if(isset($_POST["add_company"])){ //Formulario agregar empresa
            echo $objCompanyController->add_company_controller();
        }

        if(isset($_POST["id_company_update"])){ //Formulario agregar empresa
            echo $objCompanyController->update_company_controller();
        }
    }else{
        session_start(["name" => 'Error']);
        session_unset();
        session_destroy();
        header('Location: '.serverUrl."login/");
        exit();
    }