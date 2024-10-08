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
            <h1>GEANT4 Detector Efficiencies</h1>  
        </header>
        <br>
        <p>
        It's common knowledge that particle detectors are not 100% efficient when detecting particles. It is with this in mind that adding detector efficiencies brings our simulation one step closer to truly replicating nature. The following aims to detil how this functionality can be added to GEANT4 and our Cherenkov Detector, contruction so far. Note, this section will require a working simulation upto and including the step of adding user defined messages. Source code for this simulation can be found via GitHub, accessed through the Contact page. 
        </p>
        <br>
      	<p>
      	There is not a standard built in function to enable efficiencies to be integrated into GEANT4, as such there's several different methods that can be used. In any example, a data set is required to model the efficiency of the detector in question. There's a sample data file describing an efficiency held within the source code here titled eff.dat. Be careful at this point to ensure your data file does not contain a blank line at the end. Next, using a similar method outlined previously for the macro files, we need to ensure our data file is copied from the source directory into the build directory. As such, we retun to our CMakeLists.txt file. The change made here will ensure that any .dat files created are copied to the build directory once the programme is compiled. Note, once the .dat file has initially been copied to the build directory, if any further changes are made, the simulation will need to be re-compiled to ensure these changes are pulled across. Note, the data file used here will plot the wavelength of the incident particle against the detector efficiency, as a percentage. Each of these data files mapping efficiency remain specific to the detector in question. 
      	</p>
      	<br>
      	<p>
      	Before we implement the efficiency data file into our simulation we return to our run.cc file to adjust the output of our data. Previously, the Ntuples that we've created were used to produce output from the Monte Carlo simulations for comparison against nature. Next we will look to produce more Ntuples which are purely Monte Carlo outputs (without a direct comparison with nature). For example, this can be used to state the exact position/momentum/wavelength of a photon when it hits our photosensor, which is not possible physically. It is important to note here, the Monte Carlo data stored here is not physically obervable, it remains purely for the benifit of the simulation. The process to implement this is very similar to that used for the previous Ntuples.
      	</p>
      	<br>
      	<p>
      	Next, to implement the actual efficiency changes within the detector we return to our detector.cc and detector.hh files. Following on from the previous, the detector hits are now stored in Ntuple 1, so we need to change the index used, this is achieved by adding a further Ntuple index, specifying 1. Then we can create the commands to store the data in the zeroth Ntuple, this uses very similar syntax to that used previously, but taking care to ensure the indicies used are correct. Further, we are not looking to use the posDetector variable for these next Ntuples. We instead wish to find the exact photo details, so can use the posPhoton variable previously defined. Then we need to pass a value for the fWlen that we defined within the run.cc file. The variable we pass is called wlen, which we now need to define. 
      	</p>
      	<br>
      	<p>
      	Wlen is calculated in our simulation from the momentum of the photon. This is achieved with a similar method to the posPhoton variable, using the preStepPoint function with the instruction to GetMomentum. With the momentum of the photon confirmed we can calculate the wavelength and store in the wlen variable. Note, the use of the command .mag in this calculation denotes the magnitude of the wlen vector, then the addition of the 1E+03 is used to convert the wavelength to nanometers. Be sure to include the G4SystemOfUnits.hh within the detector header file to ensure the eV value is accessable. At this point we can test our simulation to ensure it works. After running the simulation with several events, there should be two outputs within the output0.root file, the first titled fWlen should show results with an improved granularity, as it produces the physical position of the photons, when compared with the fEvent output, which plots the detectors that observe photon activity. Note, at this points, no results factor in our detector efficiency.
      	</p>
      	<br>
      	<p>
      	To begin working in our efficiency, we return to our detector.hh file, within the private section we used a pre-defined function called G4PhysicsOrderedFreeVector, this is used to define the variable quEff. Then, within the constructor of the detector.cc file, we define our quEff variable as a new G4PhysicsOrderedFreeVector. Be sure to include the G4PhysicsOrderedFreeVector.hh header file within the detector.hh file. Next we need to read in the data from our eff.dat file and place it in the new variable quEff. This is done within the header of our detector.cc file. This uses the standard, built in function within c++ ifstream, here we create datafile, open eff.dat, and read in the data from both columns using a while loop. The example given here reads the first variable into the wlen variable, then the second into queff. We also include the if statement at the end of our loop to ensure we break at the end of the data file. Lastly, to ensure the loop runs as planned we can read out the values to the terminal as they're being extracted. Further, within this loop we also need to fill the values of our quEff vector, for this we use the InsertValues function. The factor of 100 is introduced here to ensure we have values ranging between zero and one for the efficiency (converting from percentage to decimal). Once the contents of the loop is complete, be sure to close the datafile.
      	</p>
      	<br>
      	<p>
      	The last thing required is to include our detector output within the detector.cc file. We do this using an if statement surrounding the second Ntuple. The logic behind this, we create a random number between zero and one, then if the quEff value is smaller then this random number, it is stored within the Ntuple. All other values exceeding the quEff will be disgarded. With these steps complete, we can re-compile our code to test these new efficiencies. Success can be noted when comparing the results in the output0.root file (after generating some events). Principally, there should be a notable drop in the number of events observed when comparing the real world data (first Ntuple) with the results from the detectors (second Ntuple). Provided your simulation is working correctly, this should be the result. 
      	</p>
</article>

<?php
    include_once 'footer.php'
?> 