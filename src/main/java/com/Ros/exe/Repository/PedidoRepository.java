package com.Ros.exe.Repository;

import com.Ros.exe.Entity.Pedido;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.query.Param;
import org.springframework.stereotype.Repository;
import java.util.Date;
import java.util.List;

@Repository
public interface PedidoRepository extends JpaRepository<Pedido, Long> {
    
    @Query("SELECT p FROM Pedido p WHERE p.fechaCreacion BETWEEN :fechaInicio AND :fechaFin")
    List<Pedido> findByFechaCreacionBetween(@Param("fechaInicio") Date fechaInicio, @Param("fechaFin") Date fechaFin);
    
    int countByEmpleadoAsignado_IdUserAndEstadoIn(Long empleadoId, List<String> estados);
    
    List<Pedido> findByUser_IdUser(Long userId);
    
    List<Pedido> findByEmpleadoAsignado_IdUser(Long empleadoId);
}



