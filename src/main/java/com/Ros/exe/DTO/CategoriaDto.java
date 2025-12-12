package com.Ros.exe.DTO;

import lombok.Data;
import java.util.Date;

@Data
public class CategoriaDto {
    private Long idCategoria;
    private String nombre;
    private String descripcion;
    private Date createdAt;
    private Date updatedAt;
}
