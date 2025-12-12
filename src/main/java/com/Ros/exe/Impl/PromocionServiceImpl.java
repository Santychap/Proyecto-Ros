package com.Ros.exe.Impl;

import com.Ros.exe.DTO.PromocionDto;
import com.Ros.exe.Entity.Promocion;
import com.Ros.exe.Repository.PromocionRepository;
import com.Ros.exe.Service.PromocionService;
import org.modelmapper.ModelMapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.Date;
import java.util.List;
import java.util.Objects;
import java.util.stream.Collectors;

@Service
public class PromocionServiceImpl implements PromocionService {

    @Autowired
    private PromocionRepository promocionRepository;
    
    @Autowired
    private ModelMapper modelMapper;

    @Override
    public PromocionDto crearPromocion(PromocionDto promocionDto) {
        Promocion promocion = modelMapper.map(promocionDto, Promocion.class);
        promocion.setCreatedAt(new Date());
        promocion.setUpdatedAt(new Date());
        
        Promocion guardada = promocionRepository.save(promocion);
        return modelMapper.map(guardada, PromocionDto.class);
    }

    @Override
    public List<PromocionDto> listarPromociones() {
        return promocionRepository.findAll()
                .stream()
                .map(promocion -> modelMapper.map(promocion, PromocionDto.class))
                .collect(Collectors.toList());
    }

    @Override
    public PromocionDto actualizarPromocion(Long idPromocion, PromocionDto promocionDto) {
        Promocion promocion = promocionRepository.findById(Objects.requireNonNull(idPromocion))
                .orElseThrow(() -> new RuntimeException("Promoción no encontrada con ID: " + idPromocion));

        modelMapper.map(promocionDto, promocion);
        promocion.setUpdatedAt(new Date());

        Promocion actualizada = promocionRepository.save(promocion);
        return modelMapper.map(actualizada, PromocionDto.class);
    }

    @Override
    public void eliminarPromocion(Long idPromocion) {
        if (!promocionRepository.existsById(Objects.requireNonNull(idPromocion))) {
            throw new RuntimeException("Promoción no encontrada con ID: " + idPromocion);
        }
        promocionRepository.deleteById(Objects.requireNonNull(idPromocion));
    }
}
