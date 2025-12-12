package com.Ros.exe.Impl;

import com.Ros.exe.DTO.InventarioDto;
import com.Ros.exe.Entity.Inventario;
import com.Ros.exe.Entity.Producto;
import com.Ros.exe.Repository.InventarioRepository;
import com.Ros.exe.Repository.ProductoRepository;
import com.Ros.exe.Service.InventarioService;
import org.modelmapper.ModelMapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.Date;
import java.util.List;

import java.util.stream.Collectors;

@Service
public class InventarioServiceImpl implements InventarioService {

    @Autowired
    private ModelMapper modelMapper;

    @Autowired
    private InventarioRepository inventarioRepository;

    @Autowired
    private ProductoRepository productoRepository;

    @Override
    public InventarioDto crearInventario(InventarioDto inventarioDto) {
        Inventario inventario = modelMapper.map(inventarioDto, Inventario.class);

        Producto producto = productoRepository.findById(inventarioDto.getProductoId())
                .orElseThrow(() -> new RuntimeException("Producto no encontrado"));

        inventario.setProducto(producto);
        inventario.setFechaCreacion(new Date());
        inventario.setFechaActualizacion(new Date());

        Inventario guardado = inventarioRepository.save(inventario);
        return convertirAInventarioDto(guardado);
    }

    @Override
    public List<InventarioDto> listarInventario() {
        return inventarioRepository.findAll().stream()
                .map(this::convertirAInventarioDto)
                .collect(Collectors.toList());
    }

    @Override
    public InventarioDto obtenerPorId(Long id) {
        Inventario inventario = inventarioRepository.findById(id)
                .orElseThrow(() -> new RuntimeException("Inventario no encontrado"));
        return convertirAInventarioDto(inventario);
    }

    @Override
    public InventarioDto actualizarInventario(Long id, InventarioDto inventarioDto) {
        Inventario inventario = inventarioRepository.findById(id)
                .orElseThrow(() -> new RuntimeException("Inventario no encontrado"));

        modelMapper.map(inventarioDto, inventario);

        Producto producto = productoRepository.findById(inventarioDto.getProductoId())
                .orElseThrow(() -> new RuntimeException("Producto no encontrado"));
        inventario.setProducto(producto);
        inventario.setFechaActualizacion(new Date());

        Inventario actualizado = inventarioRepository.save(inventario);
        return convertirAInventarioDto(actualizado);
    }

    @Override
    public boolean eliminarInventario(Long id) {
        if (!inventarioRepository.existsById(id)) {
            return false;
        }
        inventarioRepository.deleteById(id);
        return true;
    }
    
    private InventarioDto convertirAInventarioDto(Inventario inventario) {
        InventarioDto dto = modelMapper.map(inventario, InventarioDto.class);
        if (inventario.getProducto() != null) {
            dto.setProductoId(inventario.getProducto().getIdProducto());
        }
        return dto;
    }
}
