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
            (:DNI, :Nombre, :Apellido, :Telefono, :Direccion, :Email, :Usuario :Clave, :Estado, :Privilegio)
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

}