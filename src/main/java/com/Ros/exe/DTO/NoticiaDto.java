package com.Ros.exe.DTO;

import lombok.Data;
import org.springframework.format.annotation.DateTimeFormat;
import java.util.Date;

@Data
public class NoticiaDto {
    private Long id;
    private String titulo;
    private String contenido;
    private String imagen;
    
    @DateTimeFormat(pattern = "yyyy-MM-dd")
    private Date fechaPublicacion;
    
    private Date fechaActualizacion;
}
