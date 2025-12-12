package com.Ros.exe.Service;

import com.Ros.exe.Entity.User;

public interface EmpleadoAsignacionService {
    User asignarEmpleadoDisponible();
    boolean empleadoTieneCapacidad(Long empleadoId);
    int contarMesasAsignadas(Long empleadoId);
}