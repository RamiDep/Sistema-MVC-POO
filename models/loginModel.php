<?php

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

            $sql->bindParam(":Usuario", $data["Usuario"],);
            $sql->bindParam(":Clave", $data["Clave"],);
            $sql->bindParam(":Estado", $data["Estado"],);

            $sql->execute();

            return $sql;

        }

    }

   