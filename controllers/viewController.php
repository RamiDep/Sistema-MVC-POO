<?php

    require_once("./models/viewModel.php");

    class ViewController extends ViewModel{

        /*----controlador para optener plantilla*/
        public function getTemplateController(){
            return require_once("./views/template.php");
        }
        
        /*----controlador para optener viatas*/ 
        public function getViewsController(){
            if(isset($_GET['views'])){
                $route = explode("/", $_GET['views']);
                //var_dump($route);
                $response = viewModel :: getViewModel($route[0]);
            }else{
                $response = "login";
            }
            //echo $response;
            return $response;
        }    

    }