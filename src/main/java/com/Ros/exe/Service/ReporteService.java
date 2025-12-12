package com.Ros.exe.Service;

import com.Ros.exe.Entity.*;
import com.Ros.exe.Repository.*;
import com.itextpdf.text.*;
import com.itextpdf.text.pdf.*;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.io.ByteArrayOutputStream;
import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.Date;
import java.util.List;

@Service
public class ReporteService {
    @Autowired
    private PedidoRepository pedidoRepository;
    
    @Autowired
    private PagoRepository pagoRepository;
    
    @Autowired
    private ReservaRepository reservaRepository;
    
    @Autowired
    private ProductoRepository productoRepository;
    
    @Autowired
    private UserRepository userRepository;

    // Reportes de Pedidos
    public byte[] generarReportePedidosSemanal() {
        Date[] fechas = calcularFechas(7);
        List<Pedido> pedidos = pedidoRepository.findByFechaCreacionBetween(fechas[0], fechas[1]);
        return generarPDFPedidos(pedidos, "REPORTE SEMANAL DE PEDIDOS");
    }

    public byte[] generarReportePedidosMensual() {
        Date[] fechas = calcularFechas(30);
        List<Pedido> pedidos = pedidoRepository.findByFechaCreacionBetween(fechas[0], fechas[1]);
        return generarPDFPedidos(pedidos, "REPORTE MENSUAL DE PEDIDOS");
    }

    public byte[] generarReportePedidosAnual() {
        Date[] fechas = calcularFechas(365);
        List<Pedido> pedidos = pedidoRepository.findByFechaCreacionBetween(fechas[0], fechas[1]);
        return generarPDFPedidos(pedidos, "REPORTE ANUAL DE PEDIDOS");
    }

    // Reportes de Pagos
    public byte[] generarReportePagosSemanal() {
        Date[] fechas = calcularFechas(7);
        List<Pago> pagos = pagoRepository.findByFechaCreacionBetween(fechas[0], fechas[1]);
        return generarPDFPagos(pagos, "REPORTE SEMANAL DE PAGOS");
    }

    public byte[] generarReportePagosMensual() {
        Date[] fechas = calcularFechas(30);
        List<Pago> pagos = pagoRepository.findByFechaCreacionBetween(fechas[0], fechas[1]);
        return generarPDFPagos(pagos, "REPORTE MENSUAL DE PAGOS");
    }

    public byte[] generarReportePagosAnual() {
        Date[] fechas = calcularFechas(365);
        List<Pago> pagos = pagoRepository.findByFechaCreacionBetween(fechas[0], fechas[1]);
        return generarPDFPagos(pagos, "REPORTE ANUAL DE PAGOS");
    }

    // Reportes de Reservas
    public byte[] generarReporteReservasSemanal() {
        Date[] fechas = calcularFechas(7);
        List<Reserva> reservas = reservaRepository.findByFechaCreacionBetween(fechas[0], fechas[1]);
        return generarPDFReservas(reservas, "REPORTE SEMANAL DE RESERVAS");
    }

    public byte[] generarReporteReservasMensual() {
        Date[] fechas = calcularFechas(30);
        List<Reserva> reservas = reservaRepository.findByFechaCreacionBetween(fechas[0], fechas[1]);
        return generarPDFReservas(reservas, "REPORTE MENSUAL DE RESERVAS");
    }

    public byte[] generarReporteReservasAnual() {
        Date[] fechas = calcularFechas(365);
        List<Reserva> reservas = reservaRepository.findByFechaCreacionBetween(fechas[0], fechas[1]);
        return generarPDFReservas(reservas, "REPORTE ANUAL DE RESERVAS");
    }

    // Reportes de Productos
    public byte[] generarReporteProductosSemanal() {
        List<Producto> productos = productoRepository.findAll();
        return generarPDFProductos(productos, "REPORTE SEMANAL DE PRODUCTOS");
    }

    public byte[] generarReporteProductosMensual() {
        List<Producto> productos = productoRepository.findAll();
        return generarPDFProductos(productos, "REPORTE MENSUAL DE PRODUCTOS");
    }

    public byte[] generarReporteProductosAnual() {
        List<Producto> productos = productoRepository.findAll();
        return generarPDFProductos(productos, "REPORTE ANUAL DE PRODUCTOS");
    }

    // Reportes de Usuarios
    public byte[] generarReporteUsuariosSemanal() {
        List<User> usuarios = userRepository.findAll();
        return generarPDFUsuarios(usuarios, "REPORTE SEMANAL DE USUARIOS");
    }

