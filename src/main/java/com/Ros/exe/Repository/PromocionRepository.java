package com.Ros.exe.Repository;

import com.Ros.exe.Entity.Promocion;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

@Repository
public interface PromocionRepository extends JpaRepository<Promocion, Long> {}







