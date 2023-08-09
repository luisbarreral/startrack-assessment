# startrack-assessment

Guía de Instalación

- Instalación Rápida:
    1. Instalar XAMPP para el sistema operativo que se esté trabajando.
    2. Asegurarse que esté activada la librería de sqlite en php.ini ubicado en xampp/php/
        2.1 Descomentar la línea ;extension=sqlite3
    3. Copiar carpeta de proyecto en directorio xampp/htdocs/
    4. Abrir consola de XAMPP
        4.1 Iniciar servicio de Apache.

- Instalación en un servidor Ubuntu:
    1. Instala el servidor web Apache.
        1.1 sudo apt install apache2
    2. Instala el paquete PHP 8.
        2.1 sudo apt install php8
    3. Instala la extensión SQLite3 para PHP.
        3.1 sudo apt install php8-sqlite3
    4. Edita el archivo php.ini. 
        4.1 sudo nano /etc/php/8/apache2/php.ini
        4.2 Encuentra la línea que dice extension=sqlite3 y asegúrate de que esté descomentada.
        4.3 Guarda el archivo php.ini y sal del editor.
    5. Reiniciar Apache
        5.1 sudo systemctl restart apache2
    6. Verifica que Apache y PHP estén instalados y en ejecución.
        6.1 sudo systemctl status apache2
        6.2 sudo php -v
    7. Copiar carpeta de proyecto en directorio /var/www/html

Luis Eduardo Barrera López.
