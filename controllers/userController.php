<?php

    if($ajaxRequest){
        require_once "../models/userModel.php";
    }else{
        require_once "./models/userModel.php";
    }

    class UserController extends UserModel{
         /*--------------CONTROLLADOR PARA AGREGAR USUARIOS-------- */

        /* La funcion es publica  y no es estatica por que es un controlador*/

        public function add_user_controller(){
            $dni = MainModel :: clearString($_POST['user_dni_add']);
            $name = MainModel :: clearString($_POST['user_name_add']);
            $last_name = MainModel :: clearString($_POST['usuario_apellido_reg']);
            $telefone_number = MainModel :: clearString($_POST['usuario_telefono_reg']);
            $adress = MainModel :: clearString($_POST['usuario_direccion_reg']);

            $user = mainModel :: clearString($_POST['usuario_usuario_reg']);
            $email = mainModel :: clearString($_POST['usuario_email_reg']);
            $password = mainModel :: clearString($_POST['usuario_clave_1_reg']);
            $passwordCheck = mainModel :: clearString($_POST['usuario_clave_2_reg']);

            $privile = MainModel :: clearString($_POST['usuario_privilegio_reg']);

            // print_r($dni, $name, $last_name, $password, $passwordCheck);

            if ($dni == "" || $name == "" || $last_name == "" || $password == "" || $passwordCheck == ""){
                $alerta = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"No llenaste todos los campos",
                    "Type"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            /**
             * Verificamos los fultros del formulario
             */

            if (MainModel::checkData("[0-9\-]{1,20}", $dni)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"Formato incorrecto en el campo DNI",
                    "Type"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            if (MainModel::checkData("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}", $name)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"Formato incorrecto en el algun campo",
                    "Type"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            if (MainModel::checkData("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}", $last_name)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"Formato incorrecto en algun campo",
                    "Type"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            if (MainModel::checkData("[0-9\-]{1,10}", $telefone_number)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"Formato incorrecto en algun campo",
                    "Type"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            if (MainModel::checkData("^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s,.\-#\/]{1,190}$", $adress)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"Formato incorrecto en algun campo",
                    "Type"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            if (MainModel::checkData("[a-zA-Z0-9]{1,35}", $user)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"Formato incorrecto en algun campo",
                    "Type"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            
            if (MainModel::checkData("[a-zA-Z0-9$@.\-]{7,100}", $password) || MainModel::checkData("[a-zA-Z0-9$@.\-]{7,100}", $passwordCheck)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"Formato incorrecto en algun campo",
                    "Type"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            $check_dni = MainModel :: setConsult("SELECT usuario_dni FROM `usuario` WHERE usuario_dni = '$dni'");
            if ($check_dni->rowCount()>0){
                $alerta = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"¡El DNI ingresado ya existe en el sistema!",
                    "Type"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            $check_user = MainModel :: setConsult("SELECT usuario_usuario FROM `usuario` WHERE usuario_usuario = '$user'");
            if ($check_user->rowCount()>0){
                $alerta = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"¡El usuario ingresado ya existe en el sistema!",
                    "Type"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

           
            if ($email != "")
            {
                if(filter_var($email, FILTER_VALIDATE_EMAIL))
                {
                    $check_email = MainModel :: setConsult("SELECT usuario_email FROM `usuario` WHERE usuario_email = '$email'");
                    if ($check_email->rowCount()>0){
                        $alerta = [
                            "Alerta"=>"simple",
                            "Title"=>"Ocurrio un error inesperado",
                            "Text"=>"¡El correo ingresado ya existe en el sistema!",
                            "Type"=>"error"
                        ];
                        echo json_encode($alerta);
                        exit();  
                    }  

                }else{
                    $alerta = [
                        "Alerta"=>"simple",
                        "Title"=>"Ocurrio un error inesperado",
                        "Text"=>"¡Debes poner un correo valido!",
                        "Type"=>"error"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
                
            }


            


            
        }
    }