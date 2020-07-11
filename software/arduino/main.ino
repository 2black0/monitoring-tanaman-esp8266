// library yang dipakai
#include <Arduino.h>
#include <EMailSender.h>
#include <ESP8266WiFi.h>
#include <Wire.h>
#include <LiquidCrystal_I2C.h>
#include <ESP8266HTTPClient.h>
#include <SimpleTimer.h>
#include <DHT.h>

#define DHTTYPE DHT11

// waktu pengiriman ke server 60000ms = 60s = 1m
#define timersend 120000

// ganti sesuai yang dipakai
const char *ssid = "Wifi-Roboto";                    // ganti wifi
const char *password = "arDY1234";                   // ganti password
String url = "http://192.168.1.4/humtemp/save.php?"; // ganti ip komputer
//http://192.168.1.4/humtemp/save.php?temp=56&huma=99&hums=20&pump=1&fan=1

// variable yang dipakai
bool debugSerial = 1;
bool debugLCD = 1;

const int soilhumPin = A0;
const int DHTPin = D4;
const int pumpPin = D5;
const int fanPin = D6;

float SoilHumidity;
float Temperature;
float Humidity;
int statusPump = 0;
int statusFan = 0;
int statusSend = 0;

uint8_t connection_state = 0;
uint16_t reconnect_interval = 10000;

// definisi instanse
LiquidCrystal_I2C lcd(0x27, 16, 2);
SimpleTimer timer;
DHT dht(DHTPin, DHTTYPE);

// fungsi connect dgn wifi
uint8_t WiFiConnect(const char *nSSID = nullptr, const char *nPassword = nullptr)
{
  static uint16_t attempt = 0;
  serial_show("Connecting to ", 0);
  lcd_show(1, "Connecting to", 0, 0, String(nSSID), 0, 1, 1000);
  if (nSSID)
  {
    WiFi.begin(nSSID, nPassword);
    serial_show(nSSID, 0);
  }

  uint8_t i = 0;
  while (WiFi.status() != WL_CONNECTED && i++ < 50)
  {
    delay(200);
    serial_show(".", 0);
  }
  ++attempt;
  if (i == 51)
  {
    serial_show("\nConnection: TIMEOUT on attempt: ", 0);
    lcd_show(1, "Connecting:", 0, 0, "Timeout", 0, 1, 1000);
    serial_show(String(attempt), 1);
    if (attempt % 2 == 0)
      serial_show("Check if access point available or SSID and Password", 1);
    return false;
  }

  serial_show("\nConnected", 1);
  serial_show("IP Address: ", 0);
  String ip_address = WiFi.localIP().toString();
  serial_show(ip_address, 1);
  lcd_show(1, "Connected", 0, 0, ip_address, 0, 1, 1000);
  return true;
}

// fungsi menunggu koneksi wifi
void Awaits()
{
  uint32_t ts = millis();
  while (!connection_state)
  {
    delay(50);
    if (millis() > (ts + reconnect_interval) && !connection_state)
    {
      connection_state = WiFiConnect();
      ts = millis();
    }
  }
}

// fungsi setup
void setup()
{
  Serial.begin(115200);
  lcd.init();
  delay(250);
  pinMode(DHTPin, INPUT);
  pinMode(pumpPin, OUTPUT);
  pinMode(fanPin, OUTPUT);
  digitalWrite(pumpPin, HIGH);
  digitalWrite(fanPin, HIGH);

  dht.begin();
  serial_show("Turbidity WeMoS D1 Mini", 1);
  lcd_show(1, "Turbidity", 0, 0, "WeMoS D1 Mini", 0, 1, 1000);

  connection_state = WiFiConnect(ssid, password);
  if (!connection_state)
    Awaits();

  timer.setInterval(timersend, send_http);
}

