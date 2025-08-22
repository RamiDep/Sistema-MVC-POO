<?php
    if($ajaxRequest){
        require_once "../models/clientModel.php";
    }else{
        require_once "./models/clientModel.php";
    }

    class ClientController extends ClientModel{

        /*Controlador para agregar clientes */
        public function add_client_controller(){
            /*Video 50 */
            $dni = MainModel :: clearString($_POST['client_dni_add']);
            $name = MainModel :: clearString($_POST['client_name_add']);
            $last_name = MainModel :: clearString($_POST['client_lastname_add']);
            $telefone_number = MainModel :: clearString($_POST['client_phone_add']);
            $adress = MainModel :: clearString($_POST['client_adress_add']);

            if ($dni == "" || $name == "" || $last_name == "" || $telefone_number == "" || $adress == ""){
                $alerta = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"No llenaste todos los campos (Obligatorios)",
                    "Type"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(MainModel :: checkData("[0-9\-]{1,20}", $dni)){
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
            if(MainModel :: checkData("[0-9\-]{1,10}", $telefone_number)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"Formato incorrecto en el campo telefono",
                    "Type"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            if(MainModel :: checkData("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s,.\-#\/]{1,190}$", $adress)){
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
            /*video 51 */
            

            $check_dni = MainModel :: setConsult("SELECT cliente_dni FROM cliente WHERE cliente_dni = '$dni'");
            if($check_dni ->rowCount() == 1){
                $alerta = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"El DNI ya existe en la base de datos",
                    "Type"=>"error"
                ];
                echo json_encode($alerta);
                exit(); 
            }
            $data = [
                "client_dni" => $dni,
                "client_name" => $name,
                "client_lastname" => $last_name,
                "client_phone" => $telefone_number,
                "client_adress" => $adress
            ];

            $addData = ClientModel :: add_client_model($data);
            if($addData -> rowCount() > 0 ){
                $alerta = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"Se inserto correctamente el cliente",
                    "Type"=>"success"
                ];
            }else{
                $alerta = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"No se pudo insertar el cliente",
                    "Type"=>"error"
                ];
            }
            echo json_encode($alerta);
            /*Fin video 51 */
        }

        /*Controlador para paginar clientes *Video 52* */
        public function pager_client_controller($page, $record, $privile, $url, $search){

            
            $page = mainModel :: clearString($page);
            $record = mainModel :: clearString($record);
            $privile = mainModel :: clearString($privile);
            $url = mainModel :: clearString($url);
            $search = mainModel :: clearString($search);

            $url = serverUrl . $url."/";

            $table = "";

            $page = (isset($page) && $page > 0) ? (int) $page : 1;
            $index = (isset($page) && $page > 0) ? (($page * $record) - $record)  : 0;


            if(isset($search) && $search != ""){
                $querySearch ="SELECT SQL_CALC_FOUND_ROWS * FROM cliente 
                  WHERE (cliente_dni LIKE '%$search%'
                    OR cliente_nombre LIKE '%$search%' 
                    OR cliente_apellido LIKE '%$search%'
                    OR cliente_telefono LIKE '%$search%'
                    OR cliente_direccion LIKE '%$search%')
                  ORDER BY cliente_nombre ASC LIMIT $index, $record    
                ";
            }else{
                $querySearch ="SELECT SQL_CALC_FOUND_ROWS * FROM cliente 
                ORDER BY cliente_nombre ASC LIMIT $index, $record";
                //  var_dump($querySearch);
            }

            $connect = MainModel :: connection();

            $data = $connect -> query($querySearch);
            $data = $data -> fetchAll();
            

            $total = $connect -> query("SELECT FOUND_ROWS()");
            
            $total = (int)$total->fetchColumn();
            // var_dump($total);
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
                                <th>DIRECCION</th>';
                            if($privile == 1 || $privile == 2){
                                $table .= '<th>ACTUALIZAR</th>';
                            }
                            if($privile == 1){
                                $table .= '<th>ELIMINAR</th>';
                            }
            $table .= '     </tr>
                        </thead>
                        <tbody>
            ';
            /*Fin video 52 */
            if($total >= 1 && $page <= $pagesTotal){
                $count = $index+1;
                $pageIni = $index+1;
                foreach($data as $row){
                    /*video 53 */
                    $table .= '
                        <tr class="text-center" >
                            <td>'.$count.'</td>
                            <td>'.$row['cliente_dni'].'</td>
                            <td>'.$row['cliente_nombre'].'</td>
                            <td>'.$row['cliente_apellido'].'</td>
                            <td>'.$row['cliente_telefono'].'</td>
                        
                            <td>
                                <button type="button" 
                                        class="btn btn-info" 
                                        data-toggle="popover" 
                                        data-trigger="hover" 
                                        title="'.$row['cliente_nombre'].'" 
                                        data-content="'.$row['cliente_direccion'].'">
                                    <i class="fas fa-info-circle"></i>
                                </button>
                            </td>';
                           
                    
                    if($privile == 1 || $privile == 2){
                        $table .= '<td>
                                    <a href="'.serverUrl.'client-update/'.mainModel :: encryption($row['cliente_id']).'/" class="btn btn-success">
                                        <i class="fas fa-sync-alt"></i>	
                                    </a>
                                    </td>';
                    }
                    if($privile == 1){
                        $table.='
                            <td>
                                <form class="ajaxForm" action="'.serverUrl.'ajax/clientAjax.php" method="POST" data-form="delete" autocomplete="">
                                    <input type="hidden" name="id_client_delete" value="'.mainModel :: encryption($row['cliente_id']).'">
                                    <button type="submit" class="btn btn-warning">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>';
                    }       
                            
                        $count++;
                }
                /*Fin video 53 */
                $pageFin = $count-1;
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

            if($total >= 1){
            }

            if($total >= 1 && $page <= $pagesTotal){
                $table .= '<p class="text-right">mostrando cliente '.$pageIni.' al '.$pageFin.' de un total de '.$total.'';
                $table .= mainModel ::  doTable($page, $pagesTotal, $url, 7);
            }

            return $table;

        } // final pager_controller

        /**
         * Controllador para eliminar clientes
         * video 55
         */
        public function delete_client_controller(){
            /*Video 56 */
            $id_client = MainModel :: decryption($_POST['id_client_delete']);
            $id_client = MainModel :: clearString($id_client);

            $check_id_client = MainModel :: setConsult("SELECT cliente_id FROM cliente WHERE cliente_id = '$id_client'");
            
            if ($check_id_client -> rowCount() < 1){
                $alerta = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"No se encuentra ese id en la base de datos",
                    "Type"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            /**Verificamos si el cliente no tiene prestamos */
            $check_client_prestamo = MainModel :: setConsult("SELECT cliente_id FROM prestamo WHERE cliente_id = '$id_client' LIMIT 1");

            if ($check_client_prestamo -> rowCount() > 0){
                $alerta = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"No se puede eliminar ese cliente por que tiene prestamos pendientes",
                    "Type"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            /*Video 56 FIN*/
            /*Video 57*/
            session_start(['name'=>'ITM']);
            if($_SESSION['privile_itm'] != 1){
                $alerta = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"No tienes permisos necesarios para eliminar clientes",
                    "Type"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            $delete_client = ClientModel :: delete_client_model($id_client);

            if($delete_client -> rowCount() == 1){
                $alerta = [
                    "Alerta"=>"recargar",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"Se ha eliminado correctamente el cliente",
                    "Type"=>"success"
                ];
            }else{
                $alerta = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"No se ha podido eliminar el cliente, por favor intente de nuevo",
                    "Type"=>"error"
                ];
            }
            echo json_encode($alerta);
            /*Video 56 FIN*/



        }
         /* video 55*/

    }