package com.Ros.exe.Service;

import com.Ros.exe.DTO.DetallePagoDto;
import java.util.List;

public interface DetallePagoService {

    DetallePagoDto crearDetallePago(DetallePagoDto detallePagoDto);

    List<DetallePagoDto> listarDetallePago();

    DetallePagoDto obtenerPorId(Long idDetalle);

    DetallePagoDto actualizarDetallePago(Long idDetalle, DetallePagoDto detallePagoDto);

    boolean eliminarDetallePago(Long idDetalle);
}
