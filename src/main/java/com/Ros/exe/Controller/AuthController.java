package com.Ros.exe.Controller;

import org.springframework.security.core.Authentication;
import org.springframework.security.core.authority.SimpleGrantedAuthority;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.GetMapping;

@Controller
public class AuthController {

    @GetMapping("/login")
    public String login() {
        return "auth/login";
    }
    
    @GetMapping("/dashboard")
    public String dashboard(Authentication authentication) {
        if (authentication != null) {
            if (authentication.getAuthorities().contains(new SimpleGrantedAuthority("ROLE_ADMIN"))) {
                return "redirect:/users";
            } else if (authentication.getAuthorities().contains(new SimpleGrantedAuthority("ROLE_CLIENTE"))) {
                return "redirect:/mis-pedidos";
            } else if (authentication.getAuthorities().contains(new SimpleGrantedAuthority("ROLE_EMPLEADO"))) {
                return "redirect:/mi-horario";
            }
        }
        return "redirect:/login";
    }
}
