package com.Ros.exe.Repository;

import com.Ros.exe.Entity.Pago;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.query.Param;
import org.springframework.stereotype.Repository;
import java.util.Date;
import java.util.List;
import java.util.Optional;

@Repository
public interface PagoRepository extends JpaRepository<Pago, Long> {
    
    @Query("SELECT p FROM Pago p WHERE p.fechaCreacion BETWEEN :fechaInicio AND :fechaFin")
    List<Pago> findByFechaCreacionBetween(@Param("fechaInicio") Date fechaInicio, @Param("fechaFin") Date fechaFin);
    
    java.util.Optional<Pago> findByPedido_Id(Long pedidoId);
}