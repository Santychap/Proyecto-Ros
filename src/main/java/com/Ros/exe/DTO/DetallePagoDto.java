package com.Ros.exe.DTO;

import lombok.Data;
import java.util.Date;

@Data
public class DetallePagoDto {
    private Long id;
    private Long pagoId;
    private double monto;
    private String descripcion;
    private Date fechaCreacion;
    private Date fechaActualizacion;
}
