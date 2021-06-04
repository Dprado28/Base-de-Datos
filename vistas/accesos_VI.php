<?php
class accesos_VI
{
    function __construct(){}

    function formularioInicioSesion()
    {
        ?>
        <!DOCTYPE html>
          <html>
          <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <title>Clinica Veterinaria</title>
            <!-- Tell the browser to be responsive to screen width -->
            <meta name="viewport" content="width=device-width, initial-scale=1">

            <!-- Font Awesome -->
            <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
            <!-- Ionicons -->
            <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
            <!-- icheck bootstrap -->
            <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
            <!-- Theme style -->
            <link rel="stylesheet" href="dist/css/adminlte.min.css">
            <!-- Google Font: Source Sans Pro -->
            <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
          </head>
          <body class="hold-transition login-page">
        <?php
        if(isset($_GET["error"]))
        {
            $error=$_GET["error"];
            $usuario=$_GET["usuario"];
            
            echo "<span style='color:red;'>".$error."</span><br><br>";
        }
        ?>
        <div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html"><b>Clinica Veterinaria</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Completa los campos para iniciar sesión</p>

      <form method="post">
        <div class="input-group mb-3">
          <input type="text" name="usuario" class="form-control" placeholder="Usuario"  value="<?php if(isset($usuario)){echo $usuario;}?>">
          <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-user-circle"></span>            
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="clave" class="form-control" placeholder="Contraseña">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- /.col -->
          <div class="col-12">
            <input type="submit" class="btn btn-primary btn-block"  value="Iniciar Sesi&oacute;n">
          </div>
          <!-- /.col -->
        </div>
      </form>

      
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

</body>
</html>
        <?php
    }

    function listar()
    {
        require_once "modelos/accesos_MO.php";

        $conexion=new servidor('A');
        $accesos_MO=new accesos_MO($conexion);

        $arreglo_accesos=$accesos_MO->seleccionarMascota();
        ?>
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Mascotas Registradas en el Sistema</h3>
                <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#ventana_modal" onclick="vistaAgregarAccesos()">
                <i class="far fa-plus-square"></i> Agregar
                </button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="listar_accesos" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Nombre Mascota</th>
                    <th>Tipo de Animal</th>
                    <th>Raza</th>
                    <th>Dueño</th>
                    <th style="text-align:center;">Acci&oacute;n</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                  if($arreglo_accesos)
                  {
                      foreach($arreglo_accesos as $objeto_accesos)
                      {
                          $nombre_mascota=$objeto_accesos->nombre_mascota;
                          $nombre_t_m=$objeto_accesos->nombre_t_m;
                          $nombre_raza=$objeto_accesos->nombre_raza;
                          $nombre_cliente=$objeto_accesos->nombre_cliente;
                          
                          $id_mascota=$objeto_accesos->id_mascota;
                          /*
                          $activo=$objeto_accesos->activo;

                          if($activo=='SI')
                          {
                              $icono='fas fa-thumbs-up';
                              $titulo="Desactivar";
                              $activo='NO';
                              $color="color:green;";
                              
                          }
                          else if($activo=='NO')
                          {
                              $icono='fas fa-thumbs-down';
                              $titulo="Activar";
                              $activo='SI';
                              $color="color:red;";
                          }*/
                        ?>
                        <tr>
                            <td><?php echo $nombre_mascota;?></td>
                            <td><?php echo $nombre_t_m;?></td>
                            <td><?php echo $nombre_raza;?></td>
                            <td><?php echo $nombre_cliente;?></td>
                            <td style="text-align:center;">
                            <i class="far fa-edit" style="cursor:pointer; margin-right:10px;" data-toggle="modal" data-target="#ventana_modal" onclick="vistaActualizarAccesos('<?php echo $id_mascota;?>')" title="Actualizar"></i>
                            <i class="far fa-trash-alt" style="cursor:pointer; <?php echo $color;?>" title="<?php echo $titulo;?>" onClick="eliminar('<?php echo $id_mascota;?>')"></i>
                            </td>
                        </tr>
                        <?php
                      }
                  }
                  ?>

                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Nombre Mascota</th>
                    <th>Tipo de Animal</th>
                    <th>Raza</th>
                    <th>Dueño</th>
                    <th style="text-align:center;">Acci&oacute;n</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <script>
            function vistaAgregarAccesos()
            {
               $.post('accesos_VI/agregar',function(respuesta)
               {
                  $('#titulo_modal').html('Agregar Mascotas al Sistema');
                  $('#contenido_modal').html(respuesta);
               });
            }

            function vistaActualizarAccesos(id_mascota)
            {
               $.post('accesos_VI/actualizar',{id_mascota:id_mascota},function(respuesta)
               {
                  $('#titulo_modal').html('Actualizar Mascota');
                  $('#contenido_modal').html(respuesta);
               });
            }
            function eliminar(id_mascota)
            {
                 var cadena='id_mascota='+id_mascota;
                
                $.post('accesos_CO/activo',cadena,function(respuesta)
                {
                    var objeto_respuesta=JSON.parse(respuesta);
                    
                    if(objeto_respuesta.estado=="EXITO")
                    {
                        $.post('accesos_VI/listar',function(res)
                        {
                            $('#contenido').html(res);
                        });
                    }
                    else if(objeto_respuesta.estado=="ADVERTENCIA")
                    {
                        advertencia(objeto_respuesta.mensaje);
                    }
                    else if(objeto_respuesta.estado=="ERROR")
                    {
                        error(objeto_respuesta.mensaje);
                    }				
                });
            }

              data_table_accesos=organizarTabla({id:"listar_accesos"});
            </script>
        <?php
  }

