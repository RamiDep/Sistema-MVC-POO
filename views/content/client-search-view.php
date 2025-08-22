<!-- Page header -->
<div class="full-box page-header">
    <h3 class="text-left">
        <i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR CLIENTE
    </h3>
    <p class="text-justify">
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Suscipit nostrum rerum animi natus beatae ex. Culpa blanditiis tempore amet alias placeat, obcaecati quaerat ullam, sunt est, odio aut veniam ratione.
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
            <a class="active" href="<?= serverUrl ?>client-search/"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR CLIENTE</a>
        </li>
    </ul>	
</div>

<!-- Content here-->
<!--Video 54-->
<?php
if (!isset($_SESSION['search_clients']) && empty($_SESSION['search_clients'])){
?>
<div class="container-fluid">
    <form class="form-neon ajaxForm" action="<?php echo serverUrl;?>ajax/searchAjax.php" method="POST" data-form="default" autocomplete="">
         <input type="hidden" name="modulo" value="clients">
        <div class="container-fluid">
            <div class="row justify-content-md-center">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="inputSearch" class="bmd-label-floating">¿Qué cliente estas buscando?</label>
                        <input type="text" class="form-control" name="search_object" id="inputSearch_user" maxlength="30">                    </div>
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
<?php
}else{
?>

<div class="container-fluid">
    <form class="form-neon ajaxForm" action="<?php echo serverUrl;?>ajax/searchAjax.php" method="POST" data-form="search" autocomplete="">
        <input type="hidden" name="delete_search" value="delete">
        <input type="hidden" name="modulo" value="clients">
        <div class="container-fluid">
            <div class="row justify-content-md-center">
                <div class="col-12 col-md-6">
                    <p class="text-center" style="font-size: 20px;">
                        Resultados de la busqueda <strong>“<?php echo $_SESSION['search_clients']?>”</strong>
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
        <?php /* Video 47  */
            require_once "./controllers/clientController.php";
            $object_client = new ClientController();
            echo $object_client->pager_client_controller($page[1], 15, $_SESSION['privile_itm'], $page[0], $_SESSION['search_clients']);
        ?>
    </div>
<?php
}
?>
<!--Video 54 FIN-->