package com.Ros.exe.DTO;

import lombok.Data;
import java.util.Date;
import java.util.List;

@Data
public class PedidoDto {

    private Long id;
    private Long userId;
    private Long reservaId;
    private Long empleadoAsignadoId;
    private String comentarios;
    private double total;
    private String estado;
    private Date fechaCreacion;
    private Date fechaActualizacion;
    private String clienteNombre;
    private String numeroMesa;
    private List<DetallePedidoDto> detalles;
}
