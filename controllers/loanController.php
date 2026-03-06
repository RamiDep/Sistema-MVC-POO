<?php 
    if ($ajaxRequest){
        require_once("../models/loanModel.php");
    }else{
        require_once("./models/loanModel.php");         
    }

    class LoanController extends LoanModel {

    }