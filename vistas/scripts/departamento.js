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
	$("#idedificio").val("");
	$("#nombre").val("");

	$("#total_consumo").val("");
	$(".filas").remove();
	$("#total").html("0");

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
		$("#btnagregar").hide();
		$("#btnGuardar").hide();
		$("#btnCancelar").show();
		listarElementos();
		detalles=0;
		$("#btnAgregarArt").show();
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
//Función Listar
function listarElementos()
{
	tabla=$('#tblelementos').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [		          
		            
		        ],
		"ajax":
				{
					url: '../ajax/departamento.php?op=listarElementos',
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
	          listar();
	    }

	});
	limpiar();
}

function mostrar(iddepartamento)
{
	$.post("../ajax/departamento.php?op=mostrar",{iddepartamento : iddepartamento}, function(data, status)
	{
		$.post("../ajax/departamento.php?op=listarDetalle&id="+iddepartamento,function(r){
	        $("#detalles").html(r);
	});
		
		data = JSON.parse(data);
		mostrarform(true);

		
		$("#idedificio").val(data.idedificio);
		$("#idedificio").selectpicker('refresh');
		$("#nombre").val(data.nombre);
		$("#fecha").val(data.fecha);
		$("#total_consumo").val(data.total_consumo);
		$("#total").val(data.total_consumo);
		$("#iddepartamento").val(data.iddepartamento);

		//Ocultar y mostrar los botones
		$("#btnGuardar").hide();
		$("#btnCancelar").show();
		$("#btnAgregarArt").hide();
 	});
 	
}
var cont=0;
var detalles=0;
//$("#guardar").hide();
$("#btnGuardar").hide();
function agregarDetalle(idelemento,nombre)
  {
  	var cantidad=0;
    var potencia_unidad=0;
    var capacidad =0;
    var tiempo_operacion=0;


    if (idelemento!="")
    {
    	var potencia_total=cantidad*potencia_unidad;
    	var subtotal=capacidad * tiempo_operacion;
    	var fila='<tr class="filas" id="fila'+cont+'">'+
    	'<td><button type="button" class="btn btn-danger" onclick="eliminarDetalle('+cont+')">X</button></td>'+
    	'<td><input type="hidden" name="idelemento[]" value="'+idelemento+'">'+nombre+'</td>'+
    	'<td><input type="number" step="any" class="form-control" onkeyup="modificarSubototales()" name="cantidad[]" id="cantidad[]" value="'+cantidad+'"></td>'+
    	'<td><input type="number" step="any" class="form-control" name="funcionando[]" id="funcionando" value=""></td>'+
    	'<td><input type="number" step="any" class="form-control" name="fundidas[]" id="fundidas" value=""></td>'+
    	'<td><input type="number" step="any" class="form-control" onkeyup="modificarSubototales()" name="potencia_unidad[]" id="potencia_unidad" value="'+potencia_unidad+'"></td>'+
    	'<td><input type="number" step="any" readonly="" class="form-control" name="potencia_total[]" id="potencia_total" value=""></td>'+
    	'<td><input type="number" step="any" readonly="" class="form-control" name="capacidad[]" id="capacidad" value=""></td>'+
    	'<td><input type="number" step="any" class="form-control" onkeyup="modificarSubototales()" name="tiempo_operacion[]" id="tiempo_operacion" value=""></td>'+
    	'<td><span name="subtotal" id="subtotal'+cont+'">'+subtotal+'</span><input type="hidden" name="consumo[]" id="consumo"></td>'+
    	'</tr>';
    	cont++;
    	detalles=detalles+1;
    	$('#detalles').append(fila);
    	modificarSubototales();
    }
    else
    {
    	alert("Error al ingresar el detalle, revisar los datos del artículo");
    }
  }
function modificarSubototales()
  {
  	var cant = document.getElementsByName("cantidad[]");
    var prec = document.getElementsByName("potencia_unidad[]");
    var tmp = document.getElementsByName("tiempo_operacion[]");
    var pott= document.getElementsByName("potencia_total[]");
    var capp = document.getElementsByName("capacidad[]");
    var cons = document.getElementsByName("consumo[]");
    var subs = document.getElementsByName("subtotal");

    for (var i = 0; i <cant.length; i++) {
    	var inpC=cant[i];
    	var inpP=prec[i];
    	var tm=tmp[i];
    	var inpS=pott[i];
    	var cap=capp[i];
    	var con=cons[i];
    	var sub=subs[i];

    	inpS.value=inpC.value * inpP.value;
    	cap.value=inpS.value/1000;
    	con.value=cap.value * tm.value;
    	sub.value=cap.value * tm.value;
    	document.getElementsByName("subtotal")[i].innerHTML = con.value;

    }
    calcularTotales();

  }
 function calcularTotales(){
  	var sub = document.getElementsByName("subtotal");
  	var total = 0.0;

  	for (var i = 0; i <sub.length; i++) {
		total += document.getElementsByName("subtotal")[i].value;
	}
	$("#total").html("$ " + total);
    $("#total_consumo").val(total);
    evaluar();
  }

//Función para desactivar registros
function desactivar(iddepartamento)
{
	bootbox.confirm("¿Está Seguro de desactivar eliminar este departamento?", function(result){
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
function evaluar(){
  	if (detalles>0)
    {
      $("#btnGuardar").show();
    }
    else
    {
      $("#btnGuardar").hide(); 
      cont=0;
    }
  }
  
function eliminarDetalle(indice){
  	$("#fila" + indice).remove();
  	calcularTotales();
  	detalles=detalles-1;
  	evaluar();
  }
init();
