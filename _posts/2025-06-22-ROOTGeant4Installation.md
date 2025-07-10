---
layout: post
title: ROOT and GEANT4 Installation Guide
subtitle: 
cover-img: 
thumbnail-img: /assets/img/computers/geant4Logo.png
share-img: /assets/img/computers/geant4Logo.png
tags: [Computer, Software]
author: 
---

### Introduction

ROOT and GEANT4 are each open source software platforms that are routinely used within a variety of physics fields. They are both owned and moderated by CERN. The author is not a contributor to ROOT or GEANT4 but is a user of each, no credit can be taken for their development. These packages are developed by expert groups of software developers, whose efforts have streamlined many aspects of computational physics. 

The websites for each of these tools can be found: 

- [ROOT](https://root.cern/)
- [GEANT4](https://geant4.web.cern.ch/)

The following is a guide presented to describe the installation of each of these tools, and allow the user to develop their own simulations locally. Whilst some of the details may evolve (Linux distributions, dependencies, etc.), the general methodology should remain the same. 

### Background

Each of the tools noted here were installed on a virtual machine built on VMware workstation pro. Ubuntu 22.04.5-desktop-amd64 was installed via the graphical interface with settings left as defaults. Once the installation was complete, default software packages were updated via package manager (apt) and several other packages were added (git, htop and net-tools). With these steps complete, the prerequisites for ROOT and GEANT4 were installed prior to the installation of any of the actual tools. These were installed using the following: 

#### ROOT
```C
sudo apt-get install binutils cmake dpkg-dev g++ gcc libssl-dev git libx11-dev \
libxext-dev libxft-dev libxpm-dev python3 libtbb-dev libvirt-dev libgif-dev \
gfortran libpcre3-dev \
libglu1-mesa-dev libglew-dev libftgl-dev \
libfftw3-dev libcfitsio-dev libgraphviz-dev \
libavahi-compat-libdnssd-dev libldap2-dev \
python3-dev python3-numpy libxml2-dev libkrb5-dev \
libgsl-dev qtwebengine5-dev nlohmann-json3-dev libmysqlclient-dev
```

#### GEANT4
```C
sudo apt install cmake cmake-curses-gui gcc g++ libexpat1-dev \
qtbase5-dev qtchooser qt5-qmake qtbase5-dev-tools libxmu-dev \
libmotif-dev libxerces-c-dev
```

### ROOT

ROOT was installed first and was build from the source code. From the software directory, the most recent ROOT distribution was obtained using: 
```C
git clone --branch latest-stable https://github.com/root-project/root.git root_src
```
At this time of testing, this installed version 6.32.04. This created a new directory called 'root' and sub directory 'root_src'. Moving into the 'root' directory, a 'root_build' directory was also created. After moving into the 'root_build', the cmake project was compiled using the following command and flags: 
```C
cmake -DCMAKE_INSTALL_PREFIX=../root_install ../root_src/
```
Finally, the project was built using the following commands: 
```C
make -j6
```
Note, the -j6 here indicates the number of cores to be used during the installation, this should be adjusted for each specific installation. 
```C
make install
```
Once complete the root installation was finalised by adding the ROOT source script to the Ubuntu .bashrc with the following command (with the username adjusted appropriately): 
```C
source /home/user/software/root/root_install/bin/thisroot.sh
```

### GEANT4

The source code for GEANT4 (v11.2.2) was downloaded from the GEANT4 website (linked above) and unzipped into a new directory named 'geant4', also within the top level 'software' directory. Moving into the unzipped 'geant4' directory, a further sub-directory was created called 'build'. Moving into this directory, the GEANT4 cmake build files were created via the graphical interface with the command 'ccmake ..'. Then, the following options were specified for the installation:

- install prefix
- build multithreaded
- install data
- use gdml
- use qt
- use raytracer x11
- use expat

Note, the installation prefix should be adjusted so that the project builds within the 'geant4' directory, under the top level 'software' directory, but not in the source directory. This method can allow for multiple GEANT4 installations to be built and sourced separately. Then, the build was completed by again using the command: 
```C
make -j6
```
Once complete, the installation was completed using:
```C
make install
```
Finally, the GEANT4 .sh file was also added to the Ubuntu .bashrc file. Lastly, the functionality of GEANT4 was tested by building and running one of the pre-installed examples. 

With these steps completed, the used should be able to access and run both ROOT and GEANT4.

Note, if installing GEANT4 in Ubuntu 24, be sure to check 'Ubuntu on Xorg' at the Ubuntu login screen. 
