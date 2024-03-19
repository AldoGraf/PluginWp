jQuery(document).ready(($) => {
  //Añadiendo funcionalidad al botón de añadir
  $("#nuevo").click(function () {
    $("#modalnuevo").modal("show");
  });
  $("#cerrar").click(() => {
    $("#modalnuevo").modal("hide");
  });
  let i = 1;
  $("#add").click(() => {
    i++;
    $("#camposDinamicos").append(`
        <tr id="row${i}">
            <td>
                <label for="txtpregunta" class="col-form-label">Pregunta ${i}</label>
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
                <button type="button" id="${i}" name="remove" class="btn btn-danger btn_remove" value="${i}">Quitar</button>
            </td>
        </tr>
        `);
  });
  $(document).on("click", ".btn_remove", function () {
    // Elimina la fila más cercana (tr) al botón al que se le dio clic
    $(`#row${$(this).val()}`).remove();
  });

  // Para usar $(this) tenemos que emplear function () {}
  $(document).on("click", "a[data-id]", function () {
    let id = $(this).data("id")
    $.ajax({
      type: "POST",
      url: solicitudesAjax.url,
      data: {
        action: "peticioEliminar",
        nonce: solicitudesAjax.seguridad,
        id: id,
      },
      success: function () {
        location.reload()
      }
    });
  });
});
