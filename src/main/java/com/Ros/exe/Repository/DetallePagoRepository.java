package com.Ros.exe.Repository;

import com.Ros.exe.Entity.DetallePago;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

@Repository
public interface DetallePagoRepository extends JpaRepository<DetallePago, Long> {}
