
<html>
    <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../dist/css/estilos2.css">
    </head>
    <body class="bodypdf">
    <center>
		<br>
		<br>
		<br>
		<br>     
       <?php 
            require_once "../librerias/configuraciones.php";
            require_once "../librerias/servidor.php";
            require_once "../librerias/controlador.php";

            require_once "../modelos/accesos_MO.php";

            $conexion=new servidor('A');
            $accesos_MO=new accesos_MO($conexion);

            $arreglo_accesos=$accesos_MO->seleccionarCita();

         ?>
         
         <table class="table">
                  <thead>
                  <tr>
                    <th>Nombre Mascota</th>
                    <th>Nombre Cliente</th>
                    <th>Nombre Veterinario</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                  if($arreglo_accesos)
                  {
                      foreach($arreglo_accesos as $objeto_accesos)
                      {
                          
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
                        </tr>
                        <?php
                      }
                  }
                  ?>

                  </tbody>
                </table>
		
    </center>
    </body>
</html>