    function agregar()
    {

        $conexion = pg_connect ("host=localhost port=5432 password=123 user=postgres dbname=veterinaria");
        $query = "SELECT id_tipo_mascota, nombre_t_m FROM control_citas.tipo_mascota";
        $resultado = pg_query ($conexion, $query);
        $numReg = pg_num_rows($resultado);
        
        $query1 = "SELECT id_raza, nombre_raza FROM control_citas.raza";
        $resultado1 = pg_query ($conexion, $query1);
        $numReg1 = pg_num_rows($resultado1);
        
        $query2 = "SELECT id_cliente, CONCAT(p.nombre1,' ',p.nombre2,' ',p.apellido1,' ',apellido2) as nombre_cliente
        FROM control_citas.cliente cl INNER JOIN  control_citas.persona p
        on (cl.id_persona=p.id_persona)";
        $resultado2 = pg_query ($conexion, $query2);
        $numReg2 = pg_num_rows($resultado2);
      ?>
        <div class="card">
          <div class="card-body">
            <form id="formulario_agregar_accesos">

              <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                    <label for="nombre_mascota">Nombre Mascota</label>
                    <input type="text" class="form-control" id="nombre_mascota" name="nombre_mascota">
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="nombre_t_m">Tipo de Mascota</label>
                      <select name="nombre_t_m" class="form-control" id="nombre_t_m" class="ingreso3"> 
                        <option value="0">Seleccione el Tipo de Mascota</option>
            
                        <?php
                          while ($fila=pg_fetch_array($resultado)){
                            echo "<option value=".$fila['id_tipo_mascota'].">".$fila['nombre_t_m']."</option>";
                          }
          
                        ?>
                      </select>
                    </div>
                  </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="nombre_raza">Raza</label>
                    <select name="nombre_raza" class="form-control" id="nombre_raza" class="ingreso3"> 
                        <option value="0">Ninguna Raza seleccionada</option>
            
                        <?php
                          while ($fila=pg_fetch_array($resultado1)){
                            echo "<option value=".$fila['id_raza'].">".$fila['nombre_raza']."</option>";
                          }
          
                        ?>
                      </select>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="nombre_cliente">Nombre del Dueño</label>
                    <select name="nombre_cliente" class="form-control" id="nombre_cliente" class="ingreso3"> 
                        <option value="0">Ningun Cliente seleccionado</option>
            
                        <?php
                          while ($fila=pg_fetch_array($resultado2)){
                            echo "<option value=".$fila['id_cliente'].">".$fila['nombre_cliente']."</option>";
                          }
          
                        ?>
                      </select>
                  </div>
                </div>
                


              </div>

              <button type="button" class="btn btn-primary float-right" onclick="controladorAgregarAccesos()"><i class="fas fa-save"></i> Guardar</button>
            </form>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
        <script>
        function controladorAgregarAccesos()
        {
            var cadena=$('#formulario_agregar_accesos').serialize();

            $.post('accesos_CO/agregar',cadena,function(respuesta)
            {
                var objeto_respuesta=JSON.parse(respuesta);

                if(objeto_respuesta.estado=="EXITO")
                {
                    exito(objeto_respuesta.mensaje);
                    $('#formulario_agregar_accesos')[0].reset();

                    let boton='<div style="text-align:center;"><button type="button" class="btn btn-warning" data-toggle="modal" data-target="#ventana_modal" onclick=vistaActualizarAccesos("'+objeto_respuesta.id_mascota+'") title="Actualizar"><i class="far fa-edit"></i></button></div> <div style="text-align:center;"><button type="button" class="btn btn-warning"  onclick=eliminar("'+objeto_respuesta.id_mascota+'") title="Eliminar"><i class="far fa-trash-alt"></i></button></div>';

                    data_table_accesos.row.add([objeto_respuesta.nombre_mascota,objeto_respuesta.nombre_t_m,objeto_respuesta.nombre_raza,objeto_respuesta.nombre_cliente,boton]).draw();

                }
                else if(objeto_respuesta.estado=="ADVERTENCIA")
                {
                   advertencia(objeto_respuesta.mensaje);
                }
                else if(objeto_respuesta.estado=="ERROR")
                { 
                    error(objeto_respuesta.mensaje);
                }
                else
                {
                    advertencia('ADVERTENCIA: Falta el atributo estado');
                }
            });
        }
        </script>
    <?php
    }

