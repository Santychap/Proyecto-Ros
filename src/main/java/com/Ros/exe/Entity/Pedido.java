package com.Ros.exe.Entity;

import jakarta.persistence.*;
import lombok.Data;
import java.util.Date;
import java.util.List;

@Entity
@Table(name = "pedidos")
@Data
public class Pedido {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;

    @ManyToOne
    @JoinColumn(name = "cliente_id", nullable = true)
    private User user;
    
    @Column(name = "cliente_nombre", length = 100)
    private String clienteNombre;
    
    @Column(name = "numero_mesa", length = 10)
    private String numeroMesa;

    @ManyToOne
    @JoinColumn(name = "reserva_id")
    private Reserva reserva;

    @ManyToOne
    @JoinColumn(name = "empleado_id")
    private User empleadoAsignado;

    @Column(name = "comentarios", length = 500)
    private String comentarios;

    @Column(nullable = false)
    private double total;

    @Column(length = 50, nullable = false)
    private String estado;

    @Temporal(TemporalType.TIMESTAMP)
    @Column(nullable = false)
    private Date fechaCreacion;

    @Temporal(TemporalType.TIMESTAMP)
    @Column(nullable = false)
    private Date fechaActualizacion;

    @OneToMany(mappedBy = "pedido", cascade = CascadeType.ALL, orphanRemoval = true)
    private List<DetallePedido> detalles;
}
