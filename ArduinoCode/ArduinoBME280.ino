#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClient.h>
#include <ArduinoJson.h>

#include <Wire.h>

// Easy Scheduler
#include <EasyScheduler.h>

// For Blynk
#include <BlynkSimpleEsp8266.h>

// For BME280
#include <Adafruit_Sensor.h>
#include <Adafruit_BME280.h>
#include <SPI.h>

WidgetLCD lcd(V6);

// Replace with your network credentials
const char *auth = "YOUR_BLYNK_TOKEN";
const char *ssid = "YOUR_WIFI_SSID";
const char *password = "YOUR_WIFI_PASSWORD";

#define ipWebServer "127.0.0.1"

// REPLACE with your Domain name and URL path or IP address with path
String serverNameStr;
String serverStatusStr;
String serverSyncStr;
String serverUpdateStr;

// Keep this API Key value to be compatible with the PHP code provided in the project page.
String apiKeyValue = "YOUR_API_KEY";

String sensorName = "BME280";
String sensorLocation = "Home";

int httpResponseCode;
boolean findIP = true;

// #define BME_SCK 13
// #define BME_MISO 12
// #define BME_MOSI 11
// #define BME_CS 10

#define SEALEVELPRESSURE_HPA (1013.25)

Adafruit_BME280 bme;  // I2C
// Adafruit_BME280 bme(BME_CS);  // hardware SPI
// Adafruit_BME280 bme(BME_CS, BME_MOSI, BME_MISO, BME_SCK);  // software SPI

// Create Task
Schedular SendData;
Schedular SendDataToBlynk;
Schedular CheckStatus;
Schedular SyncSettings;

// Global Variable
int dataRate;
int newDataRate;

void setup() {
  Serial.begin(115200);

  // Start Task
  SendData.start();
  SendDataToBlynk.start();
  CheckStatus.start();
  SyncSettings.start();

  WiFi.begin(ssid, password);
  Serial.println("Connecting");
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("");
  Serial.print("Connected to WiFi network with IP Address: ");
  Serial.println(WiFi.localIP());

  // Blynk Connect
  Blynk.begin(auth, ssid, password, "elec.cmtc.ac.th", 8080);

  // (you can also pass in a Wire library object like &Wire2)
  // bool status = bme.begin(0x76);
  unsigned status;
  status = bme.begin(0x76);
  if (!status) {
    Serial.println("Could not find a valid BME280 sensor, check wiring, address, sensor ID!");
    Serial.print("SensorID was: 0x");
    Serial.println(bme.sensorID(), 16);
    Serial.print(" ID of 0xFF probably means a bad address, a BMP 180 or BMP 085\n");
    Serial.print(" ID of 0x56-0x58 represents a BMP 280,\n");
    Serial.print(" ID of 0x60 represents a BME 280.\n");
    Serial.print(" ID of 0x61 represents a BME 680.\n");
    while (1)
      ;
  }

// Set the web server ip
  serverNameStr = "http://" ipWebServer "/_api/updateData.php";
  serverStatusStr = "http://" ipWebServer "/_api/getStatus.php";
  serverSyncStr = "http://" ipWebServer "/_api/getSettings.php";
  serverUpdateStr = "http://" ipWebServer "/_api/updateSettings.php";

  // Default Data Rate
  dataRate = 10;
  Blynk.syncAll();
}

void loop() {

  // Blynk
  Blynk.run();

  // FindIP

  // Send an HTTP POST request
  SendData.check(sendData, dataRate * 1000);

  // Send an Data to Blynk App every 1 second
  SendDataToBlynk.check(sendDataToBlynk, 1000);

  // Check Status
  CheckStatus.check(checkStatus, 5000);

  // Sync Settings
  SyncSettings.check(syncSettings, 10000);
}

BLYNK_CONNECTED() {
  Blynk.syncAll();
}

BLYNK_WRITE(V8) {
  int btnState = param.asInt();
  if (WiFi.status() == WL_CONNECTED) {
    WiFiClient client;
    HTTPClient http;
    // Your Domain name with URL path or IP address with path

    http.begin(client, serverUpdateStr);
    if (btnState == 1) {

      // Specify content-type header
      http.addHeader("Content-Type", "application/x-www-form-urlencoded");
      String httpRequestData =
        "api_key=" + apiKeyValue + "&dataRate=" + String(newDataRate) + "";

      // Send HTTP POST request
      httpResponseCode = http.POST(httpRequestData);
    }
  }
}

BLYNK_WRITE(V7) {
  newDataRate = param.asInt();
}

