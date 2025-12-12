package com.Ros.exe.Controller;

import com.Ros.exe.Service.*;
import com.Ros.exe.DTO.*;
import com.Ros.exe.Entity.CarritoItem;
import com.Ros.exe.Entity.User;
import com.Ros.exe.Entity.Rol;
import com.Ros.exe.Repository.RolRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.core.Authentication;
import org.springframework.security.core.context.SecurityContextHolder;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.*;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;

import java.util.Date;
import java.util.List;
import java.util.stream.Collectors;
import jakarta.servlet.http.HttpSession;

@Controller
public class PublicController {

    @Autowired
    private ProductoService productoService;
    
    @Autowired
    private CarritoService carritoService;
    
    @Autowired
    private PedidoService pedidoService;
    
    @Autowired
    private MesaService mesaService;
    
    @Autowired
    private CategoriaService categoriaService;
    
    @Autowired
    private NoticiaService noticiaService;
    
    @Autowired
    private PromocionService promocionService;
    
    @Autowired
    private UserService userService;
    
    @Autowired
    private PagoService pagoService;
    
    @Autowired
    private RolRepository rolRepository;
    
    @Autowired
    private ReservaService reservaService;
    
    @Autowired
    private com.Ros.exe.Repository.UserRepository userRepository;

    @GetMapping("/")
    public String home(Model model) {
        // Obtener las últimas 3 noticias para mostrar en eventos
        List<NoticiaDto> noticias = noticiaService.listarNoticias().stream()
                .limit(3)
                .collect(Collectors.toList());
        model.addAttribute("noticias", noticias);
        
        // Obtener las últimas 3 promociones
        List<PromocionDto> promociones = promocionService.listarPromociones().stream()
                .limit(3)
                .collect(Collectors.toList());
        model.addAttribute("promociones", promociones);
        
        // Obtener la última promoción para "Promoción del Día"
        PromocionDto ultimaPromocion = promocionService.listarPromociones().stream()
                .findFirst()
                .orElse(null);
        model.addAttribute("promocionDelDia", ultimaPromocion);
        
        return "public/index";
    }

    @GetMapping("/menu")
    public String menu(@RequestParam(required = false) Long categoriaId, Model model, HttpSession session) {
        model.addAttribute("productos", productoService.listarProducto());
        model.addAttribute("categorias", categoriaService.listarCategoria());
        model.addAttribute("categoriaSeleccionada", categoriaId);
        model.addAttribute("carritoItems", carritoService.getItems());
        model.addAttribute("carritoTotal", carritoService.getTotal());
        model.addAttribute("cantidadTotal", carritoService.getCantidadTotal());
        
        // Verificar si hay usuario autenticado
        Authentication auth = SecurityContextHolder.getContext().getAuthentication();
        boolean usuarioAutenticado = auth != null && auth.isAuthenticated() && !"anonymousUser".equals(auth.getName());
        model.addAttribute("usuarioAutenticado", usuarioAutenticado);
        
        return "public/menu";
    }

    @PostMapping("/carrito/agregar")
    public String agregarAlCarrito(@RequestParam Long productoId, 
                                   @RequestParam String nombre, 
                                   @RequestParam Double precio,
                                   RedirectAttributes redirectAttributes) {
        carritoService.agregarItem(productoId, nombre, precio);
        redirectAttributes.addFlashAttribute("mensaje", "Producto agregado al carrito");
        return "redirect:/menu";
    }
    
    @PostMapping("/carrito/remover")
    public String removerDelCarrito(@RequestParam Long productoId) {
        carritoService.removerItem(productoId);
        return "redirect:/menu";
    }
    
    @PostMapping("/carrito/actualizar")
    public String actualizarCarrito(@RequestParam Long productoId, @RequestParam Integer cantidad) {
        carritoService.actualizarCantidad(productoId, cantidad);
        return "redirect:/menu";
    }
    
