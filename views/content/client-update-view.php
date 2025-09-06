<!-- Page header -->
<?php 
    if($_SESSION['privile_itm'] < 1 || $_SESSION['privile_itm'] > 2){
        $lc->closet_session();
    }
    
?>

<?php ?>

<div class="full-box page-header">
    <h3 class="text-left">
        <i class="fas fa-sync-alt fa-fw"></i> &nbsp; ACTUALIZAR CLIENTE
    </h3>
    <p class="text-justify">
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem odit amet asperiores quis minus, dolorem repellendus optio doloremque error a omnis soluta quae magnam dignissimos, ipsam, temporibus sequi, commodi accusantium!
    </p>
</div>

<div class="container-fluid">
    <ul class="full-box list-unstyled page-nav-tabs">
        <li>
            <a href="<?= serverUrl ?>client-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR CLIENTE</a>
        </li>
        <li>
            <a href="<?= serverUrl ?>client-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE CLIENTES</a>
        </li>
        <li>
            <a href="<?= serverUrl ?>client-search/"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR CLIENTE</a>
        </li>
    </ul>	
</div>

<!-- Content here-->
<div class="container-fluid">
    <?php 
        require_once "./controllers/clientController.php";
        $object_client = new ClientController();

        $data_client = $object_client->show_client_controller(1, $lc->decryption($page[1]));

        if ($data_client -> rowCount() == 1){
            $data = $data_client->fetch();
    ?>
    <form action="<?php echo serverUrl;?>ajax/clientAjax.php" class="form-neon ajaxForm" autocomplete="off" data-form="update">
        <input type="hidden" name="id_client_update" value="">
        <fieldset>
            <legend><i class="fas fa-user"></i> &nbsp; Información básica</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="cliente_dni" class="bmd-label-floating">DNI</label>
                            <input type="text"  pattern="[0-9-]{1,27}" value="<?= $data['cliente_dni'] ?>" class="form-control" name="cliente_dni_up" id="cliente_dni" maxlength="27">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="cliente_nombre" class="bmd-label-floating">Nombre</label>
                            <input type="text" value="<?= $data['cliente_nombre'] ?>" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,40}" class="form-control" name="cliente_nombre_up" id="cliente_nombre" maxlength="40">
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="cliente_apellido" class="bmd-label-floating">Apellido</label>
                            <input type="text" value="<?= $data['cliente_apellido'] ?>" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,40}" class="form-control" name="cliente_apellido_up" id="cliente_apellido" maxlength="40">
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="cliente_telefono" class="bmd-label-floating">Teléfono</label>
                            <input type="text" value="<?= $data['cliente_telefono'] ?>" pattern="[0-9()+]{8,20}" class="form-control" name="cliente_telefono_up" id="cliente_telefono" maxlength="20">
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="cliente_direccion" class="bmd-label-floating">Dirección</label>
                            <input type="text" value="<?= $data['cliente_direccion'] ?>" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,150}" class="form-control" name="cliente_direccion_up" id="cliente_direccion" maxlength="150">
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <br><br><br>
        <p class="text-center" style="margin-top: 40px;">
            <button type="submit" class="btn btn-raised btn-success btn-sm"><i class="fas fa-sync-alt"></i> &nbsp; ACTUALIZAR</button>
        </p>
    </form>
        <?php }else{ ?>
    <div class="alert alert-danger text-center" role="alert">
        <p><i class="fas fa-exclamation-triangle fa-5x"></i></p>
        <h4 class="alert-heading">¡Ocurrió un error inesperado!</h4>
        <p class="mb-0">Lo sentimos, no podemos mostrar la información solicitada debido a un error.</p>
    </div>
          <?php } ?>
</div>	