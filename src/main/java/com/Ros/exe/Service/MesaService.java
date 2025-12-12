package com.Ros.exe.Service;

import com.Ros.exe.DTO.MesaDto;
import java.util.List;

public interface MesaService {

    MesaDto crearMesa(MesaDto mesaDto);

    List<MesaDto> listarMesa();

    MesaDto actualizarMesa(Long idMesa, MesaDto mesaDto);

    boolean eliminarMesa(Long idMesa);
}
