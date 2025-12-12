package com.Ros.exe.DTO;

import lombok.Data;
import java.util.Date;

@Data
public class UserDto {
    private Long idUser;
    private String nombre;
    private String apellido;
    private String email;
    private String password;
    private Boolean activo;
    private Date fechaCreacion;
    private Date fechaActualizacion;
    private Date fechaRegistro; // Alias para fechaCreacion
    private Long rolId;
    private RolDto rol;
}