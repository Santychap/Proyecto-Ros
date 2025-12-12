package com.Ros.exe.Service;

import com.Ros.exe.DTO.DetallePedidoDto;
import java.util.List;

public interface DetallePedidoService {

    DetallePedidoDto crearDetallePedido(DetallePedidoDto detalleDto);

    List<DetallePedidoDto> listarDetallePedido();

    DetallePedidoDto obtenerPorId(Long idDetallePedido);

    DetallePedidoDto actualizarDetallePedido(Long idDetallePedido, DetallePedidoDto detalleDto);

    boolean eliminarDetallePedido(Long idDetallePedido);
}

