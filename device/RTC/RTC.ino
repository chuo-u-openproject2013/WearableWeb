/*
 * RTC-8564NB
 *
 * http://www.geocities.jp/zattouka/GarageHouse/micon/Arduino/RTC/RTC.htm
 * 上記ページよりskRTClibを利用させていただいています。
 *
 * https://github.com/chuo-u-openproject2013/WearableWeb
*/

#include <Wire.h>
#include <skRTClib.h>
#include <string.h>
#include <stdio.h>

void setup()
{
  Serial.begin(9600) ;
  
  char MonthStr[][4] = { "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" };
 
  char str[4] = {0};
  byte hh, mm, ss, month, day, weekday; int year;
  sscanf(__TIME__, "%d:%d:%d", &hh, &mm, &ss);
  sscanf(__DATE__, "%s %d %d", str, &day, &year);
  for(int i = 1; i <= 12; i++){
    if(strcmp(str, MonthStr[i-1]) == 0){
      month = i; break;
    }
  }
  weekday = getWday(year, month, day);
  
  RTC.begin(2, year-2000, month, day, weekday, hh, mm, ss);
  //RTC.sTime(year-2000, month, day, weekday, hh, mm, ss) ;
}

void loop()
{
  byte tm[7] ; 
  char buf[24] ;
  
  if(RTC.InterFlag == 1) {               // 割込みが発生したか？
    RTC.rTime(tm) ;                    // RTCから現在の日付と時刻を読込む
    RTC.cTime(tm,(byte *)buf) ;        // 日付と時刻を文字列に変換する
    Serial.println(buf) ;              // シリアルモニターに表示
    RTC.InterFlag = 0 ;                // 割込みフラグをクリアする
  }
}

byte getWday(int y, int m, int d){
  if(m < 3){y--; m += 12;}
  return (y + y / 4 - y / 100 + y / 400 + (13 * m + 8) / 5 + d) % 7; 
}
