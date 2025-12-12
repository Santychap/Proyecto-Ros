package com.Ros.exe.Impl;

import com.Ros.exe.DTO.ProductoDto;
import com.Ros.exe.Entity.Categoria;
import com.Ros.exe.Entity.Promocion;
import com.Ros.exe.Entity.Producto;
import com.Ros.exe.Repository.CategoriaRepository;
import com.Ros.exe.Repository.PromocionRepository;
import com.Ros.exe.Repository.ProductoRepository;
import com.Ros.exe.Service.ProductoService;
import org.modelmapper.ModelMapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.Date;
import java.util.List;
import java.util.stream.Collectors;

@Service
public class ProductoServiceImpl implements ProductoService {

    @Autowired
    private ProductoRepository productoRepository;

    @Autowired
    private CategoriaRepository categoriaRepository;

    @Autowired
    private PromocionRepository promocionRepository;
    
    @Autowired
    private ModelMapper modelMapper;

    @Override
    public ProductoDto crearProducto(ProductoDto productoDto) {
        Producto producto = modelMapper.map(productoDto, Producto.class);

        Categoria categoria = categoriaRepository.findById(productoDto.getCategoriaId())
                .orElseThrow(() -> new RuntimeException("Categoría no encontrada"));
        producto.setCategoria(categoria);

        if (productoDto.getPromocionIds() != null && !productoDto.getPromocionIds().isEmpty()) {
            List<Promocion> promociones = productoDto.getPromocionIds().stream()
                    .map(id -> promocionRepository.findById(id)
                            .orElseThrow(() -> new RuntimeException("Promoción no encontrada con ID: " + id)))
                    .collect(Collectors.toList());
            producto.setPromociones(promociones);
        }

        producto.setCreatedAt(new Date());
        producto.setUpdatedAt(new Date());

        producto = productoRepository.save(producto);
        return convertirAProductoDto(producto);
    }

    @Override
    public List<ProductoDto> listarProducto() {
        return productoRepository.findAll()
                .stream()
                .map(this::convertirAProductoDto)
                .collect(Collectors.toList());
    }

    @Override
    public ProductoDto obtenerProductoPorId(Long idProducto) {
        Producto producto = productoRepository.findById(idProducto)
                .orElseThrow(() -> new RuntimeException("Producto no encontrado con ID: " + idProducto));
        return convertirAProductoDto(producto);
    }

    @Override
    public ProductoDto actualizarProducto(Long idProducto, ProductoDto productoDto) {
        Producto productoExistente = productoRepository.findById(idProducto)
                .orElseThrow(() -> new RuntimeException("Producto no encontrado"));

        // Actualizar campos específicos sin usar modelMapper
        productoExistente.setNombre(productoDto.getNombre());
        productoExistente.setDescripcion(productoDto.getDescripcion());
        productoExistente.setPrecio(productoDto.getPrecio());
        productoExistente.setImagenUrl(productoDto.getImagenUrl());

        Categoria categoria = categoriaRepository.findById(productoDto.getCategoriaId())
                .orElseThrow(() -> new RuntimeException("Categoría no encontrada"));
        productoExistente.setCategoria(categoria);

        if (productoDto.getPromocionIds() != null && !productoDto.getPromocionIds().isEmpty()) {
            List<Promocion> promociones = productoDto.getPromocionIds().stream()
                    .map(id -> promocionRepository.findById(id)
                            .orElseThrow(() -> new RuntimeException("Promoción no encontrada con ID: " + id)))
                    .collect(Collectors.toList());
            productoExistente.setPromociones(promociones);
        } else {
            productoExistente.setPromociones(null);
        }

        productoExistente.setUpdatedAt(new Date());

        Producto productoActualizado = productoRepository.save(productoExistente);
        return convertirAProductoDto(productoActualizado);
    }

    @Override
    public void eliminarProducto(Long idProducto) {
        Producto producto = productoRepository.findById(idProducto)
                .orElseThrow(() -> new RuntimeException("Producto no encontrado"));
        productoRepository.delete(producto);
    }

    private ProductoDto convertirAProductoDto(Producto producto) {
        ProductoDto dto = modelMapper.map(producto, ProductoDto.class);
        if (producto.getCategoria() != null) {
            dto.setCategoriaId(producto.getCategoria().getIdCategoria());
        }
        if (producto.getPromociones() != null && !producto.getPromociones().isEmpty()) {
            dto.setPromocionIds(producto.getPromociones().stream()
                    .map(Promocion::getIdPromocion)
                    .collect(Collectors.toList()));
        }
        return dto;
    }
}
