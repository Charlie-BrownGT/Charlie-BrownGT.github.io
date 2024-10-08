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
            <h1>Storing the Results from GEANT4 in ROOT</h1>  
        </header>
        <br>
        <h2>Initial Setup</h2>
        <br>
        <p>       
        This page intends to detail the process of storing the results from a GEANT4 simulation within a ROOT file, leaving it able to be interpreted by ROOT. Before begining this section ensure you've completed the section detailing how to build a Cherenkov Detector. The source code for the content covered here can be found on GitHub at <a href="https://github.com/Charlie-BrownGT/geant4-root-results.git">ROOT Results</a>.
        </p>
        <br>
        <p>
        The results that are generated within the photo detector previously are stored within a ROOT file in this section. To begin, create two additional files within the project folder called run.cc and run.hh. The header file will begin with the usual definitions. Further, be sure to include the G4UserRunAction.hh header to allow for ROOT output. Moving on, the next step is to define the new class, MyRunAction. When defining MyRunAction, be sure to specify that it inherits from the public class G4UserRunAction. From there we proceed with defining the public and private sections of the class, this includes the usual constructor and destructor then moves to BeginOfRunAction and EndOfRunAction. These pull from the pre-defined class, remain virtual and take the argument G4Run*.
        </p>
        <br>
        <p>
        With these steps complete we move to our run.cc file and begin by inlcuding our run.hh file as a header. Next we define our constructor, destructor and actual functions in the normal manner. With these steps complete, we've created the framework but now need to fill it. This begins by considering which content we actuall wish to store in our output file. We can also consider where we wish to create our output file, if we place the functionality in the contructor, the output file will be created as soon as we run our simulation. However, in this example we wish to create a new output file each time an event runs within the simulaiton. As such, we begin by building out the contents in the BeginOfRunAction function.
        </p>
        <br>
        <p>
        The functionality to interact with files originates from the G4AnalysisManager where here we create and example called man. From there, we can instruct man to open the output file called output.root (which is also closed in the destructor). Note, before closing we also need to instruct the destructor to Write to the file, this prevents damage ocuring and ensures our data is appropriately stored. Further, be sure to include the G4AnalysisManager within your header file.
        </p>
        <br>
        <p>
        Next we look to what actual information we wish to store. Here we use Ntuples within the run.cc files, these effectively create trees within the simulation that can be used to store files in different locations. These are used to define the output in rows, here called Hits, then create the columns, using the CreateNtupleIColumn and CreateNtupleDColumn commands, which defines which columns we want. The I and D here represent the intergers that we wish to store. We can use this same command to store the coordinates of the events when they're located. At this stage, you could equally create an output from the detector number but this would require a detector mapping to understand which events were observed where. To avoid this complication we stick with producing the output coordinates. Finally we issue the command FinishNtuple, giving an argument of 0 as this is the first Ntuple that we've created. Currently this will not produce an output as the class isn't included within our GEANT4 programme. To change this we return to our action files.
        </p>
        <br>
        <p>
        Start by ensuring you include the run.hh file within the action.hh file. Then, moving to the action.cc file, below the generator, we can define the MyRunAction within the simulation. Once defined, be sure to issue the SetUserRunAction command in the same manner as before to make sure the runAction is called. At this point, you can test your new files using the cmake .. and make commands and complete any debugging. Next we return to our detector files to insturct the ouput to be sent to our root file. Here we include the relevant headers in our file, in this case the G4AnalysisManager, then add the detail to the detector.cc file. The FillNtupleIColumn command is used here to actually pass data to our file. It's worth noting here, the first arguments here (0 - 3) represent the numbered rows of the Ntuples that your defining, if you add or remove a row later within the run.cc file, these will need to be re-indexed. The last row here ensures we finish the file correctly. To find the evt variable we use the G4RunManager to find the current event and store it in an appropriate variable. Be sure to include the G4RunManager header within your header file. With all of these steps complete, you should be able to re-compile and run your simulation and produce an output file in a root format. Please refer to the ROOT section for more detail on how to install and use ROOT. As a final point, you can use ROOT to plot the x and y hits against eachother using the command 'Hits->Draw("fX:fY", "", "colz)' from the root terminal. 
    </article>
<?php
    include_once 'footer.php'
?> 