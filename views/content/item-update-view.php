<?php 
    if($_SESSION['privile_itm'] < 1 || $_SESSION['privile_itm'] > 2){
        $lc->closet_session();
    }
?>

<!-- Page header -->
<div class="full-box page-header">
    <h3 class="text-left">
        <i class="fas fa-sync-alt fa-fw"></i> &nbsp; ACTUALIZAR ITEM
    </h3>
    <p class="text-justify">
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eaque laudantium necessitatibus eius iure adipisci modi distinctio. Earum repellat iste et aut, ullam, animi similique sed soluta tempore cum quis corporis!
    </p>
</div>

<div class="container-fluid">
    <ul class="full-box list-unstyled page-nav-tabs">
        <li>
            <a href="<?= serverUrl ?>item-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR ITEM</a>
        </li>
        <li>
            <a href="<?= serverUrl ?>item-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE ITEMS</a>
        </li>
        <li>
            <a href="<?= serverUrl ?>item-search/"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR ITEM</a>
        </li>
    </ul>
</div>


<!--CONTENT-->
<div class="container-fluid">
    <?php 
        require_once("./controllers/itemController.php");
        $objectItem = new ItemController();

        $data_item = $objectItem -> show_item_controller(1, $lc->decryption($page[1]));
        if ($data_item -> rowCount() == 1){
                $data = $data_item->fetch();

    ?>

    <form action="<?= serverUrl?>ajax/itemAjax.php" class="form-neon ajaxForm" method="POST" data-form="update" autocomplete="off">
        <input type="hidden" class="form-control" value="<?= $page[1]?>" name="id_item_update" id="id_item_update" >
        <fieldset>
            <legend><i class="far fa-plus-square"></i> &nbsp; Información del item</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="item_codigo" class="bmd-label-floating">Códido</label>
                            <input type="text" pattern="[0-9\-]{1,20}" value="<?= $data['item_codigo']?>" class="form-control" name="item_codigo_up" id="item_codigo" maxlength="45">
                        </div>
                    </div>
                    
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="item_nombre" class="bmd-label-floating">Nombre</label>
                            <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}" value="<?= $data['item_nombre']?>" class="form-control" name="item_nombre_up" id="item_nombre" maxlength="140">
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="item_stock" class="bmd-label-floating">Stock</label>
                            <input type="num" pattern="[0-9]{1,9}" value="<?= $data['item_stock']?>" class="form-control" name="item_stock_up" id="item_stock" maxlength="9">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="item_estado" class="bmd-label-floating">Estado</label>
                            <select class="form-control" name="item_estado_up" id="item_estado">
                                <option value="" selected="" disabled="">Seleccione una opción</option>
                                <option value="1" <?= ($data['item_estado'] == '1') ? "selected" : "" ?> >Habilitado</option>
                                <option value="0" <?= ($data['item_estado'] == '0') ? "selected" : "" ?> >Deshabilitado</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="item_detalle" class="bmd-label-floating">Detalle</label>
                            <input type="text" pattern="^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s,.\-#\/]{1,190}$" value="<?= $data['item_detalle']?>" class="form-control" name="item_detalle_up" id="item_detalle" maxlength="190">
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

    <?php } else{ ?>

    <div class="alert alert-danger text-center" role="alert">
        <p><i class="fas fa-exclamation-triangle fa-5x"></i></p>
        <h4 class="alert-heading">¡Ocurrió un error inesperado!</h4>
        <p class="mb-0">Lo sentimos, no podemos mostrar la información solicitada debido a un error.</p>
    </div>
     <?php }  ?>
</div>

