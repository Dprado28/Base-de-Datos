<?php
require_once "modelos/accesos_MO.php";

class accesos_CO
{
    function __construct(){}

    function verificarInicioSesion()
    {
        $usuario=$_POST["usuario"];
        $clave=$_POST["clave"];

        $conexion=new servidor('A');

        $accesos_MO=new accesos_MO($conexion);

        $arreglo_accesos=$accesos_MO->verificarInicioSesion($usuario,$clave);

        if($arreglo_accesos)
        {
            $_SESSION["id_usuario"]=$arreglo_accesos[0]->id_usuario;
            $_SESSION["autenticado"]="SI";
            header("Location: index.php");
        }
        else
        {
            header("Location: index.php?error=ERROR: Usuario No Registrado&usuario=$usuario");
        }
    }

    function agregar()
    {
        $nombre_mascota=$_POST["nombre_mascota"];
        $nombre_t_m=$_POST["nombre_t_m"];
        $nombre_raza=$_POST["nombre_raza"];
        $nombre_cliente=$_POST["nombre_cliente"];

        $conexion=new servidor('A');

        $accesos_MO=new accesos_MO($conexion);

        /*$arreglo_accesos=$accesos_MO->unico($correo);
        if($arreglo_accesos)
        {
            $respuesta = [
                "estado" => "ADVERTENCIA",
                'mensaje' => "ADVERTENCIA: El correo <b>$correo</b> ya existe"
            ];
        }
        else
        {*/

            $filas_afectadas=$accesos_MO->agregar($nombre_mascota,$nombre_raza,$nombre_cliente);
            
            if($filas_afectadas)
            {

                $arreglo_accesos=$accesos_MO->seleccionarMascota("nombre_mascota",$nombre_mascota);
                $id_mascota=$arreglo_accesos[0]->id_mascota;
                $nombre_mascota=$arreglo_accesos[0]->nombre_mascota;
                $nombre_t_m=$arreglo_accesos[0]->nombre_t_m;
                $nombre_raza=$arreglo_accesos[0]->nombre_raza;
                $nombre_cliente=$arreglo_accesos[0]->nombre_cliente;
                
                $respuesta = [
                    "estado" => "EXITO",
                    'mensaje' => "EXITO: Registro Guardado",
                    'nombre_mascota' => $nombre_mascota,
                    'nombre_t_m' => $nombre_t_m,
                    'nombre_raza' => $nombre_raza,
                    'nombre_cliente' => $nombre_cliente,
                ];
            }
            else
            {
                $respuesta = [
                    "estado" => "ADVERTENCIA",
                    'mensaje' => "ADVERTENCIA: No se guardo el registro"
                ];
            }

        echo json_encode($respuesta);
        //}
    }

    function actualizar()
    {
        $nombre_mascota=$_POST["nombre_mascota"];
        $id_mascota=$_POST["id_mascota"];

        $conexion=new servidor('A');

        $accesos_MO=new accesos_MO($conexion);

        //$arreglo_accesos=$accesos_MO->unico($correo,$id_persona);

       /* if($arreglo_accesos)
        {
            $respuesta = [
                "estado" => "ADVERTENCIA",
                'mensaje' => "ADVERTENCIA: El empleado <b>$correo</b> ya existe"
            ];
        }
        else
        {*/
            $filas_afectadas=$accesos_MO->actualizar($id_mascota,$nombre_mascota);
            
            if($filas_afectadas)
            {
                $arreglo_accesos=$accesos_MO->seleccionarMascota("id_mascota",$id_mascota);
                $nombre_mascota=$arreglo_accesos[0]->nombre_mascota;
                $id_mascota=$arreglo_accesos[0]->id_mascota;

                $respuesta = [
                    "estado" => "EXITO",
                    'mensaje' => "EXITO: Actualización Exitosa",
                    'id_mascota' => $id_mascota,
                    'nombre_mascota' => $nombre_mascota,
                ];
            }
            else
            {
                $respuesta = [
                    "estado" => "ADVERTENCIA",
                    'mensaje' => "ADVERTENCIA: No ocurrieron cambios"
                ];
            }
        //}
        echo json_encode($respuesta);
    }

    function cerrarSesion($arreglo_url)
    {
        session_unset();
        // Destruir todas las variables de sesión.	
        $_SESSION = array();
        
        // Si se desea destruir la sesión completamente, borre también la cookie de sesión.
        // Nota: ¡Esto destruirá la sesión, y no la información de la sesión!
        if (ini_get("session.use_cookies")) 
        {
          $params = session_get_cookie_params();
          setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
        }
        // Finalmente, destruir la sesión.	
        session_destroy();

        $usuario="<b>".$arreglo_url[0]."</b> Que tenga un buen d&iacute;a ";

        $respuesta = [
            "estado" => "EXITO",
            'mensaje' => $usuario
        ];

        echo json_encode($respuesta);
    }

