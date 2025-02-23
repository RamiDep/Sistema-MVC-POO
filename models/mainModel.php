<?php

    if ($peticionAjax){
        require_once ("../config/SERVER.php");
    }else{
        require_once ("./config/SERVER.php");
    }

    class mainModel{

        /* -------FUNCION PARA CONECTAR BASE DE DATOS-------*/
        protected static function connection(){
            $conn = new PDO(SGBD, USER, PASS);
            $conn->exec("SET CARACTER SET utf8");
            return $conn;
        }

        protected static function setConsult($query){
            $response = self::connection()->prepare($query); //hace referencia a otro metodo
            $response->execute();
            return $response;
        }

        /**-----------Funcion para Encriptar  ---------------------*/
        public function encryption($string){
			$output=FALSE;
			$key=hash('sha256', SECRET_KEY);
			$iv=substr(hash('sha256', SECRET_IV), 0, 16);
			$output=openssl_encrypt($string, METHOD, $key, 0, $iv);
			$output=base64_encode($output);
			return $output;
		}

        /**-----------Funcion para desencriptar  ---------------------*/
		protected static function decryption($string){
			$key=hash('sha256', SECRET_KEY);
			$iv=substr(hash('sha256', SECRET_IV), 0, 16);
			$output=openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
			return $output;
		}

        /**-------------Funcion para generar codigos Aleatirios */
        protected static function getRandomCode($letter, $lenght, $number){
            for($i = 0; $i < $lenght; $i++){
                $random = rand(0, 9);
                $letter.=$random;
            }
            return $letter."-".$number;
        }

        protected static function clearString($string){
            $string = trim($string); //Elimina espacios antes de la cadena y al final
            $string = stripcslashes($string); // Elimina diagonales invertidas
            $string = str_ireplace("<script>", "", $string);
            $string = str_ireplace("</script>", "", $string);
            $string = str_ireplace("<script src", "", $string);
            $string = str_ireplace("<script type=", "", $string);
            $string = str_ireplace("SELECT * FROM", "", $string);
            $string = str_ireplace("DELETE FROM", "", $string);
            $string = str_ireplace("INSERT INTO", "", $string);
            $string = str_ireplace("DROP TABLE", "", $string);
            $string = str_ireplace("DROP DATABASE", "", $string);
            $string = str_ireplace("TRUNCATE TABLE", "", $string);
            $string = str_ireplace("SHOW TABLES", "", $string);
            $string = str_ireplace("SHOW DATABASES", "", $string);
            $string = str_ireplace("<?php", "", $string);
            $string = str_ireplace("?>", "", $string);
            $string = str_ireplace("--", "", $string);
            $string = str_ireplace(">", "", $string);
            $string = str_ireplace("<", "", $string);
            $string = str_ireplace("[", "", $string);
            $string = str_ireplace("]", "", $string);
            $string = str_ireplace("==", "", $string);
            $string = str_ireplace("^", "", $string);
            $string = str_ireplace(";", "", $string);
            $string = str_ireplace("::", "", $string);
            $string = stripcslashes($string); // Elimina diagonales invertidas
            $string = trim($string); //Elimina espacios antes de la cadena y al final
        }



    }