void sendData()
{
    // Check WiFi connection status
    if (WiFi.status() == WL_CONNECTED)
    {
        WiFiClient client;
        HTTPClient http;

        // Your Domain name with URL path or IP address with path
        http.begin(client, serverNameStr);

        // Specify content-type header
        http.addHeader("Content-Type", "application/x-www-form-urlencoded");

        // Prepare your HTTP POST request data
        // Test Code
        String httpRequestData =
            "api_key=" + apiKeyValue + "&sensor=" + sensorName + "&location=" + sensorLocation + "&temp=" + String(bme.readTemperature()) + "&humidity=" + String(bme.readHumidity()) + "&pressure=" + String(bme.readPressure() / 100.0F) + "&altitude=" + String(bme.readAltitude(SEALEVELPRESSURE_HPA)) + "";

        Serial.print("httpRequestData: ");
        Serial.println(httpRequestData);

        // Check if BME280 can't read data => Don't send data to server and Blynk then try to reset ESP8266
        if (isnan(bme.readTemperature()) || isnan(bme.readHumidity()) || isnan(bme.readPressure()))
        {
            Serial.println("Failed to read from BME280 sensor!");
            ESP.restart();
        }
        else
        {
            // Send HTTP POST request
            httpResponseCode = http.POST(httpRequestData);
        }

        if (httpResponseCode > 0)
        {
            Serial.print("Server still online response code: ");
            Serial.println(httpResponseCode);
        }
        else
        {
            Serial.print("Can't connect to server response code: ");
            Serial.println(httpResponseCode);
        }

        // Free resources
        http.end();
    }
    else
    {
        Serial.println("WiFi Disconnected");
    }
}

void sendDataToBlynk() {
  // Send to Blynk
  Blynk.virtualWrite(V10, bme.readTemperature());
  Blynk.virtualWrite(V11, bme.readHumidity());
  Blynk.virtualWrite(V12, bme.readPressure() / 100.0F);
  Blynk.virtualWrite(V13, bme.readAltitude(SEALEVELPRESSURE_HPA));

  Blynk.virtualWrite(V3, sensorName);
  Blynk.virtualWrite(V4, sensorLocation);
}

// Check Status Hosting Server
void checkStatus() {
  // Check WiFi connection status
  if (WiFi.status() == WL_CONNECTED) {
    WiFiClient client;
    HTTPClient http;

    // Your Domain name with URL path or IP address with path
    http.begin(client, serverStatusStr);

    // send HTTP GET request
    int httpStatusCode = http.GET();

    if (httpStatusCode == 200) {
    //   digitalWrite(D3, HIGH);
      Blynk.virtualWrite(V5, "Online");
      lcd.clear();
      lcd.print(0, 0, "Server Online");
    } else {
    //   digitalWrite(D3, LOW);
      Blynk.virtualWrite(V5, "Offline");
      lcd.clear();
      lcd.print(0, 0, "Server Offline");
    }

    // print the HTTP response code
    Serial.println("Check Status Response code: " + String(httpStatusCode));

    // Free resources
    http.end();
  } else {
    Serial.println("WiFi Disconnected");
  }
}

void syncSettings() {
  const size_t capacity = JSON_OBJECT_SIZE(12) + 250;
  DynamicJsonDocument doc(capacity);

  // Check WiFi connection status

  if (WiFi.status() == WL_CONNECTED) {

    WiFiClient client;
    HTTPClient http;

    String json = httpGETRequest(serverSyncStr);

    // คำสั่ง deserialize ถอดประโยคของ JSON ออกมาเป็นตัวแปรต่าง ๆ
    deserializeJson(doc, json);

    // แยกค่าออกมา ชื่อตัวแปร = key และ ข้อมูลของตัวแปรนั้น = value
    dataRate = doc["data_rate"];
    Blynk.syncVirtual(V7, dataRate);

    // แสดงค่าที่ได้
    Serial.println("dataRate: " + String(dataRate));

    // Serial.println(json);
  } else {
    Serial.println("WiFi Disconnected");
  }
}

String httpGETRequest(String webServerName) {
  // สร้าง Object HTTP Client ตั้งชื่อว่า http
  WiFiClient client;
  HTTPClient http;

  // เชื่อมต่อไปที่ URL ของเรา
  http.begin(client, webServerName);

  // ส่งคำขอ HTTP code
  int httpResponseCode = http.GET();

  String payload = "{}";
  // ถ้ารับข้อมูลสำเร็จให้ payload = ข้อมูลที่ได้รับมา ถ้าไม่สำเร็จให้แสดง Error code
  if (httpResponseCode > 0) {
    payload = http.getString();
  } else {
    Serial.print("Check Status HTTP Response code: ");
    Serial.println(httpResponseCode);
  }

  // จบการทำงานและ return ค่า payload กลับไปทำงานต่อ
  http.end();
  return payload;
}
