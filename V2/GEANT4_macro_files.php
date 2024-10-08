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
        <h1>Home</h1>  
        </header>
        <br>
        <p>
        This sections aims to provide a description of how macro files can be introduced to GEANT4 simulations to allow for improved user interaction and elements of automation. The base code used throughout this section is from the Cherenkov Detector built previously. Please ensure you have a working copy of this simulation before begining here. It would also be useful to have your simulation able to write results to ROOT files as these will be used for testing (this is also detailed within a section on this site). 
        </p>
        <br>
        <p>
        An advantage of using macro files with GEANT4 is that we're able to make changes within the macros without needing to recompile our code each time we wish to run it. This enables us to freely change parameters without the need to rebuild. This also enables changes to be made iteratively to run several simulations in succession. To begin, we return to the sim.cc file.
        </p>
        <br>
        <p>
        Within the sim.cc file we can place each of the UImanager commands into a macro file. The macro file itself here is called vis.mac (to stand for visualisation). This is a simple test file that's stored in the same location as the simulation code. To begin, cut the UImanager commands from the simulation file into the macro file, then delete the references to UImanager and ApplyCommnd (they're not needed). Be sure to remove the brackets, quotations and semi-colons that came with the commands at this point. At the end you should have the folders with commands, then the input paramters remaining. 
        </p>
        <br>
        <p>
        The next step is to tell GEANT4 to actually load the macro file at the start, then run the actual commands. This is done with the UImanager->ApplyCommand("/control/execute vis.mac");. As it stands, the macro files created in the simulation folder will not be found as they do no exist within the build folder. To solve this problem, we can adjust out CMake file to copy any macro files straight into the build folder. Within the CMakeLists.txt file, add the command file(GLOB...). In the code within this example, this command looks for any files with the extension .mac, stores them in the variable MACRO_FILES then copies them into the PROJECT_BINARY_DIR folder (our build folder). With this command included, we can re-test our code to ensure it works. Note, at this point there have been some additional commands included within the vis.mac file, these are used to add some detail to the simulation and allow for easier debugging.
        </p>
        <br>
        <p>
        To take the macro implementation one step further, we now look to use a macro file that can be used to change the parameters of the particle generator. To begin we return to our generator.cc file and move the previous declarations to the constructor. This is done to avoid the GeneratePrimaries function replacing our variables each time an event is generated. At this point we will also adjust our sim.cc file so that it only produces a graphical ouput if we don't supply it with a command line instruction, this is implemented to better computing resource. This is done by changing the ui definition to 0 then construction the appropriate if loops. Note, within this code, the visualization manager is only launched when there are no arguments passed from the command line. When there are commands, the argv and fileName variables are passed to action the simulation. This code can be tested to ensure the simulation still runs, at this point it should work provided there's no argument passed at the command this, if there is, the programme should crash as we've not created this file yet.  
        </p>
        <br>
        <p>
        To make this file we create a file called run.mac, within this file we begin by changing the momentum of our particle. This follow a similar process to the vis.mac file where we pass folders and commands straight in. Within the run.mac file, we begin by sending a proton with 0.5 GeV momentum, then iterate upwards. To test this, and pass the macro to the simulation from the command line we use the command ./sim run.mac. At this point we have successfully implemented macros into our simulation however if would be useful to store each run in a different root file. 
        </p>
        <br>
        <p>
        To output our results into different root files we return to our run.cc file. Here we will insert the run number into the output file name so that each run is created in a seperate file. Here we take the G4Run variable and give it the name runNumber, here we've used the GetRunID command. Then, using stringstream to convert out integer to a string, then add this detail to our output file. Lastly, we also move the creation of our Ntuples from the BeginOfRunAction to the constructor, to avoid creating them every time a run starts. Note, be sure to include the G4Run.hh header within the run.hh header file. With these steps complete, you should be able to re-run your simulation and produce three output root files. 
        </p>
    </article>
<?php
    include_once 'footer.php'
?> 