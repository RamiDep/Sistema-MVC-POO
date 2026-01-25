<!-- Page header -->
<?php
/*error_reporting(E_ALL);
ini_set("display_errors", 1);*/
 
?>

<div class="full-box page-header">
    <h3 class="text-left">
        <i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR ITEM
    </h3>
    <p class="text-justify">
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Harum delectus eos enim numquam fugit optio accusantium, aperiam eius facere architecto facilis quibusdam asperiores veniam omnis saepe est et, quod obcaecati.
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
            <a class="active" href="<?= serverUrl ?>item-search/"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR ITEM</a>
        </li>
    </ul>
</div>

<?php if(!isset($_SESSION['search_items']) && empty($_SESSION['search_items'])) { ?>

<!--CONTENT-->
<div class="container-fluid">
    <form class="form-neon ajaxForm" action="<?= serverUrl ?>ajax/searchAjax.php" method="POST" data-form="default" >
         <input type="hidden" name="modulo" value="items">
        <div class="container-fluid">
            <div class="row justify-content-md-center">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="inputSearch" class="bmd-label-floating">¿Qué item estas buscando?</label>
                        <input type="text" class="form-control" name="search_object" id="item-searched" maxlength="30">
                    </div>
                </div>
                <div class="col-12">
                    <p class="text-center" style="margin-top: 40px;">
                        <button type="submit" class="btn btn-raised btn-info"><i class="fas fa-search"></i> &nbsp; BUSCAR</button>
                    </p>
                </div>
            </div>
        </div>
    </form>
</div>
<?php }else{ ?>

<div class="container-fluid">
    <form class="form-neon ajaxForm" action="<?= serverUrl ?>ajax/searchAjax.php" data-form="delete" method="POST" autocomplete="" >
        <input type="hidden" name="delete_search" value="delete">
        <input type="hidden" name="modulo" value="items">
        <div class="container-fluid">
            <div class="row justify-content-md-center">
                <div class="col-12 col-md-6">
                    <p class="text-center" style="font-size: 20px;">
                        Resultados de la busqueda <strong>“<?= $_SESSION['search_items']?>”</strong>
                    </p>
                </div>
                <div class="col-12">
                    <p class="text-center" style="margin-top: 20px;">
                        <button type="submit" class="btn btn-raised btn-danger"><i class="far fa-trash-alt"></i> &nbsp; ELIMINAR BÚSQUEDA</button>
                    </p>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="container-fluid">
   <?php 
        require_once("./controllers/itemController.php");
        $obj_item = new ItemController();
        echo $obj_item -> pager_item_controller($page[1], 15, $_SESSION['privile_itm'], $page[0], $_SESSION['search_items']);
   ?>
   <?php ?>
</div>
<?php } ?>