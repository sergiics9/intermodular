# StyleSphere

**StyleSphere** es una tienda de ropa en línea desarrollada con PHP, JavaScript, HTML y CSS, que permite a los usuarios explorar productos, agregarlos a un carrito de compras y realizar pedidos. Incluye funcionalidades de autenticación, administración de productos, gestión de pedidos y un panel de administración.

## Requisitos

- **PHP** 8.2 o superior
- **MySQL** 5.7 o superior
- **Servidor web** Apache

## Instalación

1. **Clona el repositorio**:

```bash
git clone https://github.com/sergiics9/intermodular_final.git
cd intermodular_final
```

2. **Configura la base de datos**:

- Crea una nueva base de datos llamada `intermodular`.
- Importa el archivo `database/intermodular.sql` en tu base de datos.

3. **Configura los archivos de entorno**:

Edita el archivo `config/db.php` con los datos de conexión a tu base de datos:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'intermodular');
```

En `config/config.php`, define la URL base:

```php
define('BASE_URL', 'http://localhost/stylesphere/public');
```

4. **Establece permisos a las carpetas necesarias** (si usas Linux):

```bash
chmod -R 755 public/images
```

5. **Accede desde el navegador**:

```text
http://localhost/stylesphere/public
```

## Configuración

### Configuración del Entorno

Puedes activar o desactivar el modo debug en `config/config.php`:

```php
define('DEBUG', true); // o false en producción
```

## Uso

### Experiencia del Cliente

1. **Registro / Inicio de Sesión**

   - Los usuarios pueden crear una cuenta y acceder a sus pedidos.

2. **Explorar Productos**

   - Página principal con filtros de categoría, búsqueda y orden.

3. **Carrito de Compras**

   - Agrega productos, selecciona talla y ajusta cantidad.

4. **Formulario de Compra**

   - Introduce los datos de envío y realiza el pedido.

5. **Historial de Pedidos**
   - Consulta pedidos anteriores y su estado.

## Funciones Administrativas

### Gestión de Productos

- Añadir, editar o eliminar productos con imagen y tallas.

### Gestión de Categorías

- Crear nuevas categorías y editar las existentes.

### Gestión de Pedidos

- Ver todos los pedidos realizados por los usuarios.

### Gestión de Usuarios

- Consultar datos básicos y rol de cada usuario.

## Esquema de Base de Datos

Las tablas principales del sistema son:

- `usuarios`
- `productos`
- `categorias`
- `tallas`
- `carrito`
- `pedidos`
- `detalle_pedido`
- `comentarios`
- `contacto`

Puedes ver el esquema completo en el archivo:  
`database/intermodular.sql`

## Contribuciones

¡Las contribuciones son bienvenidas!

1. Haz un fork del repositorio.
2. Crea una nueva rama (`feature/nueva-funcionalidad`).
3. Haz tus cambios y crea un commit.
4. Sube tu rama y abre un Pull Request.

### Estándares de Código

- Usa comentarios claros en las funciones complejas.
- Agrupa el código siguiendo el patrón MVC.
- Prioriza seguridad (validación y sanitización de inputs).
