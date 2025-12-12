package com.Ros.exe.Impl;

import com.Ros.exe.DTO.NoticiaDto;
import com.Ros.exe.Entity.Noticia;
import com.Ros.exe.Repository.NoticiaRepository;
import com.Ros.exe.Service.NoticiaService;
import org.modelmapper.ModelMapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;
import java.util.Date;
import java.util.List;

import java.util.stream.Collectors;

@Service
public class NoticiaServiceImpl implements NoticiaService {

    @Autowired
    private NoticiaRepository noticiaRepository;

    @Autowired
    private ModelMapper modelMapper;

    @Override
    public NoticiaDto crearNoticia(NoticiaDto noticiaDto) {
        Noticia noticia = modelMapper.map(noticiaDto, Noticia.class);
        
        if (noticia.getFechaPublicacion() == null) {
            noticia.setFechaPublicacion(new Date());
        }
        noticia.setFechaActualizacion(new Date());
        
        Noticia nuevaNoticia = noticiaRepository.save(noticia);
        return modelMapper.map(nuevaNoticia, NoticiaDto.class);
    }

    @Override
    public List<NoticiaDto> listarNoticias() {
        return noticiaRepository.findAll()
                .stream()
                .map(noticia -> modelMapper.map(noticia, NoticiaDto.class))
                .collect(Collectors.toList());
    }

    @Override
    public NoticiaDto actualizarNoticia(Long idNoticia, NoticiaDto noticiaDto) {
        Noticia noticiaExistente = noticiaRepository.findById(idNoticia)
                .orElseThrow(() -> new RuntimeException("Noticia no encontrada con ID: " + idNoticia));

        modelMapper.map(noticiaDto, noticiaExistente);
        noticiaExistente.setId(idNoticia);
        noticiaExistente.setFechaActualizacion(new Date());

        Noticia guardada = noticiaRepository.save(noticiaExistente);
        return modelMapper.map(guardada, NoticiaDto.class);
    }

    @Override
    public boolean eliminarNoticia(Long idNoticia) {
        if (!noticiaRepository.existsById(idNoticia)) {
            return false;
        }
        noticiaRepository.deleteById(idNoticia);
        return true;
    }
}
