/*
 * NTCTサーミスタの温度特性式による温度測定
 *
 * (参考)http://www.mmea.com/pdf/Division_PDF/80.pdf
 *       http://www.ohizumi-mfg.jp/products/tech01.html
 *
 * https://github.com/chuo-u-openproject2013/WearableWeb
*/

#include<math.h>

// B定数
const int B = 3380;
// 基準温度(K)
const double T0 = 25 + 273.15;
// 基準抵抗
const long R0 = 10000;
// PullUp抵抗 
const long R_pu = 10000;

void setup() {
  Serial.begin(9600);
}

void loop() {
  unsigned long Val = 0;   //Analog入力値
  double Volt;  //入力電圧
  double R_th;  //サーミスタ抵抗
  double T;     //温度
  
  for(int i = 0; i < 100; i++){
    Val  += analogRead(A0);
  }
  
  Val /= 100;
  Volt = 5.0 * Val / 1023;
  R_th = R_pu * Val / (1023.0 - Val);
  T    = 1 / ( log(R_th/R0)/B + 1/T0 );
  
  Serial.print(Val);
  Serial.print(", ");
  Serial.print(Volt);
  Serial.print(", ");
  Serial.print(R_th);
  Serial.print(", ");
  Serial.print(T - 273.15);
  Serial.print("\n");
  
  delay(1000);
}
