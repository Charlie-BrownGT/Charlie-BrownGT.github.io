---
layout: post
title: Making an Arduino-based FM Transmitter and Receiver
subtitle: A simple arduino project
cover-img: 
thumbnail-img: /assets/img/electronics/arduino.jpg
share-img: /assets/img/electronics/arduino2.jpg
tags: [electronics, arduino]
author:
---

Materials for this projects were found [here](https://randomnerdtutorials.com/rf-433mhz-transmitter-receiver-module-with-arduino/).

The components required for this project were: 

1. Two arduino chips, personally I used an Elegoo Mega 2560 and an Arduino Uno. 
1. A 433MHz RF Transmitter and Receiver module set. This was sourced from [here](https://www.ebay.co.uk/itm/276489151766) for £4.36.
1. Breadboard jumper wires used to connect components to the modules. 

The ArduinoIDE was used to handle the software requirement throughout this project. The RadioHead library was required for both the transmitter and receiver sketches so was added to the IDE library.

The transmitter circuit was configured as follows: 

![Transmitter](/assets/img/electronics/433MhzTransmitterCircuit.jpg){: .mx-auto.d-block :}

The transmitter sketch was written as: 

```C
#include <RH_ASK.h>
#include <SPI.h> // Not actually used but needed to compile

RH_ASK driver;

void setup()
{
    Serial.begin(9600);	  // Debugging only
    if (!driver.init())
         Serial.println("init failed");
}

void loop()
{
    const char *msg = "Hello World!";
    driver.send((uint8_t *)msg, strlen(msg));
    driver.waitPacketSent();
    delay(1000);
}
```

The receiver circuit was configured as follows: 

![Receiver](/assets/img/electronics/433MhzReceiverCircuit.jpg){: .mx-auto.d-block :}

The receiver sketch was written as: 

```C
#include <RH_ASK.h>
#include <SPI.h>

RH_ASK driver;

void setup()
{
    Serial.begin(9600);
    if (!driver.init())
         Serial.println("init failed");
}

void loop()
{
    uint8_t buf[12];
    uint8_t buflen = sizeof(buf);
    if (driver.recv(buf, &buflen)) // Non-blocking
    {
      int i;
      // Message with a good checksum received, dump it.
      Serial.print("Message: ");
      Serial.println((char*)buf);         
    }
}
```

Once built, this setup was able to transmit and receiver FM data over short distances. The message that was transmitted could be modified within the transmitter sketch. 