    @PostMapping("/pedido/crear")
    public String crearPedido(@RequestParam(required = false) String numeroMesa, 
                              @RequestParam(required = false) String nombreCliente,
                              @RequestParam(required = false) String comentarios,
                              RedirectAttributes redirectAttributes) {
        if (carritoService.getItems().isEmpty()) {
            redirectAttributes.addFlashAttribute("error", "El carrito está vacío");
            return "redirect:/menu";
        }
        
        try {
            // Verificar si hay usuario autenticado
            Authentication auth = SecurityContextHolder.getContext().getAuthentication();
            Long userId = null;
            String clienteNombre = nombreCliente;
            
            if (auth != null && auth.isAuthenticated() && !"anonymousUser".equals(auth.getName())) {
                // Usuario autenticado - obtener datos del usuario
                User usuario = userService.obtenerPorEmail(auth.getName());
                if (usuario != null) {
                    userId = usuario.getIdUser();
                    clienteNombre = usuario.getNombre() + " " + usuario.getApellido();
                    numeroMesa = numeroMesa != null ? numeroMesa : "0"; // Mesa por defecto para usuarios autenticados
                }
            }
            
            // Crear pedido usando el servicio mejorado
            PedidoDto pedidoCreado = pedidoService.crearPedidoPublicoCompleto(
                carritoService.getItems(), numeroMesa, clienteNombre, userId, comentarios);
            
            carritoService.limpiarCarrito();
            
            redirectAttributes.addFlashAttribute("pedidoId", pedidoCreado.getId());
            redirectAttributes.addFlashAttribute("numeroMesa", numeroMesa);
            redirectAttributes.addFlashAttribute("nombreCliente", clienteNombre);
            redirectAttributes.addFlashAttribute("total", pedidoCreado.getTotal());
            redirectAttributes.addFlashAttribute("empleadoAsignado", pedidoCreado.getEmpleadoAsignadoId());
            redirectAttributes.addFlashAttribute("mensaje", 
                "Pedido #" + pedidoCreado.getId() + " confirmado" + 
                (numeroMesa != null && !"0".equals(numeroMesa) ? " para la mesa " + numeroMesa : "") + 
                ". Se ha asignado un empleado.");
            
        } catch (Exception e) {
            redirectAttributes.addFlashAttribute("error", "Error al crear el pedido: " + e.getMessage());
            return "redirect:/menu";
        }
        
        return "redirect:/pedido/confirmado";
    }
    
    @GetMapping("/pedido/confirmado")
    public String pedidoConfirmado(Model model) {
        model.addAttribute("mesas", mesaService.listarMesa());
        return "public/pedido-confirmado";
    }
    
    @GetMapping("/pedido/pago/{pedidoId}")
    public String mostrarPago(@PathVariable Long pedidoId, Model model) {
        PedidoDto pedido = pedidoService.obtenerPedido(pedidoId);
        if (pedido == null) {
            return "redirect:/menu";
        }
        
        // Verificar si ya está pagado
        PagoDto pagoExistente = pagoService.obtenerPagoPorPedido(pedidoId);
        if (pagoExistente != null) {
            return "redirect:/pedido/pago/exitoso/" + pedidoId;
        }
        
        model.addAttribute("pedido", pedido);
        return "public/pago";
    }
    
    @PostMapping("/pedido/pago/procesar")
    public String procesarPago(@RequestParam Long pedidoId,
                               @RequestParam String metodoPago,
                               @RequestParam(required = false) String numeroTarjeta,
                               @RequestParam(required = false) String numeroNequi,
                               RedirectAttributes redirectAttributes) {
        try {
            PagoDto pago = pagoService.procesarPago(pedidoId, metodoPago, numeroTarjeta, numeroNequi);
            redirectAttributes.addFlashAttribute("pagoId", pago.getId());
            redirectAttributes.addFlashAttribute("metodoPago", metodoPago);
            redirectAttributes.addFlashAttribute("monto", pago.getMontoTotal());
            return "redirect:/pedido/pago/exitoso/" + pedidoId;
        } catch (Exception e) {
            redirectAttributes.addFlashAttribute("error", "Error al procesar el pago: " + e.getMessage());
            return "redirect:/pedido/pago/" + pedidoId;
        }
    }
    
