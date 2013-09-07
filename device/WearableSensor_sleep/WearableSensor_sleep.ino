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
#include <Wire.h>
#include <skRTClib.h>
#include <avr/sleep.h>
#include <string.h>
#include <math.h>

void setup() {
  pinMode(13, OUTPUT); // LED
  pinMode( 2, INPUT_PULLUP); // 割り込み
  Serial.begin(9600);
  InitTime();
}

double temp[2] = {0}; // 温度
byte cnt = 0;

void loop() {
  digitalWrite(13, HIGH);
  
  // 温度記録
  byte tm[7];     // BCDデータ
  char buf[24] ;  // 日付時刻の文字列
  
  temp[0] += getTemp(A0, 0);
  temp[1] += getTemp(A1, 0);
  cnt++;
  
  RTC.rTime(tm);
  if( (tm[0] & 0x0F) % 5 == 0 ){ // 5秒ごと
    temp[0] /= cnt;
    temp[1] /= cnt;
  
    RTC.cTime(tm, (byte *)buf);
    Serial.print(buf);
    Serial.print(", ");
    Serial.print(temp[0], 1);
    Serial.print(", ");
    Serial.print(temp[1], 1);
    Serial.print("\n");
    
    for(int i= 0; i < 2; i++){
      temp[i] = 0;
    }
    cnt = 0;
  }
  
  // Seria送信待ち
  delay(50);
  digitalWrite(13, LOW);
  // Sleep
  set_sleep_mode(SLEEP_MODE_PWR_DOWN);
  sleep_mode();
}

/* RTC初期化 */
void InitTime(){
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
  
  RTC.begin(2, year-2000, month, day, weekday, hh, mm, ss);
  //RTC.sTime(year-2000, month, day, weekday, hh, mm, ss) ;
  
  return;
}

/* 曜日計算・取得 */
byte getWday(int y, int m, int d){
  if(m < 3){y--; m += 12;}
  return (y + y / 4 - y / 100 + y / 400 + (13 * m + 8) / 5 + d) % 7; 
}


/* サーミスタ 係数 */
const int B = 3380; // B定数
const double T0 = 25 + 273.15; // 基準温度(K)
const long R0 = 10000;   // 基準抵抗
const long R_pu = 10000; // PullUp抵抗 

/* 温度計算・取得 */
double getTemp(byte pin, int offset){
  unsigned long Val = 0;   //Analog入力値
  double R_th;  //サーミスタ抵抗
  double T;     //温度
  
  for(int i = 0; i < 100; i++){
    Val  += analogRead(pin);
  }
  
  Val /= 100;
  R_th = (R_pu + offset) * Val / (1023.0 - Val);
  T    = 1 / ( log(R_th/R0)/B + 1/T0 );
  return roundn(T - 273.15, -2);
}

/* 10^nでround */
double roundn(double x, int n){  
    x = x * pow(10, -(n + 1) );
    x = (double)(int)(x + 0.5);
    return x * pow(10, n + 1);
}
