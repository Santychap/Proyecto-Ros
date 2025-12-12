<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Olla y Sazón - Bienvenidos</title>
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
            width: 420px;
            height: 420px;
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
            width: 290px;
            height: 290px;
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
<body class="particles-bg">
    <!-- Header -->
    <header class="header" style="background: #fff; box-shadow: 0 2px 16px rgba(24,24,40,0.06); padding: 1.2rem 0 1.2rem 0; display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #d4af37;">
        <div style="display: flex; align-items: center; margin-left: 2.5rem;">
            <span style="font-family: 'Playfair Display', serif; font-size: 1.5rem; font-weight: 700; color: #d4af37; letter-spacing: 1px; display: flex; align-items: center;"><i class="fas fa-utensils" style="margin-right: 0.5rem;"></i>Olla y Sazón</span>
        </div>
        <nav class="header-nav" style="display: flex; gap: 2.5rem; margin-right: 2.5rem;">
            <a href="/menu" style="color: #181828; text-decoration: none; font-family: 'Playfair Display', serif; font-weight: 700; font-size: 1.15rem; letter-spacing: 1px; padding: 0.3rem 0.7rem; border-radius: 8px; transition: background 0.2s, color 0.2s;">Menú</a>
            <a href="{{ route('reservas.publicCreate') }}" style="color: #181828; text-decoration: none; font-family: 'Playfair Display', serif; font-weight: 700; font-size: 1.15rem; letter-spacing: 1px; padding: 0.3rem 0.7rem; border-radius: 8px; transition: background 0.2s, color 0.2s;">Reservas</a>
            <a href="{{ route('promociones.publicIndex') }}" style="color: #181828; text-decoration: none; font-family: 'Playfair Display', serif; font-weight: 700; font-size: 1.15rem; letter-spacing: 1px; padding: 0.3rem 0.7rem; border-radius: 8px; transition: background 0.2s, color 0.2s;">Promociones</a>
            <a href="{{ route('noticias.publicIndex') }}" style="color: #181828; text-decoration: none; font-family: 'Playfair Display', serif; font-weight: 700; font-size: 1.15rem; letter-spacing: 1px; padding: 0.3rem 0.7rem; border-radius: 8px; transition: background 0.2s, color 0.2s;">Noticias</a>
        </nav>
    </header>

    <!-- Main Circles -->
    @php
        // Temporalmente comentado hasta crear la tabla productos
        $plato = null;
        /*
        try {
            $plato = \App\Models\Producto::where('destacado', 1)->latest('updated_at')->first();
            if (!$plato) {
                $plato = \App\Models\Producto::latest('updated_at')->first();
            }
        } catch (Exception $e) {
            $plato = \App\Models\Producto::latest('updated_at')->first();
        }
        */
        $promocion = null; // \App\Models\Promocion::latest('created_at')->first();
    @endphp
    <section class="main-circles-bg" style="background: linear-gradient(120deg, #fff 60%, #181828 100%); padding: 4rem 0 5rem 0; display: flex; justify-content: center; align-items: center; min-height: 480px;">
        <div class="circles-row" style="display: flex; gap: 3.5rem; align-items: flex-end;">
            <div class="circle left" style="width: 290px; height: 290px; background: #fff; color: #181828; border: 4px solid #d4af37; box-shadow: 0 8px 32px rgba(24,24,40,0.10); display: flex; flex-direction: column; align-items: center; justify-content: center; border-radius: 50%; overflow: hidden; position: relative;">
                <img src="{{ $plato && $plato->imagen ? asset('storage/' . $plato->imagen) : 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=400&h=120&fit=crop' }}" alt="Plato del día gourmet" style="width: 100%; height: 140px; object-fit: cover; border-top-left-radius: 50%; border-top-right-radius: 50%;">
                <div class="label" style="font-family: 'Playfair Display', serif; font-size: 1.3rem; font-weight: 700; color: #d4af37; margin-top: 1.3rem; text-align: center;">Plato del Día</div>
                <div style="font-size:1.15rem; color:#181828; margin-top:0.7rem; font-family:'Montserrat',sans-serif; font-weight:600; text-align:center; letter-spacing:0.5px; padding: 0 15px;">
                    {{ $plato ? $plato->nombre : 'Risotto de langosta y trufa' }}
                </div>
            </div>
            <div class="circle center" style="width: 420px; height: 420px; background: linear-gradient(135deg, #181828 60%, #d4af37 100%); color: #d4af37; box-shadow: 0 12px 48px rgba(24,24,40,0.18); border: 7px solid #d4af37; z-index: 2; display: flex; flex-direction: column; align-items: center; justify-content: center; border-radius: 50%;">
                <h1 style="font-family: 'Playfair Display', serif; font-size: 3.4rem; font-weight: 700; margin: 0; color: #d4af37; letter-spacing: 2px; text-shadow: 0 2px 12px rgba(24,24,40,0.10);">Olla y Sazón</h1>
                <div style="font-family:'Montserrat',sans-serif; font-size:1.4rem; color:#fff; margin-top:1.4rem; letter-spacing:1px;">Restaurante Premium</div>
            </div>
            <div class="circle right" style="width: 290px; height: 290px; background: #fff; color: #181828; border: 4px solid #d4af37; box-shadow: 0 8px 32px rgba(24,24,40,0.10); display: flex; flex-direction: column; align-items: center; justify-content: center; border-radius: 50%; overflow: hidden; position: relative;">
                <img src="{{ $promocion && $promocion->imagen ? asset('storage/' . $promocion->imagen) : 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=400&h=120&fit=crop' }}" alt="Promoción del día premium" style="width: 100%; height: 140px; object-fit: cover; border-top-left-radius: 50%; border-top-right-radius: 50%;">
                <div class="label" style="font-family: 'Playfair Display', serif; font-size: 1.3rem; font-weight: 700; color: #d4af37; margin-top: 1.3rem; text-align: center;">Promoción del Día</div>
                <div class="promo" style="font-size:1.15rem; font-family:'Montserrat',sans-serif; color:#181828; margin-top:0.7rem; font-weight:600; text-align:center; letter-spacing:0.5px; padding: 0 15px;">{{ $promocion ? $promocion->titulo : '2x1 en vinos reserva' }}</div>
            </div>
        </div>
    </section>

    <!-- Visual Block -->
    <div class="visual-block" style="display: flex; width: 100vw; margin-left: calc(50% - 50vw); margin-right: calc(50% - 50vw); margin-top: -2.5rem;">
    <img src="https://images.unsplash.com/photo-1528605248644-14dd04022da1?w=800&h=340&fit=crop" alt="Restaurante fino elegante" style="width: 50vw; height: 340px; object-fit: cover; display: block;">
        <img src="https://images.unsplash.com/photo-1502741338009-cac2772e18bc?w=800&h=340&fit=crop" alt="Plato gourmet de lujo" style="width: 50vw; height: 340px; object-fit: cover; display: block;">
    </div>

    <!-- Squares Row -->
    @php
        $noticia = null; // \App\Models\Noticia::latest('created_at')->first();
        $sanValentin = null; // \App\Models\Promocion::where('titulo', 'like', '%valentín%')->where('fecha_fin', '>=', now())->latest('created_at')->first();
    @endphp
    <section class="squares-row" style="display: flex; justify-content: center; align-items: flex-end; gap: 2.5rem; margin: 4rem 0 3rem 0;">
        <div class="square" style="background: #23234a; border-radius: 1.2rem; box-shadow: 0 4px 24px rgba(24,24,40,0.10); padding: 2rem 1.5rem; min-width: 220px; min-height: 180px; display: flex; flex-direction: column; align-items: center; justify-content: center; font-family: 'Montserrat', Arial, sans-serif; color: #fff; position: relative;">
            <div class="title" style="font-family: 'Playfair Display', serif; font-size: 1.2rem; font-weight: 700; margin-bottom: 0.7rem; color: #d4af37;">Noticias</div>
            <div class="desc" style="font-size: 1rem; color: #fff; text-align: center;">
                @if($noticia)
                    <strong>{{ $noticia->titulo }}</strong><br>
                    {{ Str::limit($noticia->contenido, 60) }}<br>
                    <a href="{{ route('noticias.publicIndex') }}" style="color: #d4af37; font-weight: 600; text-decoration: underline;">Leer más</a>
                @else
                    Descubre las últimas novedades y eventos exclusivos de Olla y Sazón.
                @endif
            </div>
        </div>
        <div class="square center" style="min-width: 270px; min-height: 220px; background: linear-gradient(135deg, #eec9d2 60%, #d4af37 100%); color: #181828; font-family: 'Playfair Display', serif; font-size: 1.3rem; font-weight: 700; box-shadow: 0 8px 32px rgba(224, 41, 120, 0.10); border: 3px solid #d4af37; z-index: 2; display: flex; flex-direction: column; align-items: center; justify-content: center; border-radius: 1.2rem;">
            @if($sanValentin)
                <div style="font-size:1.5rem; color:#b8004c; margin-bottom:0.5rem;">{{ $sanValentin->titulo }}</div>
                <div style="font-size:1.1rem; color:#181828;">{{ Str::limit($sanValentin->descripcion, 80) }}</div>
            @else
                <div style="font-size:1.5rem; color:#b8004c; margin-bottom:0.5rem;">Especial San Valentín</div>
                <div style="font-size:1.1rem; color:#181828;">Cena romántica a la luz de las velas, menú degustación y música en vivo.</div>
            @endif
        </div>
        <div class="square" style="background: #23234a; border-radius: 1.2rem; box-shadow: 0 4px 24px rgba(24,24,40,0.10); padding: 2rem 1.5rem; min-width: 220px; min-height: 180px; display: flex; flex-direction: column; align-items: center; justify-content: center; font-family: 'Montserrat', Arial, sans-serif; color: #fff; position: relative;">
            <div class="title" style="font-family: 'Playfair Display', serif; font-size: 1.2rem; font-weight: 700; margin-bottom: 0.7rem; color: #d4af37;">Promociones</div>
            <div class="desc" style="font-size: 1rem; color: #fff; text-align: center;">
                @if($promocion)
                    <strong>{{ $promocion->titulo }}</strong><br>
                    {{ Str::limit($promocion->descripcion, 60) }}<br>
                    <a href="{{ route('promociones.publicIndex') }}" style="color: #d4af37; font-weight: 600; text-decoration: underline;">Ver promoción</a>
                @else
                    Aprovecha nuestras ofertas premium y vive una experiencia única.
                @endif
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer" style="background: #181828; color: #fff; padding: 2.2rem 0 1.2rem 0; text-align: center; border-top-left-radius: 2rem; border-top-right-radius: 2rem; margin-top: 2.5rem; font-size: 1.05rem; box-shadow: 0 -4px 24px rgba(24,24,40,0.10); border-top: 3px solid #d4af37;">
        <div class="footer-content" style="max-width: 900px; margin: 0 auto; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 1.2rem; padding: 0 1.5rem;">
            <div class="footer-info" style="flex: 1; min-width: 220px; text-align: left;">
                <div class="brand" style="font-family: 'Playfair Display', serif; font-size: 1.2rem; font-weight: 700; color: #d4af37; margin-bottom: 0.2rem;"><i class="fas fa-utensils"></i> Olla y Sazón</div>
                <div class="details" style="font-size: 1rem; color: #fffbe6;">Calle Principal 123, Ciudad<br>Tel: (555) 123-4567</div>
            </div>
            <div class="footer-social" style="flex: 1; min-width: 180px; text-align: right;">
                <a href="https://facebook.com" target="_blank" style="color: #d4af37; margin: 0 0.4rem; font-size: 1.3rem; transition: color 0.2s;"><i class="fab fa-facebook"></i></a>
                <a href="https://instagram.com" target="_blank" style="color: #d4af37; margin: 0 0.4rem; font-size: 1.3rem; transition: color 0.2s;"><i class="fab fa-instagram"></i></a>
                <a href="mailto:info@ollaysazon.com" style="color: #d4af37; margin: 0 0.4rem; font-size: 1.3rem; transition: color 0.2s;"><i class="fas fa-envelope"></i></a>
            </div>
        </div>
        <div class="copyright" style="margin-top: 1.2rem; color: #fffbe6; font-size: 0.95rem; opacity: 0.8;">&copy; {{ date('Y') }} Olla y Sazón. Todos los derechos reservados.</div>
    </footer>

    <!-- Scripts -->
    <script>
        // Efecto de parallax suave
        document.addEventListener('mousemove', (e) => {
            const circles = document.querySelectorAll('.circulo');
            const x = e.clientX / window.innerWidth;
            const y = e.clientY / window.innerHeight;
            
            circles.forEach((circle, index) => {
                const speed = (index + 1) * 0.5;
                const xPos = (x - 0.5) * speed;
                const yPos = (y - 0.5) * speed;
                
                circle.style.transform += ` translate(${xPos}px, ${yPos}px)`;
            });
        });

        // Animación de entrada
        document.addEventListener('DOMContentLoaded', () => {
            const circles = document.querySelectorAll('.circulo');
            circles.forEach((circle, index) => {
                circle.style.opacity = '0';
                circle.style.transform = 'scale(0.8) translateY(50px)';
                
                setTimeout(() => {
                    circle.style.transition = 'all 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275)';
                    circle.style.opacity = '1';
                    circle.style.transform = 'scale(1) translateY(0)';
                }, index * 200);
            });
        });
    </script>
</body>
<script>
// Animación flotante suave
document.addEventListener('DOMContentLoaded', () => {
    const circles = document.querySelectorAll('.circle');
    circles.forEach((circle, i) => {
        circle.animate([
            { transform: 'translateY(0px)' },
            { transform: `translateY(${i % 2 === 0 ? -18 : -10}px)` },
            { transform: 'translateY(0px)' }
        ], {
            duration: 4000 + i * 500,
            iterations: Infinity,
            direction: 'alternate',
            easing: 'ease-in-out'
        });
    });
});

// Parallax al mover el mouse
document.addEventListener('mousemove', (e) => {
    const circles = document.querySelectorAll('.circle');
    const x = e.clientX / window.innerWidth;
    const y = e.clientY / window.innerHeight;
    circles.forEach((circle, i) => {
        const speed = (i + 1) * 0.7;
        const xPos = (x - 0.5) * speed * 20;
        const yPos = (y - 0.5) * speed * 20;
        circle.style.transform = `translate(${xPos}px, ${yPos}px)`;
    });
});
</script>
</html>