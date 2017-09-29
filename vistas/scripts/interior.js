var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();
	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);
	});
	$("#form-elements").on("submit",function(e)
	{
		guardarelementos(e);
	})

	//Cargamos los items al select categoria
	$.post("../ajax/interior.php?op=selectEdificio", function(r){
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
	$("#totalmes").html("0");
	$("#totalsem").html("0");

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
		//listarElementos();
		listarDepartamentos();
		detalles=0;
		$("#btnAgregarArt").show();
	}
	else
	{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").hide();
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
	tabla=$('#tbledificioD').dataTable(
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
//Función Listar Departamentos
function listarDepartamentos()
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
//Función Listar 
function listarElementos(iddepartamento)
{
	$.post("../ajax/interior.php?op=listarElementos&id="+iddepartamento,function(r){
	        $("#tblelementos").html(r);
	    });
}	
//Función para guardar o editar

function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/interior.php?op=guardaryeditar",
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
function guardarelementos(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento

	var formData = new FormData($("#form-elements")[0]);

	$.ajax({
		url: "../ajax/interior.php?op=guardarelementos",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {
	          bootbox.alert(datos);
	          listar();
	    }

	});
	limpiar();
}
function mostrar(idedificio,idinterior)
{
	$.post("../ajax/interior.php?op=mostrar",{idinterior : idinterior}, function(data, status)
	{
		data = JSON.parse(data);
		mostrarform(true);

		
		$("#idedificio").val(data.idedificio);
		$("#nombre").val(data.nombre);
		$("#idinterior").val(data.idinterior);
		$("#estado").val(data.estado);
		$("#total_con").val(data.consumo_total);
		//Ocultar y mostrar los botones
		$("#btnGuardar").hide();
		$("#btnCancelar").show();
		$("#btnAgregarArt").show();


		$.post("../ajax/interior.php?op=listarDetalle&id="+idinterior,function(r){
	        $("#detallesdep").html(r);
	    });

 	});
 	
}
var cont=0;
var detalles=0;
//$("#guardar").hide();
$("#btnGuardar").hide();
function agregarDetalle(iddepartamento,nombre,total_consumo)
  {
  	verificarDep(iddepartamento);
  	
    if (iddepartamento!="")
    {
    	
    	var consumo_mensual=total_consumo* 4;
    	var consumo_semestral=total_consumo * 24;
    	var subtotal =subtotal;
    	var fila='<tr class="filas" id="fila'+cont+'">'+
    	'<td><button type="button" class="btn btn-danger" onclick="eliminarDetalle('+cont+')" title="Eliminar"><i class="fa fa-trash"></i></button></td>'+
    	'<td><input type="hidden" name="iddepartamento[]" value="'+iddepartamento+'">'+nombre+'</td>'+
    	'<td><input type="number" step="any" class="form-control" readonly name="consumo_semanal[]" id="consumo_semanal[]" value="'+total_consumo+'"></td>'+
    	'<td><input type="number" step="any" class="form-control" readonly name="consumo_mensual[]" id="consumo_mensual" value="'+consumo_mensual+'"></td>'+
    	'<td><input type="number" step="any" class="form-control" readonly name="consumo_semestral[]" id="consumo_semestral" value="'+consumo_semestral+'"></td>'+
    	'<td><span style="display:none;" name="subtotal" id="subtotal'+cont+'">'+subtotal+'</span></td>'+
    	'</tr>';
    	cont++;
    	detalles=detalles+1;
    	$('#detallesdep').append(fila);
    	modificarSubototales();
    	
    }
    else
    {
    	alert("Error al ingresar el detalle, revisar los datos del Departamento");
    }
  }
  function verificarDep(iddepartamento){
  	var idd = document.getElementsByName("iddepartamento[]");
  	var aidd = document.getElementsByName("iddepart[]");
     for(i=0;i<idd.length;i++)
	{
		if((iddepartamento)==idd[i].value)
    	{
    		swal("El Departamento ya está Agregado");
    		exit();
    	}

	}
	for(i=0;i<aidd.length;i++)
	{
		if((iddepartamento)==aidd[i].value)
    	{
    		swal("El Departamento ya está Agregado");
    		exit();
    	}
    	
	}
  }
function modificarSubototales()
  {
  	var cant = document.getElementsByName("consumo_semanal[]");
    var subs = document.getElementsByName("subtotal");

    for (var i = 0; i <cant.length; i++) {
    	var inpC=cant[i];
    	var sub=subs[i];

    	sub.value=inpC.value;

    	document.getElementsByName("subtotal")[i].innerHTML = sub.value;

    }
    calcularTotales();

  }
 function calcularTotales(){
  	var sub = document.getElementsByName("subtotal");
  	var comp = $("#estado").val();
    var ntc=0.0;
  	var total = 0.0;
  	var mens=0.0;
  	var sems=0.0;

  	for (var i = 0; i <sub.length; i++) {

		total += parseFloat(document.getElementsByName("subtotal")[i].value);
		mens =(parseFloat(total) * 4);
		sems =(parseFloat(total) * 24);
	}
  // -----------------------------------------

    if(comp!=0)
	{
		var nt = document.getElementById("total_con").value;
		ntc=(parseFloat(total) + parseFloat(nt));
		mens=(parseFloat(ntc) * 4);
		sems =(parseFloat(ntc) * 24);

	  	$("#totalss").html("KW " + ntc);
		$("#totalmess").html("KW " + mens);
		$("#totalsemm").html("KW " + sems);
	    $("#total_consumo").val(ntc);
	    evaluar();
	}
	else
	{
        $("#totalss").html("KW " + total);
		$("#totalmess").html("KW " + mens);
		$("#totalsemm").html("KW " + sems);
	    $("#total_consumo").val(total);
	    evaluar();
	}
  //------------------------------------------
	
  }

//Función para desactivar registros
function desactivar(iddepartamento)
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
        	$.post("../ajax/interior.php?op=desactivar", {iddepartamento : iddepartamento}, function(e){
        		swal(e);
	            tabla.ajax.reload();
        	});
        }
	})
}

//Función para activar registros
function activar(iddepartamento)
{
	swal({   title: "¿Estas Seguro?",   
                    text:"¿Desea desactivar el Departamento?",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#61ABCE",   
                    confirmButtonText: "Aceptar!",   
                    closeOnConfirm: true},

                    function(isConfirm)
                    {   
                          if (isConfirm) 
                          { 
        	$.post("../ajax/interior.php?op=activar", {iddepartamento : iddepartamento}, function(e){
        		swal(e);
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
