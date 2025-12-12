package com.Ros.exe.Entity;

import jakarta.persistence.*;
import lombok.Data;
import java.util.Date;

@Data
@Entity
@Table(name = "noticias")
public class Noticia {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;

    @Column(name = "titulo", length = 150, nullable = false)
    private String titulo;

    @Column(name = "contenido", columnDefinition = "TEXT", nullable = false)
    private String contenido;

    @Column(name = "imagen", length = 255)
    private String imagen;

    @Temporal(TemporalType.DATE)
    @Column(name = "fecha_publicacion")
    private Date fechaPublicacion;

    @Temporal(TemporalType.TIMESTAMP)
    @Column(name = "fecha_actualizacion", nullable = false)
    private Date fechaActualizacion = new Date(); // <-- valor por defecto
}
