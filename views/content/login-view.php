<div class="login-container">
    <div class="login-content">
        <p class="text-center">
            <i class="fas fa-user-circle fa-5x"></i>
        </p>
        <p class="text-center">
            Inicia sesión con tu cuenta
        </p>
        <form action="" method="POST" autocomplete="off" >
            <div class="form-group">
                <label for="UserName" class="bmd-label-floating"><i class="fas fa-user-secret"></i> &nbsp; Usuario</label>
                <input type="text" class="form-control" id="userName" name="userName" pattern="[a-zA-Z0-9]{1,35}" maxlength="35" required="" >
            </div>
            <div class="form-group">
                <label for="UserPassword" class="bmd-label-floating"><i class="fas fa-key"></i> &nbsp; Contraseña</label>
                <input type="password" class="form-control" id="userPassword" name="userPassword" pattern="[a-zA-Z0-9$@.\-]{7,100}" maxlength="100" required="" >
            </div>
            <button type="submit" class="btn-login text-center">LOG IN</button>
        </form>
    </div>
</div>

<?php
    if(isset($_POST['userName']) && isset($_POST['userPassword'])){
        require_once "./controllers/loginController.php";
        $objLogin = new LoginController();
        echo $objLogin->session_start_controller();
    }
?>