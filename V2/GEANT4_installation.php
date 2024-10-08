<?php
    include_once 'header.php'
?>

<nav>
    <h1>Navigation</h1>
    <ul>
    <li><a display:inline href="./GEANT4_installation">GEANT4 Installation</a></li>
    <li><a display:inline href="./GEANT4_cherenkov_detector">GEANT4 Cherenkov Detector</a></li>
    <li><a display:inline href="./GEANT4_ROOT_results">GEANT4 Output Stored in a ROOT File</a></li>
    <li><a display:inline href="./GEANT4_macro_files">GEANT4 Macro Files</a></li>
    <li><a display:inline href="./GEANT4_user_defined_messages">GEANT4 User Defined Messages</a></li>
    <li><a display:inline href="./GEANT4_MT_installation">GEANT4 Multithreaded Installation</a></li>
    <li><a display:inline href="./GEANT4_MT_application">GEANT4 Multithreaded Application</a></li>
    <li><a display:inline href="./GEANT4_detector_efficiencies">GEANT4 Detector Efficiencies</a></li>
    <li><a display:inline href="./GEANT4_user_defined_stepping_and_event_action">GEANT4 User Defined Stepping and Event Action</a></li>
    </ul>
</nav>
    <article>
        <header>
            <h1>GEANT4 Introduction</h1>  
        </header>
        <br>
        <p>
        This section aims to provide an informal documented account covering installation and initial usage of the GEANT4 software package and a simple example, including source code. 
        </p>
        <br>
        <p>
        GEANT4 is a software package owned and maintained by The GEANT4 Collaboration and remains open source. It's purpose is to used Monte Carlo Methods to simulate the passage of particle through matter. It's results can be interpreted through a GUI, direct from the terminal or plotted graphically via the ROOT package.  
        </p>
        <br>
        <h2>Installation</h2>
        <br>
        <p>
        The source code for GEANT4 can be freely downloaded from the GEANT4 website linked <a href="https://geant4.web.cern.ch/download/11.2.1.html">GEANT4 Downloads</a>. Once the download completes, the contents will needed to be extracted from the downloaded zip file to another directory. Once extracted, you should be left with a geant4 directory named something like 'geant4.x.x.x.x', detailing your version number. Next move into this directory.
        </p>
        <br>
        <p>
        It's worth noting, the GEANT4 project is a CMAKE project and will require other packages to be installed prior to compiling the source code. These are: 
        </p>
        <br>
        <ul>
        	<li>cmake</li>
        	<li>cmake-curses-gui</li> 
        	<li>gcc</li>
        	<li>g++</li> 
        	<li>libexpat1-dev</li> 
        	<li>qtbase5-dev</li>
        	<li>qtchooser</li>
        	<li>qt5-qmake</li>
        	<li>qtbase5-dev-tools</li> 
        	<li>libxmu-dev</li> 
        	<li>libmotif-dev</li>
        </ul>
        <br>
        <p>
        Once these packages are installed, ensure you're in the directory titled 'geant4.x.x.x.x' and create another directory called 'build'. After moving into the build directory, launch the ccmake gui using the command 'ccmake ..', which should launch the ccmake interface and enable you to specify the installation details.
        </p>
        <br>
        <p>
        Once launched, press 'c' to begin the configuration, provided there's no errors, ignore the initial warning. From there, specify the following details: 
        </p>
        <br>
       	<ul>
       		<li>Change the installation prefix to '/home/NAME/software/geant4/geant4.x.x.x.x-ST-install', this will create a new folder called install to store the installation.</li>
       		<li>Choose either multithreaded or single threaded modes, if this is your first installation I'd recommend starting with a single thread install.</li> 
       		<li>Specify 'On' for GEANT4_INSTALL_DATA</li>
       		<li>Specify 'On' for GEANT4_USE_QT</li> 
       		<li>Specify 'On' for GEANT4_RAYTRACER_X11</li> 
       		<li>Specify 'On' for GEANT4_USE_SYSTEM_EXPAT</li>
       	</ul>
        <br>
        <p>
        Then, once these details are confirmed, configure your setup by pressing 'c', then generate your install by pressing 'g'. Once this process is complete, you should be able to check the contents of the 'build' directory and see the required elements to begin your installation. Finally, to begin your installation, enter 'make' from inside the 'build' directory to begin. This process make take some time. It may also download some additional software packages so ensure you have a reliable internet connection throughout. Once the 'make' process is complete, enter the 'make install' command to complete the installation. 
        </p>
        <br>
        <p>
        Once the installation is complete, you should find a new directory under the top level geant4 folder with a naming convention matching 'geant4.x.x.x.x-install'. This provides a single folder in which your installation is held, and can be removed if required to re-install at any point. Finally, to actually use GEANT4, there's a file generate within this Geant4 folder that will need to be referenced, this can be achieved with the following command '. ~/software/geant4/geant.x.x.x.x-ST-install/share/Geant4/geant4make/geant4make.sh'.
        </p>
        <br>
        <p>
        With these steps completed you should have a working version of Geant4 that you can use to test examples and build your own detectors and colliders. Other pages on this site will demonstrate how to compile and build the Geant4 pre-set examples and provide a demo on how to build a detector from scratch. 
        </p> 
    </article>
<?php
    include_once 'footer.php'
?> 