	function activo()
	{
        $conexion=new servidor('A');
        $accesos_MO=new accesos_MO($conexion);
		
		$id_mascota=$_POST['id_mascota'];
        
        $filas_afectadas=$accesos_MO->activo($id_mascota);
            
        if($filas_afectadas)
        {
             $respuesta = [
                "estado" => "EXITO",
                'mensaje' => "EXITO: Registro Guardado",
            ];
        }
        else
        {
            $respuesta = [
                "estado" => "ADVERTENCIA",
                'mensaje' => "ADVERTENCIA: No ocurrieron cambios"
            ];
        }

        echo json_encode($respuesta);
    }
    
    //-------------------------------------------------

    function agregarCita()
    {
        $nombre_mascota=$_POST["nombre_mascota"];
        $nombre_cliente=$_POST["nombre_cliente"];
        $nombre_veterinario=$_POST["nombre_veterinario"];
        $fecha=$_POST["fecha"];
        $hora=$_POST["hora"];

        $conexion=new servidor('A');

        $accesos_MO=new accesos_MO($conexion);

            $filas_afectadas=$accesos_MO->agregarCita($nombre_mascota,$nombre_cliente,$nombre_veterinario,$fecha,$hora);
            
            if($filas_afectadas)
            {

                $arreglo_accesos=$accesos_MO->seleccionarCita("nombre_mascota",$nombre_mascota);
                $id_cita=$arreglo_accesos[0]->id_cita;
                $nombre_mascota=$arreglo_accesos[0]->nombre_mascota;
                $nombre_cliente=$arreglo_accesos[0]->nombre_cliente;
                $nombre_veterinario=$arreglo_accesos[0]->nombre_veterinario;
                $fecha=$arreglo_accesos[0]->fecha;
                $hora=$arreglo_accesos[0]->hora;                
                
                $respuesta = [
                    "estado" => "EXITO",
                    'mensaje' => "EXITO: Actualización Exitosa",
                    'id_cita' => $id_cita,
                    'nombre_mascota' => $nombre_mascota,
                    'nombre_cliente' => $nombre_cliente,
                    'nombre_veterinario' => $nombre_veterinario,
                    'fecha' => $fecha,
                    'hora' => $hora,
                    
                ];
            }
            else
            {
                $respuesta = [
                    "estado" => "ADVERTENCIA",
                    'mensaje' => "ADVERTENCIA: No se guardo el registro"
                ];
            }

        echo json_encode($respuesta);

    }

    function actualizarCita()
    {
        $fecha=$_POST["fecha"];
        $hora=$_POST["hora"];
        $id_cita=$_POST["id_cita"];
        

        $conexion=new servidor('A');

        $accesos_MO=new accesos_MO($conexion);

            $filas_afectadas=$accesos_MO->actualizarCita($id_cita,$fecha,$hora);
            
            if($filas_afectadas)
            {
                $arreglo_accesos=$accesos_MO->seleccionarCita("id_cita",$id_cita);
                $id_cita=$arreglo_accesos[0]->id_cita;
                $fecha=$arreglo_accesos[0]->fecha;
                $hora=$arreglo_accesos[0]->hora;

                $respuesta = [
                    "estado" => "EXITO",
                    'mensaje' => "EXITO: Registro Guardado",
                    'id_cita' => $id_cita,
                    'fecha' => $fecha,
                    'hora' => $hora,
                ];
            }
            else
            {
                $respuesta = [
                    "estado" => "ADVERTENCIA",
                    'mensaje' => "ADVERTENCIA: No ocurrieron cambios"
                ];
            }
        
        echo json_encode($respuesta);
    }

    function activoCita()
	{
        $conexion=new servidor('A');
        $accesos_MO=new accesos_MO($conexion);
		
		$id_cita=$_POST['id_cita'];
        
        $filas_afectadas=$accesos_MO->activoCita($id_cita);
            
        if($filas_afectadas)
        {
             $respuesta = [
                "estado" => "EXITO",
                'mensaje' => "EXITO: Registro Eliminado",
            ];
        }
        else
        {
            $respuesta = [
                "estado" => "ADVERTENCIA",
                'mensaje' => "ADVERTENCIA: No ocurrieron cambios"
            ];
        }

        echo json_encode($respuesta);
    }

}
?>