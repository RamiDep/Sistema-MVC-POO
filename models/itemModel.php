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

        protected function delete_item_model($id){
            $deleteItem = MainModel :: connection()->prepare("DELETE FROM item WHERE item_id = :ID");
            $deleteItem -> bindParam(":ID", $id);
            $deleteItem -> execute();
            return $deleteItem;
        }

        protected function show_item_model($type, $id_item){
            if ($type == 1){
                $select_items = MainModel :: connection() -> prepare("SELECT * FROM item WHERE item_id = :ID");
                $select_items -> bindParam(":ID", $id_item);
            }else{
                $select_items = MainModel :: connection() -> prepare("SELECT * FROM item");                
            }
            $select_items->execute();
            return $select_items;
        }

        protected function update_item_model($data){
            $update_item = MainModel :: connection()->prepare(
                "UPDATE item SET item_codigo = :CODE, 
                    item_nombre = :NAME_,
                    item_stock = :STOCK,                    
                    item_estado = :STATUS_,
                    item_detalle = :DETAILS
                WHERE item_id = :ID
                ");
            $update_item->bindParam(":CODE", $data['code']);
            $update_item->bindParam(":NAME_", $data['name']);
            $update_item->bindParam(":STOCK", $data['stock']);
            $update_item->bindParam(":STATUS_", $data['status']);
            $update_item->bindParam(":DETAILS", $data['details']);
            $update_item->bindParam(":ID", $data['id_item']);
            $update_item ->execute();
            return $update_item;
        }

    }