    function actualizar()
    {
      require_once "modelos/accesos_MO.php";

      $conexion=new servidor('A');
      $accesos_MO=new accesos_MO($conexion);

      $id_mascota=$_POST["id_mascota"];

      $arreglo_accesos=$accesos_MO->seleccionarMascota("id_mascota",$id_mascota);
      $nombre_mascota=$arreglo_accesos[0]->nombre_mascota;
      ?>
        <div class="card">
          <div class="card-body">
            <form id="formulario_actualizar_accesos">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="nombre_mascota">Nombre Mascota</label>
                    <input type="text" class="form-control" id="nombre_mascota" name="nombre_mascota"  value="<?php echo $nombre_mascota;?>">
                  </div>
                </div>
            </div>

            <input type="hidden" id="id_mascota" name="id_mascota" value="<?php echo $id_mascota;?>">
            <button type="button" class="btn btn-primary float-right" onclick="controladorActualizarAccesos()"><i class="fas fa-save"></i> Guardar</button>
            </form>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <script>
        function controladorActualizarAccesos()
        {
            var cadena=$('#formulario_actualizar_accesos').serialize();

            $.post('accesos_CO/actualizar',cadena,function(respuesta)
            {
              var objeto_respuesta=JSON.parse(respuesta);
                
              if(objeto_respuesta.estado=="EXITO")
              {
                exito(objeto_respuesta.mensaje);
                $('#formulario_actualizar_accesos')[0].reset();

                $.post('accesos_VI/listar',function(res){
                    $('#contenido').html(res);
                });
              }
              else if(objeto_respuesta.estado=="ADVERTENCIA")
              {
                advertencia(objeto_respuesta.mensaje);
              }
              else if(objeto_respuesta.estado=="ERROR")
              { 
                  error(objeto_respuesta.mensaje);
              }
              else
              {
                  advertencia('ADVERTENCIA: Falta el atributo estado');
              }
            });
        }
        </script>
      <?php
    }

    //-------------------------------------