// fungsi utama
void loop()
{
  /*
  digitalWrite(pumpPin, LOW);
  digitalWrite(fanPin, LOW);
  digitalWrite(pumpPin, HIGH);
  digitalWrite(fanPin, HIGH);

  1. Pompa
  On -> saat tanah kering (0-35)
  Off-> saat tanah lembab (40-70), tanah basah (75-100)
  On -> suhu udara panas (34-36) walaupun tanah sudah lembab, dan kipas on 
  2. Kipas
  On -> suhu udara panas (34-36), >36 sangan panas
  Off -> udara normal (24-33), (18-23) sejuk, (<18) dingin
  On -> kelembaban udara udara mulai lembab (40-75)
  */

  timer.run();
  read_dht11();
  read_soilhum();

  // kondisi pompa
  if (SoilHumidity > 35) // pompa off
  {
    digitalWrite(pumpPin, HIGH);
    statusPump = 0;
  }
  if (SoilHumidity <= 35 || Temperature >= 34) // pompa on
  {
    digitalWrite(pumpPin, LOW);
    statusPump = 1;
  }

  // kondisi fan
  if (Temperature < 34 || Humidity < 40) // fan off
  {
    digitalWrite(fanPin, HIGH);
    statusFan = 0;
  }
  if (Temperature >= 34 || Humidity >= 40) // fan on
  {
    digitalWrite(fanPin, LOW);
    statusFan = 1;
  }

  /*if (statusSend == 1)
  {
    send_http();
    statusSend = 0;
  }*/

  serial_show("T:" + String(Temperature) + "*C", 1);
  serial_show("H:" + String(Humidity) + "%", 1);
  serial_show("HS:" + String(SoilHumidity) + "%", 1);
  serial_show("P:" + String(statusPump), 1);
  serial_show("F:" + String(statusFan), 1);
  lcd_show(1, "T:" + String(Temperature) + " H:" + String(Humidity), 0, 0, "HS:" + String(SoilHumidity) + " " + String(statusPump) + " " + String(statusFan), 0, 1, 1);

  delay(10000);
}

// fungsi untuk menampilkan ke lcd
void lcd_show(int clear, String text1, int x1, int y1, String text2, int x2, int y2, int waitms)
{
  if (debugLCD == 1)
  {
    if (clear == 1)
    {
      lcd.clear();
    }
    lcd.backlight();
    lcd.setCursor(x1, y1);
    lcd.print(text1);
    lcd.setCursor(x2, y2);
    lcd.print(text2);
    delay(waitms);
  }
}

// fungsi untuk mengirim data serial
void serial_show(String text, int newline)
{
  if (debugSerial == 1)
  {
    if (newline == 1)
    {
      Serial.println(text);
    }
    else
    {
      Serial.print(text);
    }
  }
}

// fungsi untuk baca sensor dht11 (suhu dan kelembaban udara)
void read_dht11()
{
  Temperature = dht.readTemperature();
  Humidity = dht.readHumidity();
}

// fungsi untuk baca sensor kelembaban tanah
void read_soilhum()
{
  float totalValue = 0;
  float value;
  SoilHumidity = 0;

  for (int i = 0; i < 500; i++)
  {
    value = analogRead(soilhumPin);
    totalValue += value;
    value = 0;
  }

  SoilHumidity = totalValue / 500;
}

// fungsi untuk kirim ke database
void send_http()
{
  //http://192.168.1.4/humtemp/save.php?temp=56&huma=99&hums=20&pump=1&fan=1
  String temp, huma, hums, pump, fan;

  temp = "temp=" + String(Temperature);
  huma = "&huma=" + String(Humidity);
  hums = "&hums=" + String(SoilHumidity);
  pump = "&pump=" + String(statusPump);
  fan = "&fan=" + String(statusFan);
  url = url + temp + huma + hums + pump + fan;

  if (WiFi.status() == WL_CONNECTED)
  {
    serial_show("Send to Server", 1);
    lcd_show(1, "Send to Server", 0, 0, "", 0, 1, 1000);
    HTTPClient http;

    http.begin(url);
    int httpCode = http.GET();

    if (httpCode > 0)
    {
      String payload = http.getString();
      serial_show(payload, 1);
      lcd_show(1, payload, 0, 0, "", 0, 1, 1000);
    }

    http.end();
  }
}