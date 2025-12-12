package com.Ros.exe.DTO;

import lombok.Data;
import java.util.Date;

@Data
public class HorarioDto {
    private Long id;
    private Long userId;
    private String diaSemana;
    private String horaInicio;
    private String horaFin;
    private Date fechaCreacion;
    private Date fechaActualizacion;
}
