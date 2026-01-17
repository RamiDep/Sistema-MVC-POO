<?php
    require_once ("mainModel.php");

    class ItemModel extends MainModel{
        protected function add_item_model($data){
            $insertItem = MainModel :: connection()->prepare("INSERT INTO item
                (item_codigo, item_nombre, item_stock, item_estado, item_detalle)
                VALUES
                (:CODE, :NAME_, :STOCK, :STATUS_, :DETAILS)");
            $insertItem->bindParam(":CODE", $data['code']);
            $insertItem->bindParam(":NAME_", $data['name']);
            $insertItem->bindParam(":STOCK", $data['stock']);
            $insertItem->bindParam(":STATUS_", $data['status']);
            $insertItem->bindParam(":DETAILS", $data['details']);
            $insertItem -> execute();
            
            return $insertItem;
        }
    }