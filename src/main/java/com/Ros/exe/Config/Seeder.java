package com.Ros.exe.Config;

import com.Ros.exe.Entity.*;
import com.Ros.exe.Repository.*;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.boot.CommandLineRunner;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.stereotype.Component;

import java.util.Date;
import java.util.Arrays;

@Component
public class Seeder implements CommandLineRunner {

    @Autowired
    private RolRepository rolRepository;
    
    @Autowired
    private UserRepository userRepository;
    
    @Autowired
    private CategoriaRepository categoriaRepository;
    
    @Autowired
    private ProductoRepository productoRepository;
    
    @Autowired
    private MesaRepository mesaRepository;
    
    @Autowired
    private PromocionRepository promocionRepository;
    
    @Autowired
    private NoticiaRepository noticiaRepository;
    
    @Autowired
    private PasswordEncoder passwordEncoder;

    @Override
    public void run(String... args) throws Exception {
        loadInitialData();
    }

    private void loadInitialData() {
        // Crear roles básicos si no existen
        Rol adminRole = rolRepository.findByNombre("ADMINISTRADOR")
                .orElseGet(() -> {
                    Rol rol = new Rol();
                    rol.setNombre("ADMINISTRADOR");
                    return rolRepository.save(rol);
                });

        Rol clienteRole = rolRepository.findByNombre("CLIENTE")
                .orElseGet(() -> {
                    Rol rol = new Rol();
                    rol.setNombre("CLIENTE");
                    return rolRepository.save(rol);
                });

        Rol empleadoRole = rolRepository.findByNombre("EMPLEADO")
                .orElseGet(() -> {
                    Rol rol = new Rol();
                    rol.setNombre("EMPLEADO");
                    return rolRepository.save(rol);
                });

        // Crear usuario administrador si no existe
        if (!userRepository.findByEmail("admin@restaurant.com").isPresent()) {
            User admin = new User();
            admin.setNombre("Admin");
            admin.setApellido("Sistema");
            admin.setEmail("admin@restaurant.com");
            admin.setPassword(passwordEncoder.encode("1234"));
            admin.setRol(adminRole);
            admin.setActivo(true);
            admin.setFechaCreacion(new Date());
            admin.setFechaActualizacion(new Date());
            userRepository.save(admin);
            System.out.println("Usuario admin creado");
        }

        // Crear usuario cliente de prueba si no existe
        if (!userRepository.findByEmail("cliente@restaurant.com").isPresent()) {
            User cliente = new User();
            cliente.setNombre("Cliente");
            cliente.setApellido("Prueba");
            cliente.setEmail("cliente@restaurant.com");
            cliente.setPassword(passwordEncoder.encode("1234"));
            cliente.setRol(clienteRole);
            cliente.setActivo(true);
            cliente.setFechaCreacion(new Date());
            cliente.setFechaActualizacion(new Date());
            userRepository.save(cliente);
            System.out.println("Usuario cliente creado");
        }

        // Crear usuario empleado de prueba si no existe
        if (!userRepository.findByEmail("empleado@restaurant.com").isPresent()) {
            User empleado = new User();
            empleado.setNombre("Empleado");
            empleado.setApellido("Prueba");
            empleado.setEmail("empleado@restaurant.com");
            empleado.setPassword(passwordEncoder.encode("1234"));
            empleado.setRol(empleadoRole);
            empleado.setActivo(true);
            empleado.setFechaCreacion(new Date());
            empleado.setFechaActualizacion(new Date());
            userRepository.save(empleado);
            System.out.println("Usuario empleado creado");
        }

        // Crear usuarios empleados de ejemplo si no existen
        if (!userRepository.findByEmail("carlos.empleado@restaurant.com").isPresent()) {
            User empleado1 = new User();
            empleado1.setNombre("Carlos");
            empleado1.setApellido("Rodríguez");
            empleado1.setEmail("carlos.empleado@restaurant.com");
            empleado1.setPassword(passwordEncoder.encode("123456"));
            empleado1.setRol(empleadoRole);
            empleado1.setActivo(true);
            empleado1.setFechaCreacion(new Date());
            empleado1.setFechaActualizacion(new Date());
            userRepository.save(empleado1);
        }

        if (!userRepository.findByEmail("maria.empleado@restaurant.com").isPresent()) {
            User empleado2 = new User();
            empleado2.setNombre("María");
            empleado2.setApellido("González");
            empleado2.setEmail("maria.empleado@restaurant.com");
            empleado2.setPassword(passwordEncoder.encode("123456"));
            empleado2.setRol(empleadoRole);
            empleado2.setActivo(true);
            empleado2.setFechaCreacion(new Date());
            empleado2.setFechaActualizacion(new Date());
            userRepository.save(empleado2);
        }

        if (!userRepository.findByEmail("luis.empleado@restaurant.com").isPresent()) {
            User empleado3 = new User();
            empleado3.setNombre("Luis");
            empleado3.setApellido("Martínez");
            empleado3.setEmail("luis.empleado@restaurant.com");
            empleado3.setPassword(passwordEncoder.encode("123456"));
            empleado3.setRol(empleadoRole);
            empleado3.setActivo(true);
            empleado3.setFechaCreacion(new Date());
            empleado3.setFechaActualizacion(new Date());
            userRepository.save(empleado3);
        }

        // Crear mesas por defecto si no existen
        if (mesaRepository.count() == 0) {
            Mesa mesa1 = new Mesa();
            mesa1.setNumeroMesa(1);
            mesa1.setCapacidad(4);
            mesa1.setUbicacion("Ventana");
            mesa1.setEstado("libre");
            mesa1.setFechaCreacion(new Date());
            mesaRepository.save(mesa1);

            Mesa mesa2 = new Mesa();
            mesa2.setNumeroMesa(2);
            mesa2.setCapacidad(6);
            mesa2.setUbicacion("Centro");
            mesa2.setEstado("libre");
            mesa2.setFechaCreacion(new Date());
            mesaRepository.save(mesa2);
            
            System.out.println("Mesas creadas");
        }

        System.out.println("Datos básicos cargados: roles, admin, cliente, empleados y mesas");
    }
}