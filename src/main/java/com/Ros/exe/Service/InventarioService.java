package com.Ros.exe.Service;

import com.Ros.exe.DTO.InventarioDto;
import java.util.List;

public interface InventarioService {

    InventarioDto crearInventario(InventarioDto inventarioDto);

    List<InventarioDto> listarInventario();

    InventarioDto obtenerPorId(Long id);

    InventarioDto actualizarInventario(Long id, InventarioDto inventarioDto);

    boolean eliminarInventario(Long id);
}
