<?php 
    if ($ajaxRequest){
        require_once("../models/loanModel.php");
    }else{
        require_once("./models/loanModel.php");         
    }

    class LoanController extends LoanModel {
        public function search_client_loan_controller(){
            $search = MainModel :: clearString($_POST['search_client']);

            if(empty($search)){
                return '<div class="alert alert-warning" role="alert">
                            <p class="text-center mb-0">
                                <i class="fas fa-exclamation-triangle fa-2x"></i><br>
                                Debes introducir DNI, Nombre, Apellido o Telefono
                            </p>
                        </div>';
                exit();        
            }

            $check_client = MainModel :: setConsult("SELECT * FROM cliente WHERE 
                                cliente_dni LIKE '%$search%' OR
                                cliente_nombre LIKE '%$search%' OR
                                cliente_apellido LIKE '%$search%' OR                                
                                cliente_telefono LIKE '%$search%'
                                ORDER BY cliente_nombre ASC ");
            if($check_client -> rowCount() > 0){

            }else{
                 return '<div class="alert alert-warning" role="alert">
                            <p class="text-center mb-0">
                                <i class="fas fa-exclamation-triangle fa-2x"></i><br>
                                No hemos encontrado ningún cliente en el sistema que coincida con <strong>“'.$search.'”</strong>
                            </p>
                        </div>';
                exit();  
            }
        }

    }