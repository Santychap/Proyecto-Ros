package com.Ros.exe.Service;

import com.Ros.exe.DTO.PromocionDto;
import java.util.List;

public interface PromocionService {

    PromocionDto crearPromocion(PromocionDto promocionDto);

    List<PromocionDto> listarPromociones();


    PromocionDto actualizarPromocion(Long idPromocion, PromocionDto promocionDto);


    void eliminarPromocion(Long idPromocion);
}
