package com.Ros.exe.Service;

import com.Ros.exe.DTO.ProductoDto;
import java.util.List;

public interface ProductoService {

    ProductoDto crearProducto(ProductoDto productoDto);

    List<ProductoDto> listarProducto();

    ProductoDto obtenerProductoPorId(Long idProducto);

    ProductoDto actualizarProducto(Long idProducto, ProductoDto productoDto);

    void eliminarProducto(Long idProducto);
}
