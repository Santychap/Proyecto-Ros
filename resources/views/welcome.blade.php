<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Olla y sazon</title>

    <!-- REMPLAZA TODOS LOS LINK CSS POR VITE -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <!-- Agregar Font Awesome para los íconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>

<body>
  <header class="flex justify-between items-center px-6 py-3 border-b border-gray-700">
      <div class="text-gray-400 text-sm">Anuncios</div>
      <div>
          <a href="{{ route('login') }}" class="text-yellow-400 border border-yellow-400 px-3 py-1 rounded hover:bg-yellow-400 hover:text-black transition mr-2">Inicio de sesión</a>
          <a href="{{ route('register') }}" class="text-yellow-400 border border-yellow-400 px-3 py-1 rounded hover:bg-yellow-400 hover:text-black transition">Registro</a>
      </div>
  </header>

  <main>
    <!-- Sección de círculos -->
    <section class="circulos-principales">
      <div class="circulo small">
        <img src="{{ asset('imagenes/Imagen1.jpg') }}" alt="Plato del día" />
        <span>Plato del día</span>
      </div>

      <div class="circulo central">
        <img src="{{ asset('imagenes/00.jpg') }}" alt="Olla y Sazón" />
        <span>OLLA<br />Y<br />SAZÓN</span>
      </div>

      <div class="circulo small">
        <img src="{{ asset('imagenes/Imagen3.jpg') }}" alt="Promoción del día" />
        <span>Promoción del día</span>
      </div>
    </section>

    <!-- Sección de bloques -->
    <section class="bloques">
      <div class="bloque-contenedor">
        <p class="titulo-bloque">Menú</p>
        <a href="menu-restaurante.html" target="_blank" class="bloque">
          <img src="{{ asset('imagenes/01.jpg') }}" alt="Menú" />
        </a>
      </div>

      <div class="bloque-contenedor">
        <p class="titulo-bloque">Reservas</p>
        <a href="menu-restaurante.html#contacto" target="_blank" class="bloque">
          <img src="{{ asset('imagenes/000.jpg') }}" alt="Reservas" />
        </a>
      </div>

      <div class="bloque-contenedor">
        <p class="titulo-bloque">Noticias</p>
        <a href="#noticias" class="bloque">
          <img src="{{ asset('imagenes/0.webp') }}" alt="Noticias" />
        </a>
      </div>
    </section>

    <!-- Sección Noticias -->
    <section class="noticias" id="noticias">
      <h2 class="section-title">📰 Explora Nuestras Secciones</h2>

      <div class="cuadros-grid">
        <a href="platillos.html" class="cuadro-link">
          <div class="cuadro">
            <div class="cuadro-icon"><i class="fas fa-utensils"></i></div>
            <div class="cuadro-content">
              <img src="{{ asset('imagenes/1.jpg') }}" alt="Platillos" />
              <h3>Platillos Especiales</h3>
              <p>
                Nuestros platillos especiales nacen de la inspiración, el respeto por la tradición y la creatividad sin límites. Ya sea una receta de temporada, un ingrediente exótico o una reinterpretación de un clásico, cada bocado cuenta una historia pensada para deleitar tus sentidos y dejarte con ganas de más.
              </p>
              <span class="cuadro-badge">¡NUEVO!</span>
            </div>
          </div>
        </a>

        <a href="eventos.html" class="cuadro-link">
          <div class="cuadro">
            <div class="cuadro-icon"><i class="fas fa-music"></i></div>
            <div class="cuadro-content">
              <img src="{{ asset('imagenes/2.jpg') }}" alt="Eventos" />
              <h3>Eventos Especiales</h3>
              <p>
                La buena comida se disfruta más cuando se comparte en momentos memorables. Aquí te mantenemos al tanto de cenas temáticas, degustaciones exclusivas, fechas con música en vivo y celebraciones que convierten tu visita en una experiencia inolvidable. ¡Ven y sé parte de nuestros eventos más esperados!
              </p>
              <span class="cuadro-badge">PRÓXIMAMENTE</span>
            </div>
          </div>
        </a>

        <a href="lonuevo.html" class="cuadro-link">
          <div class="cuadro">
            <div class="cuadro-icon"><i class="fas fa-tags"></i></div>
            <div class="cuadro-content">
              <img src="{{ asset('imagenes/4.jpg') }}" alt="Lo Nuevo" />
              <h3>Lo Nuevo</h3>
              <p>
                Siempre estamos innovando para ofrecerte experiencias únicas. Descubre las últimas incorporaciones a nuestro menú, las novedades en ingredientes, presentaciones sorprendentes y detalles que hacen de cada visita algo especial. Nos encanta sorprenderte y que formas parte de esta evolución.
              </p>
              <span class="cuadro-badge">AHORRA</span>
            </div>
          </div>
        </a>

        <a href="reconocimientos.html" class="cuadro-link">
          <div class="cuadro">
            <div class="cuadro-icon"><i class="fas fa-trophy"></i></div>
            <div class="cuadro-content">
              <img src="{{ asset('imagenes/3.jpg') }}" alt="Reconocimientos" />
              <h3>Reconocimientos</h3>
              <p>
                Gracias a la dedicación de nuestro equipo y al apoyo de nuestros comensales, hemos sido distinguidos por nuestra calidad, creatividad y servicio. Aquí celebramos los logros que nos inspiran a seguir creciendo y cocinando con el corazón, siempre buscando superar tus expectativas.
              </p>
              <span class="cuadro-badge">PREMIADOS</span>
            </div>
          </div>
        </a>

        <a href="chef.html" class="cuadro-link">
          <div class="cuadro">
            <div class="cuadro-icon"><i class="fas fa-user-chef"></i></div>
            <div class="cuadro-content">
              <img src="{{ asset('imagenes/5.jpg') }}" alt="Chef" />
              <h3>Nuestro Chef</h3>
              <p>
                Con una pasión incansable por la cocina y una trayectoria marcada por la excelencia, nuestro chef lidera la experiencia culinaria del restaurante. Su sensibilidad, técnica y compromiso con la calidad se reflejan en cada plato. Conócelo más y descubre la historia detrás de su inspiración.
              </p>
              <span class="cuadro-badge">CONÓCELO</span>
            </div>
          </div>
        </a>

        <a href="blog.html" class="cuadro-link">
          <div class="cuadro">
            <div class="cuadro-icon"><i class="fas fa-blog"></i></div>
            <div class="cuadro-content">
              <img src="{{ asset('imagenes/6.jpg') }}" alt="Blog" />
              <h3>Blog Gastronómico</h3>
              <p>
                Explora nuestro blog y sumérgete en el fascinante mundo de la gastronomía. Encontrarás artículos sobre ingredientes, consejos culinarios, curiosidades del arte de cocinar y reflexiones sobre el placer de comer bien. Es nuestra forma de compartir contigo todo lo que amamos de esta profesión.
              </p>
              <span class="cuadro-badge">LEE MÁS</span>
            </div>
          </div>
        </a>
      </div>
    </section>
  </main>

  <!-- Footer -->
  <footer class="footer">
    <div class="container">
      <div class="footer-content">
        <div class="footer-section">
          <h3>Contacto</h3>
          <div class="info-item">
            <img src="{{ asset('imagenes/alfiler-de-mapa.png') }}" alt="Dirección" />
            <p>Cra 9 # 10-20, Bogotá</p>
          </div>
        </div>

        <div class="footer-section">
          <h3>Olla y Sazón</h3>
          <p>Donde cada comida es una celebración de sabores auténticos y momentos especiales.</p>
        </div>

        <div class="footer-section">
          <h3>Síguenos</h3>
          <div class="social-links">
            <img src="{{ asset('imagenes/instagram.png') }}" alt="Instagram" />
            <img src="{{ asset('imagenes/facebook.png') }}" alt="Facebook" />
            <img src="{{ asset('imagenes/social.png') }}" alt="WhatsApp" />
          </div>
        </div>
      </div>
      <div class="footer-bottom">
        <p>&copy; 2025 Olla y Sazón. Todos los derechos reservados.</p>
      </div>
    </div>
  </footer>

</body>
</html>