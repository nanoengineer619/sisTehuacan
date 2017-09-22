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
	$("#nombre").val("");
	$("#cantidad").val("");
	$("#potencia").val("");
	$("#potencia_total").val("");
	$("#capacidad").val("");
	$("#tiempo_operacion").val("");
	$("#consumo").val("");
	$("#funcionando").val("");
	$("#fundidas").val("");
	$("#fecha").val("");
	$("#descripcion").val("");
	$("#idexterior").val("");

	var now = new Date();
	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
		$('#fecha').val(today);
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
	tabla=$('#exterior').dataTable(
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
					url: '../ajax/exterior.php?op=listar',
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
		url: "../ajax/exterior.php?op=guardaryeditar",
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

function mostrar(idexterior)
{
	$.post("../ajax/exterior.php?op=mostrar",{idexterior : idexterior}, function(data, status)
	{
		data = JSON.parse(data);
		mostrarform(true);

		$("#nombre").val(data.nombre);
		$("#cantidad").val(data.cantidada);
		$("#potencia").val(data.potencia);
		$("#potencia_total").val(data.potencia_total);
		$("#capacidad").val(data.capacidad);
    $("#tiempo_operacion").val(data.tiempo_operacion);
		$("#consumo").val(data.consumo);
		$("#funcionando").val(data.funcionando);
		$("#fundidas").val(data.fundidas);
		$("#fecha").val(data.fecha);
 		$("#descripcion").val(data.descripcion);
		$("#idexterior").val(data.idedificio);

 	})
}

//Función para desactivar registros
function desactivar(idexterior)
{
	bootbox.confirm("¿Está Seguro de desactivar el exterior?", function(result){
		if(result)
        {
        	$.post("../ajax/exterior.php?op=desactivar", {idexterior : idexterior}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});
        }
	})
}

//Función para activar registros
function activar(idexterior)
{
	bootbox.confirm("¿Está Seguro de activar el Exterior?", function(result){
		if(result)
        {
        	$.post("../ajax/exterior.php?op=activar", {idexterior : idexterior}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});
        }
	})
}

function calcular(){
	var cant=0;
	var  pot =0;
	cant = $("#funcionando").val();
	pot = $("#potencia").val();
	total = pot * cant;
	$("#potencia_total").val(total);
    cpt = total/1000;
	$("#capacidad").val(cpt);
}
init();
