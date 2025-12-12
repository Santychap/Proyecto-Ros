package com.Ros.exe.Entity;

import jakarta.persistence.*;
import lombok.Data;
import java.util.Date;
import java.util.List;
@Entity
@Table(name = "promociones")
@Data
public class Promocion {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "id_promocion", nullable = false, unique = true)
    private Long idPromocion;

    @Column(name = "titulo", length = 100, nullable = false)
    private String titulo;

    @Column(name = "descripcion", length = 255)
    private String descripcion;

    @Column(name = "imagen_url", length = 255)
    private String imagenUrl;

    @Column(name = "descuento", nullable = false)
    private Double descuento;

    @Temporal(TemporalType.DATE)
    @Column(name = "fecha_inicio", nullable = false)
    private Date fechaInicio;

    @Temporal(TemporalType.DATE)
    @Column(name = "fecha_fin", nullable = false)
    private Date fechaFin;

    @Temporal(TemporalType.TIMESTAMP)
    @Column(name = "created_at", nullable = false, updatable = false)
    private Date createdAt;

    @Temporal(TemporalType.TIMESTAMP)
    @Column(name = "updated_at")
    private Date updatedAt;


    @ManyToMany
    @JoinTable(
            name = "promocion_productos",
            joinColumns = @JoinColumn(name = "id_promocion"),
            inverseJoinColumns = @JoinColumn(name = "id_producto")
    )
    private List<Producto> productos;
}
