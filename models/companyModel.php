<?php
require_once("mainModel.php");

    class CompanyModel extends MainModel{
        
        protected function add_company_model($company_data){
            $insertCompany = MainModel :: connection()->prepare("INSERT INTO empresa
                (empresa_nombre, empresa_email, empresa_telefono, empresa_direccion)
                VALUES
                (:NAME_, :EMAIL, :PHONE, :ADRESS)");
            $insertCompany->bindParam(":NAME_", $company_data['name']);
            $insertCompany->bindParam(":EMAIL", $company_data['email']);
            $insertCompany->bindParam(":PHONE", $company_data['phone']);
            $insertCompany->bindParam(":ADRESS", $company_data['adress']);
            $insertCompany -> execute();
            
            return $insertCompany;
        }
        
        protected function select_company_model(){
            $company = MainModel :: connection()->prepare("SELECT * FROM empresa");
            $company -> execute();
            return $company;
        }
    }