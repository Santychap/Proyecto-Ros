package com.Ros.exe.Impl;

import com.Ros.exe.DTO.DetallePedidoDto;
import com.Ros.exe.DTO.ProductoDto;
import com.Ros.exe.Entity.DetallePedido;
import com.Ros.exe.Entity.Pedido;
import com.Ros.exe.Entity.Producto;
import com.Ros.exe.Repository.DetallePedidoRepository;
import com.Ros.exe.Repository.PedidoRepository;
import com.Ros.exe.Repository.ProductoRepository;
import com.Ros.exe.Service.DetallePedidoService;
import org.modelmapper.ModelMapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;

import java.util.stream.Collectors;

@Service
public class DetallePedidoServiceImpl implements DetallePedidoService {

    @Autowired
    private DetallePedidoRepository detallePedidoRepository;

    @Autowired
    private PedidoRepository pedidoRepository;

    @Autowired
    private ProductoRepository productoRepository;
    
    @Autowired
    private ModelMapper modelMapper;

    @Override
    public DetallePedidoDto crearDetallePedido(DetallePedidoDto detalleDto) {
        DetallePedido detalle = modelMapper.map(detalleDto, DetallePedido.class);

        Pedido pedido = pedidoRepository.findById(detalleDto.getPedidoId())
                .orElseThrow(() -> new RuntimeException("Pedido no encontrado"));
        Producto producto = productoRepository.findById(detalleDto.getProductoId())
                .orElseThrow(() -> new RuntimeException("Producto no encontrado"));

        detalle.setPedido(pedido);
        detalle.setProducto(producto);

        DetallePedido guardado = detallePedidoRepository.save(detalle);
        return convertirADetallePedidoDto(guardado);
    }

    @Override
    public List<DetallePedidoDto> listarDetallePedido() {
        return detallePedidoRepository.findAll().stream()
                .map(this::convertirADetallePedidoDto)
                .collect(Collectors.toList());
    }

    @Override
    public DetallePedidoDto obtenerPorId(Long id) {
        DetallePedido detalle = detallePedidoRepository.findById(id)
                .orElseThrow(() -> new RuntimeException("Detalle no encontrado"));
        return convertirADetallePedidoDto(detalle);
    }

    @Override
    public DetallePedidoDto actualizarDetallePedido(Long id, DetallePedidoDto detalleDto) {
        DetallePedido detalle = detallePedidoRepository.findById(id)
                .orElseThrow(() -> new RuntimeException("Detalle no encontrado"));

        modelMapper.map(detalleDto, detalle);

        Producto producto = productoRepository.findById(detalleDto.getProductoId())
                .orElseThrow(() -> new RuntimeException("Producto no encontrado"));
        detalle.setProducto(producto);

        DetallePedido actualizado = detallePedidoRepository.save(detalle);
        return convertirADetallePedidoDto(actualizado);
    }

    @Override
    public boolean eliminarDetallePedido(Long id) {
        if (!detallePedidoRepository.existsById(id)) {
            return false;
        }
        detallePedidoRepository.deleteById(id);
        return true;
    }

    private DetallePedidoDto convertirADetallePedidoDto(DetallePedido detalle) {
        DetallePedidoDto dto = modelMapper.map(detalle, DetallePedidoDto.class);
        if (detalle.getPedido() != null) {
            dto.setPedidoId(detalle.getPedido().getId());
        }
        if (detalle.getProducto() != null) {
            dto.setProductoId(detalle.getProducto().getIdProducto());
            dto.setProducto(modelMapper.map(detalle.getProducto(), ProductoDto.class));
        }
        return dto;
    }
}
