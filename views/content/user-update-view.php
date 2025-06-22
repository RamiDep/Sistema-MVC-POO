<!-- Page header -->
<?php
    if($lc->encryption($_SESSION['id_itm']) != $page[1]){ //Variables que viene de template.php
        if($_SESSION['privile_itm'] != 1){
            echo  $lc->closet_session();
            exit();
        }
    }
?>

<div class="full-box page-header">
    <h3 class="text-left">
        <i class="fas fa-sync-alt fa-fw"></i> &nbsp; ACTUALIZAR USUARIO
    </h3>
    <p class="text-justify">
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Suscipit nostrum rerum animi natus beatae ex. Culpa blanditiis tempore amet alias placeat, obcaecati quaerat ullam, sunt est, odio aut veniam ratione.
    </p>
</div>
<?php  if($_SESSION['privile_itm'] == 1){  ?>
    <div class="container-fluid">
        <ul class="full-box list-unstyled page-nav-tabs">
            <li>
                <a href="<?= serverUrl ?>user-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; NUEVO USUARIO</a>
            </li>
            <li>
                <a href="<?= serverUrl ?>user-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE USUARIOS</a>
            </li>
            <li>
                <a href="<?= serverUrl ?>user-search/"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR USUARIO</a>
            </li>
        </ul>	
    </div>
<?php } ?>


