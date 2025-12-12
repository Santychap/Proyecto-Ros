package com.Ros.exe.DTO;

import lombok.Data;
import org.springframework.format.annotation.DateTimeFormat;
import java.util.Date;

@Data
public class ReservaDto {
    private Long id;
    private Long userId;
    private Long mesaId;
    
    @DateTimeFormat(pattern = "yyyy-MM-dd")
    private Date fechaReserva;
    
    private String hora;
    private int numeroPersonas;
    private String estado;
    private Date fechaCreacion;
    private Date fechaActualizacion;
}
