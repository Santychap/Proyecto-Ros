<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Olla y Sazón - Bienvenida Premium</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --gold: #d4af37;
            --dark: #181828;
            --dark2: #23234a;
            --light: #f8f6f2;
            --white: #fff;
            --rose: #eec9d2;
        }
        body {
            margin: 0;
            font-family: 'Montserrat', Arial, sans-serif;
            background: linear-gradient(135deg, var(--light) 0%, var(--white) 100%);
            color: var(--dark);
        }
        /* Header */
        .header {
            background: var(--white);
            box-shadow: 0 2px 16px rgba(24,24,40,0.06);
            padding: 1.5rem 0 1.2rem 0;
            display: flex;
            justify-content: center;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        .header-nav {
            display: flex;
            gap: 2.5rem;
        }
        .header-nav a {
            color: var(--dark2);
            text-decoration: none;
            font-family: 'Montserrat', Arial, sans-serif;
            font-weight: 600;
            font-size: 1.1rem;
            letter-spacing: 1px;
            padding: 0.3rem 0.7rem;
            border-radius: 8px;
            transition: background 0.2s, color 0.2s;
        }
        .header-nav a:hover {
            background: var(--gold);
            color: var(--white);
        }
        /* Main Circles */
        .main-circles-bg {
            background: linear-gradient(120deg, var(--light) 60%, var(--gold) 100%);
            padding: 4rem 0 5rem 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 480px;
        }
        .circles-row {
            display: flex;
            gap: 3.5rem;
            align-items: flex-end;
        }
        .circle {
            border-radius: 50%;
            box-shadow: 0 8px 32px rgba(24,24,40,0.10);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: var(--white);
            overflow: hidden;
            position: relative;
            transition: box-shadow 0.2s;
        }
        .circle.center {
            width: 340px;
            height: 340px;
            background: linear-gradient(135deg, var(--dark2) 60%, var(--gold) 100%);
            color: var(--gold);
            box-shadow: 0 12px 48px rgba(24,24,40,0.18);
            border: 6px solid var(--gold);
            z-index: 2;
        }
        .circle.center h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.7rem;
            font-weight: 700;
            margin: 0;
            color: var(--gold);
            letter-spacing: 2px;
            text-shadow: 0 2px 12px rgba(24,24,40,0.10);
        }
        .circle.left, .circle.right {
            width: 220px;
            height: 220px;
            background: var(--white);
            color: var(--dark2);
            border: 4px solid var(--gold);
            box-shadow: 0 8px 32px rgba(24,24,40,0.10);
        }
        .circle.left img, .circle.right img {
            width: 100%;
            height: 120px;
            object-fit: cover;
            border-top-left-radius: 50%;
            border-top-right-radius: 50%;
        }
        .circle.left .label, .circle.right .label {
            font-family: 'Montserrat', Arial, sans-serif;
            font-size: 1.1rem;
            font-weight: 600;
            margin-top: 1.1rem;
            color: var(--gold);
            text-align: center;
        }
        .circle.right .promo {
            font-size: 1.2rem;
            font-family: 'Playfair Display', serif;
            color: var(--dark2);
            margin-top: 0.5rem;
        }
        /* Visual Block */
        .visual-block {
            display: flex;
            width: 100vw;
            margin-left: calc(50% - 50vw);
            margin-right: calc(50% - 50vw);
            margin-top: -2.5rem;
        }
        .visual-block img {
            width: 50vw;
            height: 340px;
            object-fit: cover;
            display: block;
        }
        /* Squares Row */
        .squares-row {
            display: flex;
            justify-content: center;
            align-items: flex-end;
            gap: 2.5rem;
            margin: 4rem 0 3rem 0;
        }
        .square {
            background: var(--white);
            border-radius: 1.2rem;
            box-shadow: 0 4px 24px rgba(24,24,40,0.10);
            padding: 2rem 1.5rem;
            min-width: 220px;
            min-height: 180px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-family: 'Montserrat', Arial, sans-serif;
            color: var(--dark2);
            position: relative;
        }
        .square.center {
            min-width: 270px;
            min-height: 220px;
            background: linear-gradient(135deg, var(--rose) 60%, var(--gold) 100%);
            color: var(--dark2);
            font-family: 'Playfair Display', serif;
            font-size: 1.3rem;
            font-weight: 700;
            box-shadow: 0 8px 32px rgba(224, 41, 120, 0.10);
            border: 3px solid var(--gold);
            z-index: 2;
        }
        .square .title {
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 0.7rem;
            color: var(--gold);
        }
        .square .desc {
            font-size: 1rem;
            color: var(--dark2);
            text-align: center;
        }
        /* Footer */
        .footer {
            background: var(--dark);
            color: var(--white);
            padding: 2.2rem 0 1.2rem 0;
            text-align: center;
            border-top-left-radius: 2rem;
            border-top-right-radius: 2rem;
            margin-top: 2.5rem;
            font-size: 1.05rem;
            box-shadow: 0 -4px 24px rgba(24,24,40,0.10);
        }
        .footer .footer-content {
            max-width: 900px;
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 1.2rem;
            padding: 0 1.5rem;
        }
        .footer .footer-info {
            flex: 1;
            min-width: 220px;
            text-align: left;
        }
        .footer .footer-info .brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--gold);
            margin-bottom: 0.2rem;
        }
        .footer .footer-info .details {
            font-size: 1rem;
            color: #fffbe6;
        }
        .footer .footer-social {
            flex: 1;
            min-width: 180px;
            text-align: right;
        }
        .footer .footer-social a {
            color: var(--gold);
            margin: 0 0.4rem;
            font-size: 1.3rem;
            transition: color 0.2s;
        }
        .footer .footer-social a:hover {
            color: var(--rose);
        }
        .footer .copyright {
            margin-top: 1.2rem;
            color: #fffbe6;
            font-size: 0.95rem;
            opacity: 0.8;
        }
        @media (max-width: 1100px) {
            .circles-row, .squares-row {
                flex-direction: column;
                gap: 2rem;
                align-items: center;
            }
            .visual-block {
                flex-direction: column;
            }
            .visual-block img {
                width: 100vw;
                height: 220px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <nav class="header-nav">
            <a href="#menu">Menú</a>
            <a href="#reservas">Reservas</a>
            <a href="#promociones">Promociones</a>
            <a href="#noticias">Noticias</a>
        </nav>
    </header>
    <!-- Main Circles -->
    <section class="main-circles-bg">
        <div class="circles-row">
            <div class="circle left">
                <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=400&h=120&fit=crop" alt="Plato del día gourmet">
                <div class="label">Plato del Día</div>
                <div style="font-size:0.98rem; color:#181828; margin-top:0.5rem;">Risotto de langosta y trufa</div>
            </div>
            <div class="circle center">
                <h1>Olla y Sazón</h1>
                <div style="font-family:'Montserrat',sans-serif; font-size:1.1rem; color:#fff; margin-top:1.2rem; letter-spacing:1px;">Restaurante Premium</div>
            </div>
            <div class="circle right">
                <img src="https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=400&h=120&fit=crop" alt="Promoción del día premium">
                <div class="label">Promoción del Día</div>
                <div class="promo">2x1 en vinos reserva</div>
            </div>
        </div>
    </section>
    <!-- Visual Block -->
    <div class="visual-block">
        <img src="https://images.unsplash.com/photo-1512918728675-ed5a9ecdebfd?w=800&h=340&fit=crop" alt="Ambiente sofisticado del restaurante">
        <img src="https://images.unsplash.com/photo-1502741338009-cac2772e18bc?w=800&h=340&fit=crop" alt="Plato gourmet de lujo">
    </div>
    <!-- Squares Row -->
    <section class="squares-row">
        <div class="square">
            <div class="title">Noticias</div>
            <div class="desc">Descubre las últimas novedades y eventos exclusivos de Olla y Sazón.</div>
        </div>
        <div class="square center">
            <div style="font-size:1.5rem; color:#b8004c; margin-bottom:0.5rem;">Especial San Valentín</div>
            <div style="font-size:1.1rem; color:#181828;">Cena romántica a la luz de las velas, menú degustación y música en vivo.</div>
        </div>
        <div class="square">
            <div class="title">Promociones</div>
            <div class="desc">Aprovecha nuestras ofertas premium y vive una experiencia única.</div>
        </div>
    </section>
    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-info">
                <div class="brand"><i class="fas fa-utensils"></i> Olla y Sazón</div>
                <div class="details">Calle Principal 123, Ciudad<br>Tel: (555) 123-4567</div>
            </div>
            <div class="footer-social">
                <a href="https://facebook.com" target="_blank"><i class="fab fa-facebook"></i></a>
                <a href="https://instagram.com" target="_blank"><i class="fab fa-instagram"></i></a>
                <a href="mailto:info@ollaysazon.com"><i class="fas fa-envelope"></i></a>
            </div>
        </div>
        <div class="copyright">&copy; 2025 Olla y Sazón. Todos los derechos reservados.</div>
    </footer>
</body>
</html>
