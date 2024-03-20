<?php

//NOmbramiento de las varibales a usar para el fichero
global $wpdb;
$tabla = "{$wpdb->prefix}encuestas";
$tabla2  = "{$wpdb->prefix}encuestas_detalle";

//Inserción en la base de datos
if (isset($_POST["btnguardar"])) {
    $preguntas = $_POST["name"];
    $tipos = $_POST["type"];
    $nombre = $_POST["txtnombre"];
    $query = "SELECT EncuestaId FROM $tabla ORDER BY EncuestaId DESC limit 1";
    $resultado = $wpdb->get_results($query, ARRAY_A);
    $proximoId = $resultado[0]["EncuestaId"] + 1;
    $shortcode = "[ENC id='$proximoId']";

    //Datos para la tabla wp_encuestas
    $datos = [
        "EncuestaId" => null,
        "Nombre" => $nombre,
        "Shortcode" => $shortcode
    ];
    $wpdb->insert($tabla, $datos);

    //Añadiendo filas a la tabla wp_encuestas_detalle
    for ($i = 0; $i < count($preguntas); $i++) {
        $datos2 = [
            "detalleId" => null,
            "EncuestaId" => $proximoId,
            "pregunta" => $preguntas[$i],
            "tipo" => $tipos[$i],
        ];
        $wpdb->insert($tabla2, $datos2);
    }
}

//Obtención de los datos de la tabla encuestas
$queryt = "SELECT * FROM $tabla";
$lista_encuestas = $wpdb->get_results($queryt, ARRAY_A);
// print_r($lista_encuestas);
//Para evitar un posible error
if (empty($lista_encuestas)) {
    $lista_encuestas = array();
}

?>
<div class="wrap">
    <?php
    echo "<h1>" . get_admin_page_title() . "</h1>";
    ?>
    <a id="nuevo" class="page-title-action">Añadir nueva</a>
    <br><br><br>
    <table class="wp-list-table widefat fixed striped pages">
        <thead>
            <th>Nombre de la encuesta</td>
            <th>Shortcode</td>
            <th>Acciones</th>
        </thead>
        <tbody id="the-list">
            <?php
            foreach ($lista_encuestas as $value) {
            ?>
                <tr>
                    <td><?php echo $value["Nombre"] ?></td>
                    <td><?php echo $value["Shortcode"] ?></td>
                    <td>
                        <a class="page-title-action">Ver estadísticas</a>
                        <a data-id="<?php echo $value["EncuestaId"]?>" class="page-title-action">Borrar</a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
        </tbody>
    </table>

    <!-- Modal -->
    <div class="modal fade" id="modalnuevo" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Nueva encuesta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="txtnombrelbl" class="col-sm-4 col-form-label">
                                Nombre de la encuesta
                            </label>
                            <div class="col-sm-8">
                                <input type="text" name="txtnombre" id="txtnombre" style="width:100%">
                            </div>
                            <h4>Preguntas</h4>
                            <br>
                            <table id="camposDinamicos">
                                <tr>
                                    <td>
                                        <label for="txtpregunta" class="col-form-label">Pregunta 1</label>
                                    </td>
                                    <td>
                                        <input type="text" name="name[]" id="name" class="form-control name-list">
                                    </td>
                                    <td>
                                        <select name="type[]" id="type" class="form-control type_list">
                                            <option value="1">SI-NO</option>
                                            <option value="2">RANGO 0-5</option>
                                        </select>
                                    </td>
                                    <td>
                                        <button type="button" id="add" name="add" class="btn btn-success">Agregar más</button>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="cerrar" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" name="btnguardar">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>