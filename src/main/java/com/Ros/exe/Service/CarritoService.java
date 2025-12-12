package com.Ros.exe.Service;

import com.Ros.exe.Entity.CarritoItem;
import org.springframework.stereotype.Service;
import org.springframework.web.context.annotation.SessionScope;

import java.util.ArrayList;
import java.util.List;

@Service
@SessionScope
public class CarritoService {
    
    private List<CarritoItem> items = new ArrayList<>();
    
    public void agregarItem(Long productoId, String nombre, Double precio) {
        CarritoItem existente = items.stream()
                .filter(item -> item.getProductoId().equals(productoId))
                .findFirst()
                .orElse(null);
                
        if (existente != null) {
            existente.setCantidad(existente.getCantidad() + 1);
            existente.calcularSubtotal();
        } else {
            items.add(new CarritoItem(productoId, nombre, precio, 1));
        }
    }
    
    public void removerItem(Long productoId) {
        items.removeIf(item -> item.getProductoId().equals(productoId));
    }
    
    public void actualizarCantidad(Long productoId, Integer cantidad) {
        items.stream()
                .filter(item -> item.getProductoId().equals(productoId))
                .findFirst()
                .ifPresent(item -> {
                    item.setCantidad(cantidad);
                    item.calcularSubtotal();
                });
    }
    
    public List<CarritoItem> getItems() {
        return items;
    }
    
    public Double getTotal() {
        return items.stream()
                .mapToDouble(CarritoItem::getSubtotal)
                .sum();
    }
    
    public Integer getCantidadTotal() {
        return items.stream()
                .mapToInt(CarritoItem::getCantidad)
                .sum();
    }
    
    public void limpiarCarrito() {
        items.clear();
    }
}