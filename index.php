<?php
    
// Habilitar todos los errores (solo en desarrollo)
    

    require_once("./config/App.php");
    require_once("./controllers/viewController.php");

    $template = new viewController();
    $template -> getTemplateController();