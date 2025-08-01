<?php
    /* Inicia Video 45 */
    session_start(
        ['name' => 'ITM']
    );

    require_once "../config/App.php";

    if (isset($_POST['search_object']) || isset($_POST['delete_search'])){
        // var_dump("putos");

        $url_data = [
            'users' => 'user-search',
            'items' => 'item-search',
            'clients' => 'client-search',
            'loan' => 'loan-search'
        ];

        if (isset($_POST['modulo'])){
            $modulo = $_POST['modulo'];
            if (!isset($url_data[$modulo])){
                $alerta = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"¡Ha ocurrido un error de busqueda!",
                    "Type"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
        }else{
            $alerta = [
                "Alerta"=>"simple",
                "Title"=>"Ocurrio un error inesperado",
                "Text"=>"¡No existe el modulo que estas ingresando!",
                "Type"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }
        /*video 46*/
        if ($modulo == "loan"){
            $date_start = "date_start_".$modulo;       
            $date_end = "date_and_".$modulo;

            if (isset($_POST['search_initial_loan']) || isset($_POST['search_final_loan'])){
                $date_init = $_POST['search_initial_loan'];
                $date_final = $_POST['search_final_loan'];
                if ($date_init == "" || $date_final == ""){
                    $alerta = [
                        "Alerta"=>"simple",
                        "Title"=>"Ocurrio un error inesperado",
                        "Text"=>"¡No has completado el campo de fechas!",
                        "Type"=>"error"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
                $_SESSION[$date_start] = $date_init;
                $_SESSION[$date_end] = $date_final;
            }

            if (isset($_POST['delete_search_loan'])){
                session_unset($_SESSION[$date_start]);
                session_unset($_SESSION[$date_end] );
            }
        }else{
            $variable_modulo = "search_".$modulo;
            if (isset($_POST['search_object'])){
                if ($_POST['search_object'] == ""){
                    $alerta = [
                        "Alerta"=>"simple",
                        "Title"=>"Ocurrio un error inesperado",
                        "Text"=>"¡No llenaste el campo de busqueda!",
                        "Type"=>"error"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
                $_SESSION[$variable_modulo] = $_POST['search_object'];
            }
            
            if (isset($_POST['delete_search'])){
                unset($_SESSION[$variable_modulo]);
            }
          
         
        }

        $url = $url_data[$modulo];
        $alerta = [
            "Alerta"=>"redireccionar",
            "URL"=> serverUrl.$url."/"
            
        ];
        echo json_encode($alerta);
        /*fin video 46 */

    }else{    
        session_unset();
        session_destroy();
        header('Location: '.serverUrl."login/");
        exit();
    }
    /* Finaliza Video 45 */
    