    public byte[] generarReporteUsuariosMensual() {
        List<User> usuarios = userRepository.findAll();
        return generarPDFUsuarios(usuarios, "REPORTE MENSUAL DE USUARIOS");
    }

    public byte[] generarReporteUsuariosAnual() {
        List<User> usuarios = userRepository.findAll();
        return generarPDFUsuarios(usuarios, "REPORTE ANUAL DE USUARIOS");
    }

    // Métodos auxiliares
    private Date[] calcularFechas(int dias) {
        Calendar cal = Calendar.getInstance();
        Date fechaFin = cal.getTime();
        cal.add(Calendar.DAY_OF_MONTH, -dias);
        Date fechaInicio = cal.getTime();
        return new Date[]{fechaInicio, fechaFin};
    }

    private byte[] generarPDFPedidos(List<Pedido> pedidos, String titulo) {
        try {
            Document document = new Document(PageSize.A4);
            ByteArrayOutputStream baos = new ByteArrayOutputStream();
            PdfWriter.getInstance(document, baos);
            
            document.open();
            
            Font titleFont = new Font(Font.FontFamily.HELVETICA, 22, Font.BOLD);
            Paragraph title = new Paragraph(titulo, titleFont);
            title.setAlignment(Element.ALIGN_CENTER);
            document.add(title);
            
            document.add(new Paragraph(" "));
            Font normalFont = new Font(Font.FontFamily.HELVETICA, 12, Font.NORMAL);
            document.add(new Paragraph("Fecha: " + new SimpleDateFormat("dd/MM/yyyy").format(new Date()), normalFont));
            document.add(new Paragraph(" "));
            
            PdfPTable table = new PdfPTable(5);
            table.setWidthPercentage(100);
            
            Font headerFont = new Font(Font.FontFamily.HELVETICA, 14, Font.BOLD);
            Font cellFont = new Font(Font.FontFamily.HELVETICA, 12, Font.NORMAL);
            
            table.addCell(new PdfPCell(new Phrase("ID", headerFont)));
            table.addCell(new PdfPCell(new Phrase("Mesa", headerFont)));
            table.addCell(new PdfPCell(new Phrase("Cliente", headerFont)));
            table.addCell(new PdfPCell(new Phrase("Total", headerFont)));
            table.addCell(new PdfPCell(new Phrase("Estado", headerFont)));
            
            double totalGeneral = 0;
            for (Pedido pedido : pedidos) {
                table.addCell(new PdfPCell(new Phrase(String.valueOf(pedido.getId()), cellFont)));
                table.addCell(new PdfPCell(new Phrase(pedido.getNumeroMesa() != null ? pedido.getNumeroMesa() : "N/A", cellFont)));
                table.addCell(new PdfPCell(new Phrase(pedido.getClienteNombre() != null ? pedido.getClienteNombre() : "N/A", cellFont)));
                table.addCell(new PdfPCell(new Phrase("$ " + String.format("%.2f", pedido.getTotal()), cellFont)));
                table.addCell(new PdfPCell(new Phrase(pedido.getEstado(), cellFont)));
                totalGeneral += pedido.getTotal();
            }
            
            document.add(table);
            document.add(new Paragraph(" "));
            document.add(new Paragraph("Total pedidos: " + pedidos.size(), normalFont));
            document.add(new Paragraph("Total general: $ " + String.format("%.2f", totalGeneral), normalFont));
            
            document.close();
            return baos.toByteArray();
            
        } catch (Exception e) {
            throw new RuntimeException("Error generando reporte de pedidos", e);
        }
    }