    @GetMapping("/pedido/pago/exitoso/{pedidoId}")
    public String pagoExitoso(@PathVariable Long pedidoId, Model model) {
        PedidoDto pedido = pedidoService.obtenerPedido(pedidoId);
        PagoDto pago = pagoService.obtenerPagoPorPedido(pedidoId);
        
        if (pedido == null || pago == null) {
            return "redirect:/menu";
        }
        
        model.addAttribute("pedido", pedido);
        model.addAttribute("pago", pago);
        return "public/pago-exitoso";
    }

    @GetMapping("/public/noticias")
    public String noticias(Model model) {
        model.addAttribute("noticias", noticiaService.listarNoticias());
        return "public/noticias";
    }

    @GetMapping("/reserva")
    public String reserva(Model model) {
        // Agregar mesas disponibles para reservas
        model.addAttribute("mesas", mesaService.listarMesa());
        return "public/reserva";
    }
    
    @GetMapping("/iniciar-sesion")
    public String iniciarSesion() {
        return "public/login";
    }
    
    @GetMapping("/registro")
    public String mostrarRegistro(Model model) {
        model.addAttribute("usuario", new UserDto());
        return "public/registro";
    }
    
    @PostMapping("/registro")
    public String registrarUsuario(@ModelAttribute UserDto userDto, RedirectAttributes redirectAttributes) {
        try {
            // Asignar rol de cliente por defecto
            Rol clienteRole = rolRepository.findByNombre("CLIENTE")
                    .orElseThrow(() -> new RuntimeException("Rol CLIENTE no encontrado"));
            userDto.setRolId(clienteRole.getIdRol());
            userService.crearUsuario(userDto);
            redirectAttributes.addFlashAttribute("mensaje", "Usuario registrado exitosamente. Ahora puedes iniciar sesión.");
            return "redirect:/iniciar-sesion";
        } catch (Exception e) {
            redirectAttributes.addFlashAttribute("error", "Error al registrar usuario: " + e.getMessage());
            return "redirect:/registro";
        }
    }
    
    @GetMapping("/pedido/confirmar")
    public String confirmarPedido(Model model, HttpSession session) {
        if (carritoService.getItems().isEmpty()) {
            return "redirect:/menu";
        }
        
        // Verificar si hay usuario autenticado
        Authentication auth = SecurityContextHolder.getContext().getAuthentication();
        boolean usuarioAutenticado = auth != null && auth.isAuthenticated() && !"anonymousUser".equals(auth.getName());
        
        model.addAttribute("carritoItems", carritoService.getItems());
        model.addAttribute("carritoTotal", carritoService.getTotal());
        model.addAttribute("usuarioAutenticado", usuarioAutenticado);
        model.addAttribute("mesas", mesaService.listarMesa());
        
        return "public/confirmar-pedido";
    }
    
