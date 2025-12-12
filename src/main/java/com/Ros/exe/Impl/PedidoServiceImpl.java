package com.Ros.exe.Impl;

import com.Ros.exe.DTO.PedidoDto;
import com.Ros.exe.DTO.DetallePedidoDto;
import com.Ros.exe.DTO.ProductoDto;
import com.Ros.exe.Entity.Pedido;
import com.Ros.exe.Entity.DetallePedido;
import com.Ros.exe.Entity.User;
import com.Ros.exe.Entity.Reserva;
import com.Ros.exe.Entity.Producto;
import com.Ros.exe.Entity.CarritoItem;
import com.Ros.exe.Repository.*;
import com.Ros.exe.Service.PedidoService;
import com.Ros.exe.Service.EmpleadoAsignacionService;
import org.modelmapper.ModelMapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.Date;
import java.util.List;

import java.util.stream.Collectors;

@Service
public class PedidoServiceImpl implements PedidoService {

    @Autowired
    private PedidoRepository pedidoRepository;

    @Autowired
    private UserRepository userRepository;

    @Autowired
    private ReservaRepository reservaRepository;

    @Autowired
    private ProductoRepository productoRepository;

    @Autowired
    private ModelMapper modelMapper;
    
    @Autowired
    private EmpleadoAsignacionService empleadoAsignacionService;



    @Override
    public PedidoDto crearPedidoPublico(List<CarritoItem> items, String numeroMesa, String nombreCliente) {
        return crearPedidoPublicoCompleto(items, numeroMesa, nombreCliente, null, null);
    }
    
    @Override
    public PedidoDto crearPedidoPublicoCompleto(List<CarritoItem> items, String numeroMesa, String nombreCliente, Long userId, String comentarios) {
        if (items == null || items.isEmpty()) {
            throw new IllegalArgumentException("El carrito no puede estar vacío");
        }
        
        Pedido pedido = new Pedido();
        pedido.setEstado("SIN_CANCELAR"); // Estado inicial para pedidos sin pago online
        pedido.setFechaCreacion(new Date());
        pedido.setFechaActualizacion(new Date());
        pedido.setClienteNombre(nombreCliente);
        pedido.setNumeroMesa(numeroMesa);
        pedido.setComentarios(comentarios);
        
        // Si hay usuario autenticado, asociarlo al pedido
        if (userId != null) {
            User usuario = userRepository.findById(userId)
                    .orElseThrow(() -> new RuntimeException("Usuario no encontrado"));
            pedido.setUser(usuario);
        }
        
        // Asignar empleado automáticamente
        try {
            User empleadoAsignado = empleadoAsignacionService.asignarEmpleadoDisponible();
            if (empleadoAsignado != null) {
                pedido.setEmpleadoAsignado(empleadoAsignado);
            }
        } catch (Exception e) {
            // Si falla la asignación, continuar sin empleado asignado
        }
        
        // Calcular total y crear detalles
        List<DetallePedido> detalles = items.stream().map(item -> {
            Producto producto = productoRepository.findById(item.getProductoId())
                    .orElseThrow(() -> new RuntimeException("Producto no encontrado: " + item.getProductoId()));
            
            DetallePedido detalle = new DetallePedido();
            detalle.setProducto(producto);
            detalle.setCantidad(item.getCantidad());
            detalle.setPrecio(item.getPrecio());
            detalle.setPedido(pedido);
            return detalle;
        }).collect(Collectors.toList());
        
        double total = items.stream().mapToDouble(item -> item.getPrecio() * item.getCantidad()).sum();
        pedido.setTotal(total);
        pedido.setDetalles(detalles);
        
        Pedido pedidoGuardado = pedidoRepository.save(pedido);
        return convertirAPedidoDto(pedidoGuardado);
    }

