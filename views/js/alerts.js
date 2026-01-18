const ajaxForms = document.querySelectorAll(".ajaxForm"); // todos los formularios van a llevar el nombre de esta clase

function sentAjaxForm(e){
    e.preventDefault();

    let data = new FormData(this); //datos de formulario
    let type = this.getAttribute("data-form");
    let method = this.getAttribute("method");
    let action = this.getAttribute("action");
    let alertText = "";
    let header = new Headers();

    let config = {
      method: method,
      headers: header,
      mode: 'cors',
      cache: 'no-cache',
      body: data 
    }

   

    if(type ==="save"){
      alertText = "Los datos quedaran guardados en el sistema";
    }else if(type ==="delete"){
      alertText = "Los datos se eliminaran del sistema";
    }else if(type ==="update"){
      alertText = "Los datos se modificaran del sistema";
    }else if(type ==="search"){
      alertText = "Se eliminara el termino de busqueda del sistema";
    }else if(type ==="loans"){
      alertText = "Desea remover los datos seleccionados para prestamos o reservaciones";
    }else{
      alertText = "Quieres realizar la operacion solicitada";
    }

    Swal.fire({
      title: '¿Estas seguro?',
      text: alertText,
      type: 'question',
      confirmButtonText: 'Aceptar',
      cancelButtonText: 'Cancelar',
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
    }).then((result) => { 
      if (result.value) {
        fetch(action,config)
        .then(response => response.json())
        .then(response => {
          return ajaxAlert(response);
        });
      }
    });
}

ajaxForms.forEach( forms => {
    forms.addEventListener("submit", sentAjaxForm);
});

function ajaxAlert(alert){
    if(alert.Alerta === "simple"){
      Swal.fire({
        title: alert.Title,
        text: alert.Text,
        type: alert.Type,
        confirmButtonText: 'Aceptar'
      });
    }else if(alert.Alerta === "recargar"){
      Swal.fire({
        title: alert.Title,
        text: alert.Text,
        type: alert.Type,
        confirmButtonText: 'Aceptar'
      }).then((result) => {
        if (result.value === true) {
          location.reload();
        }
      });
    }else if(alert.Alerta === "limpiar"){
        Swal.fire({
            title: alert.Title,
            text: alert.Text,
            type: alert.Type,
            confirmButtonText: 'Aceptar'
          }).then((result) => {
            if (result.isConfirmed) {
              document.querySelector(".ajaxForm").reset();
            }
          });
    }else if(alert.Alerta ==="redireccionar"){
        window.location.href=alert.URL;
    }
}