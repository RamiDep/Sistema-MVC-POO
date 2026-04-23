<script>
    /* ------- BOTON PARA BUSCAR CLIENTES ----------*/
    function search_client_loan(){
        let valor_input = document.querySelector("#input_cliente").value;
        valor_input = valor_input.trim();
        if(valor_input !== ""){
            let data = new FormData();
            data.append("search_client", valor_input);
            fetch("<?= serverUrl?>/ajax/loanAjax.php",{
                method: 'POST',
                body: data
            }).then(response => response.text())
            .then(response => { 
                let client_table = document.querySelector('#client_table');
                client_table.innerHTML = response;
            });
        }else{
            Swal.fire({
                title: "¡Error!",
                text: "Debes introducir DNI, Nombre, Apellido o Telefono",
                type: "error",
                confirmButtonText: 'Aceptar'
            });
        }
    }

    /* ------- BOTON PARA BUSCAR ITEMS ----------*/
    function search_item_loan(){
        let valor_input = document.querySelector("#input_item").value;
        valor_input = valor_input.trim();
        if(valor_input !== ""){
            let data = new FormData();
            data.append("search_item", valor_input);
            fetch("<?= serverUrl?>/ajax/loanAjax.php",{
                method: 'POST',
                body: data
            }).then(response => response.text())
            .then(response => { 
                let item_table = document.querySelector('#items_table');
                item_table.innerHTML = response;
            });
        }else{
            Swal.fire({
                title: "¡Error!",
                text: "Debes introducir Código o nombre",
                type: "error",
                confirmButtonText: 'Aceptar'
            });
        }
    }


    /* ------- BOTON PARA AGREGAR CLIENTES ----------*/
    function modal_add_client_reservation(id){
        $('#ModalCliente').modal('hide');
        Swal.fire({
            title: '¿Quieres agregar este cliente?',
            text: 'Se va agregar para un prestamo',
            type: 'question',
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
            showCancelButton: true,
            confirmButtonColor: "#237aca",
            cancelButtonColor: "#d33",
        }).then((result) => { 
            if(result.value){
                let data = new FormData();
                data.append("id_client_loan", id);
                fetch("<?= serverUrl ?>/ajax/loanAjax.php",{
                    method: 'POST',
                    body: data
                }).then(response => response.json())
                .then(response => {
                    return ajaxAlert(response);
                });
            }else{
                $('#ModalCliente').modal('show');
            }
        });
    }

    function modal_add_item(id){
        $("#ModalItem").modal('hide');
        $("#ModalAgregarItem").modal('show');
        document.querySelector('id_agregar_item').setAttribute("value", id);
    }

    function modal_search_item(){
        $("#ModalAgregarItem").modal('hide');
        $("#ModalItem").modal('show');
    }


</script>