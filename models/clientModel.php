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

        /*video 55 */
        protected static function delete_client_model($id){
            $sql = MainModel :: connection() -> prepare("DELETE FROM cliente WHERE cliente_id = :ID");
            $sql -> bindParam(":ID", $id);       
            $sql -> execute();
            return $sql;
        }
        /*fin video 55 */

        /*Video 58
            Muestra informacion del cliente que se va actualizar
        */
        protected static function show_client_model($type, $id_client){
            if($type == 1){ //Tipo se define en las vistas 0 = Home y en 1 = Update
                $get_client_data = mainModel :: connection()->prepare("SELECT * FROM cliente WHERE cliente_id = :ID");
                $get_client_data->bindParam(":ID", $id_client);
            }else if($type == 0){
                $get_client_data = mainModel :: connection()->prepare("SELECT cliente_id FROM cliente WHERE cliente_id != 1");
            }
            $get_client_data->execute();
            return $get_client_data;
        }
        /*Fin video 58 */

        /** 
         * Video 60
         * MODELO PARA ACTUALIZAR USUARIOS */

        protected static function update_client_model($data_client){
            $sqlUpdate_client = MainModel :: connection()->prepare("UPDATE cliente set 
                                    cliente_dni = :Dni,
                                    cliente_nombre = :Name_,
                                    cliente_apellido = :LastName,
                                    cliente_telefono = :Telephone,
                                    cliente_direccion = :Adress
                                    WHERE cliente_id = :Id

            ");
            
            $sqlUpdate_client->bindParam(":Dni", $data_client['DNI']);
            $sqlUpdate_client->bindParam(":Name_", $data_client['NAME']);
            $sqlUpdate_client->bindParam(":LastName", $data_client['LASTNAME']);
            $sqlUpdate_client->bindParam(":Telephone", $data_client['PHONE']);
            $sqlUpdate_client->bindParam(":Adress", $data_client['ADRESS']);
            $sqlUpdate_client->bindParam(":Id", $data_client['ID']);

            $sqlUpdate_client->execute();

            return $sqlUpdate_client;

        }
        /**
         * Video 60 FIN
         */
    }