<?php
    if($ajaxRequest){
        require_once "../models/loginModel.php";
    }else{
        require_once "./models/loginModel.php";
    }

    class LoginController extends LoginModel{
        
        /*--------------CONTROLLADOR PARA LOGIN-------- */

        public function session_start_controller(){
         
            $userName = MainModel :: clearString($_POST['userName']) ;
            $password = MainModel :: clearString($_POST['userPassword']) ;

            /**
             * Validar que no este vacio
            */

            if($userName == "" || $password == ""){
                echo '
                <script>
                    Swal.fire({
                        title: "Ocurrió un error inesperado",
                        text: "No has llenado todos los campos requeridos",
                        type: "error",
                        confirmButtonText: "Aceptar"
                    });
                </script>
                ';
                exit();
            }

            if (MainModel::checkData("[a-zA-Z0-9]{1,35}", $userName)){
                echo '
                <script>
                    Swal.fire({
                        title: "Ocurrió un error inesperado",
                        text: "El formato del campo USUARIO no es correcto",
                        type: "error",
                        confirmButtonText: "Aceptar"
                    });
                </script>
                ';
                exit();
            }

            if (MainModel::checkData("[a-zA-Z0-9$@.\-]{7,100}", $password)){
                echo '
                <script>
                    Swal.fire({
                        title: "Ocurrió un error inesperado",
                        text: "El formato del campo CONTRASEÑA no es correcto",
                        type: "error",
                        confirmButtonText: "Aceptar"
                    });
                </script>
                ';
                exit();
            }

            $password = MainModel :: encryption($password);

            $data_logIn = [
                "user" => $userName,
                "password" => $password,
                "status" => 'Activa'
            ];

            $data_logIn = loginModel :: session_start_model($data_logIn);

            if($data_logIn->rowCount() == 1){
                $row = $data_logIn->fetch();
                session_start(['name'=>'ITM']);
                $_SESSION['id_itm'] = $row['usuario_id'];
                $_SESSION['name_itm'] = $row['usuario_nombre'];
                $_SESSION['lastName_itm'] = $row['usuario_apellido'];
                $_SESSION['user_itm'] = $row['usuario_usuario'];
                $_SESSION['privile_itm'] = $row['usuario_privilegio'];
                $_SESSION['token_itm'] = md5(uniqid(mt_rand(), true));

                return header("Location: ". serverUrl."home/" );
            }else
            {
                echo '
                <script>
                    Swal.fire({
                        title: "Ocurrió un error inesperado",
                        text: "Alguno de los campos no es correcto",
                        type: "error",
                        confirmButtonText: "Aceptar"
                    });
                </script>
                ';    
            }
            


        }

        /*--------------CONTROLLADOR PARA FINALIZAR SESIONES-------- */
        public function closet_session(){
            session_unset();
            session_destroy();
            if (headers_sent()){
                return "<script> windows.location.href='".serverUrl."login/'; </script>";
            }else{
                return header("Location: ".serverUrl."login/");
            }
        }

        public function close_session_button(){
            session_start(['name'=>'ITM']);
            $token = mainModel :: decryption($_POST['token']);
            $user = mainModel :: decryption($_POST['user']);

            if($user == $_SESSION['user_itm'] && $token == $_SESSION['token_itm']){
                session_unset();
                session_destroy();
                $alert = [
                    "Alerta" => "redireccionar",
                    "URL" => serverUrl."login/"
                ];
            }else{
                $alert = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"No se pudo cerrar la session en el sistema",
                    "Type"=>"error"
                ];
            }
            echo json_encode($alert);

        }

        
    }