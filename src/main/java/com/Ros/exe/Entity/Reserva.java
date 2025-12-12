package com.Ros.exe.Entity;

import jakarta.persistence.*;
import lombok.Data;
import java.util.Date;

@Entity
@Table(name = "reserva")
@Data
public class Reserva {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;

    @ManyToOne
    @JoinColumn(name = "user_id", nullable = false)
    private User user;

    @ManyToOne
    @JoinColumn(name = "mesa_id", nullable = false)
    private Mesa mesa;

    @Temporal(TemporalType.TIMESTAMP)
    @Column(name = "fecha_reserva", nullable = false)
    private Date fechaReserva;

    @Column(name = "hora", nullable = false, length = 10)
    private String hora;

    @Column(name = "numero_personas", nullable = false)
    private int numeroPersonas;

    @Column(name = "estado", length = 50, nullable = false)
    private String estado;

    @Temporal(TemporalType.TIMESTAMP)
    @Column(name = "fecha_creacion", nullable = false)
    private Date fechaCreacion;

    @Temporal(TemporalType.TIMESTAMP)
    @Column(name = "fecha_actualizacion", nullable = false)
    private Date fechaActualizacion;
}