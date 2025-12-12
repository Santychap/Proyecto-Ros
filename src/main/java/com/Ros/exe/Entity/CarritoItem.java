package com.Ros.exe.Entity;

import lombok.Data;

@Data
public class CarritoItem {
    private Long productoId;
    private String nombre;
    private Double precio;
    private Integer cantidad;
    private Double subtotal;
    
    public CarritoItem() {}
    
    public CarritoItem(Long productoId, String nombre, Double precio, Integer cantidad) {
        this.productoId = productoId;
        this.nombre = nombre;
        this.precio = precio;
        this.cantidad = cantidad;
        this.subtotal = precio * cantidad;
    }
    
    public void calcularSubtotal() {
        this.subtotal = this.precio * this.cantidad;
    }
}