<?php
    require_once ("mainModel.php");

    class LoanModel extends MainModel{
        
        public static function add_loan_model($data){
            $insert_load = MainModel :: connection() -> prepare("INSERT INTO loan
                (prestamo_codigo, prestamo_fecha_inicio, prestamo_hora_inicio, prestamo_fecha_final, prestamo_hora_final, 
                prestamo_cantidad, prestamo_total, prestamo_pagado, prestamo_estado, prestamo_observacion
                ,usuario_id, cliente_id) 
                VALUES 
                (:Codigo, :FechaInicio, :HoraInicio, :FechaFinal, :HoraFinal, :Cantidad, :Total, :Pagado, :Estado,
                :Observacion, :UsuarioId, :ClienteId)");
            
            $insert_load -> bindParam(":Codigo", $data['Codigo']);
            $insert_load -> bindParam(":FechaInicio", $data['FechaInicio']);
            $insert_load -> bindParam(":HoraInicio", $data['HoraInicio']);
            $insert_load -> bindParam(":FechaFinal", $data['FechaFinal']);
            $insert_load -> bindParam(":HoraFinal", $data['HoraFinal']);
            $insert_load -> bindParam(":Cantidad", $data['Cantidad']);
            $insert_load -> bindParam(":Total", $data['Total']);
            $insert_load -> bindParam(":Pagado", $data['Pagado']);
            $insert_load -> bindParam(":Estado", $data['Estado']);
            $insert_load -> bindParam(":Observacion", $data['Observacion']);
            $insert_load -> bindParam(":UsuarioId", $data['UsuarioId']);
            $insert_load -> bindParam(":ClienteId", $data['ClienteId']);

            $insert_load -> execute();
            
        }


        public static function add_loan_details_model($data){
            $insert_details_load = MainModel :: connection() -> prepare("INSERT INTO detalle
                (detalle_cantidad, detalle_formato, detalle_tiempo, detalle_costo_tiempo, detalle_descripcion, prestamo_codigo, item_id) 
                VALUES 
                (:detalle_cantidad, :detalle_formato, :detalle_tiempo, :detalle_costo_tiempo, :detalle_descripcion, :prestamo_codigo, :item_id)");
            
            $insert_details_load -> bindParam(":detalle_cantidad", $data['detalle_cantidad']);
            $insert_details_load -> bindParam(":detalle_formato", $data['detalle_formato']);
            $insert_details_load -> bindParam(":detalle_tiempo", $data['detalle_tiempo']);
            $insert_details_load -> bindParam(":detalle_costo_tiempo", $data['detalle_costo_tiempo']);
            $insert_details_load -> bindParam(":detalle_descripcion", $data['detalle_descripcion']);
            $insert_details_load -> bindParam(":prestamo_codigo", $data['prestamo_codigo']);
            $insert_details_load -> bindParam(":item_id", $data['item_id']);

            $insert_details_load -> execute();
            
        }

        public static function add_pay_model($data){
            $insert_pay = MainModel :: connection() -> prepare("INSERT INTO pagos
                (total_pago, fecha_pago, codigo_pago) 
                VALUES 
                (:total_pago, :fecha_pago, :codigo_pago)");
            
            $insert_pay -> bindParam(":total_pago", $data['total_pago']);
            $insert_pay -> bindParam(":fecha_pago", $data['fecha_pago']);
            $insert_pay -> bindParam(":codigo_pago", $data['codigo_pago']);
        
            $insert_pay -> execute();
            
        }

    }