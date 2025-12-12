package com.Ros.exe.DTO;

import lombok.Data;
import java.util.Date;
import java.util.List;

@Data
public class PagoDto {
    private Long id;
    private Long pedidoId;
    private Long userId;
    private String metodoPago;
    private double montoTotal; // CORREGIDO: debe coincidir con la entidad y el impl
    private String estado;
    private Date fechaPago;
    private Date fechaCreacion;
    private Date fechaActualizacion;

    private List<DetallePagoDto> detalles; // opcional, si manejas detalles
}
