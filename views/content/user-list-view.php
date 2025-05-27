	<!-- Page header -->
<?php
    if($_SESSION['privile_itm'] != 1){
        echo  $lc->closet_session();
        exit();
    }
?>


<div class="full-box page-header">
    <h3 class="text-left">
        <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE USUARIOS
    </h3>
    <p class="text-justify">
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Suscipit nostrum rerum animi natus beatae ex. Culpa blanditiis tempore amet alias placeat, obcaecati quaerat ullam, sunt est, odio aut veniam ratione.
    </p>
</div>

<div class="container-fluid">
    <ul class="full-box list-unstyled page-nav-tabs">
        <li>
            <a href="<?= serverUrl ?>user-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; NUEVO USUARIO</a>
        </li>
        <li>
            <a class="active" href="<?= serverUrl ?>user-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE USUARIOS</a>
        </li>
        <li>
            <a href="<?= serverUrl ?>user-search/"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR USUARIO</a>
        </li>
    </ul>	
</div>

<!-- Content -->
<div class="container-fluid">
   <?php
    require_once "./controllers/userController.php";
    $object_user = new UserController();

    echo $object_user->pager_controller($page[1], 15, $_SESSION['id_itm'], $_SESSION['privile_itm'], $page[0], "");
   ?>
</div>