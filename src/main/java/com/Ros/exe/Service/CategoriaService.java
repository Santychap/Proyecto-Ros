package com.Ros.exe.Service;

import com.Ros.exe.DTO.CategoriaDto;
import java.util.List;

public interface CategoriaService {

    CategoriaDto crearCategoria(CategoriaDto categoriaDto);

    List<CategoriaDto> listarCategoria();

    CategoriaDto obtenerPorId(Long idCategoria);

    CategoriaDto actualizarCategoria(Long idCategoria, CategoriaDto categoriaDto);

    boolean eliminarCategoria(Long idCategoria);
}
