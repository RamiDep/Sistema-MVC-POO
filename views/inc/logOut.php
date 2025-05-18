<script>

    let buttonLogOut = document.querySelector(".btn-exit-system");

    buttonLogOut.addEventListener('click', function(event){
        // event.preventDefault();
        Swal.fire({
			title: '¿Queres cerrar session?',
			text: "Cerraras el acceso de todas las paginas",
			type: 'question',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Si, salir!',
			cancelButtonText: 'No, cancelar'
		}).then((result) => {
			if (result.value) {
				let url = '<?php echo serverUrl;?>ajax/loginAjax.php';
				let user = '<?php echo  $lc->encryption($_SESSION['user_itm']);?>';
				let token = '<?php  echo $lc->encryption($_SESSION['token_itm']);?>';

				let data = new FormData();
				data.append("token",token);
				data.append("user",user);

				fetch(url, {
					method: 'POST',
					body: data
				})
				.then(response => response.json())
				.then(response => {
					return ajaxAlert(response);
				});

				
			}
		});
    });


</script>