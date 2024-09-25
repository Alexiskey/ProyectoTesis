#include <Arduino.h>
#include <SPI.h>
#include <MFRC522.h>

// Definición de pines
#define SS_PIN 5
#define RST_PIN 22

MFRC522 rfid(SS_PIN, RST_PIN);  


void setup() {
  String UID = "";
  Serial.begin(115200);   // Iniciar comunicación serial
  SPI.begin();            // Iniciar SPI bus
  rfid.PCD_Init();     // Iniciar el lector RC522
  Serial.println("Acerque su tarjeta RFID al lector...");
  Serial.println();
}

void loop() {
  if (rfid.PICC_IsNewCardPresent() && rfid.PICC_ReadCardSerial()) {
    UID =  "";
    Serial.print("");
    for (byte i = 0; i < rfid.uid.size; i++) {
      UID += String(rfid.uid.uidByte[i] < 0x10 ? "0" : "");
      UID += String(rfid.uid.uidByte[i], HEX);
    }
    Serial.println(UID);
    
    delay(1000);
  }
}
