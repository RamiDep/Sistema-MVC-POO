<?php 
    if ($ajaxRequest){
        require_once("../models/itemModel.php");
    }else{
        require_once("./models/itemModel.php");         
    }

    class ItemController extends MainModel{
        
    }