    function listarCita()
    {
        require_once "modelos/accesos_MO.php";

        $conexion=new servidor('A');
        $accesos_MO=new accesos_MO($conexion);

        $arreglo_accesos=$accesos_MO->seleccionarCita();
        ?>
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Personas con Acceso al Sistema</h3>
                <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#ventana_modal" onclick="vistaAgregarCita()">
                <i class="far fa-plus-square"></i> Agregar
                </button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="listar_accesos" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Nombre Mascota</th>
                    <th>Nombre Cliente</th>
                    <th>Nombre Veterinario</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th style="text-align:center;">Acci&oacute;n</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                  if($arreglo_accesos)
                  {
                      foreach($arreglo_accesos as $objeto_accesos)
                      {
                          $id_cita=$objeto_accesos->id_cita;
                          $nombre_mascota=$objeto_accesos->nombre_mascota;
                          $nombre_cliente=$objeto_accesos->nombre_cliente;
                          $nombre_veterinario=$objeto_accesos->nombre_veterinario;
                          $fecha=$objeto_accesos->fecha;
                          $hora=$objeto_accesos->hora;
                
                        ?>
                        <tr>
                            <td><?php echo $nombre_mascota;?></td>
                            <td><?php echo $nombre_cliente;?></td>
                            <td><?php echo $nombre_veterinario;?></td>
                            <td><?php echo $fecha;?></td>
                            <td><?php echo $hora;?></td>
                            
                            <td style="text-align:center;">
                            <i class="far fa-edit" style="cursor:pointer; margin-right:10px;" data-toggle="modal" data-target="#ventana_modal" onclick="vistaActualizarCita('<?php echo $id_cita;?>')" title="Actualizar"></i>
                            <i class="far fa-trash-alt" style="cursor:pointer; <?php echo $color;?>" title="<?php echo $titulo;?>" onClick="eliminarCita('<?php echo $id_cita;?>')"></i>
                            </td>
                        </tr>
                        <?php
                      }
                  }
                  ?>

                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Nombre Mascota</th>
                    <th>Nombre Cliente</th>
                    <th>Nombre Veterinario</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th style="text-align:center;">Acci&oacute;n</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <script>
            function vistaAgregarCita()
            {
               $.post('accesos_VI/agregarCita',function(respuesta)
               {
                  $('#titulo_modal').html('Agregar Cita');
                  $('#contenido_modal').html(respuesta);
               });
            }

            function vistaActualizarCita(id_cita)
            {
               $.post('accesos_VI/actualizarCita',{id_cita:id_cita},function(respuesta)
               {
                  $('#titulo_modal').html('Actualizar Accesos a Personas');
                  $('#contenido_modal').html(respuesta);
               });
            }
            function eliminarCita(id_cita)
            {
                 var cadena='id_cita='+id_cita;
                
                $.post('accesos_CO/activoCita',cadena,function(respuesta)
                {
                    var objeto_respuesta=JSON.parse(respuesta);
                    
                    if(objeto_respuesta.estado=="EXITO")
                    {
                        $.post('accesos_VI/listarCita',function(res)
                        {
                            $('#contenido').html(res);
                        });
                    }
                    else if(objeto_respuesta.estado=="ADVERTENCIA")
                    {
                        advertencia(objeto_respuesta.mensaje);
                    }
                    else if(objeto_respuesta.estado=="ERROR")
                    {
                        error(objeto_respuesta.mensaje);
                    }				
                });
            }

            data_table_accesos=organizarTabla({id:"listar_accesos"});
            </script>
        <?php
    }

