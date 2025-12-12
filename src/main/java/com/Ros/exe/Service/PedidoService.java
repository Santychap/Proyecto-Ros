package com.Ros.exe.Service;

import com.Ros.exe.DTO.PedidoDto;
import com.Ros.exe.Entity.CarritoItem;
import java.util.List;

public interface PedidoService {

    PedidoDto crearPedido(PedidoDto pedidoDto);
    
    PedidoDto crearPedidoPublico(List<CarritoItem> items, String numeroMesa, String nombreCliente);
    
    PedidoDto crearPedidoPublicoCompleto(List<CarritoItem> items, String numeroMesa, String nombreCliente, Long userId, String comentarios);

    List<PedidoDto> listarPedido();

    PedidoDto actualizarPedido(Long idPedido, PedidoDto pedidoDto);

    PedidoDto obtenerPedido(Long idPedido);

    boolean eliminarPedido(Long idPedido);
}
