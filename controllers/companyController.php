<?php 
    if ($ajaxRequest){
        require_once("../models/companyModel.php");
    }else{
        require_once("./models/companyModel.php");         
    }

    class CompanyController extends CompanyModel{
        public function select_company_controller(){
            return CompanyModel :: select_company_model(); 
        }

        public function add_company_controller(){
            
            $name_company = MainModel :: clearString($_POST['company_name']);
            $email_company = MainModel :: clearString($_POST['company_email']);
            $phone_company = MainModel :: clearString($_POST['company_telefono']);
            $adress_company = MainModel :: clearString($_POST['company_adress']);

            if (empty($name_company) || empty($email_company) || empty($phone_company) || empty($adress_company)){
                $alert = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"No llenaste todos los campos (Obligatorios)",
                    "Type"=>"error"
                ];
                echo json_encode($alert);
                exit();
            }

            if (MainModel :: checkData("[a-zA-z0-9áéíóúÁÉÍÓÚñÑ. ]{1,70}", $name_company)){
                $alert = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"El campo NOMBRE no contiene el formato solicitado.",
                    "Type"=>"error"
                ];
                echo json_encode($alert);
                exit();
            }

        }
    }