<?php
    if($ajaxRequest){
        require_once "../models/loginModel.php";
    }else{
        require_once "./models/loginModel.php";
    }

    class LoginController extends LoginModel{
        
        /*--------------CONTROLLADOR PARA LOGIN-------- */

        public function session_start_controller($datos){
         
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
                        confirmButtonText: 'Aceptar'
                    });
                </script>
                ';
            }

            if (MainModel::checkData("[a-zA-Z0-9]{1,35}", $userName)){
                echo '
                <script>
                    Swal.fire({
                        title: "Ocurrió un error inesperado",
                        text: "El formato del campo USUARIO no es correcto",
                        type: "error",
                        confirmButtonText: 'Aceptar'
                    });
                </script>
                ';
            }

            if (MainModel::checkData("[a-zA-Z0-9$@.-]{7,100}", $password)){
                echo '
                <script>
                    Swal.fire({
                        title: "Ocurrió un error inesperado",
                        text: "El formato del campo CONTRASEÑA no es correcto",
                        type: "error",
                        confirmButtonText: 'Aceptar'
                    });
                </script>
                ';
            }

            $password = MainModel :: encryption($password);

            $data_logIn = [
                "user" => $userName,
                "password" => $password
            ];

            


        }

        
    }