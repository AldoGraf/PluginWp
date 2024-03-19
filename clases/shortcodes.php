<?php
class CodigoCorto{
    public function obtenerEncuesta($encuestaId){
        global $wpdb;
        $tabla = "{$wpdb -> prefix}encuestas";
        $query = "SELECT * FROM $tabla WHERE EncuestaId = '$encuestaId'";
        $datos = $wpdb -> get_results($query, ARRAY_A);

        if (empty($datos)) {
            $datos = array();
        }

        //Obteniendo directamnete el id
        return $datos[0];
    }

    public function obtenerEncuestaDetalle($encuestaId){
        global $wpdb;
        $tabla = "{$wpdb -> prefix}encuestas_detalle";
        $query = "SELECT * FROM $tabla WHERE EncuestaId = '$encuestaId'";
        $datos = $wpdb -> get_results($query, ARRAY_A);

        if (empty($datos)) {
            $datos = array();
        }
        //Obteniendo directamnete el id
        return $datos[0];
    }

    public function formOpen($title) {
        //Escribiendo aquí el código html
        $html = '
        <div>
        ';
        return $html;
    }
}


