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
	$("#idexterior").val("");
	$("#nombre").val("");
	$("#cantidad").val("");
	$("#funcionando").val("");
	$("#potencia_unidad").val("");
	$("#instalada_watts").val("");
	$("#instalada_kw").val("");
	$("#t_operacion_sem").val("");
	$("#cons_semana").val("");
	$("#t_op_mensual").val("");
	$("#cons_mes").val("");
	$("#cons_semestre").val("");
	$("#fundidas").val("");
	$("#fecha").val("");

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
		"iDisplayLength": 7,//Paginación
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
		$("#idexterior").val(data.idexterior);
		$("#nombre").val(data.nombre);
		$("#cantidad").val(data.cantidad);
		$("#funcionando").val(date.funcionando);
		$("#instalada_watts").val(data.instalada_watts);
		$("#cons_semana").val(data.cons_semana);
		$("#cons_mes").val(data.cons_mes);
		$("#cons_semestre").val(data.cons_semestre);
		$("#fecha").val(data.fecha);
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
	var t_ope_semanal = 0;
	cant = $("#funcionando").val();
	pot = $("#potencia_unidad").val();

	total = pot * cant;
	$("#instalada_watts").val(total);
    cpt = total/1000;
	$("#instalada_kw").val(cpt);
		//Sacar el consumo semanal
	t_ope_semanal = $("#t_operacion_sem").val();
	consumoSemanal = cpt * t_ope_semanal;
	$("#cons_semana").val(consumoSemanal);
		//Sacar tipo de operacion mensual
	t_op_semanal = t_ope_semanal * 4;
	$("#t_op_mensual").val(t_op_semanal);
	//Sacar el consumo mensual
consumoMensual = consumoSemanal * 4;
$("#cons_mes").val(consumoMensual);
//Sacar el consumo semestral
consumoSemestral = consumoMensual * 6;
$("#cons_semestre").val(consumoSemestral);
}
init();
