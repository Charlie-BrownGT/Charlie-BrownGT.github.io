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
            <h1>GEANT4 MT Application</h1>  
        </header>
        <br>
        <p>
        This section aims to detail how to take single threaded GEANT4 simulations and make them multi thread compatable. Please note, to complete this section, it would be useful to have a working cherenkov detector, macro definition and a multithreaded version of GEANT4 installed. More information on how to make these can be found in seperate sections within this site. 
        </p>
        <br>
        <p>
        To begin, we return to our sim.cc file. Here we need to include an if condition around our G4RunManager which relies on the declaration of G4MULTITHREADED. If this is defined that we are to use the G4MTRunManager instead. Here GEANT4 will check to see which installation we have sourced, if we've sourced the multithreaded version, this one will be used for the simulation. Next we look at the action.cc and action.hh files. Within the action.hh file, we need to create a new function in the class definition called BuildForMaster. Here, what's written inside the build function is for each worker thread where what's written inside the BuildForMaster function is for the master thread. Next we need to define this function in the action.cc file. Within this function we need to create the runAction and SetUserAction. 
        </p>
        <br>
        <p>
        Returning to the sim.cc file, we also need to look at the initialization of the run mangager. Currently this is hard written into our code but if we want to define the number of threads we want to use within our scripts then we need to make sure this definition is placed before the visualisation manager, otherwise it will throw and error. As such, we will place this definition within our run.mac macro file. With these setps complete, we can return to our simulation and test our code. Here, if we build in the same manner outlines previously, then run our siulation with the run.mac passed, you should be able to see the different worker threads producing their results. 
        </p>
        <br>
        <p>
        One further point to note here, when your simulation produces results from mt mode, the results will be produced in several distinct files. As such, we need to make our results thread safe. This can be achived by merging each of these outputs using the command 'hadd test.root output0_t{0..3}.root'. This will add all of the output files into one centralised output, within test.root.
        </p>
    </article>
<?php
    include_once 'footer.php'
?> 