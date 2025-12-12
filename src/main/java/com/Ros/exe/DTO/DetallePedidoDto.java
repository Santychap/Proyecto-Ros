package com.Ros.exe.DTO;

import lombok.Data;

@Data
public class DetallePedidoDto {

    private Long id;
    private Long pedidoId;
    private Long productoId;
    private ProductoDto producto;
    private int cantidad;
    private double precio;
}
