<?php

require_once("mainModel.php");

class UserModel extends MainModel {

    /*--------------MODELO PARA AGREGAR USUARIOS-------- */

    /* La funcion es protegida  y estatica por que es un modelo*/

    protected static function add_user_model($data){
        
        $sql = MainModel::connection()->prepare("
            INSERT INTO usuario
            (usuario_dni, usuario_nombre, usuario_apellido, usuario_telefono, usuario_direccion, usuario_email, usuario_usuario, usuario_clave, usuario_estado, usuario_privilegio) 
            VALUES
            (:DNI, :Nombre, :Apellido, :Telefono, :Direccion, :Email, :Usuario, :Clave, :Estado, :Privilegio)
        ");

        $sql->bindParam(":DNI", $data["DNI"]);
        $sql->bindParam(":Nombre", $data["Nombre"],);
        $sql->bindParam(":Apellido", $data["Apellido"],);
        $sql->bindParam(":Telefono", $data["Telefono"],);
        $sql->bindParam(":Direccion", $data["Direccion"],);
        $sql->bindParam(":Email", $data["Email"],);
        $sql->bindParam(":Usuario", $data["Usuario"],);
        $sql->bindParam(":Clave", $data["Clave"],);
        $sql->bindParam(":Estado", $data["Estado"],);
        $sql->bindParam(":Privilegio", $data["Privilegio"],);
       
        $sql->execute();

        return $sql;

    }


    protected static function delete_user_model($id){
        $deleteSql = mainModel :: connection()->prepare("UPDATE usuario SET usuario_estado = 'INACTIVO' WHERE usuario_id=:ID");

        $deleteSql->bindParam(":ID", $id);
        $deleteSql->execute();
        
        return $deleteSql;
    }

    protected static function show_user_model($type, $id_user){
        if($type == 1){
            $get_user_data = mainModel :: connection()->prepare("SELECT * FROM usuario WHERE usuario_id = :ID");
            $get_user_data->bindParam(":ID", $id_user);
            

        }else if($type == 0){
            $get_user_data = mainModel :: connection()->prepare("SELECT usuario_id FROM usuario WHERE usuario_id != 1");
            // $get_user_data->bindParam(":ID", $id_user);
            
        }
        $get_user_data->execute();
        return $get_user_data;
    }

    /* MODELO PARA ACTUALIZAR USUARIOS*/

    protected static function update_user_model($data){
        $sqlUpdate = mainModel :: connection()->prepare("UPDATE usuario SET 
        usuario_dni = :_DNI, usuario_nombre = :_Name, 
        usuario_apellido = :_LastName, usuario_telefono = :_Phone, 
        usuario_direccion = :_Address, usuario_email = :_Email, 
        usuario_usuario = :_User, usuario_clave = :_Password, 
        usuario_estado = :_Status, usuario_privilegio = :_Privile
        WHERE usuario_id = :_id_user");

        $sqlUpdate->bindParam(":_DNI", $data['DNI']);
        $sqlUpdate->bindParam(":_Name", $data['Name']);
        $sqlUpdate->bindParam(":_LastName", $data['LastName']);
        $sqlUpdate->bindParam(":_Phone, ", $data['Phone']);
        $sqlUpdate->bindParam(":_Address", $data['Address']);
        $sqlUpdate->bindParam(":_Email", $data['Email']);
        $sqlUpdate->bindParam(":_User", $data['User']);
        $sqlUpdate->bindParam(":_Password", $data['Password']);
        $sqlUpdate->bindParam(":_Status", $data['Status']);
        $sqlUpdate->bindParam(":_Privile", $data['Privile']);
        $sqlUpdate->bindParam(":_id_user", $data['ID']);
        $sqlUpdate->execute();

        return $sql
    }


}