    @Override
    public PedidoDto crearPedido(PedidoDto pedidoDto) {
        if (pedidoDto == null) {
            throw new IllegalArgumentException("El pedido no puede ser nulo");
        }
        Pedido pedido = modelMapper.map(pedidoDto, Pedido.class);

        User user = userRepository.findById(pedidoDto.getUserId())
                .orElseThrow(() -> new RuntimeException("Usuario no encontrado"));
        pedido.setUser(user);

        if (pedidoDto.getReservaId() != null) {
            Reserva reserva = reservaRepository.findById(pedidoDto.getReservaId())
                    .orElseThrow(() -> new RuntimeException("Reserva no encontrada"));
            pedido.setReserva(reserva);
        }

        pedido.setFechaCreacion(new Date());
        pedido.setFechaActualizacion(new Date());

        if (pedidoDto.getDetalles() != null && !pedidoDto.getDetalles().isEmpty()) {
            List<DetallePedido> detalles = pedidoDto.getDetalles().stream().map(d -> {
                DetallePedido detalle = new DetallePedido();
                Producto producto = productoRepository.findById(d.getProductoId())
                        .orElseThrow(() -> new RuntimeException("Producto no encontrado"));
                detalle.setProducto(producto);
                detalle.setCantidad(d.getCantidad());
                detalle.setPrecio(d.getPrecio());
                detalle.setPedido(pedido);
                return detalle;
            }).collect(Collectors.toList());
            pedido.setDetalles(detalles);
        }

        Pedido pedidoGuardado = pedidoRepository.save(pedido);
        return convertirAPedidoDto(pedidoGuardado);
    }

    @Override
    public List<PedidoDto> listarPedido() {
        return pedidoRepository.findAll().stream()
                .map(this::convertirAPedidoDto)
                .collect(Collectors.toList());
    }

    @Override
    public PedidoDto obtenerPedido(Long idPedido) {
        try {
            return pedidoRepository.findById(idPedido)
                    .map(this::convertirAPedidoDto)
                    .orElse(null);
        } catch (Exception e) {
            return null;
        }
    }

    @Override
    public PedidoDto actualizarPedido(Long idPedido, PedidoDto pedidoDto) {
        Pedido pedido = pedidoRepository.findById(idPedido)
                .orElseThrow(() -> new RuntimeException("Pedido no encontrado"));

        modelMapper.map(pedidoDto, pedido);
        pedido.setFechaActualizacion(new Date());

        User user = userRepository.findById(pedidoDto.getUserId())
                .orElseThrow(() -> new RuntimeException("Usuario no encontrado"));
        pedido.setUser(user);

        if (pedidoDto.getReservaId() != null) {
            Reserva reserva = reservaRepository.findById(pedidoDto.getReservaId())
                    .orElseThrow(() -> new RuntimeException("Reserva no encontrada"));
            pedido.setReserva(reserva);
        } else {
            pedido.setReserva(null);
        }

        if (pedidoDto.getDetalles() != null) {
            pedido.getDetalles().clear();

            List<DetallePedido> nuevosDetalles = pedidoDto.getDetalles().stream().map(d -> {
                DetallePedido detalle = new DetallePedido();
                Producto producto = productoRepository.findById(d.getProductoId())
                        .orElseThrow(() -> new RuntimeException("Producto no encontrado"));
                detalle.setProducto(producto);
                detalle.setCantidad(d.getCantidad());
                detalle.setPrecio(d.getPrecio());
                detalle.setPedido(pedido);
                return detalle;
            }).collect(Collectors.toList());

            pedido.getDetalles().addAll(nuevosDetalles);
        }

        Pedido pedidoActualizado = pedidoRepository.save(pedido);
        return convertirAPedidoDto(pedidoActualizado);
    }

    @Override
    public boolean eliminarPedido(Long idPedido) {
        if (!pedidoRepository.existsById(idPedido)) {
            return false;
        }
        pedidoRepository.deleteById(idPedido);
        return true;
    }

    private PedidoDto convertirAPedidoDto(Pedido pedido) {
        PedidoDto dto = new PedidoDto();
        dto.setId(pedido.getId());
        dto.setTotal(pedido.getTotal());
        dto.setEstado(pedido.getEstado());
        dto.setFechaCreacion(pedido.getFechaCreacion());
        dto.setFechaActualizacion(pedido.getFechaActualizacion());
        dto.setClienteNombre(pedido.getClienteNombre());
        dto.setNumeroMesa(pedido.getNumeroMesa());
        dto.setComentarios(pedido.getComentarios());
        
        if (pedido.getUser() != null) {
            dto.setUserId(pedido.getUser().getIdUser());
        }
        if (pedido.getReserva() != null) {
            dto.setReservaId(pedido.getReserva().getId());
        }
        if (pedido.getEmpleadoAsignado() != null) {
            dto.setEmpleadoAsignadoId(pedido.getEmpleadoAsignado().getIdUser());
        }
        
        return dto;
    }

    private DetallePedidoDto convertirADetallePedidoDto(DetallePedido detalle) {
        DetallePedidoDto dto = new DetallePedidoDto();
        dto.setId(detalle.getId());
        dto.setCantidad(detalle.getCantidad());
        dto.setPrecio(detalle.getPrecio());
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
