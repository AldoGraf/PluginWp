<?php
/**
 * Plugin name: test Plugin
 * Description: Este es un plugin de pruebita
 *              Para creacion de menu de administrador
 * version 0.0.1
 *
 * @return void
 */

/**
 * Funcion que hará algo cuando el cliente le de a activar plugin desde Wordpress
 *
 * @return void
 */

function Activar()
{
    // Nos permitirá utilizar todas las funciones de la base de datos

    // Creación de tabla Encuestas al momento de activar el Plugin
    global $wpdb;
    $sql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}encuestas (
        EncuestaId INT NOT NULL AUTO_INCREMENT,
        Nombre VARCHAR(45) NULL,
        Shortcode VARCHAR(45) NULL,
        PRIMARY KEY (EncuestaId)
    )";

    $sql2 = "CREATE TABLE IF NOT EXISTS {$wpdb -> prefix}encuestas_detalle(
        detalleId INT NOT NULL AUTO_INCREMENT,
        EncuestaId INT NULL,
        pregunta VARCHAR(150) NULL,
        tipo VARCHAR(45) NULL,
        PRIMARY KEY(detalleId)
    )";
    $sql3 = "CREATE TABLE IF NOT EXISTS {$wpdb -> prefix}encuestas_respuesta(
        respuestaId INT NOT NULL AUTO_INCREMENT,
        detalleId INT NULL,
        respuesta VARCHAR(150) NULL,
        PRIMARY KEY(respuestaId)
    )";
    $wpdb->query($sql);
    $wpdb->query($sql2);
    $wpdb->query($sql3);
}


function Desactivar()
{
    flush_rewrite_rules();
}

register_activation_hook(__FILE__, "Activar");
register_deactivation_hook(__FILE__, "Desactivar");

add_action("admin_menu", "crearMenu");

function crearMenu()
{
    add_menu_page(
        "Super encuestas titulo",      //Titulo de la página
        "Super encuestas menu", //Titulo del menu
        "manage_options", //Capability
        plugin_dir_path(__FILE__) . "lista_encuestas.php", // slug
        null, //Funcion para mostrar el contenido
        plugin_dir_url(__FILE__) . "img/icon.png",
        "1"
    );

    // add_submenu_page(
    //     "sp_menu", //parent slug
    //     "Ajustes", //Titulo menú
    //     "Ajustes", //Titulo página
    //     "manage_options",
    //     "sp_menu_ajustes",
    //     "submenu"
    // );
}

// function submenu(){
//     echo "<h2>Página submenú de ajustes</h2>";
// }

function mostrarContenido()
{
    echo "<h1>Contenido de la página</h1>";
}

//ENCOLAR BOOTSTRAP
function encolarBootstrapCSS($hook) {
    //Para saber ruta del hook
    // echo "<script> console.log(`$hook`)</script>";

    //Evitamos que el plugin sobrecargue la página, haciendo que el bootstrap no se cargue en toda la página
    // sino solo en la página de lista_encuestas
    if($hook != "textPlugin/lista_encuestas.php"){
        return ;
    }
    wp_enqueue_style("bootstrapCSS", plugins_url("bootstrap/css/bootstrap.min.css", __FILE__));
}

add_action("admin_enqueue_scripts", "encolarBootstrapCSS");

function encolarBootstrapJS($hook) {
    //Para saber ruta del hook
    // echo "<script> console.log(`$hook`)</script>";

    //Evitamos que el plugin sobrecargue la página, haciendo que el bootstrap no se cargue en toda la página
    // sino solo en la página de lista_encuestas
    if($hook != "textPlugin/lista_encuestas.php"){
        return ;
    }
    wp_enqueue_script("bootstrapJs", plugins_url("bootstrap/js/bootstrap.min.js", __FILE__), array('jquery'));
}

add_action("admin_enqueue_scripts", "encolarBootstrapJS");

function encolarJs($hook) {
    if($hook != "textPlugin/lista_encuestas.php"){
        return ;
    }
    wp_enqueue_script("JsExterno", plugins_url("js/lista_encuestas.js", __FILE__), array("jquery"));
}
add_action("admin_enqueue_scripts", "encolarJs");


 