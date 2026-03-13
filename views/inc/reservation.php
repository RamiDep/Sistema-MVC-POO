<script>
    function validateBtnSearch(){
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
</script>