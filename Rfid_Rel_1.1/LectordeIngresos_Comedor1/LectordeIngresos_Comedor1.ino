#include <SPI.h>
#include <MFRC522.h>
#include <WiFi.h>
#include <HTTPClient.h>
#include "../config.h"

#define SS_PIN 5
#define RST_PIN 22

MFRC522 rfid(SS_PIN, RST_PIN);


const String Area = "1";  // Comedor 1

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

    rfid.PICC_HaltA();
  }
}
