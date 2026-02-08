<?php 
    if ($ajaxRequest){
        require_once("../models/itemModel.php");
    }else{
        require_once("./models/itemModel.php");         
    }

    class ItemController extends ItemModel {

        public function add_item_controller(){
        
            $dni = MainModel :: clearString($_POST['item_codigo_add']);
            $name = MainModel :: clearString($_POST['item_nombre_add']);
            $stock = MainModel :: clearString($_POST['item_stock_add']);
            $status = MainModel::clearString($_POST['item_status_add'] ?? '');
            $details = MainModel :: clearString($_POST['item_detalle_add']);

            if (empty($dni) || empty($name) || empty($stock) || empty($status) || empty($details)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"No se han completado todos los campos",
                    "Type"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            if (MainModel::checkData("[0-9\-]{1,20}", $dni)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"Formato incorrecto en el campo usuario (Nombre usuario)",
                    "Type"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            if (MainModel::checkData("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}", $name)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"Formato incorrecto en el campo usuario (Nombre usuario)",
                    "Type"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            if (MainModel::checkData("[0-9]{1,9}", $stock)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"Formato incorrecto en el campo usuario (Nombre usuario)",
                    "Type"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            if (MainModel::checkData("^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s,.\-#\/]{1,190}$", $details)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"Formato incorrecto en el campo usuario (Nombre usuario)",
                    "Type"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            $check_code = MainModel :: setConsult("SELECT * FROM item WHERE item_codigo = '$dni'");
            if($check_code -> rowCount() > 0){
                $alerta = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"El codigo ya se encuentra registrado en el sistema",
                    "Type"=>"error"
                ];
                echo json_encode($alerta);
                exit();
                
            }

             $check_name = MainModel :: setConsult("SELECT * FROM item WHERE item_nombre = '$name'");
            if($check_name -> rowCount() > 0){
                $alerta = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"El nombre ya se encuentra registrado en el sistema",
                    "Type"=>"error"
                ];
                echo json_encode($alerta);
                exit();
                
            }

            $datos = [
                "code" => $dni,
                "name" => $name,
                "stock" => $stock,
                "status" => $status,
                "details" => $details
            ];

            $insertItem = ItemModel :: add_item_model($datos);
            if($insertItem -> rowCount() == 1){
                $alerta = [
                    "Alerta"=>"recargar",
                    "Title"=>"Exito",
                    "Text"=>"Se ha insertado correctamente el item",
                    "Type"=>"success"
                ];
            }else{
                $alerta = [
                    "Alerta"=>"recargar",
                    "Title"=>"Error",
                    "Text"=>"No se ha insertado correctamente el item",
                    "Type"=>"error"
                ];
            }
            echo json_encode($alerta);

        }   

         /*Controlador para paginar items *Video 73* */
        public function pager_item_controller($page, $record, $privile, $url, $search){

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
                $querySearch ="SELECT SQL_CALC_FOUND_ROWS * FROM item 
                  WHERE (item_codigo LIKE '%$search%'
                    OR item_nombre LIKE '%$search%') 
                  ORDER BY item_nombre ASC LIMIT $index, $record    
                ";
            }else{
                $querySearch ="SELECT SQL_CALC_FOUND_ROWS * FROM item 
                ORDER BY item_nombre ASC LIMIT $index, $record";
                
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
                                <th>CODIGO</th>
                                <th>NOMBRE</th>
                                <th>STOCK</th>
                                <th>DETALLES</th>';
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
                            <td>'.$row['item_codigo'].'</td>
                            <td>'.$row['item_nombre'].'</td>
                            <td>'.$row['item_stock'].'</td>
                            <td>
                                <button type="button" 
                                        class="btn btn-info" 
                                        data-toggle="popover" 
                                        data-trigger="hover" 
                                        title="'.$row['item_nombre'].'" 
                                        data-content="'.$row['item_stock'].'">
                                    <i class="fas fa-info-circle"></i>
                                </button>
                            </td>';
                           
                    
                    if($privile == 1 || $privile == 2){
                        $table .= '<td>
                                    <a href="'.serverUrl.'item-update/'.mainModel :: encryption($row['item_id']).'/" class="btn btn-success">
                                        <i class="fas fa-sync-alt"></i>	
                                    </a>
                                    </td>';
                    }
                    if($privile == 1){
                        $table.='
                            <td>
                                <form class="ajaxForm" action="'.serverUrl.'ajax/itemAjax.php" method="POST" data-form="delete" autocomplete="">
                                    <input type="hidden" name="id_item_delete" value="'.mainModel :: encryption($row['item_id']).'">
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
                                    <td colspan="8"><a href="'.$url.'">Haga clic para recargar listado</a></td>
                                </tr>';
                }else{
                    $table .= ' <tr class="text-center">
                                    <td colspan="8">No hay registros en el sistema</td>
                                </tr>';
                }
    
            
            }
            $table .= '</tbody></table></div>';

            if($total >= 1){
            }

            if($total >= 1 && $page <= $pagesTotal){
                $table .= '<p class="text-right">mostrando Item '.$pageIni.' al '.$pageFin.' de un total de '.$total.'';
                $table .= mainModel ::  doTable($page, $pagesTotal, $url, 7);
            }

            return $table;

        } //

        public function delete_item_controller(){
            $id_item = MainModel :: decryption($_POST['id_item_delete']);
            $id_item = MainModel :: clearString($id_item);

            $check_id = MainModel :: setConsult("SELECT item_id FROM item WHERE item_id = '$id_item'");

            if($check_id -> rowCount() < 1){
                $alerta = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"El item no esta registrado en el sistema.",
                    "Type"=>"error"
                ];
                echo json_encode($alerta);
                exit();   
            }

            session_start(['name'=>'ITM']);
            
            if($_SESSION['privile_itm'] != 1){
                $alerta = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"No tienes privilegios para hacer la acción.",
                    "Type"=>"error"
                ];
                echo json_encode($alerta);
                exit(); 
            }

            $delete_item = ItemModel :: delete_item_model($id_item);
            if($delete_item -> rowCount() == 1){
                $alerta = [
                    "Alerta"=>"simple",
                    "Title"=>"Exito",
                    "Text"=>"Se ha eliminado correctamente el item",
                    "Type"=>"success"
                ];
            }else{
                $alerta = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"No se logro realizar la accion, intente nuevamente.",
                    "Type"=>"error"
                ];
            }

            echo json_encode($alerta);

        }

        



    }