<?php

    if(ajaxRequest){
        require_once "../models/userModel.php";
    }else{
        require_once "./models/userModel.php"
    }

    class UserController extends UserModel{
         /*--------------CONTROLLADOR PARA AGREGAR USUARIOS-------- */

        /* La funcion es publica  y no es estatica por que es un controlador*/

        public function add_user_controller(){
            $dni = mainModel :: clearString($_POST['user_dni_add']);
            $name = mainModel :: clearString($_POST['user_name_add']);
            $last_name = mainModel :: clearString($_POST['usuario_apellido_reg']);
            $telefone_number = mainModel :: clearString($_POST['usuario_telefono']);
            $adress = mainModel :: clearString($_POST['usuario_direccion_reg']);

            $user = mainModel :: clearString($_POST['usuario_usuario_reg']);
            $email = mainModel :: clearString($_POST['usuario_email']);
            $password = mainModel :: clearString($_POST['usuario_clave_1']);
            $passwordCheck = mainModel :: clearString($_POST['usuario_clave_2']);

            $privile = mainModel :: clearString($_POST['usuario_privilegio_reg']);

            if ($dni == "" && $name == "" && $last_name == "" && $dnipassword == "" && $passwordCheck == ""){
                $alerta[
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"No llenaste todos los campos",
                    "Type"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            
        }
    }