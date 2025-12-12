package com.Ros.exe.Controller;

import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.RequestMapping;
import jakarta.servlet.RequestDispatcher;
import jakarta.servlet.http.HttpServletRequest;

@Controller
public class ErrorController implements org.springframework.boot.web.servlet.error.ErrorController {

    @RequestMapping("/error")
    public String handleError(HttpServletRequest request, Model model) {
        Object status = request.getAttribute(RequestDispatcher.ERROR_STATUS_CODE);
        
        if (status != null) {
            int statusCode = Integer.parseInt(status.toString());
            
            switch (statusCode) {
                case 403:
                    model.addAttribute("error", "No tienes permisos para acceder a esta página");
                    model.addAttribute("statusCode", 403);
                    return "public/error";
                case 404:
                    model.addAttribute("error", "Página no encontrada");
                    model.addAttribute("statusCode", 404);
                    return "public/error";
                case 500:
                    model.addAttribute("error", "Error interno del servidor");
                    model.addAttribute("statusCode", 500);
                    return "public/error";
                default:
                    model.addAttribute("error", "Error inesperado");
                    model.addAttribute("statusCode", statusCode);
                    return "public/error";
            }
        }
        
        model.addAttribute("error", "Error desconocido");
        return "public/error";
    }
}