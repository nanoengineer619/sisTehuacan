var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	});
	//Cargamos los items al select proveedor
	$.post("../ajax/interior.php?op=selectEdificio", function(r){
	            $("#idedificio").html(r);
	            $('#idedificio').selectpicker('refresh');
	});
	
}

//Función limpiar
function limpiar()
{
	$("#idproveedor").val("");
	$("#proveedor").val("");
	$("#serie_comprobante").val("");
	$("#num_comprobante").val("");
	$("#impuesto").val("0");

	$("#total_compra").val("");
	$(".filas").remove();
	$("#total").html("0");
	
	//Obtenemos la fecha actual
	var now = new Date();
	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    $('#fecha_hora').val(today);

    //Marcamos el primer tipo_documento
    $("#tipo_comprobante").val("Boleta");
	$("#tipo_comprobante").selectpicker('refresh');
}

//Función mostrar formulario
function mostrarform(flag)
{
	limpiar();
	if (flag)
	{
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		//$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
		listarDepartamento();

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

//Función Listar
function listar()
{
	tabla=$('#tbllistadoedificio').dataTable(
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
					url: '../ajax/interior.php?op=listar',
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


//Función ListarArticulos
function listarDepartamento()
{
	tabla=$('#tbldepartamentos').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [		          
		            
		        ],
		"ajax":
				{
					url: '../ajax/interior.php?op=listarDepartamento',
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
	//$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/ingreso.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {                    
	          swal(datos);	          
	          mostrarform(false);
	          listar();
	    }

	});
	limpiar();
}

function mostrar(idedificio)
{

	$.post("../ajax/interior.php?op=mostrar",{idedificio : idedificio}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

        $("#idedificio").val(data.idedificio);
		$("#edificioname").val(data.nombre);
		$("#fecha_hora").val(data.condicion);
		

		//Ocultar y mostrar los botones
		$("#btnGuardar").hide();
		$("#btnCancelar").show();
		$("#btnAgregarArt").hide();
		$.post("../ajax/interior.php?op=listarDetalle&id="+idedificio,function(r){
	        $("#detallesdep").html(r);
	});
 	});
}

//Función para anular registros
function anular(idingreso)
{
	swal({   title: "¿Estas Seguro?",   
                    text:"¿Desea anular el Edificio?",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#61ABCE",   
                    confirmButtonText: "Aceptar!",   
                    closeOnConfirm: true},

                    function(isConfirm)
                    {   
                          if (isConfirm) 
                          { 
        	$.post("../ajax/ingreso.php?op=anular", {idingreso : idingreso}, function(e){
        		swal(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

//Declaración de variables necesarias para trabajar con las compras y
//sus detalles
var impuesto=18;
var cont=0;
var detalles=0;
//$("#guardar").hide();
$("#btnGuardar").hide();
$("#tipo_comprobante").change(marcarImpuesto);

function marcarImpuesto()
  {
  	var tipo_comprobante=$("#tipo_comprobante option:selected").text();
  	if (tipo_comprobante=='Factura')
    {
        $("#impuesto").val(impuesto); 
    }
    else
    {
        $("#impuesto").val("0"); 
    }
  }

function agregarDetalle(iddepartamento,nombre,capacidad)
  {
  	var capacidad=1;
    var tiempo_operacion=0;

    if (iddepartamento!="")
    {
    	var subtotal=capacidad*tiempo_operacion;
    	var fila='<tr class="filas" id="fila'+cont+'">'+
    	'<td><a data-toggle="modal" href="#myDep"><button id="btnAgregarDep" type="button" class="btn btn-warning"><span class="fa fa-eye"></span></button></a>&nbsp;<button type="button" class="btn btn-danger" onclick="eliminarDetalle('+cont+')">X</button></td>'+
    	'<td><input type="hidden" name="iddepartamento[]" value="'+iddepartamento+'">'+nombre+'</td>'+
    	'<td><input type="number" step="any" onkeyup="modificarSubototales()" name="capacidad[]" id="capacidad[]" value="'+capacidad+'"></td>'+
    	'<td><input type="number" step="any" onkeyup="modificarSubototales()" name="tiempo_operacion[]" id="tiempo_operacion[]" value="'+tiempo_operacion+'"></td>'+
    	'<td><span name="subtotal" id="subtotal'+cont+'">'+subtotal+'</span> <b>kWh</b></td>';
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
  	var cant = document.getElementsByName("capacidad[]");
    var prec = document.getElementsByName("tiempo_operacion[]");
    var sub = document.getElementsByName("subtotal");

    for (var i = 0; i <cant.length; i++) {
    	var inpC=cant[i];
    	var inpP=prec[i];
    	var inpS=sub[i];

    	inpS.value=inpC.value * inpP.value;
    	document.getElementsByName("subtotal")[i].innerHTML = inpS.value;
    }
    calcularTotales();

  }
  function calcularTotales(){
  	var sub = document.getElementsByName("subtotal");
  	var total = 0.0;

  	for (var i = 0; i <sub.length; i++) {
		total += document.getElementsByName("subtotal")[i].value;
	}
	$("#total").html(total + " <b>kWh</b>");
    $("#total_compra").val(total);
    evaluar();
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