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
	$.post("../ajax/elemento.php?op=selectEdificio", function(r){
	            $("#idedificio").html(r);
	            $('#idedificio').selectpicker('refresh');

	});

	$.post("../ajax/elemento.php?op=selectDepartamento", function(d){
	            $("#departamen").html(d);
	            $('#departamen').selectpicker('refresh');

	});
	$("#imagenmuestra").hide();
}

//Función limpiar
function limpiar()
{
	$("#idelemento").val("");
	$("#nombre").val("");

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
		$("#btnagregar").hide();
		$("#btnCancelar").show();
	}
	else
	{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
		$("#btnCancelar").hide();
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
					url: '../ajax/elemento.php?op=listar',
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
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/elemento.php?op=guardaryeditar",
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

function mostrar(idelemento)
{
	$.post("../ajax/elemento.php?op=mostrar",{idelemento : idelemento}, function(data, status)
	{
		data = JSON.parse(data);
		 mostrarform(true);
		$("#idelemento").val(data.idelemento);
		$("#nombre").val(data.nombre);
 	})
}

//Función para desactivar registros
function desactivar(idelemento)
{
	bootbox.confirm("¿Está Seguro de desactivar eliminar este departamento?", function(result){
		if(result)
        {
        	$.post("../ajax/elemento.php?op=desactivar", {idelemento : idelemento}, function(e){
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
        	$.post("../ajax/elemento.php?op=activar", {iddepartamento : iddepartamento}, function(e){
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
