package com.Ros.exe.Impl;

import com.Ros.exe.DTO.MesaDto;
import com.Ros.exe.Entity.Mesa;
import com.Ros.exe.Repository.MesaRepository;
import com.Ros.exe.Service.MesaService;
import org.modelmapper.ModelMapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;
import java.util.Date;
import java.util.List;
import java.util.stream.Collectors;

@Service
public class MesaServiceImpl implements MesaService {

    @Autowired
    private MesaRepository mesaRepository;
    
    @Autowired
    private ModelMapper modelMapper;

    @Override
    public MesaDto crearMesa(MesaDto mesaDto) {
        Mesa mesa = modelMapper.map(mesaDto, Mesa.class);
        mesa.setEstado(mesaDto.getEstado() != null ? mesaDto.getEstado() : "libre");
        mesa.setFechaCreacion(new Date());
        Mesa nuevaMesa = mesaRepository.save(mesa);
        return modelMapper.map(nuevaMesa, MesaDto.class);
    }

    @Override
    public List<MesaDto> listarMesa() {
        return mesaRepository.findAll()
                .stream()
                .map(this::convertirAMesaDto)
                .collect(Collectors.toList());
    }

    @Override
    public MesaDto actualizarMesa(Long idMesa, MesaDto mesaDto) {
        Mesa mesa = mesaRepository.findById(idMesa)
                .orElseThrow(() -> new RuntimeException("Mesa no encontrada"));
        
        mesa.setNumeroMesa(mesaDto.getNumeroMesa());
        mesa.setCapacidad(mesaDto.getCapacidad());
        if (mesaDto.getUbicacion() != null) {
            mesa.setUbicacion(mesaDto.getUbicacion());
        }
        if (mesaDto.getEstado() != null) {
            mesa.setEstado(mesaDto.getEstado());
        }
        
        Mesa guardada = mesaRepository.save(mesa);
        return convertirAMesaDto(guardada);
    }

    @Override
    public boolean eliminarMesa(Long idMesa) {
        if (!mesaRepository.existsById(idMesa)) {
            return false;
        }
        mesaRepository.deleteById(idMesa);
        return true;
    }

    private MesaDto convertirAMesaDto(Mesa mesa) {
        return modelMapper.map(mesa, MesaDto.class);
    }
}