    @PostMapping("/reserva/crear")
    public String crearReservaPublica(@RequestParam String nombre,
                                      @RequestParam String telefono,
                                      @RequestParam String email,
                                      @RequestParam String fecha,
                                      @RequestParam String hora,
                                      @RequestParam Integer personas,
                                      @RequestParam(required = false) String comentarios,
                                      RedirectAttributes redirectAttributes) {
        try {
            // Verificar si hay usuario autenticado
            Authentication auth = SecurityContextHolder.getContext().getAuthentication();
            boolean usuarioAutenticado = auth != null && auth.isAuthenticated() && !"anonymousUser".equals(auth.getName());
            
            ReservaDto reserva = new ReservaDto();
            // Si está autenticado = CONFIRMADA, si no = PENDIENTE
            reserva.setEstado(usuarioAutenticado ? "CONFIRMADA" : "PENDIENTE");
            reserva.setNumeroPersonas(personas);
            reserva.setHora(hora);
            
            // Parsear fecha
            try {
                java.text.SimpleDateFormat sdf = new java.text.SimpleDateFormat("yyyy-MM-dd");
                reserva.setFechaReserva(sdf.parse(fecha));
            } catch (Exception e) {
                reserva.setFechaReserva(new java.util.Date());
            }
            
            // Si está autenticado, usar su ID, si no usar usuario por defecto
            if (usuarioAutenticado) {
                User usuario = userRepository.findAll().stream()
                    .filter(u -> u.getEmail() != null && u.getEmail().equals(auth.getName()))
                    .findFirst()
                    .orElse(null);
                if (usuario != null) {
                    reserva.setUserId(usuario.getIdUser());
                } else {
                    reserva.setUserId(1L);
                }
            } else {
                reserva.setUserId(1L);
            }
            reserva.setMesaId(1L);
            
            ReservaDto reservaCreada = reservaService.crearReserva(reserva);
            
            String mensaje = usuarioAutenticado ? 
                "Reserva #" + reservaCreada.getId() + " CONFIRMADA para " + fecha + " a las " + hora + ". ¡Te esperamos!" :
                "Reserva #" + reservaCreada.getId() + " creada para " + fecha + " a las " + hora + ". Nos pondremos en contacto para confirmar.";
            
            redirectAttributes.addFlashAttribute("mensaje", mensaje);
            return "redirect:/reserva/confirmada";
        } catch (Exception e) {
            redirectAttributes.addFlashAttribute("error", "Error al crear la reserva: " + e.getMessage());
            return "redirect:/reserva";
        }
    }
    
    private String procesarReservaAutenticada(HttpSession session, RedirectAttributes redirectAttributes) {
        try {
            ReservaData data = (ReservaData) session.getAttribute("reservaData");
            if (data == null) {
                redirectAttributes.addFlashAttribute("error", "Datos de reserva no encontrados");
                return "redirect:/reserva";
            }
            
            Authentication auth = SecurityContextHolder.getContext().getAuthentication();
            User usuario = userService.obtenerPorEmail(auth.getName());
            
            // Crear la reserva usando el servicio
            ReservaDto reservaCreada = reservaService.crearReservaPublica(
                data.getNombre(), data.getTelefono(), data.getEmail(), 
                data.getFecha(), data.getHora(), data.getPersonas(), 
                data.getComentarios(), usuario.getIdUser());
            
            session.removeAttribute("reservaData");
            redirectAttributes.addFlashAttribute("mensaje", "Reserva confirmada exitosamente para " + data.getFecha() + " a las " + data.getHora());
            redirectAttributes.addFlashAttribute("reserva", reservaCreada);
            return "redirect:/reserva/confirmada";
        } catch (Exception e) {
            redirectAttributes.addFlashAttribute("error", "Error al crear la reserva: " + e.getMessage());
            return "redirect:/reserva";
        }
    }
    
    @GetMapping("/reserva/confirmada")
    public String reservaConfirmada() {
        return "public/reserva-confirmada";
    }
    
    @GetMapping("/reserva/procesar")
    public String procesarReservaDespuesLogin(HttpSession session, RedirectAttributes redirectAttributes) {
        return procesarReservaAutenticada(session, redirectAttributes);
    }
    
    // Clase auxiliar para datos de reserva
    public static class ReservaData {
        private String nombre, telefono, email, fecha, hora, comentarios;
        private Integer personas;
        
        public ReservaData(String nombre, String telefono, String email, String fecha, String hora, Integer personas, String comentarios) {
            this.nombre = nombre;
            this.telefono = telefono;
            this.email = email;
            this.fecha = fecha;
            this.hora = hora;
            this.personas = personas;
            this.comentarios = comentarios;
        }
        
        // Getters
        public String getNombre() { return nombre; }
        public String getTelefono() { return telefono; }
        public String getEmail() { return email; }
        public String getFecha() { return fecha; }
        public String getHora() { return hora; }
        public Integer getPersonas() { return personas; }
        public String getComentarios() { return comentarios; }
    }
}