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
            <h1>User Defined Stepping and Event Action</h1>  
        </header>
        <br>
        <p>
        The purpose of this section is to detail how to define your own stepping and event action classes. These can be used to accumulate particular hit energy at the end of each event. This information will then be stored in a ROOT file in the same manner as previously outlined. Here we will look specifically at deposited energy as the example, but this could equally well be used for any other information/values.
        </p>
        <br>
        <p>
        To begin we return to our run.cc file and add another Ntuple in which to store the information. In this case we call out Ntuple 'Scoring', the information stored is stored as a double, then we finish the Ntuple assigning in the number 2. Next we create two new files in the same working directory and call then event.hh and event.cc. Begining with the event.hh file, we outline the definition in the usual manner, then ensure we include the appropriate header files, note here be sure to include the locally created run.hh header file. Next we begin the description of our class, calling it MyEventAction, and derive it from the public class G4UserEventAction. Creating the public parts of a definition, we create out constructor and destructor. The constructor will need access to MyRunAction, which pulls from run.hh. We then need two virtual functions from the G4UserEventAction class, these are BeginOfEventAction and EndOfEventAction. Lastly, within the public section we need to create a final function which is AddEdep which takes a double as an argument. The sole role of this part is to add up the accumulation of deposited energy. Within the private section of our class definition we need to create a double value called fEdep, this is the same value that's called within the public section of our definition. 
        </p>
        <br>
        <p>
        Moving to our event.cc file, ensuring we include the header file event.hh. Next we define both our constructor and destructor, ensuring we carry the appropriate arguments. Within the contructor be sure to specify the initial value of fEdep as zero. The destructor can be left blank. With these complete we can move to BeginOfEventAction and start by defining the fEdep as zero, this will ensure the energy deposition value is reset to zero at the begining of each event. Next going to EndOfEventAction we want to print our energy despotion using the G4cout function. We would also like to store this information in our ROOT file using the G4AnalysisManager, then fill the Ntuple appropriately. At this point we can remake our code and test for functionality. 
        </p>
        <br>
        <p>
        Provided this works correctly we can continue by creating the two new files stepping.hh and stepping.cc. Starting with stepping.hh we define in the usual manner and include the other relevant header files, be sure to include both construction.hh and event.hh files here too. Moving now to define our class we begin with MySteppingAction which inherits from G4UserSteppingAction, then the public part should include the constructor MySteppingAction and similar destructor. We also need to define UserSteppingAction, which inherits from G4Step.hh. Then moving to the private part we need to define MyEventAction. Moving to stepping.cc we need to include the stepping.hh file and define our constructor and destructor. Within the constructor be sure to define the fEventAction so the constructor is able to access the part we've created.
        </p>
        <br>
        <p>
        With constructor and destructor defined we need to define MySteppingAction, this takes some information from the G4Step function. Within this function we need to define the double edep which stores the total energy deposit, note, this is currently storing the energy deposition in all volumes, we can be more selective later if needed. Then we move to define fEventAction and accumulate the edep values from successive events. Here the code can be tested again. To gain access to our stepping we need to return to action.cc and add MyEventAction and MySteppingAction to the MyActionInitialization function. Note, you will need to add the required header files to the action.hh file for this code to work. When this is tested, you should observe the energy desposition in the run manager following each event.
        </p>
        <br>
        <p>
        To get access to the energy deposition that's only within our scoring volume we need to return to construction.cc and construction.hh and define another volume. Within construction.hh we need to create another publically availible function called GetScoringVolume, this will return the variable fScoringVolume, note this variable will need to be defined in the private part of this header file. This is defined as a logical volume. Moving to construction.cc we need to define the volume under the LogicRadiator definition. Returning to stepping.cc, we define our volume with the type G4LogicalVolume and use the step piece to gain access to the correct information. Note, we want to check whether this is our scoring volume by defining detectorConstruction, call the run manager, and check to ensure the volume falls within the correct piece of the detector. Once this is complete, we define fScoringVolume as another logical volume. Now we have the scoring volume and the volume in which the particle sits, we now need to compare the two to see if the particle sits within the right space for scoring. This is done using a simple if statement before the energy accumulation.
        </p>
    </article>
<?php
    include_once 'footer.php'
?> 