var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listarElementos();
	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);
	})

	//Cargamos los items al select categoria
	$.post("../ajax/departamento.php?op=selectEdificio", function(r){
	            $("#idedificio").html(r);
	            $('#idedificio').selectpicker('refresh');

	});

	$.post("../ajax/departamento.php?op=selectDepartamento", function(d){
	            $("#departamen").html(d);
	            $('#departamen').selectpicker('refresh');

	});
	$("#imagenmuestra").hide();
}

//Función limpiar
function limpiar()
{
	$("#iddepartamento").val("");
	$("#departamen").val("");
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
		$("#btnagregar").hide();
		$("#btnGuardar").hide();
		$("#btnCancelar").show();
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
	tabla=$('#tbllistado').dataTable(
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
					url: '../ajax/ingreso.php?op=listar',
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
		$("#departamen").val(data.nombre);
		$('#departamen').selectpicker('refresh');
		$("#elemento").val(data.elemento);
		$("#cantidad").val(data.cantidad);
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
var cont=0;
var detalles=0;
//$("#guardar").hide();
$("#btnGuardar").hide();
function agregarDetalle(idelemento,nombre)
  {
  	var cantidad=1;
    var potencia_unidad=1;


    if (idelemento!="")
    {
    	var potencia_total=cantidad*potencia_unidad;
    	var consumo=1;
    	var fila='<tr class="filas" id="fila'+cont+'">'+
    	'<td><button type="button" class="btn btn-danger" onclick="eliminarDetalle('+cont+')">X</button></td>'+
    	'<td><input type="hidden" name="idelemento" value="'+idelemento+'">'+nombre+'</td>'+
    	'<td><input type="number" class="form-control" onkeyup="modificarSubototales()" name="cantidad[]" id="cantidad[]" value="'+cantidad+'"></td>'+
    	'<td><input type="number" class="form-control" name="funcionando[]" id="funcionando[]" value=""></td>'+
    	'<td><input type="number" class="form-control" name="fundidas[]" id="fundidas[]" value=""></td>'+
    	'<td><input type="number" class="form-control" onkeyup="modificarSubototales()" name="potencia_unidad[]" id="potencia_unidad[]" value="'+potencia_unidad+'"></td>'+
    	'<td><input type="number" readonly="" class="form-control" name="potencia_total" id="potencia_total" value=""></td>'+
    	'<td><input type="number" readonly="" class="form-control" name="capacidad" id="capacidad" value=""></td>'+
    	'<td><input type="number" class="form-control" onkeyup="modificarSubototales()" name="tiempo_operacion[]" id="tiempo_operacion[]" value=""></td>'+
    	'<td><span name="consumo" id="consumo'+cont+'">'+consumo+'</span></td>'+
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
    var pott= document.getElementsByName("potencia_total");
    var capp = document.getElementsByName("capacidad");
    var cons = document.getElementsByName("consumo");

    for (var i = 0; i <cant.length; i++) {
    	var inpC=cant[i];
    	var inpP=prec[i];
    	var tm=tmp[i];
    	var inpS=pott[i];
    	var cap=capp[i];
    	var con=cons[i];

    	inpS.value=inpC.value * inpP.value;
    	cap.value=inpS.value/1000;
    	con.value=cap.value * tm.value;
    	document.getElementsByName("potencia_total")[i].innerHTML = inpS.value;
    	document.getElementsByName("capacidad")[i].innerHTML = cap.value;
    	document.getElementsByName("consumo")[i].innerHTML = con.value;

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
    $("#total_compra").val(total);
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
function calcular(){
	var cant=0;
	var  pot =0;
	cant = $("#cantidad[]").val();
	pot = $("#potencia_unidad[]").val();
	total = cant * pot;
	alert(total);
	$("#potencia_total[]").val(total);
    cpt = total/1000; 
	$("#capacidad[]").val(cpt);
}
function eliminarDetalle(indice){
  	$("#fila" + indice).remove();
  	calcularTotales();
  	detalles=detalles-1;
  	evaluar();
  }
init();
