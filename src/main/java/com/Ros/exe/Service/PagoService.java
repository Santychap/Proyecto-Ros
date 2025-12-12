package com.Ros.exe.Service;

import com.Ros.exe.DTO.PagoDto;
import java.util.List;

public interface PagoService {
    PagoDto procesarPago(Long pedidoId, String metodoPago, String numeroTarjeta, String numeroNequi);
    PagoDto obtenerPagoPorPedido(Long pedidoId);
    List<PagoDto> listarPago();
    PagoDto crearPago(PagoDto pagoDto);
    PagoDto actualizarPago(Long idPago, PagoDto pagoDto);
    boolean eliminarPago(Long idPago);
}