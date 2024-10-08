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
            <h1>Radioactive Decays</h1>  
        </header>
        <br>
        <p>
        The purpose of this section is to detail how you can simulate radioactive decays, then add a scintillator material to help observe the result. This will also provide detail on how to read out the energy desposition of resultant particles, without the requirement to produce scintillation light. 
        </p>
        <br>
        <p>
        To begin, we need to make some changes to our physics list. As such, we return to our physics.cc and physics.hh files. Within the physics.cc file, we now need to register some additional physics lists, these are G4DecayPhysics and G4RadioactiveDecayPhysics. With these elements added, be sure to add the required header files to the physics.hh file. 
        </p>
        <br>
        <p>
        In the next step, we look to add a cobalt source to the primary generator within our detector so will return to our generator.cc and generator.hh files. Where previously we defined protons within the generator constructor we now replace the proton definition with chargedgeantino. For reference, this serves as a blank particle in Geant4 without any values. These values can be assigned later. Here we will also set the particle momentum to zero. This particle can be changed later through a macro file, this would allow for multiple different particle to be run through the same simulation. Next we need to take the radioactive decay of cobalt into account.
        </p>
        <br>
        <p>
        To achieve this, we move to our GeneratePrimaries function and create a G4ParticleDefinition. Once outlined, we can create an if condition, if the particle definition is a ChargedGeantino, we can create the remaining particle properties. Note, these particle properties include the number of protons, the total number of nucleons, energy and charge. The units for the charge and energy are eplus and keV respectively. We also need to create an ion table, which will pull the required physics from the previously defined values for protons, nucleons, etc. With these elements completed, we can set out particle definition, similar to how we did in the constructor, to take these new values. Before testing, it is worth noting, the headers for G4ChargedGeantino and G4IonTable will need to be included in the Generator.hh header file. At this point, you should be able to run and test your simulation. 
        </p>
    </article>
<?php
    include_once 'footer.php'
?> 