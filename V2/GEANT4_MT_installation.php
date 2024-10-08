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
        This section aims to provide an informal documented account covering installation and initial usage of the GEANT4 software package and a simple example, including source code. Multithreading a GEANT4 installation provides one main benifit, when compared to it's single threaded equivilant, the ability to use multiple processor threads simultaneously. This will be limited by the hardware that you have availible, to either your physical or virtual machine, but has the potential to significantly reduce the run time of any runs or calculations. 
        </p>
        <br>
        <p>
        The process of creating a multithreaded version of GEANT4 is very similar to the single threaded version. The first difference occurs when configuring the ccmake gui prior to making and intalling the project. With this in mind, please follow the steps from the single threaded installation up to entering the 'ccmake ..' command. Once at the point, the following details will need to be configured in the GUI: 
        </p>
        <br>
        	<ul>
        		<li>Change the installation prefix to '/home/NAME/software/geant4/geant4.x.x.x.x-MT-install', this will create a new folder called install to store the installation.</li>
        		<li>Specify 'On' for the enable multithreaded option</li> 
        		<li>Specify 'On' for GEANT4_INSTALL_DATA</li>
        		<li>Specify 'On' for GEANT4_USE_QT</li> 
        		<li>Specify 'On' for GEANT4_RAYTRACER_X11</li> 
        		<li>Specify 'On' for GEANT4_USE_SYSTEM_EXPAT</li>
        	</ul>
        <br>
        <p>
        Specifically, the changes here detail the new 'geant4.x.x.x.x-MT-install' candidate and switch the MT option on, when prompted. Once compiled, made and installed, these should create a seperate installation instance under the 'geant4.x.x.x.x-MT-install' folder, with multithreading enabled. Once these options have been specified, proceed with the installation, as with the ST version, using the commands 'make', then 'make install'. Once this installation is complete, you'll need to reference a different source for geant4, pulling on the multithreaded installation. This can be actioned using the command '. ~/software/geant4/geant.x.x.x.x-ST-install/share/Geant4/geant4make/geant4make.sh'. This should leave you with a functioning version of GEANT4 with multithreading enabled. 
        </p>
    </article>
<?php
    include_once 'footer.php'
?> 