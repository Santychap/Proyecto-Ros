package com.Ros.exe.DTO;

import lombok.Data;
import java.util.Date;

@Data
public class MesaDto {
    private Long idMesa;
    private int numeroMesa;
    private int capacidad;
    private String ubicacion;
    private String estado;        // "libre", "ocupada", "reservada"
    private Date fechaCreacion;   // registro de la mesa
}
