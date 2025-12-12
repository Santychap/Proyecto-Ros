package com.Ros.exe.Repository;

import com.Ros.exe.Entity.Reserva;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.query.Param;
import org.springframework.stereotype.Repository;
import java.util.Date;
import java.util.List;

@Repository
public interface ReservaRepository extends JpaRepository<Reserva, Long> {
    
    @Query("SELECT r FROM Reserva r WHERE r.fechaCreacion BETWEEN :fechaInicio AND :fechaFin")
    List<Reserva> findByFechaCreacionBetween(@Param("fechaInicio") Date fechaInicio, @Param("fechaFin") Date fechaFin);
}
