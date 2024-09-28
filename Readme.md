# Proeyecto Registro y Tracking con RFID

## Introduccion

El proyecto "Registro y Tracking con RFID" tiene como objetivo implementar un sistema de control y registro utilizando tecnología RFID. Este sistema está diseñado para gestionar el registro de usuarios.


## Pre-Requisitos 

- **Instalación de Arduino:** Asegúrate de tener instalada la última versión del IDE de Arduino para poder programar tu placa.
- **Instalación de XAMPP:** Instala XAMPP para configurar un servidor local que te permitirá ejecutar scripts PHP y gestionar bases de datos.
- **Instalación de MySQL:** Asegúrate de que MySQL esté incluido en tu instalación de XAMPP, ya que lo necesitarás para gestionar los datos de registro y seguimiento.


### 1. Codigo Arduino
-   *Instalacion de Placas:* ara poder ejecutar los códigos de Arduino, se debe primero instalar las placas necesarias para el tipo específico que esté usando.
    - **ESP32 - Placa NodeMCU-32S:** Se debe agregar la adjuntar la librería la pestaña Preferencias...
        
        1. Ve a "Archivo > Preferencias..."
        2. Agrega la siguiente URL en la seccion `URLs adicionales de gestor de placas`:

        <https://espressif.github.io/arduino-esp32/package_esp32_index.json>

    - **Librerias:** Es necesario instalar la librería RFID para poder interactuar con el módulo RFID. Puedes hacerlo a través de `Gestor de Bibliotecas de Arduino`:

        1. Ve a "Herramientas > Gestor de Bibliotecas... ".
        2. Busca como `MFRC522` e instala la librería `RFID`.

## Caracteristicas

 Los archivos PHP se encargan de la gestión del sistema desde el lado del servidor, permitiendo la administración y visualización de usuarios, áreas y la visualización de datos, mientras que los codigos arduino se encargan de la interacción con el hardware RFID, leyendo datos y enviándolos al servidor para su procesamiento.

## Uso

1. Al encender el sistema Apacche como base de datos Mysql, espera a que se inicialice.
2. Al encender el sistema Arduino.
3. Ingresar a la interfaz en <http://localhost/phpmyadmin/index.php>
4. Navegar por la interfaz a donde desee ir.
5. En las secciones que se requiera lectura de targeta se indicara en un boton selecionable, la opciond escaneo de targetas.
6. Acerca una tarjeta RFID al lector.
7. El sistema registrará automáticamente la tarjeta y mostrará información relevante en el seria Monitor de arduino, y ejecutara la accion correspondiente en la interfaz.
8. Puedes consultar los registros en tiempo real dentro de la base de datos en <http://localhost/phpmyadmin/>.


