package com.Ros.exe.DTO;

import lombok.Data;
import java.util.Date;
import java.util.List;

@Data
public class ProductoDto {

    private Long idProducto;

    private Long categoriaId;

    private List<Long> promocionIds; // <- lista de IDs de promociones

    private String nombre;

    private String descripcion;

    private Double precio;

    private String imagenUrl;

    private Date createdAt;

    private Date updatedAt;

}
