var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();
	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);
	})

	//Cargamos los items al select categoria
	$.post("../ajax/departamento.php?op=selectEdificio", function(r){
	            $("#idedificio").html(r);
	            $('#idedificio').selectpicker('refresh');

	});
	$("#imagenmuestra").hide();
}

//Función limpiar
function limpiar()
{
	$("#iddepartamento").val("");
	$("#nombre").val("");
	$("#elemento").val("");
	$("#cantidad").val("");
	$("#potencia").val("");
	$("#potencia_total").val("");
	$("#capacidad").val("");
	$("#funcionando").val("");
	$("#fundidas").val("");
	$("#fecha_hora").val("");
	$("#descripcion").val("");
	$("#idedificio").val("");

	var now = new Date();
	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    $('#fecha_hora').val(today);
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
	tabla=$('#tbldepartamento').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [
		            'copyHtml5',
		            'excelHtml5',
		            'csvHtml5',
		            'pdf'
		        ],
		"ajax":
				{
					url: '../ajax/departamento.php?op=listar',
					type : "get",
					dataType : "json",
					error: function(e){
						console.log(e.responseText);
					}
				},
		"bDestroy": true,
		"iDisplayLength": 5,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}
//Función para guardar o editar

function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/departamento.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {
	          bootbox.alert(datos);
	          mostrarform(false);
	          tabla.ajax.reload();
	    }

	});
	limpiar();
}

function mostrar(iddepartamento)
{
	$.post("../ajax/departamento.php?op=mostrar",{iddepartamento : iddepartamento}, function(data, status)
	{
		data = JSON.parse(data);
		mostrarform(true);

		$("#idedificio").val(data.idedificio);
		$('#idedificio').selectpicker('refresh');
		$("#nombre").val(data.nombre);
		$("#elemento").val(data.elemento);
		$("#cantidad").val(data.cantidada);
		$("#potencia").val(data.potencia);
		$("#potencia_total").val(data.potencia_total);
		$("#capacidad").val(data.capacidad);
		$("#funcionando").val(data.funcionando);
		$("#fundidas").val(data.fundidas);
		$("#fecha_hora").val(data.fecha_hora);
		$("#descripcion").val(data.descripcion);
 		$("#iddepartamento").val(data.iddepartamento);
 	})
}

//Función para desactivar registros
function desactivar(iddepartamento)
{
	bootbox.confirm("¿Está Seguro de desactivar el artículo?", function(result){
		if(result)
        {
        	$.post("../ajax/departamento.php?op=desactivar", {iddepartamento : iddepartamento}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});
        }
	})
}

//Función para activar registros
function activar(iddepartamento)
{
	bootbox.confirm("¿Está Seguro de activar el Artículo?", function(result){
		if(result)
        {
        	$.post("../ajax/departamento.php?op=activar", {iddepartamento : iddepartamento}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});
        }
	})
}
function calcular(){
	var cant=0;
	var  pot =0;
	cant = $("#cantidad").val();
	pot = $("#potencia").val();
	total = cant * pot;
	$("#potencia_total").val(total);
    cpt = total/1000; 
	$("#capacidad").val(cpt);
}
init();
