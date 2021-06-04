<?php
class accesos_MO
{
    private $conexion;

    function __construct($conexion)
    {
        $this->conexion=$conexion;
    }

    function verificarInicioSesion($usuario,$clave)
    {
        $sql = "SELECT * FROM control_citas.usuarios WHERE usuario='$usuario' AND clave='$clave'";

        $this->conexion->consulta($sql);

        $arreglo_accesos=$this->conexion->extraerRegistro();

        return $arreglo_accesos;
    }
    

    function agregar($nombre_mascota,$nombre_raza,$nombre_cliente)
    {
        $sql = "INSERT INTO control_citas.mascotas (ID_MASCOTA,ID_RAZA,NOMBRE_MASCOTA,ID_CLIENTE)
            VALUES (DEFAULT,'$nombre_raza','$nombre_mascota','$nombre_cliente')";

        $filas_afectadas=$this->conexion->consulta($sql);

        return $filas_afectadas;
    }

    function actualizar($id_mascota,$nombre_mascota)
    {
        $sql = "UPDATE control_citas.mascotas SET nombre_mascota='$nombre_mascota' WHERE id_mascota='$id_mascota'";

        $filas_afectadas=$this->conexion->consulta($sql);

        return $filas_afectadas;
    }

    function seleccionar($atributo='',$valor='')
    {
        $condicion="";
        
        if($atributo && $valor)
        {
            $condicion = " WHERE $atributo='$valor'";
        }

        $sql = "SELECT * FROM control_citas.usuarios $condicion";
        
        $this->conexion->consulta($sql);

        $arreglo_accesos=$this->conexion->extraerRegistro();

        return $arreglo_accesos;
    } 

    function seleccionarMascota($atributo='',$valor='')
    {
        $condicion="";
        
        if($atributo && $valor)
        {
            $condicion = "WHERE $atributo='$valor'";
        }

        $sql = "SELECT m.id_mascota, t.nombre_t_m, r.nombre_raza, m.nombre_mascota, CONCAT(p.nombre1,' ',p.apellido1) as nombre_cliente
        FROM control_citas.mascotas m INNER JOIN control_citas.raza r
        on (m.id_raza=r.id_raza)
        inner join control_citas.tipo_mascota t
        on (r.id_tipo_mascota=t.id_tipo_mascota)
        inner join control_citas.cliente cl
        on (m.id_cliente=cl.id_cliente)
        inner join control_citas.persona p
        on (cl.id_persona=p.id_persona) $condicion ";
        
        $this->conexion->consulta($sql);

        $arreglo_accesos=$this->conexion->extraerRegistro();

        return $arreglo_accesos;
    } 


    function activo($id_mascota)
    {
        $sql = "DELETE FROM control_citas.mascotas WHERE id_mascota='$id_mascota'";

        $filas_afectadas=$this->conexion->consulta($sql);

        return $filas_afectadas;
    }

    //----------------------

    function seleccionarProducto($atributo='',$valor='')
    {
        $condicion="";
        
        if($atributo && $valor)
        {
            $condicion = "WHERE $atributo=$valor";
        }

        $sql = "SELECT p.id_producto,p.nombre as nombre_producto ,p.precio,p.descripcion,p.stock,e.nombre as nombre_estante,pe.tipo as tipo_producto,pro.nombre as nombre_proveedor,la.nombre as nombre_laboratorio
        FROM inventario.producto p INNER JOIN inventario.estante e
        on (p.cod_estante=e.cod_estante)
        inner join inventario.presentacion pe
        on (p.cod_presentacion=pe.cod_presentacion)
        inner join inventario.proveedor pro
        on (p.cod_proveedor=pro.cod_proveedor)
        inner join inventario.laboratorio la
        on (p.cod_laboratorio=la.cod_laboratorio) $condicion ";
        
        $this->conexion->consulta($sql);

        $arreglo_accesos=$this->conexion->extraerRegistro();

        return $arreglo_accesos;
    } 

    function seleccionarCita($atributo='',$valor='')
    {
        
        $sql = "SELECT c.id_cita, m.nombre_mascota, CONCAT(p.nombre1,' ',p.apellido1) as nombre_cliente, CONCAT(per.nombre1,' ',per.apellido1) as nombre_veterinario, c.fecha,c.hora
        FROM control_citas.citas c INNER JOIN control_citas.mascotas m
        on (c.id_mascota=m.id_mascota)
        inner join control_citas.cliente cl
        on (c.id_cliente=cl.id_cliente)
        inner join control_citas.persona p
        on (cl.id_persona=p.id_persona)
        inner join control_citas.empleado e
        on (c.id_empleado=e.id_empleado)
        inner join control_citas.persona per
        on (e.id_persona=per.id_persona)";
        
        $this->conexion->consulta($sql);

        $arreglo_accesos=$this->conexion->extraerRegistro();

        return $arreglo_accesos;
    } 

    function agregarCita($nombre_mascota,$nombre_cliente,$nombre_veterinario,$fecha,$hora)
    {
        $sql = "INSERT INTO control_citas.citas (id_cita,id_mascota,id_cliente,id_empleado,fecha,hora)
                VALUES (DEFAULT,'$nombre_mascota','$nombre_cliente','$nombre_veterinario','$fecha','$hora')";

        $filas_afectadas=$this->conexion->consulta($sql);

        return $filas_afectadas;
    }

    function actualizarCita($id_cita,$fecha,$hora)
    {
        $sql = "UPDATE control_citas.citas SET fecha='$fecha', hora='$hora' WHERE id_cita='$id_cita'";

        $filas_afectadas=$this->conexion->consulta($sql);

        return $filas_afectadas;
    }

    function activoCita($id_cita)
    {
        $sql = "DELETE FROM control_citas.citas WHERE id_cita='$id_cita'";

        $filas_afectadas=$this->conexion->consulta($sql);

        return $filas_afectadas;
    }




}
?>