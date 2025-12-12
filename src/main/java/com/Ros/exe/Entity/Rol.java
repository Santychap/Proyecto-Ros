package com.Ros.exe.Entity;

import jakarta.persistence.*;
import lombok.Data;

@Entity
@Table(name = "rol")
@Data
public class Rol {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "id_rol", nullable = false, unique = true)
    private Long idRol;

    @Column(name = "nombre", length = 50, nullable = false, unique = true)
    private String nombre;
}
