package com.Ros.exe.Impl;

import com.Ros.exe.DTO.HorarioDto;
import com.Ros.exe.Entity.Horario;
import com.Ros.exe.Entity.User;
import com.Ros.exe.Repository.HorarioRepository;
import com.Ros.exe.Repository.UserRepository;
import com.Ros.exe.Service.HorarioService;
import org.modelmapper.ModelMapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.Date;
import java.util.List;
import java.util.stream.Collectors;

@Service
public class HorarioServiceImpl implements HorarioService {

    @Autowired
    private HorarioRepository horarioRepository;

    @Autowired
    private UserRepository userRepository;
    
    @Autowired
    private ModelMapper modelMapper;

    @Override
    public HorarioDto crearHorario(HorarioDto horarioDto) {
        Horario horario = modelMapper.map(horarioDto, Horario.class);

        User user = userRepository.findById(horarioDto.getUserId())
                .orElseThrow(() -> new RuntimeException("Usuario no encontrado"));
        horario.setUser(user);

        horario.setFechaCreacion(new Date());
        horario.setFechaActualizacion(new Date());

        Horario guardado = horarioRepository.save(horario);
        return convertirAHorarioDto(guardado);
    }

    @Override
    public List<HorarioDto> listarHorario() {
        return horarioRepository.findAll().stream()
                .map(this::convertirAHorarioDto)
                .collect(Collectors.toList());
    }

    @Override
    public HorarioDto obtenerPorId(Long id) {
        Horario horario = horarioRepository.findById(id)
                .orElseThrow(() -> new RuntimeException("Horario no encontrado"));
        return convertirAHorarioDto(horario);
    }

    @Override
    public HorarioDto actualizarHorario(Long id, HorarioDto horarioDto) {
        Horario horario = horarioRepository.findById(id)
                .orElseThrow(() -> new RuntimeException("Horario no encontrado"));

        if (horarioDto.getDiaSemana() != null) {
            horario.setDiaSemana(horarioDto.getDiaSemana());
        }
        if (horarioDto.getHoraInicio() != null) {
            horario.setHoraInicio(horarioDto.getHoraInicio());
        }
        if (horarioDto.getHoraFin() != null) {
            horario.setHoraFin(horarioDto.getHoraFin());
        }
        if (horarioDto.getUserId() != null) {
            User user = userRepository.findById(horarioDto.getUserId())
                    .orElseThrow(() -> new RuntimeException("Usuario no encontrado"));
            horario.setUser(user);
        }
        horario.setFechaActualizacion(new Date());

        Horario actualizado = horarioRepository.save(horario);
        return convertirAHorarioDto(actualizado);
    }

    @Override
    public boolean eliminarHorario(Long id) {
        Horario horario = horarioRepository.findById(id)
                .orElseThrow(() -> new RuntimeException("Horario no encontrado"));
        horarioRepository.delete(horario);
        return true;
    }

    private HorarioDto convertirAHorarioDto(Horario horario) {
        HorarioDto dto = modelMapper.map(horario, HorarioDto.class);
        if (horario.getUser() != null) {
            dto.setUserId(horario.getUser().getIdUser());
        }
        return dto;
    }
}
