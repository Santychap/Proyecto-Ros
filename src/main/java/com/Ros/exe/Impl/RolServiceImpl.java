package com.Ros.exe.Impl;

import com.Ros.exe.DTO.RolDto;
import com.Ros.exe.Entity.Rol;
import com.Ros.exe.Repository.RolRepository;
import com.Ros.exe.Service.RolService;
import org.modelmapper.ModelMapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;
import java.util.stream.Collectors;

@Service
public class RolServiceImpl implements RolService {

    @Autowired
    private RolRepository rolRepository;
    
    @Autowired
    private ModelMapper modelMapper;

    @Override
    public RolDto crearRol(RolDto rolDto) {
        Rol rol = modelMapper.map(rolDto, Rol.class);
        Rol nuevo = rolRepository.save(rol);
        return modelMapper.map(nuevo, RolDto.class);
    }

    @Override
    public List<RolDto> listarRol() {
        return rolRepository.findAll()
                .stream()
                .map(this::convertirARolDto)
                .collect(Collectors.toList());
    }

    @Override
    public RolDto actualizarRol(Long idRol, RolDto rolDto) {
        Rol rol = rolRepository.findById(idRol)
                .orElseThrow(() -> new RuntimeException("Rol no encontrado"));
        modelMapper.map(rolDto, rol);
        Rol actualizado = rolRepository.save(rol);
        return modelMapper.map(actualizado, RolDto.class);
    }

    @Override
    public RolDto obtenerPorId(Long idRol) {
        return rolRepository.findById(idRol)
                .map(rol -> modelMapper.map(rol, RolDto.class))
                .orElse(null);
    }

    @Override
    public boolean eliminarRol(Long idRol) {
        if (!rolRepository.existsById(idRol)) {
            return false;
        }
        rolRepository.deleteById(idRol);
        return true;
    }

    private RolDto convertirARolDto(Rol rol) {
        return modelMapper.map(rol, RolDto.class);
    }
}
