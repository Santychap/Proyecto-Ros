package com.Ros.exe.Config;

import jakarta.servlet.ServletException;
import jakarta.servlet.http.HttpServletRequest;
import jakarta.servlet.http.HttpServletResponse;
import org.springframework.context.annotation.Bean;
import org.springframework.context.annotation.Configuration;
import org.springframework.security.config.annotation.web.builders.HttpSecurity;
import org.springframework.security.config.annotation.web.configuration.EnableWebSecurity;
import org.springframework.security.core.Authentication;
import org.springframework.security.crypto.bcrypt.BCryptPasswordEncoder;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.security.core.userdetails.UserDetailsService;
import org.springframework.security.web.SecurityFilterChain;
import org.springframework.security.web.authentication.AuthenticationSuccessHandler;

import org.springframework.beans.factory.annotation.Autowired;

import java.io.IOException;

@Configuration
@EnableWebSecurity
public class SecurityConfig {

    @Autowired
    private UserDetailsService userDetailsService;

    @Bean
    public PasswordEncoder passwordEncoder() {
        return new BCryptPasswordEncoder();
    }
    


    @Bean
    public SecurityFilterChain securityFilterChain(HttpSecurity http) throws Exception {
        http
                .csrf(csrf -> csrf.disable()) // Deshabilitar CSRF para rutas públicas
.authorizeHttpRequests(auth -> auth
                        // Recursos estáticos y rutas públicas
                        .requestMatchers("/css/**", "/js/**", "/images/**", "/static/**").permitAll()
                        .requestMatchers("/", "/menu", "/public/**", "/reserva", "/reserva/**", "/carrito/**", "/pedido/**", "/iniciar-sesion", "/registro").permitAll()
                        .requestMatchers("/login", "/error").permitAll()
                        
                        // Cambiar estado de pedidos - PRIMERA PRIORIDAD
                        .requestMatchers("/pedidos/cambiar-estado/**").hasAnyRole("EMPLEADO", "ADMINISTRADOR")
                        
                        // ADMIN - Acceso total
                        .requestMatchers("/users/**", "/categorias/**", "/productos/**",
                                "/promociones/**", "/inventario/**", "/mesas/**", "/reservas/**",
                                "/pedidos/**", "/pagos/**", "/horarios/**", "/noticias/**", "/admin/**").hasRole("ADMINISTRADOR")
                        
                        // EMPLEADO - Pedidos asignados
                        .requestMatchers("/mi-horario", "/mi-horario/**", "/pedidos-asignados", "/pedidos-asignados/**").hasRole("EMPLEADO")
                        
                        // CLIENTE - Rutas específicas
                        .requestMatchers("/mi-perfil", "/mi-perfil/**", "/mis-pedidos", "/mis-pedidos/**", "/mis-reservas", "/mis-reservas/**", "/mis-pagos", "/mis-pagos/**").hasRole("CLIENTE")
                        .requestMatchers("/pedidos/new", "/pedidos/save", "/pedidos/view/**").hasRole("CLIENTE")
                        .requestMatchers("/reservas/new", "/reservas/save", "/reservas/view/**", "/reservas/edit/**", "/reservas/cancel/**").hasRole("CLIENTE")
                        .requestMatchers("/productos/list").hasRole("CLIENTE")
                        
                        // Dashboard accesible para todos los autenticados
                        .requestMatchers("/dashboard").authenticated()
                        
                        .anyRequest().authenticated()
                )
                .formLogin(form -> form
                        .loginPage("/iniciar-sesion")
                        .loginProcessingUrl("/perform-login")
                        .usernameParameter("email")
                        .passwordParameter("password")
                        .successHandler(authenticationSuccessHandler())
                        .failureUrl("/iniciar-sesion?error=true")
                        .permitAll()
                )
                .userDetailsService(userDetailsService)
                .logout(logout -> logout
                        .logoutSuccessUrl("/")
                        .permitAll());

        return http.build();
    }

    @Bean
    public AuthenticationSuccessHandler authenticationSuccessHandler() {
        return new AuthenticationSuccessHandler() {
            @Override
            public void onAuthenticationSuccess(HttpServletRequest request, HttpServletResponse response,
                                                Authentication authentication) throws IOException, ServletException {
                String redirectUrl = "/login";
                
                // Verificar si hay datos de reserva pendientes en la sesión
                if (request.getSession().getAttribute("reservaData") != null) {
                    redirectUrl = "/reserva/procesar";
                } else if (authentication.getAuthorities().stream()
                        .anyMatch(a -> a.getAuthority().equals("ROLE_ADMINISTRADOR"))) {
                    redirectUrl = "/users";
                } else if (authentication.getAuthorities().stream()
                        .anyMatch(a -> a.getAuthority().equals("ROLE_CLIENTE"))) {
                    redirectUrl = "/dashboard";
                } else if (authentication.getAuthorities().stream()
                        .anyMatch(a -> a.getAuthority().equals("ROLE_EMPLEADO"))) {
                    redirectUrl = "/mi-horario";
                }
                
                response.sendRedirect(redirectUrl);
            }
        };
    }
}
