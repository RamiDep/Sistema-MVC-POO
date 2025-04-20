<?php
    class ViewModel
    {

        protected static function getViewModel($view){
            $listWithe = ["home","client-list","client-new","client-search","client-update","company",
                "item-search","item-update","item-new","item-list","reservation-list","reservation-new",
                "reservation-pending","reservation-reservation","reservation-search","reservation-update",
                "user-search","user-update","user-new","user-list"
            ];
            if (in_array($view, $listWithe))
            {
                if (is_file ("./views/content/".$view."-view.php")){
                    $contend = "./views/content/".$view."-view.php";
                }  
                else{ $contend = "404";}     
            }elseif($view == "index" || $view == "login")
            {
                $contend = "login";
            }else{
                 $contend = "404";
            }
              
            return $contend;    
        }
    } 