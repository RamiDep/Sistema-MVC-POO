<?php 
    if ($ajaxRequest){
        require_once("../models/companyModel.php");
    }else{
        require_once("./models/companyModel.php");         
    }

    class CompanyCotroller extends CompanyModel{
        public function select_company_controller(){
            return CompanyModel :: select_company_model(); 
        }
    }