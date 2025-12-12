package com.Ros.exe.Service;

import com.Ros.exe.DTO.HorarioDto;
import java.util.List;

public interface HorarioService {

    HorarioDto crearHorario(HorarioDto horarioDto);

    List<HorarioDto> listarHorario();

    HorarioDto obtenerPorId(Long id);

    HorarioDto actualizarHorario(Long id, HorarioDto horarioDto);

    boolean eliminarHorario(Long id);
}
