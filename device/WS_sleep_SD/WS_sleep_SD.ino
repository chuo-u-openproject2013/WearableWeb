/*
 * Wearable Web Project
 *
 * Copyright (c) 0x5A4D
 * https://github.com/chuo-u-openproject2013/WearableWeb
---------------------------------------------------------
 * RTC-8564NBのライブラリは以下のskRTClibを利用させていただいています。
 * http://www.geocities.jp/zattouka/GarageHouse/micon/Arduino/RTC/RTC.htm
 *
*/
#include <stdio.h>
#include <avr/sleep.h>
#include <string.h>
#include <math.h>
#include <Wire.h>
#include <skRTClib.h>
#include <SD.h>

/* アナログセンサー */
const byte numSensPin = 4; // AnalogPin センサー数 (A0～)
double value[numSensPin] = {0}; // Analog入力値
double temp[numSensPin]  = {0}; // 温度  
int offset[numSensPin]   = {0, 0, 0, 0}; // 誤差調整

/* サーミスタ 係数 */
const int B = 3380; // B定数
const double T0 = 25 + 273.15; // 基準温度(K)
const long R0 = 10000;   // 基準抵抗
const long R_pu = 10000; // PullUp抵抗

//----------------------------------

void setup() {
  pinMode( 2, INPUT_PULLUP); // 割り込み
  
  Serial.begin(9600);
  
  // SDカード初期化
  Serial.print("Initializing SD card...");
  if (!SD.begin(4)) {
    Serial.println("Card failed, or not present");
  }
  else{
    Serial.println("card initialized.");
  }
  
  // RTC初期化
  InitRTC();
}

//----------------------------------

byte tm[7]; // BCDデータ
byte cnt = 0; // カウンタ変数

void loop() {
  // データ記録
  getData();
  cnt++;

  // RTC時刻取得
  RTC.rTime(tm);
  if( (tm[0] & 0x0F) % 5 == 0 ){ // 5秒ごと
    // 保存処理
    SaveToSD();
    
    // 初期化
    for(int i= 0; i < numSensPin; i++){
      value[i] = 0;
    }
    cnt = 0;
  }
  
  // Seria送信待ち
  delay(50);
  // Sleep
  set_sleep_mode(SLEEP_MODE_PWR_DOWN);
  sleep_mode();
}


//----------------------------------

/* センサーからデータ取得 */
void getData(){
  for(byte i = 0; i < numSensPin; i++){
    unsigned long temp = 0;
    for(byte j = 0; j < 100; j++){ 
      temp += analogRead(i+14);
    }
    value[i] += temp / 100;
  }
}

/* データをSDに保存 */
void SaveToSD(){
  // 平均化・温度計算
  for(int i = 0; i < numSensPin; i++){
    value[i] /= cnt;
    temp[i] = getTemp(value[i], offset[i]);
  }
  
  // 日時文字列化
  char bufRTC[24] ;
  RTC.cTime(tm, (byte *)bufRTC);
  
  // 日時・データをStringに連結
  String dataString = String(bufRTC) + ",";
  for(int i = 0; i < numSensPin; i++){
    char str[6];
    dtostrf(temp[i], 5, 1, str);
    dataString += String(str);
    if(i != numSensPin-1) dataString += ",";
  }
  
  Serial.println(dataString);
}

//----------------------------------

/* RTC初期化 */
int InitRTC(){
  int ans;
  char MonthStr[][4] = { "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" };
  char str[4] = {0};
  byte hh, mm, ss, month, day, weekday; int year;
  
  sscanf(__TIME__, "%d:%d:%d", &hh, &mm,  &ss);
  sscanf(__DATE__, "%s %d %d", str, &day, &year);
  for(int i = 1; i <= 12; i++){
    if(strcmp(str, MonthStr[i-1]) == 0){
      month = i; break;
    }
  }
  weekday = getWday(year, month, day);
  
  ans = RTC.begin(2, year-2000, month, day, weekday, hh, mm, ss);
  //RTC.sTime(year-2000, month, day, weekday, hh, mm, ss) ;
  
  return ans;
}

/* 曜日計算・取得 */
byte getWday(int y, int m, int d){
  if(m < 3){y--; m += 12;}
  return (y + y / 4 - y / 100 + y / 400 + (13 * m + 8) / 5 + d) % 7; 
} 

/* 温度計算
   Val: analog入力値(0-1023)
   offset: Pullup抵抗 誤差調整 */
double getTemp(int Val, int offset){
  double R_th;  // サーミスタ抵抗
  double T;     // 温度(K)
  
  R_th = (R_pu + offset) * Val / (1023.0 - Val);
  T    = 1 / ( log(R_th/R0)/B + 1/T0 );
  return T - 273.15;
}
