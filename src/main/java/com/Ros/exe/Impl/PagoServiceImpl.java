package com.Ros.exe.Impl;

import com.Ros.exe.DTO.PagoDto;
import com.Ros.exe.Entity.Pago;
import com.Ros.exe.Entity.Pedido;
import com.Ros.exe.Entity.DetallePago;
import com.Ros.exe.Repository.PagoRepository;
import com.Ros.exe.Repository.PedidoRepository;
import com.Ros.exe.Service.PagoService;
import org.modelmapper.ModelMapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.Date;
import java.util.List;
import java.util.stream.Collectors;

@Service
public class PagoServiceImpl implements PagoService {

    @Autowired
    private PagoRepository pagoRepository;
    
    @Autowired
    private PedidoRepository pedidoRepository;
    
    @Autowired
    private ModelMapper modelMapper;

    @Override
    public PagoDto procesarPago(Long pedidoId, String metodoPago, String numeroTarjeta, String numeroNequi) {
        Pedido pedido = pedidoRepository.findById(pedidoId)
                .orElseThrow(() -> new RuntimeException("Pedido no encontrado"));

        // Simular validación de pago
        boolean pagoExitoso = simularProcesoPago(metodoPago, numeroTarjeta, numeroNequi);
        
        if (!pagoExitoso) {
            throw new RuntimeException("Error en el procesamiento del pago");
        }

        // Crear registro de pago
        Pago pago = new Pago();
        pago.setPedido(pedido);
        pago.setMetodoPago(metodoPago);
        pago.setMontoTotal(pedido.getTotal());
        pago.setEstado("completado");
        pago.setFechaPago(new Date());
        pago.setFechaCreacion(new Date());
        pago.setFechaActualizacion(new Date());
        
        if (pedido.getUser() != null) {
            pago.setUser(pedido.getUser());
        }

        Pago pagoGuardado = pagoRepository.save(pago);
        
        // Crear detalle de pago automáticamente
        DetallePago detalle = new DetallePago();
        detalle.setPago(pagoGuardado);
        detalle.setMonto(pagoGuardado.getMontoTotal());
        detalle.setDescripcion("Pago de pedido #" + pedido.getId() + " - " + metodoPago);
        detalle.setFechaCreacion(new Date());
        detalle.setFechaActualizacion(new Date());
        
        // Agregar detalle a la lista del pago
        if (pagoGuardado.getDetalles() == null) {
            pagoGuardado.setDetalles(new java.util.ArrayList<>());
        }
        pagoGuardado.getDetalles().add(detalle);
        
        // Actualizar estado del pedido a PAGADO cuando se paga online
        pedido.setEstado("PAGADO");
        pedidoRepository.save(pedido);

        return convertirAPagoDto(pagoGuardado);
    }

    @Override
    public PagoDto obtenerPagoPorPedido(Long pedidoId) {
        return pagoRepository.findByPedido_Id(pedidoId)
                .map(this::convertirAPagoDto)
                .orElse(null);
    }

    private boolean simularProcesoPago(String metodoPago, String numeroTarjeta, String numeroNequi) {
        switch (metodoPago.toLowerCase()) {
            case "tarjeta":
                return validarTarjeta(numeroTarjeta);
            case "nequi":
                return validarNequi(numeroNequi);
            case "daviplata":
                return validarDaviplata(numeroNequi);
            case "pse":
                return true; // PSE siempre exitoso en simulación
            default:
                return false;
        }
    }

    private boolean validarTarjeta(String numeroTarjeta) {
        return numeroTarjeta != null && numeroTarjeta.length() >= 16;
    }

    private boolean validarNequi(String numeroNequi) {
        return numeroNequi != null && numeroNequi.length() == 10;
    }

    private boolean validarDaviplata(String numeroDaviplata) {
        return numeroDaviplata != null && numeroDaviplata.length() == 10;
    }

    @Override
    public List<PagoDto> listarPago() {
        return pagoRepository.findAll().stream()
                .map(this::convertirAPagoDto)
                .collect(Collectors.toList());
    }

    @Override
    public PagoDto crearPago(PagoDto pagoDto) {
        Pago pago = modelMapper.map(pagoDto, Pago.class);
        
        if (pagoDto.getPedidoId() != null) {
            Pedido pedido = pedidoRepository.findById(pagoDto.getPedidoId())
                    .orElseThrow(() -> new RuntimeException("Pedido no encontrado"));
            pago.setPedido(pedido);
        }
        
        pago.setFechaCreacion(new Date());
        pago.setFechaActualizacion(new Date());
        
        Pago pagoGuardado = pagoRepository.save(pago);
        return convertirAPagoDto(pagoGuardado);
    }

    @Override
    public PagoDto actualizarPago(Long idPago, PagoDto pagoDto) {
        Pago pagoExistente = pagoRepository.findById(idPago)
                .orElseThrow(() -> new RuntimeException("Pago no encontrado"));
        
        pagoExistente.setMetodoPago(pagoDto.getMetodoPago());
        pagoExistente.setMontoTotal(pagoDto.getMontoTotal());
        pagoExistente.setEstado(pagoDto.getEstado());
        pagoExistente.setFechaActualizacion(new Date());
        
        Pago pagoActualizado = pagoRepository.save(pagoExistente);
        return convertirAPagoDto(pagoActualizado);
    }

    @Override
    public boolean eliminarPago(Long idPago) {
        if (!pagoRepository.existsById(idPago)) {
            return false;
        }
        pagoRepository.deleteById(idPago);
        return true;
    }

    private PagoDto convertirAPagoDto(Pago pago) {
        PagoDto dto = modelMapper.map(pago, PagoDto.class);
        if (pago.getUser() != null) {
            dto.setUserId(pago.getUser().getIdUser());
        }
        if (pago.getPedido() != null) {
            dto.setPedidoId(pago.getPedido().getId());
        }
        return dto;
    }
}