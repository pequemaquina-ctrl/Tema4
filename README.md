# 🎵 Music Manager & Shop App

¡Bienvenido a mi aplicación de gestión de discografía y tienda! Este proyecto es un sistema desarrollado en **PHP** que permite gestionar álbumes musicales, canciones y un módulo de inventario para una tienda integrada.

---

## 🚀 Funcionalidades Principales

### 🔐 Sistema de Usuarios
* **Registro y Login:** Gestión completa de usuarios para acceso restringido.
* **Autenticación:** Control de sesiones mediante `auth.php`.

### 💿 Gestión de Discografía
* **Visualización:** Listado de álbumes y detalles de canciones.
* **CRUD completo:** * Añadir nuevos álbumes (`albumnuevo.php`).
    * Eliminar álbumes existentes (`Borraralbum.php`).
    * Gestión de canciones (`canciones.php` y `cancionnueva.php`).

### 🛒 Módulo de Tienda
* **Catálogo:** Vista principal de productos en la sección de tienda.
* **Control de Inventario:** Gestión de existencias a través de `stock.php`.

---

## 📂 Estructura del Proyecto

A continuación se detalla la organización de los archivos del repositorio:

```text
/
├── 📁 discografia/         # Módulo principal de música
│   ├── index.php           # Landing page de la sección
│   ├── login.php           # Acceso de usuarios
│   ├── register.php        # Registro de nuevos usuarios
│   ├── auth.php            # Lógica de seguridad
│   ├── conexion.php        # Configuración de Base de Datos
│   ├── album.php           # Vista de álbum
│   ├── albumnuevo.php      # Formulario para nuevos álbumes
│   ├── Borraralbum.php     # Lógica de eliminación
│   ├── canciones.php       # Listado de temas
│   └── cancionnueva.php    # Añadir nuevas pistas
│
└── 📁 tienda/              # Módulo de comercio
    ├── index.php           # Portada de la tienda
    └── stock.php           # Gestión de existencias
