package com.Ros.exe.Entity;

import jakarta.persistence.*;
import lombok.Data;
import java.util.Date;

@Data
@Entity
@Table(name = "mesas")
public class Mesa {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long idMesa;

    @Column(name = "numero_mesa", nullable = false)
    private int numeroMesa;

    @Column(name = "capacidad", nullable = false)
    private int capacidad;

    @Column(name = "ubicacion", length = 100)
    private String ubicacion;

    @Column(name = "estado", length = 50, nullable = false)
    private String estado; // "libre", "ocupada", "reservada"

    @Temporal(TemporalType.TIMESTAMP)
    @Column(name = "fecha_creacion", nullable = false)
    private Date fechaCreacion; // registro de la mesa
}
