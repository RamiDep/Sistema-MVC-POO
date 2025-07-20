
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <title><?= company  ?></title>
    
        <?php include("./views/inc/links.php") ?>
    </head>
    <body>
    <?php   
        $ajaxRequest = false;
        require_once("./controllers/viewController.php");

        $objView = new viewController();
        $view = $objView->getViewsController();

        if ($view == "login" || $view == "404"){
            require_once("./views/content/".$view."-view.php");
        }else{
            session_start(['name'=>'ITM']);

            $page = explode("/", $_GET['views']);

            require_once "./controllers/loginController.php";
            $lc = new LoginController();

            if(!isset($_SESSION['id_itm']) || !isset($_SESSION['user_itm']) || !isset($_SESSION['privile_itm']) || !isset($_SESSION['token_itm'])){
                echo  $lc->closet_session();
                exit();
            }
             
    ?>    
            <!-- Main container -->
            <main class="full-box main-container">
                <!-- Nav lateral -->
            <?php include("./views/inc/navLateral.php") ?>
        
                <!-- Page content -->
                <section class="full-box page-content">
                    <?php 
                    include("./views/inc/navBar.php");
                    include $view; 
                    ?>

                    
        
                </section>
            </main>
            
        <!--=============================================
        =            Include JavaScript files           =
        ==============================================-->
        <?php
            include("./views/inc/logOut.php");
            } 
            include("./views/inc/scripts.php"); ?>
    </body>
    </html>
