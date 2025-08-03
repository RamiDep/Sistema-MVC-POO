<?php
    require_once ("mainModel.php");

    class ClientModel extends MainModel{
        
        /*video 49 */
        protected static function add_client_model($data){
            $sql = MainModel :: connection() -> prepare("INSERT INTO cliente(cliente_dni, cliente_nombre, cliente_apellido,
                        cliente_telefono, cliente_direccion) VALUES(:DNI, :_NAME, :LASTNAME, :PHONE, :ADRESS)");
            $sql -> bindParam(":DNI", $data['client_dni']);     
            $sql -> bindParam(":_NAME", $data['client_name']);   
            $sql -> bindParam(":LASTNAME", $data['client_lastname']);   
            $sql -> bindParam(":PHONE", $data['client_phone']);   
            $sql -> bindParam(":ADRESS", $data['client_adress']);   

            $sql -> execute();
            return $sql;
        }
        /*fin video 49 */
    }