<div align="center">

# 🐄 Sistema ganadero

Control de animales, salud, reproducción y movimientos del hato.

**Laravel · Blade · Tailwind CSS**

[Explorar código](https://github.com/cristoferpina/sistema-ganadero) · [Reportar un problema](https://github.com/cristoferpina/sistema-ganadero/issues)

</div>

---

<p align="center">
  Plataforma web para llevar el control operativo de un hato: animales, salud, reproducción, movimientos y usuarios desde una sola interfaz.
</p>

<p align="center">
  <a href="http://34.73.62.113"><strong>🚀 Abrir sistema en producción</strong></a>
  &nbsp;·&nbsp;
  <a href="#instalación-local">Instalación local</a>
  &nbsp;·&nbsp;
  <a href="#módulos">Módulos</a>
</p>

---

## Acceso a producción

El sistema está disponible en:

### [http://34.73.62.113](http://34.73.62.113)

> La URL utiliza HTTP. Para información sensible o acceso público permanente, se recomienda habilitar HTTPS con un certificado TLS antes de operar en un entorno real.

## Qué resuelve

Administrar un hato no debería depender de hojas de cálculo dispersas. Sistema Ganadero centraliza la información clave del rancho, facilita la consulta por arete y conserva el historial de cada animal para apoyar decisiones oportunas.

## Módulos

| Módulo | Capacidades principales |
| --- | --- |
| 🐄 **Ganado** | Alta, edición, consulta y baja de animales; control de arete, raza, sexo, peso, categoría, estatus y madre. |
| 🩺 **Historial clínico** | Registro de vacunas, desparasitaciones y tratamientos, con fechas de aplicación y próxima dosis. |
| 🧬 **Ciclos reproductivos** | Seguimiento de monta natural o inseminación, gestación, parto y destete. |
| 💰 **Ventas y bajas** | Registro de ventas, compras, muertes, bajas y sus datos de movimiento. |
| 👥 **Usuarios** | Administración de usuarios, roles y estado de las cuentas. |

## Experiencia de uso

- Diseño oscuro, claro y enfocado en información operativa.
- Interfaz adaptable a computadora, tablet y teléfono.
- Menú lateral desplegable para navegación en pantallas pequeñas.
- Filtros y búsquedas por módulo para localizar registros con rapidez.
- Tablas con desplazamiento horizontal en móvil para conservar todos los datos sin perder columnas.
- Formularios y paneles de detalle para trabajar sin salir de la pantalla actual.

## Stack tecnológico

- **Backend:** PHP 8.3 y Laravel 13.
- **Base de datos:** mariaDB
- **Frontend:** Blade, Tailwind CSS 4 y Vite.
- **Pruebas:** PHPUnit.

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

## Comandos útiles

| Acción | Comando |
| --- | --- |
| Ejecutar pruebas | `php artisan test` |
| Compilar recursos para producción | `npm run build` |
| Limpiar configuración en caché | `php artisan config:clear` |
| Aplicar migraciones | `php artisan migrate` |
| Cargar datos de demostración | `php artisan db:seed` |

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

## Licencia

Proyecto desarrollado para la gestión interna de una operación ganadera. Define la licencia de distribución que corresponda antes de reutilizarlo o publicarlo.
