package com.Ros.exe.DTO;

import lombok.Data;
import org.springframework.format.annotation.DateTimeFormat;
import java.util.Date;

@Data
public class PromocionDto {
    private Long idPromocion;
    private String titulo;
    private String descripcion;
    private String imagenUrl;
    private Double descuento;
    
    @DateTimeFormat(pattern = "yyyy-MM-dd")
    private Date fechaInicio;
    
    @DateTimeFormat(pattern = "yyyy-MM-dd")
    private Date fechaFin;
    
    private Date createdAt;
    private Date updatedAt;
}
