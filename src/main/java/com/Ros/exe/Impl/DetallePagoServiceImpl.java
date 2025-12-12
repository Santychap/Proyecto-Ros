package com.Ros.exe.Impl;

import com.Ros.exe.DTO.DetallePagoDto;
import com.Ros.exe.Entity.DetallePago;
import com.Ros.exe.Entity.Pago;
import com.Ros.exe.Repository.DetallePagoRepository;
import com.Ros.exe.Repository.PagoRepository;
import com.Ros.exe.Service.DetallePagoService;
import org.modelmapper.ModelMapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.Date;
import java.util.List;

import java.util.stream.Collectors;

@Service
public class DetallePagoServiceImpl implements DetallePagoService {

    @Autowired
    private ModelMapper modelMapper;

    @Autowired
    private DetallePagoRepository detallePagoRepository;

    @Autowired
    private PagoRepository pagoRepository;

    @Override
    public DetallePagoDto crearDetallePago(DetallePagoDto dto) {

        DetallePago detalle = new DetallePago();

        // Transformación del DTO → Entity
        detalle.setMonto(dto.getMonto());
        detalle.setDescripcion(dto.getDescripcion());
        detalle.setFechaCreacion(new Date());
        detalle.setFechaActualizacion(new Date());

        Pago pago = pagoRepository.findById(dto.getPagoId())
                .orElseThrow(() -> new RuntimeException("Pago no encontrado"));

        detalle.setPago(pago);

        DetallePago guardado = detallePagoRepository.save(detalle);
        return modelMapper.map(guardado, DetallePagoDto.class);
    }

    @Override
    public List<DetallePagoDto> listarDetallePago() {
        return detallePagoRepository.findAll().stream()
                .map(detalle -> modelMapper.map(detalle, DetallePagoDto.class))
                .collect(Collectors.toList());
    }

    @Override
    public DetallePagoDto obtenerPorId(Long idDetalle) {
        return detallePagoRepository.findById(idDetalle)
                .map(detalle -> modelMapper.map(detalle, DetallePagoDto.class))
                .orElse(null);
    }

    @Override
    public DetallePagoDto actualizarDetallePago(Long idDetalle, DetallePagoDto detallePagoDto) {
        DetallePago detalle = detallePagoRepository.findById(idDetalle)
                .orElseThrow(() -> new RuntimeException("Detalle no encontrado"));

        Pago pago = pagoRepository.findById(detallePagoDto.getPagoId())
                .orElseThrow(() -> new RuntimeException("Pago no encontrado"));

        modelMapper.map(detallePagoDto, detalle);
        detalle.setPago(pago);
        detalle.setFechaActualizacion(new Date());

        DetallePago actualizado = detallePagoRepository.save(detalle);
        return modelMapper.map(actualizado, DetallePagoDto.class);
    }

    @Override
    public boolean eliminarDetallePago(Long idDetalle) {
        if (!detallePagoRepository.existsById(idDetalle)) {
            return false;
        }
        detallePagoRepository.deleteById(idDetalle);
        return true;
    }
}
