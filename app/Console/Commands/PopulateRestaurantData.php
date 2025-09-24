<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Inventario;
use App\Models\Noticia;
use App\Models\Promocion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PopulateRestaurantData extends Command
{
    protected $signature = 'restaurant:populate';
    protected $description = 'Poblar restaurante con productos, ingredientes, noticias y promociones típicas colombianas';

    public function handle()
    {
        // Autenticar como administrador
        $admin = User::where('rol', 'admin')->first();
        if (!$admin) {
            $this->error('No se encontró usuario administrador');
            return;
        }
        
        Auth::login($admin);
        $this->info("Autenticado como: {$admin->name}");

        // Crear categorías si no existen
        $this->createCategories();
        
        // Crear productos típicos colombianos
        $this->createProducts();
        
        // Crear ingredientes en inventario
        $this->createInventory();
        
        // Crear noticias
        $this->createNews();
        
        // Crear promociones
        $this->createPromotions();

        $this->info('¡Datos del restaurante creados exitosamente!');
    }

    private function createCategories()
    {
        $categorias = [
            'Sopas y Caldos',
            'Platos Principales', 
            'Acompañamientos',
            'Postres',
            'Bebidas',
            'Entradas'
        ];

        foreach ($categorias as $nombre) {
            Categoria::firstOrCreate(['nombre' => $nombre]);
        }
        
        $this->info('Categorías creadas');
    }

    private function createProducts()
    {
        $productos = [
            // Sopas y Caldos
            [
                'categoria' => 'Sopas y Caldos',
                'nombre' => 'Ajiaco Santafereño',
                'descripcion' => 'Sopa tradicional bogotana con pollo, papas criollas, sabaneras y pastusa, mazorca y guascas',
                'ingredientes' => 'Pollo, Papa criolla, Papa sabanera, Papa pastusa, Mazorca, Guascas, Alcaparras, Crema de leche',
                'precio' => 18000,
                'imagen' => 'productos/ajiaco.jpg'
            ],
            [
                'categoria' => 'Sopas y Caldos',
                'nombre' => 'Sancocho Trifásico',
                'descripcion' => 'Sancocho vallecaucano con pollo, cerdo y res, acompañado de yuca, plátano y mazorca',
                'ingredientes' => 'Pollo, Cerdo, Res, Yuca, Plátano verde, Mazorca, Cilantro, Cebolla larga',
                'precio' => 22000,
                'imagen' => 'productos/sancocho.jpg'
            ],
            
            // Platos Principales
            [
                'categoria' => 'Platos Principales',
                'nombre' => 'Bandeja Paisa',
                'descripcion' => 'Plato típico antioqueño con frijoles, arroz, carne molida, chicharrón, chorizo, huevo, plátano maduro y arepa',
                'ingredientes' => 'Frijoles rojos, Arroz, Carne molida, Chicharrón, Chorizo, Huevo, Plátano maduro, Arepa, Aguacate',
                'precio' => 25000,
                'imagen' => 'productos/bandeja_paisa.jpg'
            ],
            [
                'categoria' => 'Platos Principales',
                'nombre' => 'Lechona Tolimense',
                'descripcion' => 'Cerdo relleno con arroz, arveja y especias, cocido al horno tradicionalmente',
                'ingredientes' => 'Cerdo, Arroz, Arveja verde, Cebolla, Ajo, Comino, Pimienta',
                'precio' => 20000,
                'imagen' => 'productos/lechona.jpg'
            ],
            [
                'categoria' => 'Platos Principales',
                'nombre' => 'Mojarra Frita',
                'descripcion' => 'Mojarra fresca frita acompañada de patacones, arroz con coco y ensalada',
                'ingredientes' => 'Mojarra, Plátano verde, Arroz, Coco, Lechuga, Tomate, Cebolla',
                'precio' => 24000,
                'imagen' => 'productos/mojarra.jpg'
            ],
            [
                'categoria' => 'Platos Principales',
                'nombre' => 'Sobrebarriga a la Criolla',
                'descripcion' => 'Sobrebarriga guisada con papa criolla, yuca y hogao tradicional',
                'ingredientes' => 'Sobrebarriga, Papa criolla, Yuca, Tomate, Cebolla, Ajo, Cilantro',
                'precio' => 21000,
                'imagen' => 'productos/sobrebarriga.jpg'
            ],

            // Acompañamientos
            [
                'categoria' => 'Acompañamientos',
                'nombre' => 'Patacones',
                'descripcion' => 'Plátano verde frito y aplastado, crujiente por fuera y suave por dentro',
                'ingredientes' => 'Plátano verde, Aceite, Sal, Ajo',
                'precio' => 8000,
                'imagen' => 'productos/patacones.jpg'
            ],
            [
                'categoria' => 'Acompañamientos',
                'nombre' => 'Yuca Frita',
                'descripcion' => 'Yuca cocida y frita hasta dorar, acompañada de hogao',
                'ingredientes' => 'Yuca, Aceite, Tomate, Cebolla, Sal',
                'precio' => 7000,
                'imagen' => 'productos/yuca_frita.jpg'
            ],

            // Entradas
            [
                'categoria' => 'Entradas',
                'nombre' => 'Empanadas Vallenas',
                'descripcion' => 'Empanadas criollas rellenas de carne y papa, fritas hasta dorar',
                'ingredientes' => 'Harina de maíz, Carne molida, Papa, Cebolla, Ajo, Comino',
                'precio' => 3500,
                'imagen' => 'productos/empanadas.jpg'
            ],
            [
                'categoria' => 'Entradas',
                'nombre' => 'Arepa de Chócolo',
                'descripcion' => 'Arepa dulce hecha con maíz tierno, queso y un toque de panela',
                'ingredientes' => 'Maíz tierno, Queso campesino, Panela, Mantequilla',
                'precio' => 6000,
                'imagen' => 'productos/arepa_chocolo.jpg'
            ],

            // Postres
            [
                'categoria' => 'Postres',
                'nombre' => 'Tres Leches',
                'descripcion' => 'Bizcocho empapado en tres tipos de leche con canela y coco rallado',
                'ingredientes' => 'Leche condensada, Leche evaporada, Crema de leche, Huevos, Harina, Canela, Coco',
                'precio' => 9000,
                'imagen' => 'productos/tres_leches.jpg'
            ],
            [
                'categoria' => 'Postres',
                'nombre' => 'Flan de Coco',
                'descripcion' => 'Flan cremoso de coco con caramelo y coco rallado',
                'ingredientes' => 'Coco rallado, Leche condensada, Huevos, Azúcar, Gelatina sin sabor',
                'precio' => 8000,
                'imagen' => 'productos/flan_coco.jpg'
            ],

            // Bebidas
            [
                'categoria' => 'Bebidas',
                'nombre' => 'Limonada de Coco',
                'descripcion' => 'Refrescante bebida con limón, coco rallado y hielo',
                'ingredientes' => 'Limón, Coco rallado, Azúcar, Agua, Hielo',
                'precio' => 6000,
                'imagen' => 'productos/limonada_coco.jpg'
            ],
            [
                'categoria' => 'Bebidas',
                'nombre' => 'Jugo de Lulo',
                'descripcion' => 'Jugo natural de lulo, fruta exótica colombiana, refrescante y nutritivo',
                'ingredientes' => 'Lulo, Azúcar, Agua, Hielo',
                'precio' => 5500,
                'imagen' => 'productos/jugo_lulo.jpg'
            ]
        ];

        foreach ($productos as $productoData) {
            $categoria = Categoria::where('nombre', $productoData['categoria'])->first();
            
            Producto::create([
                'nombre' => $productoData['nombre'],
                'descripcion' => $productoData['descripcion'],
                'ingredientes' => $productoData['ingredientes'],
                'precio' => $productoData['precio'],
                'stock' => rand(15, 50),
                'image' => $productoData['imagen'],
                'category_id' => $categoria->id
            ]);
        }

        $this->info('Productos creados');
    }

    private function createInventory()
    {
        $ingredientes = [
            ['nombre' => 'Pollo', 'categoria' => 'proteina', 'unidad' => 'kg', 'precio' => 8500, 'stock' => 25],
            ['nombre' => 'Cerdo', 'categoria' => 'proteina', 'unidad' => 'kg', 'precio' => 12000, 'stock' => 15],
            ['nombre' => 'Res', 'categoria' => 'proteina', 'unidad' => 'kg', 'precio' => 15000, 'stock' => 20],
            ['nombre' => 'Mojarra', 'categoria' => 'proteina', 'unidad' => 'kg', 'precio' => 18000, 'stock' => 12],
            ['nombre' => 'Papa criolla', 'categoria' => 'verdura', 'unidad' => 'kg', 'precio' => 3500, 'stock' => 40],
            ['nombre' => 'Papa sabanera', 'categoria' => 'verdura', 'unidad' => 'kg', 'precio' => 2800, 'stock' => 35],
            ['nombre' => 'Yuca', 'categoria' => 'verdura', 'unidad' => 'kg', 'precio' => 2200, 'stock' => 30],
            ['nombre' => 'Plátano verde', 'categoria' => 'verdura', 'unidad' => 'kg', 'precio' => 2500, 'stock' => 25],
            ['nombre' => 'Plátano maduro', 'categoria' => 'verdura', 'unidad' => 'kg', 'precio' => 3000, 'stock' => 20],
            ['nombre' => 'Frijoles rojos', 'categoria' => 'cereal', 'unidad' => 'kg', 'precio' => 6500, 'stock' => 18],
            ['nombre' => 'Arroz', 'categoria' => 'cereal', 'unidad' => 'kg', 'precio' => 3200, 'stock' => 50],
            ['nombre' => 'Maíz tierno', 'categoria' => 'cereal', 'unidad' => 'kg', 'precio' => 4000, 'stock' => 15],
            ['nombre' => 'Queso campesino', 'categoria' => 'lacteo', 'unidad' => 'kg', 'precio' => 14000, 'stock' => 8],
            ['nombre' => 'Crema de leche', 'categoria' => 'lacteo', 'unidad' => 'lt', 'precio' => 5500, 'stock' => 12],
            ['nombre' => 'Leche condensada', 'categoria' => 'lacteo', 'unidad' => 'lt', 'precio' => 8000, 'stock' => 10],
            ['nombre' => 'Guascas', 'categoria' => 'condimento', 'unidad' => 'gr', 'precio' => 2500, 'stock' => 5],
            ['nombre' => 'Cilantro', 'categoria' => 'condimento', 'unidad' => 'kg', 'precio' => 3000, 'stock' => 8],
            ['nombre' => 'Cebolla larga', 'categoria' => 'condimento', 'unidad' => 'kg', 'precio' => 4500, 'stock' => 12],
            ['nombre' => 'Ajo', 'categoria' => 'condimento', 'unidad' => 'kg', 'precio' => 8000, 'stock' => 6],
            ['nombre' => 'Coco rallado', 'categoria' => 'otro', 'unidad' => 'kg', 'precio' => 6000, 'stock' => 10],
            ['nombre' => 'Lulo', 'categoria' => 'verdura', 'unidad' => 'kg', 'precio' => 7000, 'stock' => 8],
            ['nombre' => 'Limón', 'categoria' => 'verdura', 'unidad' => 'kg', 'precio' => 4000, 'stock' => 15]
        ];

        foreach ($ingredientes as $ingrediente) {
            Inventario::create([
                'codigo' => Inventario::generarCodigo(),
                'nombre' => $ingrediente['nombre'],
                'descripcion' => 'Ingrediente para preparación de platos típicos',
                'categoria' => $ingrediente['categoria'],
                'unidad_medida' => $ingrediente['unidad'],
                'stock_inicial' => $ingrediente['stock'],
                'stock_actual' => $ingrediente['stock'],
                'stock_minimo' => round($ingrediente['stock'] * 0.2),
                'stock_maximo' => round($ingrediente['stock'] * 2),
                'precio_unitario' => $ingrediente['precio'],
                'proveedor' => 'Proveedor Central',
                'fecha_vencimiento' => now()->addDays(rand(30, 90)),
                'estado' => 'disponible'
            ]);
        }

        $this->info('Inventario creado');
    }

    private function createNews()
    {
        $noticias = [
            [
                'titulo' => 'Nuevo Menú de Temporada con Sabores Colombianos',
                'contenido' => 'Nos complace anunciar el lanzamiento de nuestro nuevo menú de temporada, que celebra la rica tradición culinaria colombiana. Hemos incorporado platos auténticos de diferentes regiones del país, preparados con ingredientes frescos y técnicas tradicionales que han pasado de generación en generación.',
                'imagen' => 'noticias/menu_temporada.jpg'
            ],
            [
                'titulo' => 'Celebración del Día de la Independencia con Descuentos Especiales',
                'contenido' => 'En conmemoración del Día de la Independencia de Colombia, ofrecemos descuentos especiales en nuestros platos más representativos. Ven y disfruta de la auténtica gastronomía colombiana con precios únicos durante toda la semana patria.',
                'imagen' => 'noticias/independencia.jpg'
            ],
            [
                'titulo' => 'Ampliación de Horarios de Atención',
                'contenido' => 'Debido a la gran acogida de nuestros clientes, hemos decidido ampliar nuestros horarios de atención. Ahora podrás disfrutar de nuestros deliciosos platos desde las 7:00 AM hasta las 11:00 PM de lunes a domingo, para que nunca te quedes sin probar nuestras especialidades.',
                'imagen' => 'noticias/horarios.jpg'
            ],
            [
                'titulo' => 'Certificación en Buenas Prácticas de Manufactura',
                'contenido' => 'Nos enorgullece anunciar que hemos obtenido la certificación en Buenas Prácticas de Manufactura (BPM), lo que garantiza la más alta calidad e higiene en todos nuestros procesos. Tu salud y satisfacción son nuestra prioridad.',
                'imagen' => 'noticias/certificacion.jpg'
            ],
            [
                'titulo' => 'Nuevo Servicio de Domicilios sin Costo Adicional',
                'contenido' => 'Ahora puedes disfrutar de nuestros platos favoritos desde la comodidad de tu hogar. Hemos implementado un servicio de domicilios gratuito para pedidos superiores a $30.000 en un radio de 5 kilómetros. ¡Ordena ya!',
                'imagen' => 'noticias/domicilios.jpg'
            ]
        ];

        foreach ($noticias as $noticia) {
            Noticia::create([
                'titulo' => $noticia['titulo'],
                'contenido' => $noticia['contenido'],
                'imagen' => $noticia['imagen'],
                'fecha_publicacion' => now()->subDays(rand(1, 30))
            ]);
        }

        $this->info('Noticias creadas');
    }

    private function createPromotions()
    {
        $promociones = [
            [
                'titulo' => '2x1 en Empanadas los Viernes',
                'descripcion' => 'Todos los viernes disfruta de nuestras deliciosas empanadas vallenas al 2x1. Perfectas para compartir en familia o con amigos.',
                'descuento' => 50,
                'dias' => 30,
                'imagen' => 'promociones/2x1_empanadas.jpg'
            ],
            [
                'titulo' => 'Combo Familiar Bandeja Paisa',
                'descripcion' => 'Combo especial para 4 personas: 4 Bandejas Paisas + 4 bebidas + postre para compartir. Ideal para reuniones familiares.',
                'descuento' => 20,
                'dias' => 45,
                'imagen' => 'promociones/combo_familiar.jpg'
            ],
            [
                'titulo' => 'Descuento Estudiantes - 15% OFF',
                'descripcion' => 'Estudiantes universitarios reciben 15% de descuento presentando su carnet vigente. Válido de lunes a jueves.',
                'descuento' => 15,
                'dias' => 60,
                'imagen' => 'promociones/descuento_estudiantes.jpg'
            ],
            [
                'titulo' => 'Happy Hour Bebidas Tropicales',
                'descripcion' => 'De 3:00 PM a 6:00 PM todas nuestras bebidas naturales y jugos tropicales tienen 30% de descuento.',
                'descuento' => 30,
                'dias' => 90,
                'imagen' => 'promociones/happy_hour.jpg'
            ],
            [
                'titulo' => 'Menú Ejecutivo Almuerzo',
                'descripcion' => 'Menú completo de almuerzo: sopa, plato fuerte, bebida y postre por solo $15.000. Disponible de lunes a viernes de 12:00 PM a 3:00 PM.',
                'descuento' => 25,
                'dias' => 30,
                'imagen' => 'promociones/menu_ejecutivo.jpg'
            ]
        ];

        foreach ($promociones as $promocion) {
            Promocion::create([
                'titulo' => $promocion['titulo'],
                'descripcion' => $promocion['descripcion'],
                'descuento' => $promocion['descuento'],
                'fecha_inicio' => now(),
                'fecha_fin' => now()->addDays($promocion['dias']),
                'imagen' => $promocion['imagen']
            ]);
        }

        $this->info('Promociones creadas');
    }
}