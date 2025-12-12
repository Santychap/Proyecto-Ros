package com.Ros.exe.Entity;

import jakarta.persistence.*;
import lombok.Data;
import java.util.Date;

@Data
@Entity
@Table(name = "horarios")
public class Horario {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;

    @ManyToOne
    @JoinColumn(name = "user_id", nullable = false)
    private User user;  // empleado al que pertenece el horario

    @Column(name = "dia_semana", length = 20, nullable = false)
    private String diaSemana; // Lunes, Martes, etc.

    @Column(name = "hora_inicio", length = 5, nullable = false)
    private String horaInicio; // "08:00"

    @Column(name = "hora_fin", length = 5, nullable = false)
    private String horaFin; // "17:00"

    @Temporal(TemporalType.TIMESTAMP)
    @Column(name = "fecha_creacion", nullable = false)
    private Date fechaCreacion;

    @Temporal(TemporalType.TIMESTAMP)
    @Column(name = "fecha_actualizacion", nullable = false)
    private Date fechaActualizacion;
}
