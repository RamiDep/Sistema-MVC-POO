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
            if(empty($privile))
                $privile = 0;

            // print_r($dni, $name, $last_name, $password, $passwordCheck);

            if ($dni == "" || $name == "" || $last_name == "" || $password == "" || $passwordCheck == ""){
                $alerta = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"No llenaste todos los campos (Obligatorios)",
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
                    "Text"=>"Formato incorrecto en el campo nombre",
                    "Type"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            if (MainModel::checkData("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}", $last_name)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"Formato incorrecto en el campo apellido",
                    "Type"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            if (MainModel::checkData("[0-9\-]{1,10}", $telefone_number)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"Formato incorrecto en el campo telefono",
                    "Type"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            if (MainModel::checkData("^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s,.\-#\/]{1,190}$", $adress)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"Formato incorrecto en el campo direccion",
                    "Type"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            if (MainModel::checkData("[a-zA-Z0-9]{1,35}", $user)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"Formato incorrecto en el campo usuario",
                    "Type"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            
            if (MainModel::checkData("[a-zA-Z0-9$@.\-]{7,100}", $password) || MainModel::checkData("[a-zA-Z0-9$@.\-]{7,100}", $passwordCheck)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"Formato incorrecto en el campo contraseña",
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

            if($password != $passwordCheck){
                $alerta = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"¡Las contraseñas no son iguales!",
                    "Type"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }else{
                $password = MainModel :: encryption($password);
            }

            if($privile < 1 || $privile >3){
                $alerta = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"¡El privilegio no es valido!",
                    "Type"=>"error"
                ];
                echo json_encode($alerta);
                exit();   
            }

            $dataUser = [
                "DNI" => $dni,
                "Nombre" => $name,
                "Apellido" => $last_name,
                "Telefono" => $telefone_number,
                "Direccion" => $adress,
                "Email" => $email,
                "Usuario" => $user,
                "Clave" => $password,
                "Estado" => "Activa",
                "Privilegio" => $privile
            ];

            $addUser = UserModel :: add_user_model($dataUser);

            if($addUser->rowCount() == 1){
                $alerta = [
                    "Alerta"=>"limpiar",
                    "Title"=>"Usuario registrado",
                    "Text"=>"Los datos han sido guardados",
                    "Type"=>"success"
                ];
                echo json_encode($alerta);
            }else{
                $alerta = [
                    "Alerta"=>"simple",
                    "Title"=>"Usuario  No registrado",
                    "Text"=>"Ocurrio un error al guardar los datos",
                    "Type"=>"error"
                ];
                echo json_encode($alerta);
            }


            
        }

        public function pager_controller($page, $record, $privile, $id, $url, $search){

            
            $page = mainModel :: clearString($page);
            $record = mainModel :: clearString($record);
            $privile = mainModel :: clearString($privile);
            $id = mainModel :: clearString($id);
            $url = mainModel :: clearString($url);
            $search = mainModel :: clearString($search);

            $url = serverUrl . $url."/";

            $table = "";

            $page = (isset($page) && $page > 0) ? (int) $page : 1;
            $index = (isset($page) && $page > 0) ? (($page * $record) - $record)  : 0;


            if(isset($search) && $search != ""){
                $querySearch ="SELECT SQL_CALC_FOUND_ROWS * FROM usuario 
                  WHERE ((usuario_id != '$id' AND usuario_id != '1')
                   AND (usuario_dni LIKE '%$search%' 
                    OR usuario_nombre LIKE '%$search%' 
                    OR usuario_apellido LIKE '%$search%'
                    OR usuario_telefono LIKE '%$search%'
                    OR usuario_email LIKE '%$search%'
                    OR usuario_usuario LIKE '%$search%'))
                  ORDER BY usuario_nombre ASC LIMIT $index, $record    
                ";
            }else{
                $querySearch ="SELECT SQL_CALC_FOUND_ROWS * FROM usuario 
                  WHERE usuario_id != '$id' AND usuario_id != '1'
                  ORDER BY usuario_nombre ASC LIMIT $index, $record 
                  ";
            }

            $connect = mainModel :: connection();

            $data = $connect -> query($querySearch);
            $data = $data -> fetchAll();

            $total = $connect -> query("SELECT FOUND_ROWS()");
            $total = (int)$total->fetchColumn();

            $pagesTotal = ceil($total/$record);

            $table .= ' 
                <div class="table-responsive">
                    <table class="table table-dark table-sm">
                        <thead>
                            <tr class="text-center roboto-medium">
                                <th>#</th>
                                <th>DNI</th>
                                <th>NOMBRE</th>
                                <th>APELLIDO</th>
                                <th>TELÉFONO</th>
                                <th>DIRECCION</th>
                                <th>USUARIO</th>
                                <th>EMAIL</th>
                                <th>ACTUALIZAR</th>
                                <th>ELIMINAR</th>
                            </tr>
                        </thead>
                        <tbody>
                ';
            if($total >= 1 && $page <= $pagesTotal){
                $count = $index+1;
                foreach($data as $row){
                    $table .= '
                        <tr class="text-center" >
                            <td>'.$count.'</td>
                            <td>'.$row['usuario_dni'].'</td>
                            <td>'.$row['usuario_nombre'].'</td>
                            <td>'.$row['usuario_apellido'].'</td>
                            <td>'.$row['usuario_telefono'].'</td>
                            <td>'.$row['usuario_direccion'].'</td>
                            <td>'.$row['usuario_usuario'].'</td>
                            <td>'.$row['usuario_email'].'</td>
                            
                            <td>
                                <a href="<?= serverUrl ?>user-update/" class="btn btn-success">
                                    <i class="fas fa-sync-alt"></i>	
                                </a>
                            </td>
                            <td>
                                <form action="">
                                    <button type="button" class="btn btn-warning">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>';
                        $count++;
                }
            }else{
                if($total >= 1){
                    $table .= ' <tr class="text-center">
                                    <td colspan="9"><a href="'.$url.'">Haga clic para recargar listado</a></td>
                                </tr>';
                }else{
                    $table .= ' <tr class="text-center">
                                    <td colspan="9">No hay registros en el sistema</td>
                                </tr>';
                }
    
            
            }
            $table .= '</tbody></table></div>';

            if($total >= 1 && $page <= $pagesTotal){
                $table .= mainModel ::  doTable($page, $pagesTotal, $url, 7);
            }

            return $table;

        } // final controller
    }