    private byte[] generarPDFPagos(List<Pago> pagos, String titulo) {
        try {
            Document document = new Document(PageSize.A4);
            ByteArrayOutputStream baos = new ByteArrayOutputStream();
            PdfWriter.getInstance(document, baos);
            
            document.open();
            
            Font titleFont = new Font(Font.FontFamily.HELVETICA, 22, Font.BOLD);
            Paragraph title = new Paragraph(titulo, titleFont);
            title.setAlignment(Element.ALIGN_CENTER);
            document.add(title);
            
            document.add(new Paragraph(" "));
            Font normalFont = new Font(Font.FontFamily.HELVETICA, 12, Font.NORMAL);
            document.add(new Paragraph("Fecha: " + new SimpleDateFormat("dd/MM/yyyy").format(new Date()), normalFont));
            document.add(new Paragraph(" "));
            
            PdfPTable table = new PdfPTable(4);
            table.setWidthPercentage(100);
            
            Font headerFont = new Font(Font.FontFamily.HELVETICA, 14, Font.BOLD);
            Font cellFont = new Font(Font.FontFamily.HELVETICA, 12, Font.NORMAL);
            
            table.addCell(new PdfPCell(new Phrase("ID", headerFont)));
            table.addCell(new PdfPCell(new Phrase("Método", headerFont)));
            table.addCell(new PdfPCell(new Phrase("Monto", headerFont)));
            table.addCell(new PdfPCell(new Phrase("Estado", headerFont)));
            
            double totalGeneral = 0;
            for (Pago pago : pagos) {
                table.addCell(new PdfPCell(new Phrase(String.valueOf(pago.getId()), cellFont)));
                table.addCell(new PdfPCell(new Phrase(pago.getMetodoPago(), cellFont)));
                table.addCell(new PdfPCell(new Phrase("$ " + String.format("%.2f", pago.getMontoTotal()), cellFont)));
                table.addCell(new PdfPCell(new Phrase(pago.getEstado(), cellFont)));
                totalGeneral += pago.getMontoTotal();
            }
            
            document.add(table);
            document.add(new Paragraph(" "));
            document.add(new Paragraph("Total pagos: " + pagos.size(), normalFont));
            document.add(new Paragraph("Total recaudado: $ " + String.format("%.2f", totalGeneral), normalFont));
            
            document.close();
            return baos.toByteArray();
            
        } catch (Exception e) {
            throw new RuntimeException("Error generando reporte de pagos", e);
        }
    }

    private byte[] generarPDFReservas(List<Reserva> reservas, String titulo) {
        try {
            Document document = new Document(PageSize.A4);
            ByteArrayOutputStream baos = new ByteArrayOutputStream();
            PdfWriter.getInstance(document, baos);
            
            document.open();
            
            Font titleFont = new Font(Font.FontFamily.HELVETICA, 22, Font.BOLD);
            Paragraph title = new Paragraph(titulo, titleFont);
            title.setAlignment(Element.ALIGN_CENTER);
            document.add(title);
            
            document.add(new Paragraph(" "));
            Font normalFont = new Font(Font.FontFamily.HELVETICA, 12, Font.NORMAL);
            document.add(new Paragraph("Fecha: " + new SimpleDateFormat("dd/MM/yyyy").format(new Date()), normalFont));
            document.add(new Paragraph(" "));
            
            PdfPTable table = new PdfPTable(5);
            table.setWidthPercentage(100);
            
            Font headerFont = new Font(Font.FontFamily.HELVETICA, 14, Font.BOLD);
            Font cellFont = new Font(Font.FontFamily.HELVETICA, 12, Font.NORMAL);
            
            table.addCell(new PdfPCell(new Phrase("ID", headerFont)));
            table.addCell(new PdfPCell(new Phrase("Cliente", headerFont)));
            table.addCell(new PdfPCell(new Phrase("Mesa", headerFont)));
            table.addCell(new PdfPCell(new Phrase("Fecha", headerFont)));
            table.addCell(new PdfPCell(new Phrase("Estado", headerFont)));
            
            for (Reserva reserva : reservas) {
                table.addCell(new PdfPCell(new Phrase(String.valueOf(reserva.getId()), cellFont)));
                table.addCell(new PdfPCell(new Phrase(reserva.getUser() != null ? reserva.getUser().getNombre() : "N/A", cellFont)));
                table.addCell(new PdfPCell(new Phrase(reserva.getMesa() != null ? String.valueOf(reserva.getMesa().getNumeroMesa()) : "N/A", cellFont)));
                table.addCell(new PdfPCell(new Phrase(new SimpleDateFormat("dd/MM/yyyy").format(reserva.getFechaReserva()), cellFont)));
                table.addCell(new PdfPCell(new Phrase(reserva.getEstado(), cellFont)));
            }
            
            document.add(table);
            document.add(new Paragraph(" "));
            document.add(new Paragraph("Total reservas: " + reservas.size(), normalFont));
            
            document.close();
            return baos.toByteArray();
            
        } catch (Exception e) {
            throw new RuntimeException("Error generando reporte de reservas", e);
        }
    }

