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
            <h1>GEANT4 MT User Defined Messages</h1>  
        </header>
        <br>
        <p>
        User defined messages within GEANT4 can be used for many things, ranging from changing detector geometries during a simulation to adjusting input parameters from the particle generators. This section aims to detail how to create these within a simulation and cater for a broad array of effects. The detail covered here will use the code generated throughout the GEANT4 Cherenkov Detector, macro files and multithreading sections. As such, in order to complete this section it would be useful to have a working version of this simulation locally.
        </p>
        <br>
        <p>
        We begin by returning to our construction.cc and construction.hh files. Within the header we declare usage of the G4GenericMessengar header. Then we can create an object within our private section of the header file. This can remain private as we do not need to use it outside of our function. In this case we call it fMessenger. Moving to the constructor of the source file we define the new G4GenericMessenger and pass the relevant arguments. Note, within these arguments the first /detector/ argument defines the folder in which the new commands will be stored, this sits under the initial root directory. Then, the Detector Construction argument provides a prompt for the user during the simulation's execution.
        </p>
        <br>
        <p>
        With this step complete we can use the DeclareProperty command to define the actual changes that the message will execute. The arguments passed will be the pieces that are changed later on. In this case we're using the message to change the number of columns and number of rows within the particle detector. Note, the variables nCols and nRows will serve as the variables that we change, these will need to be defined within the private part of the header file. With these steps complete, your simulation can be re-compiled and tested. 
        </p>
        <br>
        <p>
        The next step required is to change the loops that are used to define the detector positions in order to build based on rows and columns specified. The placement of the detectors also needs to be adjusted within the loop contents. Next, the actual size of the detectors should also change, this is so the detector surface fills the entire volume. This begins by defining the world volume dimensions within the xWorld, yWorld and zWorld variables. Once these variables are implemented into the solidWorld definition we move to the solidDetector definition. This parameterization needs to depend explicitly on the number of rows and columns. Another point here, whenever you instruct GEANT4 to change the detector construction, you need to instruct it to run the construct function again. This can cause memory problems as you create new variables with the same names that were used previously during the first build. To solve this problem we can put our definitions for volumes and place them into the definition of the class (header file). A note here, if your detector isn't displayed within the simulation, you can run the geometry again using the /run/reinitializeGeometry then /control/execute vis.mac commands. Note, these commands can be combined in an additional macro file, the example code includes this functionality within the draw.mac file. 
        </p>
        <br>
        <p>
        We also wish to ensure the materials used within our simulation are only defined once (rathern then each time we change the geometry of our detector). As such, we make a new class within our construction source and place all our materials definitions within this. This way, they'll only be defined once. In this case, the new function is called DefineMaterials. Once created we need to move the material definitions into this new function, taking care to also define these pieces within the header file. We can also place the material properties tables within this function, but it shouldn't create any lasting problems if we do not. One further point here, before our code will run we need to change the sensor ID so that it depends on the number of columns and rows. As a result, we multiple the sensor ID by nCols, rather then 100. Additionally we need to call our new function from the contructor by introducing the DefineMaterials() command, otherwise there's no materials present within our detector. Now we can make and run our simulation and test out the new functionality by changing the number of rows and columns. 
        </p>
        <br>
        <p>
        To keep our code concise, we now move all the content related to materail definitions to the DefineMaterials function. We can further optimise our simulation by creating another macro file, called det.mac, which can be used to change parameters with ease. Within this file we want to loop the number of columns from 10 to 100 in steps of 10. This pulls on one further macro file, scandet.mac, which we now need to define. Within this macro we iterate through the number columns using the cols value, restart our geometry, then run with 100 particles per value. With these steps complete, the code for the simulation can be rebuilt and should run with variable column and row numbers and the ability to produce root output files with iterations through the number of detectors. 
        </p>
    </article>
<?php
    include_once 'footer.php'
?> 