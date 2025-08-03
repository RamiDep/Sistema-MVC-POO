<?php
    if($ajaxRequest){
        require_once "../models/userModel.php";
    }else{
        require_once "./models/userModel.php";
    }

    class ClientController extends MainModel{

        public function add_client_controller(){

        }

    }