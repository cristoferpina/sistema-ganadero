<div align="center">

<sub>CRISTOFER PIÑA · DESARROLLO DE SOFTWARE</sub>

# Sistema ganadero

Control de animales, salud, reproducción y movimientos del hato.

<img alt="Laravel" src="https://img.shields.io/badge/Laravel-0F172A?style=for-the-badge" />
<img alt="Blade" src="https://img.shields.io/badge/Blade-1D4ED8?style=for-the-badge" />
<img alt="Tailwind CSS" src="https://img.shields.io/badge/Tailwind%20CSS-0F766E?style=for-the-badge" />

[Código fuente](https://github.com/cristoferpina/sistema-ganadero) &nbsp; / &nbsp; [Incidencias](https://github.com/cristoferpina/sistema-ganadero/issues) &nbsp; / &nbsp; [Perfil](https://github.com/cristoferpina)

</div>

---

[Acceso a producción](#seccion-1) · [Qué resuelve](#seccion-2) · [Módulos](#seccion-3) · [Experiencia de uso](#seccion-4) · [Stack tecnológico](#seccion-5)

---

<a id="seccion-1"></a>

## Acceso a producción

El sistema está disponible en:

### http://34.73.62.113](http://34.73.62.113)

> La URL utiliza HTTP. Para información sensible o acceso público permanente, se recomienda habilitar HTTPS con un certificado TLS antes de operar en un entorno real.

<a id="seccion-2"></a>

## Qué resuelve

Administrar un hato no debería depender de hojas de cálculo dispersas. Sistema Ganadero centraliza la información clave del rancho, facilita la consulta por arete y conserva el historial de cada animal para apoyar decisiones oportunas.

<a id="seccion-3"></a>

## Módulos

| Módulo | Capacidades principales |
| --- | --- |
| 🐄 **Ganado** | Alta, edición, consulta y baja de animales; control de arete, raza, sexo, peso, categoría, estatus y madre. |
| 🩺 **Historial clínico** | Registro de vacunas, desparasitaciones y tratamientos, con fechas de aplicación y próxima dosis. |
| 🧬 **Ciclos reproductivos** | Seguimiento de monta natural o inseminación, gestación, parto y destete. |
| 💰 **Ventas y bajas** | Registro de ventas, compras, muertes, bajas y sus datos de movimiento. |
| 👥 **Usuarios** | Administración de usuarios, roles y estado de las cuentas. |

<a id="seccion-4"></a>

## Experiencia de uso

- Diseño oscuro, claro y enfocado en información operativa.
- Interfaz adaptable a computadora, tablet y teléfono.
- Menú lateral desplegable para navegación en pantallas pequeñas.
- Filtros y búsquedas por módulo para localizar registros con rapidez.
- Tablas con desplazamiento horizontal en móvil para conservar todos los datos sin perder columnas.
- Formularios y paneles de detalle para trabajar sin salir de la pantalla actual.

<a id="seccion-5"></a>

## Stack tecnológico

- **Backend:** PHP 8.3 y Laravel 13.
- **Base de datos:** mariaDB
- **Frontend:** Blade, Tailwind CSS 4 y Vite.
- **Pruebas:** PHPUnit.

<a id="seccion-6"></a>

## Instalación local

### Requisitos

- PHP 8.3 o superior y Composer.
- Node.js LTS y npm.
- SQLite o un servidor MySQL, según la configuración elegida.

### Puesta en marcha

```bash
git clone https://github.com/cristoferpina/sistema-ganadero.git
cd sistema-ganadero

composer install
npm install

copy .env.example .env
php artisan key:generate

php artisan migrate --seed
npm run build
```

En macOS o Linux, sustituye `copy` por `cp`.

Para iniciar el entorno de desarrollo completo:

```bash
composer run dev
```

La aplicación quedará disponible en la dirección indicada por Laravel, normalmente `http://127.0.0.1:8000`.

<a id="seccion-7"></a>

## Configuración de base de datos

El proyecto viene preparado para SQLite. Para usar MySQL, actualiza estas variables en `.env`:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistema_ganadero
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```

Después ejecuta las migraciones:

```bash
php artisan migrate --seed
```

El seeder incluye animales de ejemplo para iniciar una demostración del módulo de ganado.

<a id="seccion-8"></a>

## Comandos útiles

| Acción | Comando |
| --- | --- |
| Ejecutar pruebas | `php artisan test` |
| Compilar recursos para producción | `npm run build` |
| Limpiar configuración en caché | `php artisan config:clear` |
| Aplicar migraciones | `php artisan migrate` |
| Cargar datos de demostración | `php artisan db:seed` |

<a id="seccion-9"></a>

## Despliegue

En el servidor de producción, configura `APP_ENV=production`, `APP_DEBUG=false` y una `APP_KEY` segura. Después instala las dependencias, compila los recursos y optimiza las cachés:

```bash
composer install --no-dev --optimize-autoloader
npm ci
npm run build

php artisan migrate --force
php artisan optimize
```

El servidor web debe apuntar al directorio `public/` de Laravel y tener permisos de escritura sobre `storage/` y `bootstrap/cache/`.

<a id="seccion-10"></a>

## Estructura del proyecto

```text
app/
├── Http/Controllers/      # Lógica de los módulos
├── Models/                # Entidades del dominio ganadero
database/
├── migrations/            # Esquema de base de datos
└── seeders/               # Datos de demostración
resources/
├── css/                   # Estilos globales y responsivos
├── js/                    # Comportamiento de interfaz
└── views/                 # Vistas Blade por módulo
routes/web.php             # Rutas de la aplicación
```

<a id="seccion-11"></a>

## Licencia

Proyecto desarrollado para la gestión interna de una operación ganadera. Define la licencia de distribución que corresponda antes de reutilizarlo o publicarlo.

---

<div align="center">
<sub>Desarrollado por <a href="https://github.com/cristoferpina">Cristofer Piña</a></sub>
</div>