    private byte[] generarPDFProductos(List<Producto> productos, String titulo) {
        try {
            Document document = new Document(PageSize.A4);
            ByteArrayOutputStream baos = new ByteArrayOutputStream();
            PdfWriter.getInstance(document, baos);
            
            document.open();
            
            Font titleFont = new Font(Font.FontFamily.HELVETICA, 22, Font.BOLD);
            Paragraph title = new Paragraph(titulo, titleFont);
            title.setAlignment(Element.ALIGN_CENTER);
            document.add(title);
            
            document.add(new Paragraph(" "));
            Font normalFont = new Font(Font.FontFamily.HELVETICA, 12, Font.NORMAL);
            document.add(new Paragraph("Fecha: " + new SimpleDateFormat("dd/MM/yyyy").format(new Date()), normalFont));
            document.add(new Paragraph(" "));
            
            PdfPTable table = new PdfPTable(4);
            table.setWidthPercentage(100);
            
            Font headerFont = new Font(Font.FontFamily.HELVETICA, 14, Font.BOLD);
            Font cellFont = new Font(Font.FontFamily.HELVETICA, 12, Font.NORMAL);
            
            table.addCell(new PdfPCell(new Phrase("ID", headerFont)));
            table.addCell(new PdfPCell(new Phrase("Nombre", headerFont)));
            table.addCell(new PdfPCell(new Phrase("Categoría", headerFont)));
            table.addCell(new PdfPCell(new Phrase("Precio", headerFont)));
            
            for (Producto producto : productos) {
                table.addCell(new PdfPCell(new Phrase(String.valueOf(producto.getIdProducto()), cellFont)));
                table.addCell(new PdfPCell(new Phrase(producto.getNombre(), cellFont)));
                table.addCell(new PdfPCell(new Phrase(producto.getCategoria() != null ? producto.getCategoria().getNombre() : "Sin categoría", cellFont)));
                table.addCell(new PdfPCell(new Phrase("$ " + String.format("%.2f", producto.getPrecio()), cellFont)));
            }
            
            document.add(table);
            document.add(new Paragraph(" "));
            document.add(new Paragraph("Total productos: " + productos.size(), normalFont));
            
            document.close();
            return baos.toByteArray();
            
        } catch (Exception e) {
            throw new RuntimeException("Error generando reporte de productos", e);
        }
    }

    private byte[] generarPDFUsuarios(List<User> usuarios, String titulo) {
        try {
            Document document = new Document(PageSize.A4);
            ByteArrayOutputStream baos = new ByteArrayOutputStream();
            PdfWriter.getInstance(document, baos);
            
            document.open();
            
            Font titleFont = new Font(Font.FontFamily.HELVETICA, 22, Font.BOLD);
            Paragraph title = new Paragraph(titulo, titleFont);
            title.setAlignment(Element.ALIGN_CENTER);
            document.add(title);
            
            document.add(new Paragraph(" "));
            Font normalFont = new Font(Font.FontFamily.HELVETICA, 12, Font.NORMAL);
            document.add(new Paragraph("Fecha: " + new SimpleDateFormat("dd/MM/yyyy").format(new Date()), normalFont));
            document.add(new Paragraph(" "));
            
            PdfPTable table = new PdfPTable(4);
            table.setWidthPercentage(100);
            
            Font headerFont = new Font(Font.FontFamily.HELVETICA, 14, Font.BOLD);
            Font cellFont = new Font(Font.FontFamily.HELVETICA, 12, Font.NORMAL);
            
            table.addCell(new PdfPCell(new Phrase("ID", headerFont)));
            table.addCell(new PdfPCell(new Phrase("Nombre", headerFont)));
            table.addCell(new PdfPCell(new Phrase("Email", headerFont)));
            table.addCell(new PdfPCell(new Phrase("Rol", headerFont)));
            
            for (User usuario : usuarios) {
                table.addCell(new PdfPCell(new Phrase(String.valueOf(usuario.getIdUser()), cellFont)));
                table.addCell(new PdfPCell(new Phrase(usuario.getNombre(), cellFont)));
                table.addCell(new PdfPCell(new Phrase(usuario.getEmail(), cellFont)));
                table.addCell(new PdfPCell(new Phrase(usuario.getRol() != null ? usuario.getRol().getNombre() : "Sin rol", cellFont)));
            }
            
            document.add(table);
            document.add(new Paragraph(" "));
            document.add(new Paragraph("Total usuarios: " + usuarios.size(), normalFont));
            
            document.close();
            return baos.toByteArray();
            
        } catch (Exception e) {
            throw new RuntimeException("Error generando reporte de usuarios", e);
        }
    }
}