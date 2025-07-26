<?php
    session_start(
        ['name' => 'ITM']
    );

    require_once "../config/App.php";

    if (isset($_POST['search_user'])){
        // var_dump("putos");

        $url_data = [
            'users' => 'user-search'
        ]

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
    }else{    
        session_unset();
        session_destroy();
        header('Location: '.serverUrl."login/");
        exit();
    }
    