package com.Ros.exe.Entity;

import jakarta.persistence.*;

import lombok.Data;
import java.util.Date;
import java.util.List;

@Entity
@Table(name = "users")
@Data
public class User {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "id_user")
    private Long idUser;

    @Column(name = "nombre", length = 100)
    private String nombre;

    @Column(name = "apellido", length = 100)
    private String apellido;

    @Column(name = "email", length = 100, unique = true)
    private String email;

    @Column(name = "password", length = 200)
    private String password;

    @Column(name = "activo", nullable = false, columnDefinition = "BOOLEAN DEFAULT TRUE")
    private Boolean activo = true;

    @Temporal(TemporalType.TIMESTAMP)
    @Column(name = "fecha_creacion", nullable = false, updatable = false)
    private Date fechaCreacion = new Date();

    @Temporal(TemporalType.TIMESTAMP)
    @Column(name = "fecha_actualizacion", nullable = false)
    private Date fechaActualizacion = new Date();

    // Si tienes entidad Rol:
    @ManyToOne
    @JoinColumn(name = "id_rol")
    private Rol rol;

    @OneToMany(mappedBy = "user", cascade = CascadeType.ALL, fetch = FetchType.LAZY)
    private List<Reserva> reservas;

    @OneToMany(mappedBy = "user", cascade = CascadeType.ALL, fetch = FetchType.LAZY)
    private List<Pedido> pedidos;

    @OneToMany(mappedBy = "user", cascade = CascadeType.ALL, fetch = FetchType.LAZY)
    private List<Pago> pagos;

    @OneToMany(mappedBy = "user", cascade = CascadeType.ALL, fetch = FetchType.LAZY)
    private List<Horario> horarios;
}