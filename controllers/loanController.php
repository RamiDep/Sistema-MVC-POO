<?php 
    if ($ajaxRequest){
        require_once("../models/loanModel.php");
    }else{
        require_once("./models/loanModel.php");         
    }

    class LoanController extends LoanModel {
        
        public function search_client_loan_controller(){
            $search = MainModel :: clearString($_POST['search_client']);

            if(empty($search)){
                return '<div class="alert alert-warning" role="alert">
                            <p class="text-center mb-0">
                                <i class="fas fa-exclamation-triangle fa-2x"></i><br>
                                Debes introducir DNI, Nombre, Apellido o Telefono
                            </p>
                        </div>';
                exit();        
            }

            $check_client = MainModel :: setConsult("SELECT * FROM cliente WHERE 
                                cliente_dni LIKE '%$search%' OR
                                cliente_nombre LIKE '%$search%' OR
                                cliente_apellido LIKE '%$search%' OR                                
                                cliente_telefono LIKE '%$search%'
                                ORDER BY cliente_nombre ASC ");
            if($check_client -> rowCount() > 0){
                
                $data = $check_client ->fetchAll();

                $table = '<div class="table-responsive">
                            <table class="table table-hover table-bordered table-sm">
                                <tbody>';
                foreach($data as $client){
                    $table .= '<tr class="text-center">
                                    <td>'.$client['cliente_dni'].' - '.$client['cliente_nombre'].' - '.$client['cliente_apellido'].'</td>
                                    <td>
                                        <button type="button" class="btn btn-primary"><i class="fas fa-user-plus" onclick="modal_add_client_reservation('.$client['cliente_id'].')"></i></button>
                                    </td>
                                </tr>';
                }                
                $table .= '</tbody>
                        </table>
                    </div>';
                return $table;
            }else{
                 return '<div class="alert alert-warning" role="alert">
                            <p class="text-center mb-0">
                                <i class="fas fa-exclamation-triangle fa-2x"></i><br>
                                No hemos encontrado ningún cliente en el sistema que coincida con <strong>“'.$search.'”</strong>
                            </p>
                        </div>';
                exit();  
            }
        }

        public function add_client_loan_controller(){
            $id_client = MainModel :: clearString($_POST['id_client_loan']);
           
            $check_client = MainModel :: setConsult("SELECT * FROM cliente WHERE cliente_id = '$id_client'");
            
            if($check_client -> rowCount() < 1){
                $alert = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"No se ha encotrado el cliente con id: ".$id_client.", por favor intente nuevamente.",
                    "Type"=>"error"
                ];
                echo json_encode($alert);
                exit();
            }else
                $datos = $check_client->fetch();

            session_start(['name' => 'ITM']);
            if(empty($_SESSION['data_client'])){
                $_SESSION['data_client'] = [
                    "ID" => $datos['cliente_id'],
                    "DNI" => $datos['cliente_dni'],
                    "NAME" => $datos['cliente_nombre'],
                    "LASTNAME" => $datos['cliente_apellido']
                ];

                $alert = [
                    "Alerta"=>"recargar",
                    "Title"=>"Cliente agregado",
                    "Text"=>"Se agrego correctamente el cliente al prestamo",
                    "Type"=>"success"
                ];
                echo json_encode($alert);

            }else{
                $alert = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"No se ha encotrado el cliente",
                    "Type"=>"error"
                ];
                echo json_encode($alert);
            }
        }

        public function destroy_session_client_controller(){
            session_start(['name' => 'ITM']);
            unset($_SESSION['data_client']);
            if(empty($_SESSION['data_client'])){
                $alert = [
                    "Alerta"=>"recargar",
                    "Title"=>"Exito",
                    "Text"=>"Se elimino el cliente de manera correcta",
                    "Type"=>"success"
                ];                
            }else{
                $alert = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"No se ha podido eliminar el cliente de la session",
                    "Type"=>"error"
                ];
            }
            echo json_encode($alert);
        }

        public function search_item_loan_controller(){
            $search = MainModel :: clearString($_POST['search_item']);

            if(empty($search)){
                return '<div class="alert alert-warning" role="alert">
                            <p class="text-center mb-0">
                                <i class="fas fa-exclamation-triangle fa-2x"></i><br>
                                Debes introducir Código ó Nombre
                            </p>
                        </div>';
                exit();        
            }

            $check_item = MainModel :: setConsult("SELECT * FROM item WHERE 
                                (item_codigo LIKE '%$search%' OR
                                item_nombre LIKE '%$search%') AND
                                (item_estado = 1)
                                ORDER BY item_nombre ASC ");
            if($check_item -> rowCount() > 0){
                
                $data = $check_item ->fetchAll();

                $table = '<div class="table-responsive">
                            <table class="table table-hover table-bordered table-sm">
                                <tbody>';
                foreach($data as $item){
                    $table .= ' <tr class="text-center">
                                    <td>'. $item['item_codigo'] . '-'. $item['item_nombre'] .'</td>
                                    <td>
                                        <button 
                                            type="button"
                                            title="AGREGAR ITEM" 
                                            class="btn btn-primary"
                                            onclick="modal_add_item('.$item['item_id'].')"
                                            ><i class="fas fa-box-open"></i></button>
                                    </td>
                                </tr>';
                }          
                $table .= '</tbody>
                        </table>
                    </div>';
                return $table;
            }else{
                 return '<div class="alert alert-warning" role="alert">
                            <p class="text-center mb-0">
                                <i class="fas fa-exclamation-triangle fa-2x"></i><br>
                                No hemos encontrado ningún item en el sistema que coincida con <strong>“'.$search.'”</strong>
                            </p>
                        </div>';
                exit();  
            }
        }

        public function add_item_loan_controller(){
            $id_item = MainModel :: clearString($_POST['id_add_item']);
            
            $check_item = MainModel :: setConsult("SELECT * FROM item WHERE item_id = '$id_item'");

            if($check_item -> rowCount() < 1){
                $alert = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"No se ha encotrado el id en el sistema '$id_item'" ,
                    "Type"=>"error"
                ];
                echo json_encode($alert);
                exit();
            }else
                $data = $check_item -> fetch();

            
            $formato = mainModel :: clearString($_POST['detalle_formato']);
            $cantidad = mainModel :: clearString($_POST['detalle_cantidad']);
            $tiempo = mainModel :: clearString($_POST['detalle_tiempo']);
            $costo = mainModel :: clearString($_POST['detalle_costo_tiempo']);   
            
            if (empty($cantidad) || empty($tiempo) || empty($costo)){
                $alert = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado!",
                    "Text"=>"Los campos no se han llenado correctamente",
                    "Type"=>"error"
                ];
            }

            if (MainModel::checkData("[0-9]{1,7}", $cantidad)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"Formato incorrecto en el campo DNI",
                    "Type"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            if (MainModel::checkData("[0-9]{1,7}", $tiempo)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"Formato incorrecto en el campo DNI",
                    "Type"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            if (MainModel::checkData("[0-9.]{1,15}", $costo)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"Formato incorrecto en el campo DNI",
                    "Type"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            if($formato != "Horas" && $formato != "Dias" && $formato != "Evento" && $formato != "Mes"){
                $alerta = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"Formato incorrecto en el campo FORMATO",
                    "Type"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }


            session_start(['name' => 'ITM']);
            if(empty($_SESSION['data_item'][$id_item])){
                $costo = number_format($costo, 2, ".", "");
                $_SESSION['data_item'][$id_item] = [
                    "ID" => $data['item_id'],
                    "CODIGO" => $data['item_codigo'],
                    "NAME" => $data['item_nombre'],
                    "DETALLE" => $data['item_detalle'],
                    "FORMATO" => $formato,
                    "CANTIDAD" => $cantidad,
                    "TIEMPO" => $tiempo,
                    "COSTO" => $costo
                ];

                $alert = [
                    "Alerta"=>"recargar",
                    "Title"=>"¡Exito!",
                    "Text"=>"Se ha agregado el item con exito",
                    "Type"=>"success"
                ];                
               

            }else{
                $alert = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"No se ha encotrado el item",
                    "Type"=>"error"
                ];
            //    echo json_encode($alert);
            //    exit();
            }
            echo json_encode($alert);

        }


        public function delete_item_loan_controller(){
            $id_item = MainModel :: clearString($_POST['id_item_prestamo_delete']);
            
            session_start(['name' => 'ITM']);

            unset($_SESSION['data_item'][$id_item]);

            if(empty($_SESSION['data_item'][$id_item])){
                $alert = [
                    "Alerta"=>"recargar",
                    "Title"=>"¡Exito!",
                    "Text"=>"Se ha eliminado el item de manera exitosa",
                    "Type"=>"success"
                ];                
            }else{
                $alert = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"No se ha podido eliminar el item",
                    "Type"=>"error"
                ];
            }
            
            echo json_encode($alert);


        }
            

        public function data_pay_controller($type, $id){
            $type = MainModel :: clearString($type);

            $id = MainModel :: decryption($id);
            $id = MainModel :: clearString($id);

            return LoanModel :: data_pay_model($type, $id);

        }

        public function add_loan_controller(){
            if(empty($_SESSION['data_item'])){
                $alert = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"No se encontrado el item",
                    "Type"=>"error"
                ];
                echo json_encode($alert);
                exit();
            }

            if(empty($_SESSION['data_client'])){
                $alert = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"No se encontrado el cliente",
                    "Type"=>"error"
                ];
                echo json_encode($alert);
                exit();   
            }

            $fecha_inicio = mainModel :: clearString($_POST['prestamo_fecha_inicio_reg']);
            $hora_inicio = mainModel :: clearString($_POST['prestamo_hora_inicio_reg']);
            $fecha_final = mainModel :: clearString($_POST['prestamo_fecha_final_reg']);
            $hora_final = mainModel :: clearString($_POST['prestamo_hora_final_reg']);
            $estado = mainModel :: clearString($_POST['prestamo_estado_reg']);
            $total_pagado = mainModel :: clearString($_POST['prestamo_pagado_reg']);
            $observacion = mainModel :: clearString($_POST['prestamo_observacion_reg']);


            if(MainModel :: checkDateIn($fecha_inicio)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"Formato incorrecto en el campo fecha inicio",
                    "Type"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            
            if(MainModel :: checkDateIn($hora_inicio)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"Formato incorrecto en el campo hora inicio",
                    "Type"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(MainModel :: checkDateIn($hora_final)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"Formato incorrecto en el campo hora final",
                    "Type"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(MainModel :: checkDateIn($fecha_final)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"Formato incorrecto en el campo fecha final",
                    "Type"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(MainModel :: checkData("[0-9.]{1,10}", $total_pagado)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"Formato incorrecto en el campo fecha final",
                    "Type"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(!empty($observacion)){
                if(MainModel :: checkData("[a-zA-z0-9áéíóúÁÉÍÓÚñÑ#() ]{1,400}", $observacion)){
                    $alerta = [
                        "Alerta"=>"simple",
                        "Title"=>"Ocurrio un error inesperado",
                        "Text"=>"Formato incorrecto en el campo fecha final",
                        "Type"=>"error"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }else{
                $alerta = [
                        "Alerta"=>"simple",
                        "Title"=>"Ocurrio un error inesperado",
                        "Text"=>"El campo observacion esta vacio",
                        "Type"=>"error"
                    ];
                    echo json_encode($alerta);
                    exit();
            }

            if($estado != "1" || $estado != "2" || $estado != "3"){
                $alerta = [
                        "Alerta"=>"simple",
                        "Title"=>"Ocurrio un error inesperado",
                        "Text"=>"El campo estado no  contiene un valor valido",
                        "Type"=>"error"
                    ];
                    echo json_encode($alerta);
                    exit();
            }

            if (strtotime($fecha_final) < strtotime($fecha_inicio)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"El campo estado no  contiene un valor valido",
                    "Type"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            /** FORMATEANDO TOTALES FECHAS Y HORAS */

            $total_prestamo = number_format($_SESSION['prestamo_total'], 2, '.', '');
            $total_pagado = number_format($total_pagado, 2, '.', '');

            $fecha_inicio = date("Y-m-d", strtotime($fecha_inicio));
            $fecha_final = date("Y-m-d", strtotime($fecha_final));

            $hora_inicio = date("h:i a", strtotime($hora_inicio));
            $hora_final = date("h:i a", strtotime($hora_final));

            $correlativo = mainModel :: setConsult("SELECT id_prestamo FROM prestamo");
            $correlativo = ($correlativo -> rowCount()) + 1;
            $codigo = MainModel :: getRandomCode("CP", 7, $correlativo);


            $data_loan = [
                "codigo" -> $codigo,
                "fecha_inicio" -> $fecha_inicio,
                "hora_inicio" -> $hora_inicio,
                "fecha_final" -> $fecha_final,
                "hora_final" -> $hora_final,
                "cantidad" -> $_SESSION['prestamo_item'],
                "pagado" -> $total_prestamo,
                "total_pagado" -> $total_pagado,
                "observacion" -> $observacion,
                "estado" -> $estado,
                "id_usuario" -> $_SESSION['id_spm'],
                "id_cliente" -> $_SESSION['data_client']['id']
            ];

            $insert_loan = LoanModel :: add_loan_model($data_loan);

            if($insert_loan -> rowCount() != 1){
                $alerta = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"El campo estado no  contiene un valor valido",
                    "Type"=>"error"
                ];  
                echo json_encode($alerta);
                exit();   
            }


            /**
             * Insert a la tabla de pagos
             */
            if($total_pagado > 0){
                $datos_pago_reg = [
                    "total" => $total_pagado,
                    "fecha" => $fecha_inicio,
                    "codigo" => $codigo,
                ];
                
                $insert_pago = LoanModel :: add_pay_model($datos_pago_reg);

                if($insert_pago -> rowCount() != 1){
                    LoanModel :: delete_pay_model($codigo, "prestamo");
                    $alerta = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"No se ha podigo insertar el pago (Error 001)",
                    "Type"=>"error"
                    ];  
                    echo json_encode($alerta);
                    exit();
                }

            }

            /**
             * Insert a la tabla detalles
            */

    
            echo json_encode($alerta);
            
        }

    }