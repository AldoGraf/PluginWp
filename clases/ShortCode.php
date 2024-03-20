<?php
class ShortCode
{
    public function obtenerEncuesta($encuestaId)
    {
        global $wpdb;
        $tabla = "{$wpdb->prefix}encuestas";
        $query = "SELECT * FROM $tabla WHERE EncuestaId = '$encuestaId'";
        $datos = $wpdb->get_results($query, ARRAY_A);

        if (empty($datos)) {
            $datos = array();
        }

        //Obteniendo directamnete el id
        return $datos[0];
    }

    public function obtenerEncuestaDetalle($encuestaId)
    {
        $html = '';
        global $wpdb;
        $tabla = "{$wpdb->prefix}encuestas_detalle";
        $query = "SELECT * FROM $tabla WHERE EncuestaId = '$encuestaId'";
        $datos = $wpdb->get_results($query, ARRAY_A);

        if (empty($datos)) {
            $datos = array();
        }
        //Obteniendo directamnete el id
        return $datos;
    }

    public function formOpen($title)
    {
        //Escribiendo aquí el código html
        $html = "
            <div class='wrap'>
                <h4>$title</h4>
                </br>
                <form method='POST'>";
        return $html;
    }

    public function formClose()
    {
        //Escribiendo aquí el código html
        $html = "
            </br>
            <input type='submit' id='botonGuardar' name='botonGuardar' class='page-title-action' value='enviar'>
            </form>
        </div>
        ";
        return $html;
    }
    
    public function formContent($id, $question, $type)
    {
        $html = "";
        if ($type == 1) {
            $html = "
            <div class = 'form-group'>
                <p><b>$question</b></p>
                <div class='col-sm-8'>
                    <select class = 'form-control' id = '$id' name = '$id'>
                        <option value = 'SI'>SI</option>
                        <option value = 'NO'>NO</option>
                    </select>
                </div>
            </div>
                    
            ";
        } elseif ($type == 2) {
        } else {
        }
        return $html;
    }

    public function armado($encuestaId)
    {
        $encuesta = $this->obtenerEncuesta($encuestaId);
        $nombre = $encuesta["Nombre"];
        $preguntas = "";
        $listaPreguntas = $this->obtenerEncuestaDetalle($encuestaId);
        foreach ($listaPreguntas as $key => $value) {
            $detalleId = $value["detalleId"];
            $pregunta = $value["pregunta"];
            $tipo = $value['tipo'];
            $encId = $value['EncuestaId'];
            if ($encId == $encuestaId) {
                $preguntas .= $this->formContent($detalleId, $pregunta, $tipo);
            }
        }

        // Formación del formulario
        $html = $this->formOpen($nombre);
        $html .= $preguntas;
        $html .= $this->formClose();
        return $html;
    }
}
