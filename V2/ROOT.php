<?php
    include_once 'header.php'
?>

<article>
    <header>
        <h1>Home</h1>  
    </header>
    <br>
    <p>
    This section aims to provide an informal documented account covering installation and initial usage of the ROOT software package and a series of simple examples outlining it's usage. 
    </p>
    <br>
    <p>
    The following outlines the process of installing ROOT from the Ubuntu 22.04.4 distribution. There are several software packages required before begining installation, these can be installed using the following commands - 'sudo apt-get install binutils cmake dpkg-dev g++ gcc libssl-dev git libx11-dev libxext-dev libxft-dev libxpm-dev python3', which will provide the required packages. There are also several others which may be useful in optimising ROOT's performance, these can be intalled with 'sudo apt-get install gfortran libpcre3-dev xlibmesa-glu-dev libglew-dev libftgl-dev libmysqlclient-dev libfftw3-dev libcfitsio-dev graphviz-dev libavahi-compat-libdnssd-dev libldap2-dev python3-dev python3-numpy libxml2-dev libkrb5-dev libgsl0-dev qtwebengine5-dev nlohmann-json3-dev'. Each of these are installed, in this case using the sudo package manager. 
    </p>
    <br>
    <p>
    With these steps complete, ROOT can be intalled using the snap package manger via the command 'sudo snap install root-framework'. Once complete, ROOT can be launched from the terminal using the command 'root'. This will launch the root console which allows for interaction with the toolset.
    </p>
</article> 

<?php
    include_once 'footer.php'
?> 