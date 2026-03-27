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
                
                $data = $check_client ->fetchAll();

                $table = '<div class="table-responsive">
                            <table class="table table-hover table-bordered table-sm">
                                <tbody>';
                foreach($data as $client){
                    $table .= '<tr class="text-center">
                                    <td>'.$client['cliente_dni'].' - '.$client['cliente_nombre'].' - '.$client['cliente_apellido'].'</td>
                                    <td>
                                        <button type="button" class="btn btn-primary"><i class="fas fa-user-plus" onclick="add_client_reservation('.$client['cliente_id'].')"></i></button>
                                    </td>
                                </tr>';
                }                
                $table .= '</tbody>
                        </table>
                    </div>';
                return $table;
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

        public function add_client_loan_controller(){
            $id_client = MainModel :: clearString($_POST['id_client_loan']);
           
            $check_client = MainModel :: setConsult("SELECT * FROM cliente WHERE cliente_id = '$id_client'");
            
            if($check_client -> rowCount() < 1){
                $alert = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"No se ha encotrado el cliente con id: ".$id_client.", por favor intente nuevamente.",
                    "Type"=>"error"
                ];
                echo json_encode($alert);
                exit();
            }else
                $datos = $check_client->fetch();

            session_start(['name' => 'ITM']);
            if(empty($_SESSION['data_client'])){
                $_SESSION['data_client'] = [
                    "ID" => $datos['cliente_id'],
                    "DNI" => $datos['cliente_dni'],
                    "NAME" => $datos['cliente_nombre'],
                    "LASTNAME" => $datos['cliente_apellido']
                ];

                $alert = [
                    "Alerta"=>"recargar",
                    "Title"=>"Cliente agregado",
                    "Text"=>"Se agrego correctamente el cliente al prestamo",
                    "Type"=>"success"
                ];
                echo json_encode($alert);

            }else{
                $alert = [
                    "Alerta"=>"simple",
                    "Title"=>"Ocurrio un error inesperado",
                    "Text"=>"No se ha encotrado el cliente",
                    "Type"=>"error"
                ];
                echo json_encode($alert);
            }
        }

    }