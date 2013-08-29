#include<math.h>

// PullUp抵抗 
const long R_pu = 3300;
// B定数
const int B = 3380;
// 基準温度(K)
const double T0 = 25 + 273.15;
// 基準抵抗
const long R0 = 10000;

void setup() {
  Serial.begin(9600);
}

void loop() {
  int Val = 0;   //Analog入力値
  double Volt;  //入力電圧
  double R_th;  //サーミスタ抵抗
  double T;     //温度
  
  for(int i = 0; i < 5; i++){
    Val  += analogRead(A0);
    delay(1000);
  }
  
  Val /= 5;
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
                  
}
