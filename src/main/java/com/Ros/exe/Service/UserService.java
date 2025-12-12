package com.Ros.exe.Service;

import com.Ros.exe.DTO.UserDto;
import java.util.List;

public interface UserService {

    UserDto crearUsuario(UserDto userDto);

    List<UserDto> listarUser();

    UserDto actualizarUser(Long idUser, UserDto userDto);

    UserDto obtenerPorId(Long idUser);

    void eliminarUsuario(Long idUser);
    
    void toggleEstadoUsuario(Long idUser);
    
    com.Ros.exe.Entity.User obtenerPorEmail(String email);
}
