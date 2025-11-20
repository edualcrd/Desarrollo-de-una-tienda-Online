# 🛒 Desarrollo de una Tienda Online con API REST y Cliente HTML

Este proyecto implementa una aplicación de comercio electrónico básica, dividida en una API REST construida en **PHP** para la lógica del servidor, y un cliente **HTML/JavaScript** que utiliza el **LocalStorage** para gestionar el estado de la aplicación.

El proyecto cumple con los criterios de la actividad RA4, demostrando la programación del lado del cliente, la comunicación con el servidor mediante la **Fetch API**, y la aplicación de los principios **SOLID** en la estructura del código.

## 🛠️ Tecnologías Utilizadas

| Componente | Tecnología | Uso Principal |
| :--- | :--- | :--- |
| **Frontend** | HTML5, CSS3, JavaScript | Interfaz de Usuario, Lógica del Cliente, LocalStorage. |
| **Comunicación** | Fetch API | Conexión asíncrona entre el cliente (JS) y el servidor (PHP). |
| **Backend** | PHP | API REST para login y validación de precios (seguridad). |
| **Almacenamiento**| JSON | Base de datos simple para usuarios y catálogo (`usuarios.json`, `tienda.json`). |
| **Estado** | LocalStorage | Almacenamiento local del Token de Autenticación, Carrito y Productos Vistos. |

## 🚀 Cómo Ejecutar el Proyecto

1.  **Instalación del Servidor:** Asegúrate de tener un entorno de servidor local con soporte PHP (como **XAMPP, WAMP** o **Laragon**).
2.  **Configuración de Archivos:** Coloca toda la carpeta del proyecto (`api`, `data`, `assets`, `login.html`, etc.) dentro del directorio `htdocs` (o el directorio raíz de tu servidor web).
3.  **Inicio:** Inicia el módulo **Apache** en tu panel de control de XAMPP/WAMP.
4.  **Acceso:** Abre el navegador y navega a la URL de tu proyecto: `http://localhost/nombre_de_la_carpeta/login.html`

**Credenciales de Prueba:**
* **Usuario:** `user`
* **Contraseña:** `pass`
