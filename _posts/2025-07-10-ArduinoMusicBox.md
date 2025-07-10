---
layout: post
title: Making an Arduino-based music box
subtitle:
cover-img: 
thumbnail-img: /assets/img/electronics/arduino.jpg
share-img: /assets/img/electronics/arduino2.jpg
tags: [electronics, arduino]
author: 
---

During this project an arduino based music boxed was created that played two different songs. The songs were played each time one of the two buttons were pushed. 

The components required for this project were: 

1. An Elegoo Mega 2560.
1. A passive buzzer.
1. Two digital buttons.
1. Breadboard jumper wires.


The circuit was configured as follows: 

![Transmitter](/assets/img/electronics/musicBox.png){: .mx-auto.d-block :}

The music box arduino sketch was written as: 

```C
#include "pitches.h"

int buttonApin = 2;
int buttonBpin = 3;
bool lastButtonAState = HIGH;
bool lastButtonBState = LOW;

int melody[] = {
  NOTE_E4, NOTE_E4, NOTE_F4, NOTE_G4,
  NOTE_G4, NOTE_F4, NOTE_E4, NOTE_D4,
  NOTE_C4, NOTE_C4, NOTE_D4, NOTE_E4,
  NOTE_E4, NOTE_D4, NOTE_D4
};

int noteDurations[] = {
  300, 300, 300, 300,
  300, 300, 300, 300,
  300, 300, 300, 300,
  300, 300, 600
};

int melody2[] = {
  NOTE_E5, NOTE_DS5, NOTE_E5, NOTE_DS5, NOTE_E5,
  NOTE_B4, NOTE_D5, NOTE_C5, NOTE_A4,
  NOTE_C4, NOTE_E4, NOTE_A4, NOTE_B4,
  NOTE_E4, NOTE_GS4, NOTE_B4, NOTE_C5
};

int noteDurations2[] = {
  250, 250, 250, 250, 250,
  250, 250, 250, 500,
  250, 250, 250, 500,
  250, 250, 250, 500
};

void setup() {
  pinMode(buttonApin, INPUT_PULLUP);
  pinMode(buttonBpin, INPUT_PULLUP);
}

void loop() {
  bool currentButtonAState = digitalRead(buttonApin);
  bool currentButtonBState = digitalRead(buttonBpin);

  if (lastButtonAState == HIGH && currentButtonAState == LOW) {
    for (int i = 0; i < sizeof(melody) / sizeof(melody[0]); i++) {
      tone(8, melody[i], noteDurations[i]);
      delay(noteDurations[i] + 50); 
    }
    noTone(8); 
  }

  lastButtonAState = currentButtonAState;

  if (lastButtonBState == HIGH && currentButtonBState == LOW){
    for (int i = 0; i < sizeof(melody2) / sizeof(melody2[0]); i++) {
      tone(8, melody2[i], noteDurations2[i]);
      delay(noteDurations2[i] + 50);
    }
    noTone(8);
  }

  lastButtonBState = currentButtonBState;
}
```


