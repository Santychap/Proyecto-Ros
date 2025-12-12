package com.Ros.exe.Impl;

import com.Ros.exe.DTO.CategoriaDto;
import com.Ros.exe.Entity.Categoria;
import com.Ros.exe.Repository.CategoriaRepository;
import com.Ros.exe.Service.CategoriaService;
import org.modelmapper.ModelMapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.Date;
import java.util.List;
import java.util.stream.Collectors;

@Service
public class CategoriaServiceImpl implements CategoriaService {

    @Autowired
    private CategoriaRepository categoriaRepository;
    
    @Autowired
    private ModelMapper modelMapper;

    @Override
    public CategoriaDto crearCategoria(CategoriaDto categoriaDto) {
        Categoria categoria = modelMapper.map(categoriaDto, Categoria.class);
        categoria.setCreatedAt(new Date());
        categoria.setUpdatedAt(new Date());

        Categoria guardada = categoriaRepository.save(categoria);
        return modelMapper.map(guardada, CategoriaDto.class);
    }

    @Override
    public List<CategoriaDto> listarCategoria() {
        return categoriaRepository.findAll().stream()
                .map(this::convertirACategoriaDto)
                .collect(Collectors.toList());
    }

    @Override
    public CategoriaDto obtenerPorId(Long idCategoria) {
        Categoria categoria = categoriaRepository.findById(idCategoria)
                .orElseThrow(() -> new RuntimeException("Categoría no encontrada"));
        return modelMapper.map(categoria, CategoriaDto.class);
    }

    @Override
    public CategoriaDto actualizarCategoria(Long idCategoria, CategoriaDto categoriaDto) {
        Categoria categoria = categoriaRepository.findById(idCategoria)
                .orElseThrow(() -> new RuntimeException("Categoría no encontrada"));

        modelMapper.map(categoriaDto, categoria);
        categoria.setUpdatedAt(new Date());

        Categoria actualizada = categoriaRepository.save(categoria);
        return modelMapper.map(actualizada, CategoriaDto.class);
    }

    @Override
    public boolean eliminarCategoria(Long idCategoria) {
        Categoria categoria = categoriaRepository.findById(idCategoria)
                .orElseThrow(() -> new RuntimeException("Categoría no encontrada"));
        categoriaRepository.delete(categoria);
        return true;
    }

    private CategoriaDto convertirACategoriaDto(Categoria categoria) {
        return modelMapper.map(categoria, CategoriaDto.class);
    }
}
