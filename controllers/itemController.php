<?php 
    if ($ajaxRequest){
        require_once("../models/itemModel.php");
    }else{
        require_once("./models/itemModel.php");         
    }

    class ItemController extends MainModel{

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

            $datos = [
                "code" => $dni,
                "name" => $name,
                "stock" => $stock,
                "status" => $status,
                "details" => $details
            ];

            $insertItem = ItemModel :: add_item_model($datos);
            if($insertItem -> rowCount() == 1){
                $alert = [
                    "Alerta"=>"recargar",
                    "Title"=>"Exito",
                    "Text"=>"Se ha insertado correctamente el item",
                    "Type"=>"success"
                ];
            }else{
                $alert = [
                    "Alerta"=>"recargar",
                    "Title"=>"Exito",
                    "Text"=>"No se ha insertado correctamente el item",
                    "Type"=>"success"
                ];
            }
            echo json_encode($alert);

        }   



    }