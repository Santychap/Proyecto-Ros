package com.Ros.exe.DTO;

import lombok.Data;
import java.util.Date;

@Data
public class InventarioDto {

    private Long id;
    private Long productoId;
    private int cantidadDisponible;
    private int cantidadMinima;
    private Date fechaCreacion;
    private Date fechaActualizacion;
}
