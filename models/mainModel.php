<?php

    if ($ajaxRequest){
        require_once ("../config/SERVER.php");
    }else{
        require_once ("./config/SERVER.php");
    }

    class MainModel{

        /* -------FUNCION PARA CONECTAR BASE DE DATOS-------*/
        protected static function connection(){
            $conn = new PDO(SGBD, USER, PASS);
            $conn->exec("SET NAMES utf8");
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
            return $string;
        }

        /*Valida una expresion regular */
        protected static function checkData($filter, $stringIn){
            if(preg_match("/^". $filter ."$/", $stringIn)){
                return false;
            }else{
                return true;
            }
        }

        /*Valida una fecha */
        protected static function checkDateIn($date){
            $split = explode("-", $date);
            if(count($split) == 3 && checkdate($split[1], $split[2], $split[0])){
                return false;
            }else{
                return true;
            }
        }

        /* Formato para tablas del sistema */
        protected static function doTable($page, $numPage, $url, $buttons){
            $table = ' <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center">';
            if($page == 1){
                $table .= ' <li class="page-item disabled">
                                <a class="page-link"><i class="fa-regular fa-circle-left"></i></a>
                            </li>';
            }else{
                $table .= ' <li class="page-item"><a class="page-link href="'.$url.'1/">
                                <i class="fa-regular fa-circle-left"></i></a>
                            </li>
                            <li class="page-item"><a class="page-link href="'.$url.($page-1).'/">
                                Anterior</a>
                            </li>
                            ';
            }


            $ci = 0;
            for($i=$page;$i <= $numPage; $i++){
                if($ci>=$buttons){
                    break;
                }
                if($page == $i){
                    $table.='
                            <li class="page-item">
                                <a class="page-link active" href="'.$url.$i.'/">'.$i.'</a>
                            </li>';
                }else{
                    $table.='
                    <li class="page-item">
                        <a class="page-link" href="'.$url.$i.'/">'.$i.'</a>
                    </li>';
                }
                $ci++;

            }

            if($page == $numPage){
                $table .= ' <li class="page-item disabled">
                                <a class="page-link"><i class="fa-regular fa-circle-right"></i></a>
                            </li>';
            }else{
                $table .= ' <li class="page-item"><a class="page-link href="'.$url.($page+1).'/">
                                Siguiente</a>
                            </li>
                            <li class="page-item"><a class="page-link href="'.$url.$numPage.'/">
                                <i class="fa-regular fa-circle-right"></i></a>
                            </li>
                            ';
            }


            $table .= '</ul></nav>';
            return $table;
        }



    }