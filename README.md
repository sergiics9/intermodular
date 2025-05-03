# Proyecto Intermodular - 1ºDAW

## Descripción

Este proyecto es una tienda en línea desarrollada con **HTML, CSS, JavaScript, PHP y MySQL**. Permite la visualización y gestión de productos, así como la administración de usuarios y pedidos mediante un panel de administración.

## Características principales

### Usuario General

- **Visualización de productos** con información detallada.
- **Buscador de productos** para filtrar por nombre.
- **Registro y login de usuarios** con validación.
- **Gestión de pedidos**, permitiendo a los usuarios realizar compras.
- **Página de detalles** de cada producto con descripción ampliada.

### Administrador

- **Panel de Administración** con funcionalidades avanzadas.
- **Gestor de productos**:
  - Añadir nuevos productos.
  - Modificar productos existentes.
  - Eliminar productos.
- **Gestión de usuarios**:
  - Visualización de usuarios registrados.
  - Asignación de roles (usuario normal o administrador).

## Tecnologías utilizadas

- **Frontend**: HTML, CSS, JavaScript.
- **Backend**: PHP.
- **Base de Datos**: MySQL.

## Instalación y configuración

1. Clonar este repositorio:
   ```bash
   git clone https://github.com/tu-repositorio.git
   ```
2. Importar la base de datos desde `database.sql` a MySQL.
3. Configurar la conexión en el archivo `config.php`:
   ```php
   $host = "localhost";
   $user = "root";
   $password = "";
   $database = "nombre_base_datos";
   ```
4. Iniciar un servidor local (XAMPP, WAMP, MAMP) y acceder a la carpeta del proyecto desde el navegador.

## Estado del proyecto

El proyecto está en desarrollo y se están agregando mejoras de seguridad y diseño.

## Contribución

Si deseas contribuir, puedes hacer un fork del repositorio y enviar un pull request con mejoras.
