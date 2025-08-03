<?php
    if($ajaxRequest){
        require_once "../models/userModel.php";
    }else{
        require_once "./models/userModel.php";
    }

    class ClientController extends MainModel{

        public function add_client_controller(){
            /*Video 50 */
            $dni = MainModel :: clearString($_POST['client_dni_add']);
            $name = MainModel :: clearString($_POST['client_name_add']);
            $last_name = MainModel :: clearString($_POST['client_lastname_add']);
            $telefone_number = MainModel :: clearString($_POST['client_phone_add']);
            $adress = MainModel :: clearString($_POST['client_adress_add']);

            if ($dni == "" || $name == "" || $last_name == "" || $telefone_number == "" $adress == ""){
                $alerta = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"No llenaste todos los campos (Obligatorios)",
                    "Type"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(MainModel :: checkData("[0-9-]{1,27}", $dni)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"Formato incorrecto en el campo DNI",
                    "Type"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            if(MainModel :: checkData("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,40}", $name)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"Formato incorrecto en el campo Nombre",
                    "Type"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            if(MainModel :: checkData("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,40}", $last_name)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"Formato incorrecto en el campo apellido",
                    "Type"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            if(MainModel :: checkData("[0-9()+]{8,20}", $telefone_number)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"Formato incorrecto en el campo telefono",
                    "Type"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            if(MainModel :: checkData("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,150}", $adress)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"Formato incorrecto en el campo direccion",
                    "Type"=>"error"
                ];
                echo json_encode($alerta);
                exit();   
            }

            /*fin video 50 */
        }

    }