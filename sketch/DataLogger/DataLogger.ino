/*
 * Copyright (c) 0x5A4D
 * https://github.com/chuo-u-openproject2013/WearableWeb
---------------------------------------------------------
 * 以下のskRTClibを利用しています
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

/* アナログセンサー設定 */
const byte numSensPin = 1; // AnalogPin センサー数
const byte SensPin[numSensPin] = {A0};  // AnalogPin リスト
float (*calcVal[])(float) = {calcTemp}; // 値計算関数 リスト
float value[numSensPin] = {0};

/* SDカード 保存設定*/
char dat_dir[] = "dat"; // 保存先ディレクトリ

//----------------------------------
/* LM35DZ */
float calcTemp(float Val){
  return (Val * 5.0 / 1024) * 100;
}

//----------------------------------

void setup() {
  pinMode(2, INPUT_PULLUP); // 割り込み
  set_sleep_mode(SLEEP_MODE_PWR_DOWN); // Sleep Mode
  Serial.begin(9600);
  
  // SDカード初期化
  Serial.print("Initializing SD card...");
  if (!SD.begin(4)) {
    Serial.println("Card failed, or not present");
  }
  else{
    Serial.println("card initialized.");
    // 保存ディレクトリ作成
    if (!SD.exists(dat_dir)) SD.mkdir(dat_dir);
  }
  
  // RTC初期化
  InitRTC();
}

//----------------------------------

byte tm[7]; // BCDデータ
byte cnt = 0; // カウンタ

void loop() {
  // データ取得
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
  
  // Sleep
  sleep_mode();
}


//----------------------------------

/* センサーからデータ取得 */
void getData(){
  for(byte i = 0; i < numSensPin; i++){
    unsigned long tmp = 0;
    for(byte j = 0; j < 50; j++){ 
      tmp += analogRead(SensPin[i]);
    }
    value[i] += tmp / 50;
  }
}

/* データをSDに保存 */
void SaveToSD(){
  // 平均化・値計算
  for(int i = 0; i < numSensPin; i++){
    value[i] /= cnt;
    if(calcVal[i] != NULL){
      value[i] = calcVal[i](value[i]);
    }
  }
  
  // 日時文字列化
  char bufRTC[24];
  char date[9]; // yyyymmdd
  char time[9]; // hh:mm:ss
  RTC.cTime(tm, (byte *)bufRTC);
  sscanf(bufRTC, "%4s/%2s/%2s %*s %8s", &date[0], &date[4], &date[6], time);
  
  // 日時・データをStringに連結
  String dataString = String(time) + ",";
  for(int i = 0; i < numSensPin; i++){
    char str[6];
    dtostrf(value[i], 5, 1, str); // 実数を文字列に変換 (-)xx.x
    dataString += String(str);
    if(i != numSensPin-1) dataString += ",";
  }
  
  // ファイルネーム作成
  char filename[13 + strlen(dat_dir)]; // 8.3形式
  sprintf(filename, "%s/%s.%s\0", dat_dir, date, "log");
  
  // SDカードに書き込み
  File dataFile = SD.open(filename, FILE_WRITE);
  if (dataFile) {
    dataFile.println(dataString);
    dataFile.close();
  }  
  else {
    Serial.println("error opening file");
  } 
  
  Serial.println(dataString);
  delay(80); // Seria送信待ち
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
