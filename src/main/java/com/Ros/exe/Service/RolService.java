package com.Ros.exe.Service;

import com.Ros.exe.DTO.RolDto;
import java.util.List;

public interface RolService {

    RolDto crearRol(RolDto rolDto);

    List<RolDto> listarRol();

    RolDto actualizarRol(Long idRol, RolDto rolDto);

    RolDto obtenerPorId(Long idRol);

    boolean eliminarRol(Long idRol);
}
