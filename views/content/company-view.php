  <!-- Page header -->
<div class="full-box page-header">
    <h3 class="text-left">
        <i class="fas fa-building fa-fw"></i> &nbsp; INFORMACÓN DE LA EMPRESA
    </h3>
    <p class="text-justify">
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Libero nam eaque nostrum, voluptates, rerum quo. Consequuntur ut, maxime? Quibusdam ipsum maxime non veritatis dignissimos qui reiciendis, amet eum nihil! Et!
    </p>
</div>

  <?php 
  require_once "./controllers/companyController.php";
  $obj_company = new  CompanyController();

  $companyData = $obj_company -> select_company_controller();

  if ($companyData -> rowCount() < 1){
  ?>

<!--CONTENT-->
    <div class="container-fluid">
        <form action="<?= serverUrl?>ajax/companyAjax.php" class="form-neon ajaxForm"  method="POST" form-data="save" autocomplete="off">
            <input type="hidden" name="add_company">
            <fieldset>
                <legend><i class="far fa-building"></i> &nbsp; Información de la empresa</legend>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="empresa_nombre" class="bmd-label-floating">Nombre de la empresa</label>
                                <input type="text" pattern="[a-zA-z0-9áéíóúÁÉÍÓÚñÑ. ]{1,70}" class="form-control" name="company_name" id="empresa_nombre" maxlength="70">
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="empresa_email" class="bmd-label-floating">Correo</label>
                                <input type="email" class="form-control" name="company_email" id="empresa_email" maxlength="70">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="empresa_telefono" class="bmd-label-floating">Telefono</label>
                                <input type="text" pattern="[0-9\-]{1,10}" class="form-control" name="company_telefono" id="empresa_telefono" maxlength="20">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="empresa_direccion" class="bmd-label-floating">Dirección</label>
                                <input type="text" pattern="^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s,.\-#\/]{1,190}$" class="form-control" name="company_adress" id="empresa_direccion" maxlength="190">
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
            <br><br><br>
            <p class="text-center" style="margin-top: 40px;">
                <button type="reset" class="btn btn-raised btn-secondary btn-sm"><i class="fas fa-paint-roller"></i> &nbsp; LIMPIAR</button>
                &nbsp; &nbsp;
                <button type="submit" class="btn btn-raised btn-info btn-sm"><i class="far fa-save"></i> &nbsp; GUARDAR</button>
            </p>
        </form>
    </div>
  <?php } else if($companyData -> rowCount() == 1 && ($_SESSION['ITM_PRIVILE'] == 1 || $_SESSION['ITM_PRIVILE'] == 2){ 

        $company = $companyData -> fetch();
    ?>
    <div class="container-fluid">
        <form action="<?= serverUrl?>ajax/companyAjax.php" class="form-neon ajaxForm"  method="POST" form-data="update" autocomplete="off">
            <input type="hidden" name="id_company_update" value="<?= $company['empresa_id']?>" >
            <fieldset>
                <legend><i class="far fa-building"></i> &nbsp;Actualizar Información de la empresa</legend>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="empresa_nombre" class="bmd-label-floating">Nombre de la empresa</label>
                                <input type="text" value="<?= $company['empresa_nombre']?>" pattern="[a-zA-z0-9áéíóúÁÉÍÓÚñÑ. ]{1,70}" class="form-control" name="company_name" id="empresa_nombre" maxlength="70">
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="empresa_email" class="bmd-label-floating">Correo</label>
                                <input type="email" value="<?= $company['empresa_email']?>" class="form-control" name="company_email" id="empresa_email" maxlength="70">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="empresa_telefono" class="bmd-label-floating">Telefono</label>
                                <input type="text" value="<?= $company['empresa_telefono']?>" pattern="[0-9\-]{1,10}" class="form-control" name="company_telefono" id="empresa_telefono" maxlength="20">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="empresa_direccion" class="bmd-label-floating">Dirección</label>
                                <input type="text" value="<?= $company['empresa_direccion']?>" pattern="^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s,.\-#\/]{1,190}$" class="form-control" name="company_adress" id="empresa_direccion" maxlength="190">
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
    </div>
    <?php } else { ?>
    <div class="alert alert-danger text-center" role="alert">
        <p><i class="fas fa-exclamation-triangle fa-5x"></i></p>
        <h4 class="alert-heading">¡Ocurrió un error inesperado!</h4>
        <p class="mb-0">Lo sentimos, no podemos mostrar la información solicitada debido a un error.</p>
    </div>
    <?php }  ?>
