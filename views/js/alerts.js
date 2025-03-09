const ajaxForms = document.querySelectorAll(".ajaxForm");

function sentAjaxForm(e){
    e.preventDefault();
}

ajaxForms.forEach( forms =>{
    forms.addEventListener("submit", sentAjaxForm);
});

function ajaxAlert(alert){
    if(alert.Alert === "simple"){
        Swal.fire({
            title: alerta.Title,
            text: alerta.Text,
            icon: alerta.Type,
            confirmButtonText: 'Aceptar'
          });
    }else if(alert.Alerta ==="Recargar"){
        
    }
}