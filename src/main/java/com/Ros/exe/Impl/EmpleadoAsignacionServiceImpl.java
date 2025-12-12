package com.Ros.exe.Impl;

import com.Ros.exe.Entity.User;
import com.Ros.exe.Repository.UserRepository;
import com.Ros.exe.Repository.PedidoRepository;
import com.Ros.exe.Service.EmpleadoAsignacionService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;

@Service
public class EmpleadoAsignacionServiceImpl implements EmpleadoAsignacionService {

    @Autowired
    private UserRepository userRepository;
    
    @Autowired
    private PedidoRepository pedidoRepository;

    @Override
    public User asignarEmpleadoDisponible() {
        try {
            // Obtener empleados activos
            List<User> empleados = userRepository.findAll().stream()
                .filter(u -> u.getRol() != null && "EMPLEADO".equals(u.getRol().getNombre()) && u.getActivo())
                .collect(java.util.stream.Collectors.toList());
            
            if (empleados.isEmpty()) {
                return null;
            }
            
            // Buscar empleado con menos de 2 pedidos asignados
            for (User empleado : empleados) {
                if (empleadoTieneCapacidad(empleado.getIdUser())) {
                    return empleado;
                }
            }
            
            // Si todos están ocupados, devolver el primero
            return empleados.get(0);
        } catch (Exception e) {
            return null;
        }
    }

    @Override
    public boolean empleadoTieneCapacidad(Long empleadoId) {
        return contarMesasAsignadas(empleadoId) < 2;
    }

    @Override
    public int contarMesasAsignadas(Long empleadoId) {
        try {
            return (int) pedidoRepository.findAll().stream()
                .filter(p -> p.getEmpleadoAsignado() != null && 
                           p.getEmpleadoAsignado().getIdUser().equals(empleadoId) &&
                           ("confirmado".equals(p.getEstado()) || "en_preparacion".equals(p.getEstado()) || "listo".equals(p.getEstado())))
                .count();
        } catch (Exception e) {
            return 0;
        }
    }
}