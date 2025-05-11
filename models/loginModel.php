<?php
    require_once("mainModel.php");

    class LoginModel extends MainModel{
        /**
        * Modelo para uso de Login
        */

        protected static function session_start_model($data){
            $sql = MainModel::connection()->prepare("
                SELECT * FROM usuario WHERE 
                    usuario_usuario = :Usuario 
                    AND usuario_clave = :Clave
                    AND usuario_estado = 'Activa'
            ");

            $sql->bindParam(":Usuario", $data["user"],);
            $sql->bindParam(":Clave", $data["password"],);
            // $sql->bindParam(":Estado", $data["status"],);

            $sql->execute();

            return $sql;

        }

    }

   