<!-- Content -->
<div class="container-fluid">
    <?php 


        require_once "./controllers/userController.php";
        $object = new UserController();

        $data_user = $object->show_user_controller(1, $lc->decryption($page[1]));
        if($data_user->rowCount() == 1){
            $campos = $data_user->fetch();
    ?>

    <form class="form-neon ajaxForm" action="<?php echo serverUrl;?>ajax/userAjax.php" method="POST" data-form="update" autocomplete="">
        <input type="hidden" name="user_id" value="<?= $page[1]?>">
        <fieldset>
            <legend><i class="far fa-address-card"></i> &nbsp; Información personal</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="usuario_dni" class="bmd-label-floating">DNI</label>
                            <input type="text" 
                                pattern="[0-9\-]{1,20}"
                                class="form-control" 
                                name="usuario_dni_up" 
                                id="usuario_dni"
                                value="<?= $campos['usuario_dni']?>" 
                                maxlength="20">
                        </div>
                    </div>
                    
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="usuario_nombre" class="bmd-label-floating">Nombres</label>
                            <input type="text" 
                                pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}" 
                                class="form-control" 
                                name="usuario_nombre_up" 
                                id="usuario_nombre" 
                                value="<?= $campos['usuario_nombre']?>" 
                                maxlength="35">
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="usuario_apellido" class="bmd-label-floating">Apellidos</label>
                            <input type="text" 
                                pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}" 
                                class="form-control" 
                                name="usuario_apellido_up" 
                                id="usuario_apellido" 
                                value="<?= $campos['usuario_apellido']?>" 
                                maxlength="35">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="usuario_telefono" class="bmd-label-floating">Teléfono</label>
                            <input type="text" 
                                pattern="[0-9\-]{1,10}" 
                                class="form-control" 
                                name="usuario_telefono_up" 
                                id="usuario_telefono" 
                                value="<?= $campos['usuario_telefono']?>" 
                                maxlength="20">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="usuario_direccion" class="bmd-label-floating">Dirección</label>
                            <input type="text" 
                                pattern="^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s,.\-#\/]{1,190}$" 
                                class="form-control" 
                                name="usuario_direccion_up" 
                                id="usuario_direccion" 
                                value="<?= $campos['usuario_direccion']?>" 
                                maxlength="190">
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <br><br><br>
        <fieldset>
            <legend><i class="fas fa-user-lock"></i> &nbsp; Información de la cuenta</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="usuario_usuario" class="bmd-label-floating">Nombre de usuario</label>
                            <input type="text" pattern="[a-zA-Z0-9]{1,35}" 
                            class="form-control"  value="<?= $campos['usuario_usuario']?>"  name="usuario_usuario_up" id="usuario_usuario" maxlength="35">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="usuario_email" class="bmd-label-floating">Email</label>
                            <input type="email" class="form-control" value="<?= $campos['usuario_email']?>" name="usuario_email_up" id="usuario_email" maxlength="70">
                        </div>
                    </div>

                    <?php if($_SESSION['privile_itm'] == 1 && $campos['usuario_id'] != 2){?>
                    <div class="col-12">
                        <div class="form-group">
                            <?php if($campos['usuario_estado'] == 'Activo'){ ?>
                                <span>Estado de la cuenta  &nbsp; <span class="badge badge-info">Activa</span></span>
                                <select class="form-control" name="usuario_estado_up">
                                    <option value="Activa" selected="" >Activa</option>
                                    <option value="Deshabilitada">Deshabilitada</option>
                                </select>
                            <?php }else{ ?>
                                <span>Estado de la cuenta  &nbsp; <span class="badge badge-danger">Inactiva</span></span>
                                <select class="form-control" name="usuario_estado_up">
                                    <option value="Activa">Activa</option>
                                    <option value="Deshabilitada" selected="">Deshabilitada</option>
                                </select>
                            <?php } ?>
                        </div>
                    </div>
                    <?php }?>
                </div>
            </div>
        </fieldset>
        <br><br><br>
        <fieldset>
            <legend style="margin-top: 40px;"><i class="fas fa-lock"></i> &nbsp; Nueva contraseña</legend>
            <p>Para actualizar la contraseña de esta cuenta ingrese una nueva y vuelva a escribirla. En caso que no desee actualizarla debe dejar vacíos los dos campos de las contraseñas.</p>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="usuario_clave_nueva_1" class="bmd-label-floating">Contraseña</label>
                            <input type="password" class="form-control" name="usuario_clave_nueva_1" id="usuario_clave_nueva_1" pattern="[a-zA-Z0-9$@.\-]{7,100}" maxlength="100" >
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="usuario_clave_nueva_2" class="bmd-label-floating">Repetir contraseña</label>
                            <input type="password" class="form-control" name="usuario_clave_nueva_2" id="usuario_clave_nueva_2" pattern="[a-zA-Z0-9$@.\-]{7,100}" maxlength="100" >
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <br><br><br>
        <?php if($_SESSION['privile_itm'] == 1 && $campos['usuario_id'] != 2){ ?>
            <fieldset>
                <legend><i class="fas fa-medal"></i> &nbsp; Nivel de privilegio</legend>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <p><span class="badge badge-info">Control total</span> Permisos para registrar, actualizar y eliminar</p>
                            <p><span class="badge badge-success">Edición</span> Permisos para registrar y actualizar</p>
                            <p><span class="badge badge-dark">Registrar</span> Solo permisos para registrar</p>
                            <div class="form-group">
                                <select class="form-control" name="usuario_privilegio_up">
                                    <option <?php if($campos['usuario_privilegio'] == 1) echo 'selected=""' ?> 
                                        value="1">Control total <?php if($campos['usuario_privilegio'] == 1) echo ' (Actual)'?></option>
                                    <option <?php if($campos['usuario_privilegio'] == 2) echo 'selected=""' ?> 
                                         value="2">Edición <?php if($campos['usuario_privilegio'] == 2) echo ' (Actual)'?></option>
                                    <option <?php if($campos['usuario_privilegio'] == 3) echo 'selected=""' ?> 
                                         value="3">Registrar <?php if($campos['usuario_privilegio'] == 3) echo ' (Actual)'?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
        <?php } ?>
        <br><br><br>
        <fieldset>
            <p class="text-center">Para poder guardar los cambios en esta cuenta debe de ingresar su nombre de usuario y contraseña</p>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="usuario_admin" class="bmd-label-floating">Nombre de usuario</label>
                            <input type="text" pattern="[a-zA-Z0-9]{1,35}" class="form-control" name="usuario_admin" id="usuario_admin" maxlength="35" required="" >
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="clave_admin" class="bmd-label-floating">Contraseña</label>
                            <input type="password" class="form-control" name="clave_admin" id="clave_admin" pattern="[a-zA-Z0-9$@.\-]{7,100}" maxlength="100" required="" >
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>

        <?php if($lc->encryption($_SESSION['id_itm']) != $page[1]){?>
            <input type="hidden" name="type_acount" value="propia">
        <?php }else{?>
            <input type="hidden" name="type_acount" value="inpropia">
        <?php}?>

        <p class="text-center" style="margin-top: 40px;">
            <button type="submit" class="btn btn-raised btn-success btn-sm"><i class="fas fa-sync-alt"></i> &nbsp; ACTUALIZAR</button>
        </p>
    </form>
    <?php }else{?>
    <div class="alert alert-danger text-center" role="alert">
        <p><i class="fas fa-exclamation-triangle fa-5x"></i></p>
        <h4 class="alert-heading">¡Ocurrió un error inesperado!</h4>
        <p class="mb-0">Lo sentimos, no podemos mostrar la información solicitada debido a un error.</p>
    </div>
    <?php } ?>
</div>