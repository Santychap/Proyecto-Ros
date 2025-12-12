package com.Ros.exe.Service;

import com.Ros.exe.DTO.NoticiaDto;
import java.util.List;

public interface NoticiaService {

    NoticiaDto crearNoticia(NoticiaDto noticiaDto);

    List<NoticiaDto> listarNoticias();

    NoticiaDto actualizarNoticia(Long idNoticia, NoticiaDto noticiaDto);

    boolean eliminarNoticia(Long idNoticia);
}
