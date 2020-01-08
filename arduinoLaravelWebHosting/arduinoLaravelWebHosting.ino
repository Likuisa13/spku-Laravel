#include <SoftwareSerial.h>
#include <DHT.h>
#include "MQ7.h"
#define analogMQ135 A1
#define measurePin A5
#define DHTTYPE DHT22
#define DHTPIN 7
#define ledPower 8

SoftwareSerial ESP8266(2, 3); // Rx,  Tx
DHT dht(DHTPIN, DHTTYPE);

float humidity, temp_f, co, no, debu;
long writingTimer = 17;
long startTime = 0;
long waitTime = 0;
unsigned int samplingTime = 280;
unsigned int deltaTime = 40;
unsigned int sleepTime = 9680;
float voMeasured = 0;
float calcVoltage = 0;
String lokasi = "JGJSLM01";
unsigned char check_connection = 0;
unsigned char times_check = 0;
boolean error;

void setup() {
  pinMode(ledPower, OUTPUT);
  Serial.begin(9600);
  ESP8266.begin(115200);
  dht.begin();
  startTime = millis();
  ESP8266.println("AT+RST");
  delay(2000);
  Serial.println("Connecting to Wifi");
  while(check_connection==0)
  {
    Serial.print(".");
    ESP8266.print("AT+CWJAP=\"My Phone\",\"bismillah\"\r\n");
    
    ESP8266.setTimeout(5000);
    if(ESP8266.find("WIFI CONNECTED\r\n")==1)
    {
      Serial.println("WIFI CONNECTED");
      break;
    }
    check_connection=1;
    times_check++;
    if(times_check>3) 
    {
      times_check=0;
      Serial.println("Trying to Reconnect..");
    }
  }
}

void loop() {
  waitTime = millis() - startTime;
  if (waitTime > (writingTimer * 1000)) {
    readSensors();
    sendData();
    startTime = millis();
  }
}

void readSensors() {
  suhu();
  mq7();
  mq135();
  dust();
}

void suhu() {
  temp_f = dht.readTemperature();
  humidity = dht.readHumidity();
  Serial.println("Suhu : " + String(temp_f));
  Serial.println("Hum : " + String(humidity));
}

void mq7() {
  MQ7 mq7(A0,5.0);
  co = mq7.getPPM();
  Serial.println("Gas CO : " + String(co));
}

void mq135() {
  no = analogRead(analogMQ135);
  Serial.println("Gas NO2 : " + String(no));
}

void dust() {
  digitalWrite(ledPower, LOW);
  delay(samplingTime);
  voMeasured = analogRead(measurePin);
  delay(deltaTime);
  digitalWrite(ledPower, HIGH);
  delay(sleepTime);
  calcVoltage = voMeasured * (5.0 / 1024);
  debu = 0.17 * calcVoltage - 0.1;
  debu = debu * 1000;
  Serial.println("debu : " + String(debu));
}

void sendData() {
  startCmd();
  //String data = "loc=JGJSLM01&debu=121&suhu=26.8&hum=88&co=22&no=31";
  String data = "loc=" + lokasi + "&suhu=" + String(temp_f) + "&hum=" + String(humidity) + "&co=" + String(co) + "&no=" + String(no) + "&debu=" + String(debu);
  String postRequest = "POST /api/polusi HTTP/1.1\r\n";
  postRequest += "Host: spku.inoreka.id\r\n";
  //  postRequest += "Accept: */*\r\n";
  postRequest += "Cache-Control: no-cache \r\n";
  postRequest += "Content-Type: application/x-www-form-urlencoded\r\n";
  postRequest += "\r\n" + data;
  String sendCmd = "AT+CIPSEND=";//determine the number of caracters to be sent.
  ESP8266.print(sendCmd);
  ESP8266.println(postRequest.length() );
  delay(100);
  Serial.println("Sending..");
  Serial.println(postRequest);
  ESP8266.println(postRequest);
  String messageBody = "";
  while (ESP8266.available()) {
    String line = ESP8266.readStringUntil('\n');
    if (line.length() == 1) {
      messageBody = ESP8266.readStringUntil('\n');
    }
  }
  Serial.print("MessageBody received: ");
  Serial.println(messageBody);
}

void startCmd() {
  ESP8266.flush();
  String cmd = "AT+CIPSTART=\"TCP\",\"";
  cmd += "spku.inoreka.id"; //192.168.43.125
  cmd += "\",80";
  ESP8266.println(cmd);
  Serial.print("Start Commands: ");
  Serial.println(cmd);
  if (ESP8266.find("Error")) {
    Serial.println("AT+CIPSTART error");
    return;
  }
}
