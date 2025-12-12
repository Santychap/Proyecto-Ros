package com.Ros.exe.Impl;

import com.Ros.exe.DTO.UserDto;
import com.Ros.exe.Entity.User;
import com.Ros.exe.Entity.Rol;
import com.Ros.exe.Repository.UserRepository;
import com.Ros.exe.Repository.RolRepository;
import com.Ros.exe.Service.UserService;
import org.modelmapper.ModelMapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.stereotype.Service;

import java.util.List;
import java.util.stream.Collectors;

@Service
public class UserServiceImpl implements UserService {

    @Autowired
    private UserRepository userRepository;

    @Autowired
    private RolRepository rolRepository;
    
    @Autowired
    private ModelMapper modelMapper;
    
    @Autowired
    private PasswordEncoder passwordEncoder;

    @Override
    public UserDto crearUsuario(UserDto userDto) {
        User user = modelMapper.map(userDto, User.class);
        
        // Encriptar contraseña
        if (userDto.getPassword() != null) {
            user.setPassword(passwordEncoder.encode(userDto.getPassword()));
        }
        
        // Asegurar que el usuario esté activo por defecto
        user.setActivo(true);
        user.setFechaCreacion(new java.util.Date());
        user.setFechaActualizacion(new java.util.Date());
        
        if (userDto.getRolId() != null) {
            Rol rol = rolRepository.findById(userDto.getRolId())
                    .orElseThrow(() -> new RuntimeException("Rol no encontrado con ID: " + userDto.getRolId()));
            user.setRol(rol);
        }

        User userGuardado = userRepository.save(user);
        System.out.println("Usuario creado con activo: " + userGuardado.getActivo());
        return convertirAUserDto(userGuardado);
    }

    @Override
    public List<UserDto> listarUser() {
        return userRepository.findAll().stream()
                .map(this::convertirAUserDto)
                .collect(Collectors.toList());
    }

    @Override
    public UserDto actualizarUser(Long idUser, UserDto userDto) {
        User userExistente = userRepository.findById(idUser)
                .orElseThrow(() -> new RuntimeException("Usuario no encontrado con ID: " + idUser));

        userExistente.setFechaActualizacion(new java.util.Date());
        
        if (userDto.getRolId() != null) {
            Rol rol = rolRepository.findById(userDto.getRolId())
                    .orElseThrow(() -> new RuntimeException("Rol no encontrado con ID: " + userDto.getRolId()));
            userExistente.setRol(rol);
        }

        User actualizado = userRepository.save(userExistente);
        return convertirAUserDto(actualizado);
    }

    @Override
    public UserDto obtenerPorId(Long idUser) {
        return userRepository.findById(idUser)
                .map(this::convertirAUserDto)
                .orElse(null);
    }

    @Override
    public void eliminarUsuario(Long id) {
        User user = userRepository.findById(id)
                .orElseThrow(() -> new RuntimeException("Usuario no encontrado"));
        user.setActivo(!user.getActivo());
        userRepository.save(user);
    }
    
    @Override
    public void toggleEstadoUsuario(Long id) {
        User user = userRepository.findById(id)
                .orElseThrow(() -> new RuntimeException("Usuario no encontrado"));
        
        // Asegurar que activo no sea null
        Boolean estadoActual = user.getActivo();
        if (estadoActual == null) {
            estadoActual = true;
        }
        
        user.setActivo(!estadoActual);
        user.setFechaActualizacion(new java.util.Date());
        userRepository.save(user);
        
        System.out.println("Usuario " + id + " cambiado de " + estadoActual + " a " + user.getActivo());
    }
    
    @Override
    public User obtenerPorEmail(String email) {
        return userRepository.findByEmail(email).orElse(null);
    }

    private UserDto convertirAUserDto(User user) {
        UserDto dto = modelMapper.map(user, UserDto.class);
        
        // Asegurar que el campo activo se mapee correctamente
        Boolean activo = user.getActivo();
        if (activo == null) {
            activo = true; // Valor por defecto
        }
        dto.setActivo(activo);
        
        if (user.getRol() != null) {
            dto.setRolId(user.getRol().getIdRol());
        }
        return dto;
    }
}
