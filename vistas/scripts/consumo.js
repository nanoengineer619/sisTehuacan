var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);
	})
}

//Función limpiar
function limpiar()
{
	$("#idedificio").val("");
	$("#nombre").val("");
}

//Función mostrar formulario
function mostrarform(flag)
{
	limpiar();
	if (flag)
	{
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
	}
	else
	{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}

//Función cancelarform
function cancelarform()
{
	limpiar();
	mostrarform(false);
}

//Función Listar
function listar()
{
	$.post("../ajax/consumo.php?op=listar", function(r){
	        $("#tblconsumo").html(r);
	    });
}
//Función para guardar o editar

function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/consumo.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {
	          swal(datos);
	          mostrarform(false);
	          tabla.ajax.reload();
	    }

	});
	limpiar();
}

function mostrar(idedificio)
{
	$.post("../ajax/consumo.php?op=mostrar",{idedificio : idedificio}, function(data, status)
	{
		data = JSON.parse(data);
		mostrarform(true);

		$("#nombre").val(data.nombre);
 		$("#idedificio").val(data.idedificio);

 	})
}

//Función para desactivar registros
function desactivar(idedificio)
{
	swal({   title: "¿Estas Seguro?",   
                    text:"¿Desea desactivar el Edificio?",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#61ABCE",   
                    confirmButtonText: "Aceptar!",   
                    closeOnConfirm: true},

                    function(isConfirm)
                    {   
                          if (isConfirm) 
                          { 
				        	$.post("../ajax/consumo.php?op=desactivar", {idedificio : idedificio}, function(e){
				        		swal(e);
					            tabla.ajax.reload();
        	                 });
                          }
	               })
}

//Función para activar registros
function activar(idedificio)
{
	swal({   title: "¿Estas Seguro?",   
                    text:"¿Desea Activar el Edificio?",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#61ABCE",   
                    confirmButtonText: "Aceptar!",   
                    closeOnConfirm: true},

                    function(isConfirm)
                    {   
                          if (isConfirm) 
                          {   
				        	$.post("../ajax/consumo.php?op=activar", {idedificio : idedificio}, function(e){
				        		swal(e);
					            tabla.ajax.reload();
        	});
        }
	})
}


init();
