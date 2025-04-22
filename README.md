![image](https://github.com/user-attachments/assets/b1bbd41b-e990-472f-9a8a-977446fb77c2)

# 📸 Lector QR de Asistencia

Este proyecto es un sistema diseñado para gestionar la asistencia de personas mediante la lectura de códigos QR. Utilizando tecnologías modernas como **JavaScript**, **PHP**, y **CSS**, este sistema permite registrar y consultar asistencias de manera rápida y eficiente.

---

## 🌟 **Descripción**

El **Lector QR de Asistencia** es una herramienta que facilita la gestión de asistencia en eventos, aulas o cualquier entorno en el que se requiera un control rápido y automatizado de personas. Este sistema utiliza un lector de códigos QR para registrar entradas en una base de datos, eliminando la necesidad de registros manuales.

---

## ✨ **Características**

- **Lectura de Códigos QR**: Escanea y procesa códigos QR para registrar asistencia.
- **Gestión de Usuarios**: Permite registrar, editar y consultar usuarios.
- **Interfaz amigable**: Diseño responsivo y fácil de usar.
- **Base de Datos**: Almacenamiento seguro de los registros de asistencia.
- **Reportes**: Generación de reportes detallados de asistencia.
- **Código modular**: Fácil de mantener y extender.

---

## 🚀 **Cómo Empezar**

Sigue estos pasos para configurar y ejecutar el proyecto en tu máquina local:

### 1. **Clona este repositorio**

   ```bash
   git clone https://github.com/jeanpaul615/Lector-QR-de-Asistencia.git
   ```

### 2. **Configura el servidor**

- Asegúrate de tener instalado un servidor local como **XAMPP** o **WAMP**.
- Copia los archivos del proyecto en la carpeta `htdocs` de tu servidor local.

### 3. **Configura la base de datos**

1. Accede a **phpMyAdmin** en tu servidor local.
2. Crea una base de datos con el nombre `lector_qr_asistencia`.
3. Importa el archivo `database.sql` incluido en el proyecto para configurar las tablas necesarias.

### 4. **Configura las credenciales de la base de datos**

- Edita el archivo de configuración (por ejemplo, `config.php`) y actualiza las credenciales de conexión a la base de datos:

   ```php
   $host = 'localhost';
   $user = 'tu_usuario';
   $password = 'tu_contraseña';
   $dbname = 'lector_qr_asistencia';
   ```

### 5. **Abre el proyecto en tu navegador**

   ```bash
   http://localhost/Lector-QR-de-Asistencia
   ```

---

## 🛠️ **Requisitos**

- Servidor local (XAMPP, WAMP, o similar).
- **PHP** v7.4 o superior.
- Navegador moderno (Google Chrome, Firefox, etc.).

---

## 📂 **Estructura del Proyecto**

```
Lector-QR-de-Asistencia/
├── index.html             # Página principal
├── config.php             # Configuración de la base de datos
├── assets/                # Archivos estáticos (imágenes, estilos, etc.)
├── js/                    # Archivos JavaScript
├── css/                   # Archivos CSS
├── database.sql           # Archivo para la configuración de la base de datos
└── README.md              # Documentación
```


## 🤝 **Contribuciones**

¡Las contribuciones son bienvenidas! Si encuentras errores o tienes ideas para mejorar este proyecto, sigue estos pasos:

1. Realiza un fork del repositorio.
2. Crea una nueva rama:
   ```bash
   git checkout -b feature/nueva-funcionalidad
   ```
3. Realiza tus cambios y haz un commit:
   ```bash
   git commit -m "Agrega nueva funcionalidad"
   ```
4. Envía los cambios:
   ```bash
   git push origin feature/nueva-funcionalidad
   ```
5. Abre un [pull request](https://github.com/jeanpaul615/Lector-QR-de-Asistencia/pulls).
