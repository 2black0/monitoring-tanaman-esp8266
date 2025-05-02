# 🌱 Plant Monitoring System with Arduino, ESP8266, and Web Dashboard

This project demonstrates a complete **IoT-based environmental monitoring system** for plants. It integrates **soil moisture, air temperature, and humidity sensing**, along with **automatic control of water pumps and fans**, and displays real-time data via a **web-based dashboard** built using PHP and Bootstrap.

Developed with love by **[2black0@gmail.com](mailto:2black0@gmail.com)** 💚

---

## 📁 Project Structure

```
.
Plant-Monitoring-System/
├── LICENSE
├── README.md
├── hardware/
│   ├── schematics_bb.png         # Gambar breadboard Fritzing
│   └── schematics.fzz            # File proyek Fritzing
└── software/
    ├── arduino/
    │   ├── main.ino              # Kode utama untuk ESP8266
    │   └── libraries/            # Folder pustaka Arduino yang dibutuhkan
    │       ├── Adafruit_Sensor-1.1.2/
    │       ├── DHT_sensor_library/
    │       ├── LiquidCrystal_I2C-master/
    │       └── SimpleTimer-master/
    └── website/
        ├── humtemp/
        │   ├── about.php
        │   ├── css/              # Berisi file CSS Bootstrap
        │   ├── dbconnect.php
        │   ├── img/              # Gambar tampilan/about
        │   ├── index.php         # Dashboard monitoring
        │   ├── js/               # JavaScript (Bootstrap, Chart.js, jQuery)
        │   ├── README.md         # Penjelasan lokal untuk web
        │   ├── save.php          # Penerima data HTTP dari ESP
        │   └── table.php         # Handler data tabel
        └── sql-command.txt       # Skrip SQL untuk membuat database & tabel

```

---

## 🧠 Features

### ✅ Sensor Integration

* **DHT11** sensor for air temperature and humidity.
* **Soil moisture sensor** for evaluating soil dryness.

### ✅ Actuator Control

* **Water pump**: activated based on soil dryness or high air temperature.
* **Cooling fan**: activated when temperature is too high or air is too humid.

### ✅ Web Monitoring Dashboard

* Real-time status view (temperature, humidity, soil moisture).
* Historical data table with intelligent status labels.
* Visual interface using **PHP + MySQL + Bootstrap**.

### ✅ IoT Functionality

* **ESP8266 (WeMos D1 Mini)** as the controller.
* Sends data to a local web server via HTTP every 60 seconds.
* Built-in auto reconnect for WiFi if disconnected.

---

## 🔌 Hardware Requirements

| Component               | Quantity | Description                         |
| ----------------------- | -------- | ----------------------------------- |
| ESP8266 (e.g., D1 Mini) | 1        | Main microcontroller                |
| DHT11                   | 1        | Temp & humidity sensor              |
| Soil Moisture Sensor    | 1        | Analog sensor                       |
| 5V Relay Module         | 2        | Control water pump and fan          |
| LCD I2C (16x2)          | 1        | Display readings locally            |
| Water Pump + Fan        | 1 each   | Actuators for environmental control |

> 🧪 See `hardware/schematics_bb.png` for wiring reference.

---

## 🚀 Arduino Setup

1. Open `main.ino` using **Arduino IDE**.
2. Ensure the following libraries are installed:

   * `DHT sensor library`
   * `Adafruit Unified Sensor`
   * `LiquidCrystal_I2C`
   * `SimpleTimer`
3. Select the board: **NodeMCU 1.0 (ESP8266)**.
4. Modify these in the sketch:

   ```cpp
   const char* ssid = "YourWiFi";
   const char* password = "YourPassword";
   String url = "http://your_server_ip/humtemp/save.php?";
   ```
5. Upload to your ESP8266.

---

## 🌐 Web Dashboard Setup

1. Copy the contents of `software/website/humtemp/` to your **Apache web server** (e.g., XAMPP, WAMP).

2. Import `sql-command.txt` into **phpMyAdmin** to create the required database and table:

   ```sql
   CREATE DATABASE humtemp;
   USE humtemp;

   CREATE TABLE logsensor (
     id_data INT AUTO_INCREMENT PRIMARY KEY,
     waktu TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
     suhu_udara FLOAT,
     kelembaban_udara INT,
     kelembaban_tanah INT,
     status_pompa INT,
     status_kipas INT
   );
   ```

3. Edit `dbconnect.php` to set correct DB credentials:

   ```php
   $dbc = mysqli_connect("localhost", "root", "", "humtemp");
   ```

4. Run the server and access:

   ```
   http://localhost/humtemp/index.php
   ```

---

## 📊 Logic Summary

| Condition                             | Action                 |
| ------------------------------------- | ---------------------- |
| SoilHumidity ≤ 35%                    | Turn pump **ON**       |
| SoilHumidity > 35%                    | Turn pump **OFF**      |
| Temperature ≥ 34°C                    | Turn **pump & fan ON** |
| Temperature < 34°C AND Humidity < 80% | Turn fan **OFF**       |
| Humidity ≥ 80%                        | Turn fan **ON**        |

> Statuses are updated and sent to server every 60 seconds.

---

## 📄 License

This project is licensed under the [MIT License](LICENSE)

---

## 👨‍💻 Author

**Ardy Seto Priambodo**
✉️ [2black0@gmail.com](mailto:2black0@gmail.com)