    function agregarCita()
    {

		$conexion = pg_connect ("host=localhost port=5432 password=123 user=postgres dbname=veterinaria");
		$query = "SELECT id_mascota, nombre_mascota FROM control_citas.mascotas";
		$resultado = pg_query ($conexion, $query);
    $numReg = pg_num_rows($resultado);
    
    $query1 = "SELECT id_cliente, CONCAT(p.nombre1,' ',p.nombre2,' ',p.apellido1,' ',p.apellido2) as nombre_cliente
    FROM control_citas.cliente cl INNER JOIN control_citas.persona p
    on (cl.id_persona=p.id_persona)";
		$resultado1 = pg_query ($conexion, $query1);
    $numReg1 = pg_num_rows($resultado1);
    
    $query2 = "SELECT id_empleado, CONCAT(p.nombre1,' ',p.nombre2,' ',p.apellido1,' ',p.apellido2) as nombre_veterinario
    FROM control_citas.empleado e INNER JOIN control_citas.persona p
    on (e.id_persona=p.id_persona)";
		$resultado2 = pg_query ($conexion, $query2);
    $numReg2 = pg_num_rows($resultado2);
    
		
      ?>
        <div class="card">
          <div class="card-body">
            <form id="formulario_agregar_cita">

              <div class="row">

                <div class="col-md-3">
                  <div class="form-group">
                    <label for="fecha">Fecha</label>
                    <input type="date" class="form-control" id="fecha" name="fecha">
                  </div>
                </div>
           

                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="hora">Hora</label>
                      <input type="time" class="form-control" id="hora" name="hora">
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="nombre_mascota">Nombre de la Mascota</label>
                      <select name="nombre_mascota" class="form-control" id="nombre_mascota" class="ingreso3"> 
                        <option value="0">Seleccione la Mascota</option>
            
                        <?php
                          while ($fila=pg_fetch_array($resultado)){
                            echo "<option value=".$fila['id_mascota'].">".$fila['nombre_mascota']."</option>";
                          }
          
                        ?>
                      </select>
                    </div>
                  </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="nombre_cliente">Nombre del Cliente</label>
                    <select name="nombre_cliente" class="form-control" id="nombre_cliente" class="ingreso3"> 
                        <option value="0">Ningun Cliente seleccionado</option>
            
                        <?php
                          while ($fila=pg_fetch_array($resultado1)){
                            echo "<option value=".$fila['id_cliente'].">".$fila['nombre_cliente']."</option>";
                          }
          
                        ?>
                      </select>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="nombre_veterinario">Nombre del Veterinario</label>
                    <select name="nombre_veterinario" class="form-control" id="nombre_veterinario" class="ingreso3"> 
                        <option value="0">Ningun Veterinario seleccionado</option>
            
                        <?php
                          while ($fila=pg_fetch_array($resultado2)){
                            echo "<option value=".$fila['id_empleado'].">".$fila['nombre_veterinario']."</option>";
                          }
          
                        ?>
                      </select>
                  </div>
                </div>

              </div>

              <button type="button" class="btn btn-primary float-right" onclick="controladorAgregarCita()"><i class="fas fa-save"></i> Guardar</button>
            </form>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
        <script>
        function controladorAgregarCita()
        {
            var cadena=$('#formulario_agregar_cita').serialize();

            $.post('accesos_CO/agregarCita',cadena,function(respuesta)
            {
                var objeto_respuesta=JSON.parse(respuesta);

                if(objeto_respuesta.estado=="EXITO")
                {
                    exito(objeto_respuesta.mensaje);
                    $('#formulario_agregar_cita')[0].reset();


                   let boton='<div style="text-align:center;"><button type="button" data-toggle="modal" data-target="#ventana_modal" onclick=vistaActualizarCita("'+objeto_respuesta.id_cita+'") title="Actualizar"><i class="far fa-edit"></i></button></div> <div style="text-align:center;"><button type="button" onclick=eliminarCita("'+objeto_respuesta.id_cita+'") title="Eliminar"><i class="far fa-trash-alt"></i></button></div>';

                    data_table_accesos.row.add([objeto_respuesta.nombre_mascota,objeto_respuesta.nombre_cliente,objeto_respuesta.nombre_veterinario,objeto_respuesta.fecha,objeto_respuesta.hora,boton]).draw();

                }
                else if(objeto_respuesta.estado=="ADVERTENCIA")
                {
                   advertencia(objeto_respuesta.mensaje);
                }
                else if(objeto_respuesta.estado=="ERROR")
                { 
                    error(objeto_respuesta.mensaje);
                }
                else
                {
                    advertencia('ADVERTENCIA: Falta el atributo estado');
                }
            });
        }
        </script>
    <?php
  }

  function actualizarCita()
    {
      require_once "modelos/accesos_MO.php";

      $conexion=new servidor('A');
      $accesos_MO=new accesos_MO($conexion);

      $id_cita=$_POST["id_cita"];

      $arreglo_accesos=$accesos_MO->seleccionarCita("p.id_cita",$id_cita);
      ?>
        <div class="card">
          <div class="card-body">
            <form id="formulario_actualizar_cita">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="fecha">Fecha</label>
                    <input type="date" class="form-control" id="fecha" name="fecha">
                  </div>
                </div>
           
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="hora">Hora</label>
                    <input type="time" class="form-control" id="hora" name="hora">
                  </div>
                </div>
              </div>

              <input type="hidden" id="id_cita" name="id_cita" value="<?php echo $id_cita;?>">
              <button type="button" class="btn btn-primary float-right" onclick="controladorActualizarCita()"><i class="fas fa-save"></i> Guardar</button>
            </form>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <script>
        function controladorActualizarCita()
        {
            var cadena=$('#formulario_actualizar_cita').serialize();

            $.post('accesos_CO/actualizarCita',cadena,function(respuesta)
            {
              var objeto_respuesta=JSON.parse(respuesta);
                
              if(objeto_respuesta.estado=="EXITO")
              {
                exito(objeto_respuesta.mensaje);
                $('#formulario_actualizar_cita')[0].reset();

                $.post('accesos_VI/listarCita',function(res){
                    $('#contenido').html(res);
                });
              }
              else if(objeto_respuesta.estado=="ADVERTENCIA")
              {
                advertencia(objeto_respuesta.mensaje);
              }
              else if(objeto_respuesta.estado=="ERROR")
              { 
                  error(objeto_respuesta.mensaje);
              }
              else
              {
                  advertencia('ADVERTENCIA: Falta el atributo estado');
              }
            });
        }
        </script>
      <?php
    }

}
?>