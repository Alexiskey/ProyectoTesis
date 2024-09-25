#include <SPI.h>
#include <MFRC522.h>
#include <WiFi.h>
#include <HTTPClient.h>

#define SS_PIN 5
#define RST_PIN 22

MFRC522 rfid(SS_PIN, RST_PIN);

// Configuración de WiFi
const char* ssid = "Red Alexis";          // Cambia esto por tu SSID
const char* password = "Alexis123#";      // Cambia esto por tu contraseña WiFi
const char* serverUrl = "http://192.168.1.4/Rfid_registros/includes/leerIngreso.php"; // Cambia la URL según tu IP
const String Area = "2";  // Sala de Reuniones 1
void setup() {
  // Inicializar monitor serie
  Serial.begin(115200);
  delay(100);

  // Inicializar el lector RFID
  SPI.begin();           
  rfid.PCD_Init();      

  // Conexión WiFi
  WiFi.begin(ssid, password);
  int attempts = 0;
  while (WiFi.status() != WL_CONNECTED && attempts < 10) { // Esperar un máximo de 10 intentos
    delay(1000); // Esperar 1 segundo entre intentos
    Serial.println("Intento ");
    Serial.println(attempts + 1);
    attempts++;
  }

  // Verificar si se conectó exitosamente
  if (WiFi.status() == WL_CONNECTED) {
    Serial.println("Conectado a la red WiFi!");
    Serial.println(WiFi.localIP());  // Imprimir la dirección IP asignada
  } else {
    Serial.println("No se pudo conectar a la red WiFi.");
  }
}

void loop() {
  delay(100);

  // Verificar si hay una nueva tarjeta presente
  if (rfid.PICC_IsNewCardPresent() && rfid.PICC_ReadCardSerial()) {
    Serial.println("Tarjeta Leída");
    String uidStr = "";
    // Leer el UID de la tarjeta

    for (byte i = 0; i < rfid.uid.size; i++) {
      uidStr += String(rfid.uid.uidByte[i] < 0x10 ? "0" : "");
      uidStr += String(rfid.uid.uidByte[i], HEX);
    }
    uidStr.toUpperCase(); 
    Serial.print("UID leído: ");
    Serial.println(uidStr);
    Serial.println(Area);
    String datos_a_enviar = "uid=" + uidStr + "&Area=" + Area;  // Cambié el formato de envío de datos
    
    HTTPClient http;
    http.begin(serverUrl);
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");      

    int codigo_respuesta = http.POST(datos_a_enviar);
    String payload = http.getString();
    Serial.println("------------------------------------");
    Serial.println(serverUrl);
    Serial.println(datos_a_enviar);
    Serial.println(codigo_respuesta);
    Serial.print("uid= "); Serial.println(payload);

    /*
    // Enviar el UID al servidor PHP si el UID no está vacío
    if (WiFi.status() == WL_CONNECTED && !uidStr.isEmpty()) {
      HTTPClient http;
      String datos_a_enviar = "uid=" + uidStr;  // Cambié el formato de envío de datos

      http.begin(serverUrl);
      http.addHeader("Content-Type", "application/x-www-form-urlencoded");

      int codigo_respuesta = http.POST(datos_a_enviar);

      if (codigo_respuesta > 0) {
        Serial.println("Código HTTP: " + String(codigo_respuesta));
        if (codigo_respuesta == 200) {
          String cuerpo_respuesta = http.getString();
          Serial.println("El servidor respondió: ");
          Serial.println(cuerpo_respuesta);
        }
      } else {
        Serial.print("Error al enviar POST, Código: ");
        Serial.println(codigo_respuesta);
      }
      http.end();
    } else {
      Serial.println("No se pudo enviar el UID. Verifica la conexión WiFi.");
    }
    */
    // Detener la comunicación con la tarjeta
    rfid.PICC_HaltA();
  }
}
