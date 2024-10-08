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
            <h1>Building a Cherenkov Detector in GEANT4</h1>  
        </header>
        <br>
        <h2>Initial Setup</h2>
        <br>
        <p>
        This page intends to detail the process of constructing a Cherenkov Detector and Particle Gun in Geant4, which will produce output files which can be analysed using the ROOT framework. Before begining this section, ensure you've completed the steps outlined in either the GEANT4 Installation page, or GEANT4 Multithreaded Installation page. From there, ensure you've referenced the appropriate version of your installation using the command at the bottom of the respective installation pages. The source code used throughout this project can be found on GitHub at <a href="https://github.com/Charlie-BrownGT/geant4-cherenkov-detector.git">Cherenkov Detector</a>.
        </p>
        <br>
        <p>
        To begin making a project, create a new directory from your landing directory named an appropriate title. Here, I've called mine geant4-cherenkov-detector. There are a number of different methods you can use to make your projects in GEANT4, here I'll use CMAKE. With this in mind, navigate into your project directory and create a file named 'CMakeLists.txt'. Within this file you'll need to specify the minimum cmake version required to comile your code, here I've specified version 2.6. Next you'll need to name the project, I've called mine 'cherenkov_detector'. Next you need to tell cmake to find GEANT4, this will use the package that you've referenced prevously (geant4make.sh) when compiling your project, and state that this is required. Within this command you also need to specify that you'll need user interface and visualisation options. You also need to add the 'include' files that come with GEANT4. Then you need to compile all the source and header files that you have in your project folder. You need to define the name of the executable for your project, this will provide the name of the programme which you will run when you run your programme, here mine is named 'sim'. You will also likely need to reference other libraries present in GEANT4 during your project, this is enabled with the 'target_link_libraries' command. Then lastly, you'll also need to add the target for your simulation. 
        </p>
        <br>
        <p>
        Next create a new file named something like 'sim.cc', which will provide the main body for your simulation. Pay particular attention here to the functionality that you include within your headers. Once the base  is setup, the next, and likely most important step, is to create the G4RunManager, this is effectively the heart of your Geant4 instance. To achieve this, you'll need to initialize several managers, principally G4UIManager, G4VisManager and G4UIExecutive. Once created you will also need to initialize your G4visManager and start your UI session. With the elements of your sim.cc file complete you can create a new directory in your project file, I've named mine 'build'. Moving into your new directory you can add and compile your work so far using the 'cmake ..' and 'make' command. Once these are complete you can run your project using the './sim' command from the terminal. This should launch a blank GEANT4 terminal without any content.
        </p>
        <br>
        <h2>Detector Construction</h2>
        <br>
        <p>
        To begin building a detector, the construction will need to pull on several other classes of the GEANT4 package. As such, it's recommended that these elements are stored in a seperate set of files named 'construction.cc' and 'construction.hh'. This construction is named 'MyDetectorConstruction', but could equally be named anything. This class should remain public and inherits from the 'G4UserDetectorConstruction' class. Here it also includes both constructor and destructor, these will become increasingly common throughout the project in the different '.cc' and '.hh' files. The most important part of this class remains the 'G4VPhysicalVolume' element as this will be where the final detector volume is contructed from. This is a virtual function as it's otherwise defined in the overall G4UserDetectorConstruction class. 
        </p>
        <br>
        <p>
        The 'contruction.cc' file begins by including the 'consturction.hh' file, again this will prove common throughout, then moves to define both the constructor and destructor. The next step is to formally outline the role of the new G4VPhysicalVolume function. This begins by defining the materials that will be used within the detector. Rather then defnining all materials from scratch, you can use the pre-defined materials within GEANT4 by calling on the G4NistManager tool. In this example, the variable 'worldMat' has been defined, then filled with the material titled 'G4_AIR'. Next the world volume needs to be defined, this is the space in which all results will be returned. In this example the 'G4Box' function in used to created a simple box. Every volume that you create in GEANT4 needs to contain three parts, the solid volume - defining the size, the logical volume - defining the material and the physical volume - which places the volume within the simulation and applies any translation or movement. 
        </p>
        <br>
        <p>
        Each of these volumes will take different variables during their definition, the examples used here aim to keep the definitions as simple as possible. It should be noted, the standard units of measurement within GEANT4 can vary, so it is useful to specify exactly which units you're using. Here the units of measurement can come predefined in the 'G4SystemOfUnits' package, included in the header file. Once the G4Box and G4_AIR pieces are defined, you need to instruct GEANT4 to place the material inside the box - this is done by defining the logical volume. Thirdly, you need to define the physical volume, this uses the class 'G4PVPlacement'. The arguments included here are rotation, central point (via G4ThreeVector), logical volume, name, whether this volume should be placed in another mother volume, any boolean operation, copy number of logical volume and whether the function should check for overlaps. Once these volumes are defined you can return the highest level mother volume - in this case 'physWorld'.
        </p>
        <br>
        <p>
        With these steps in place we can tell GEANT4 to use the geometry that we've just created. This is done in the sim.cc file via the run manager. A point here, be sure to include all the relevant header files to allow your programme to call the respective parts of GEANT4. 
        </p>
        <br>
        <h2>Implementing a Physics List</h2>
        <br>
        <p>
        The Physics List is used to determine how a particle interacts with the detector construction. This is required before any simulations can run. The Physics List is implemented by creating a new class, in this case called 'MyPhysicsList', this inherits from the class 'G4VModularPhysicsList'. With this in mind, we begin by creating two new files 'physics.cc' and 'physics.hh'. Both files here include the standard definitions including constructor, destructor, public inheritence, then the body of the definition sits in the 'MyPhysicsList.cc' file. 
        </p>
        <br>
        <p>
        Within the 'physics.cc' file, you begin by implementing the required physics for the simulation that you're running. In this case, noting that we're making a Cherenkov Detector, we need the standard EM physics and optical physics list, although there are others that are pre-defined within the GEANT4 package. The different types of physics will also need to be included within the header file. With these steps complete, you need to define your Physics List within the main 'sim.cc' file to ensure it's included within the simulation. You also need to initialize the Physics List, in the same manner that the construction was initialized. 
        </p>
        <br>
        <p>
        With these steps complete, the final step required to produce a visual output is to direct GEANT4 to display. This is achieved by using the previously defined UIManager and applying the command "/vis/open OGL" within the 'sim.cc' folder and telling GEANT4 to draw the volume using the "/vis/drawVolume" command. When re-compiled and executed, this should produce a visual representation of your detector box. You can also use the "/vis/viewer/set/viewpointVector 1 1 1" command (via UIManager) to set the default view point that the simulation will launch from. 
        </p>
        <br>
        <h2>Creating a Particle Gun</h2>
        <br>
        <p>
        There are two more classes required to implement a particle gun within a GEANT4 simulation, these are the action initialization which deals with the computation and the actual particle gun action which generates the particles that you wish to use. To begin, we create two fileds named 'action.cc' and 'action.hh' within the project folder. 
        </p>
        <br>
        <p>
        Begining with 'action.hh', this is defined in a similar manner to the other header files, then includes a reference to the public GEANT4 class 'G4VUserActionInitialization.hh'. Moving to define the class and state the public inheritance, then ensure you've defined the constructor and destructor in the usual manner. With these steps complete you can move to define the actual function that you're using. This remains a virtual function and is pulled from the G4VUserActionInitialization class, and is called build. This build function is used to run the particle gun and computes the required stepping. 
        </p>
        <br>
        <p>
        Moving to the 'action.cc' file, begin by including the 'action.hh' header and defining the constructor and destructor. From there you can build out the virtual function defined within the header file. You can test the work upto this point by including the details within the 'sim.cc' file, here you will need to add the header file and create another 'runManager->SetUserInitialization' command, here specifying 'MyActionInitialization'. This test can be completed using the cmake and make commands previously mentioned. 
        </p>
        <br>
        <p>
        With this test complete, you can return to creating the particle gun. This requires creation of two additional files, 'generator.cc' and 'generator.hh'. The header file is defined in a very similar manner to 'action.hh' but inherits from a different public class, 'G4VUserPrimaryGeneratorAction', then includes the name 'MyPrimaryGenerator' within the class name, constructor and destructor. Then the virtual function is named 'GeneratePrimaries'. One difference, when defining the class, an argument needs to be passed to the class named 'G4Event*', then you need to define the actual particle gun. This is built as a private function and is called 'G4ParticleGun', then the gun itself is called '*fParticleGun'. At this point, be sure to include the appropriate headers files. With these steps complete we can turn to our 'generator.cc' file. 
        </p>
        <br>
        <p>
        Within the constructor of the 'action.cc' file you begin by defining the particle gun. Within the definition, the new fParticleGun will require and argument, this is defning the number of particles per event. It should be noted, within GEANT4 it's usual to have one run, then each run can contain several events, each event can contain several particles. For simplicity, here each event will have one particle per event, events can be combined in the future if more particles or different runs are required. Point to note, it is also good practice to delete the fParticleGun within the destructor. Next we turn to the function MyPrimaryGenerator::GeneratePrimaries. This function takes the class 'G4Event' and serves as an input parameter for the function. 
        </p>
        <br>
        <p>
        Within the function we need to define the type of particles we wish to use. We start this process using the 'G4ParticleTable' class. The G4ParticleTable defines all the information on the particle types, much in the same way that the Nist function included the detail on the materials. Here we want to use this function to find a proton. We achieve this by defining the name of the particle "proton", then looking for it within the particle table. Here we've then copied all the relevant information on the particle and stored it in the variable '*particle'. Next we need to define the particle's starting position and momentum. Each of these are created using the G4ThreeVector class previously mentioned. In this example, the particle is created at the origin and has one unit of momentum on the z-direction. Using these definitions we can use the fParticleGun, created earlier, to define the gun's actual properties.These are passed to the particle gun as variables with arguments. Lastly we need to tell GEANT4 to generate primary vertex then feed the argument 'anEvent'.
        </p>
        <br>
        <p>
        From there, we return to our action header and include the generator header file. Once complete, moving back to our 'action.cc' file include the detail on 'MyPrimaryGenerator', here we are defining the new generator and setting the user action. At this point you can test the simlulation again. When you run the programme you will ee an output to the terminal but no visualization on screen. This is because we need to tell GEANT4 to draw the result.
        </p>
        <br>
        <p>
        To ask GEANT4 to draw particle paths, we go back to our sim.cc file and use the UIManager to apply command '/vis/scene/add/trajectories smooth'. Here we've also added some other commands to update each time an event is created. When re-compiled, this should allow for a visual output (blue line representing a proton) within the detector construction. Any red lines observed represent electron that are produced from the proton interaction with the air molecules.
        </p>
        <br>
        <h2>Adding Detector Volume</h2>
        <br>
        <p>
        Here we will concentrate on building a ridge detector for our existing setup. This contains a thin radiator made of an aerogel, then a series of photosensors that will log hits, which can be used for subsequent analysis. To begin, we return to our detector construction file - 'construction.cc'. The first thing to do within this file is to define our material that we wish to use for the aerogel. 
        </p>
        <br>
        <p>
        This aerogel will consist of silicon dioxide, water and carbon. This component is defined using the 'G4Material' function. The arguments taken in this material definition are the name, density and number of components. From there we move to define the actual material used. This is done using the previously defined nist function, then looks for the element, and defines the number of times it should be included in our material, in this case once for silicon, as there's only one silicon atom in SiO2. We then repeat this process for the O2 molicule. We then return to our build folder and recompile our code to ensure it works. We then run through a similar process for defining water, H2O. Our last element that's missing in the element definition for carbon. This is done using the G4Element function.
        </p>
        <br>
        <p>
        With these definitions confirmed we can build our aerogel material. This begins by defining the material name - aerogel, then adding the materials/elements that are used. Note, this step also includes the percentage part that each of each material within our overall aerogel material. Once these materials are included, it is worth recompiling the code to ensure there's no errors. With these steps complete we move to make the physical radiator itself, so we can see it in the physical world that we've created. 
        </p>
        <br>
        <p>
        We begin this process using a box again, note the dimensions of the box created need to be smaller then the overall volume size. The dimension in z should be significantly smaller as we want to create a notable ring once the detector is fully working. A point to note, this new volume is defined in the same manner previously mentioned - using a solid volume, logical volume then physical volume. Also, the physical radiator is a daughter volume of the overall mother volume, as such, within the arguments for the physRadiator 'logicWorld' should be included. Once complete, the simulation should run again with the aerogel surface present.
        </p>
        <br>
        <p>
        When the simulation runs, there's no cherenkov effect initiated as we need to include some extra physical details within our constructor. The particles that we generate need to travel faster then the speed of light within the aerogel surface (which they do for 100GeV protons), but we need to add the refractive index for the aerogel. This requires the cherenkov angle. We will action this by including some arrays titled 'energy'. To produce these values we need to calculate the momentum of the photons (which is not trivial), but we will include a conversion from the photon wavelength, into energy (in eV), then converts to the final value - energy. Once these values are defined we can move to the refractive index of the aerogel. In this example we've stated that the index remains the same for different light wavelengths (discounting dispersion), but for the sake of this example we shall proceed.
        </p>
        <br>
        <p>
        To add this refractive index to our material we need to create a new G4PropertiesTable called *mptAerogel. The arguments passed to this materials property table are RINDEX - denoting that it's a refractive index, energy, refractive index and the number of values. With this properties table defined we can add this to our aerogel using the 'SetMaterialPropertiesTable' command. To see photons propagating through the remainder of the detector volume, we also need to define the refractive index of the world volume (G4_AIR), we approach this problem with a similar method. With these elements complete you can accumulate multiple particles from several runs visually by adding the UImanager command '/vis/scene/endOfEventAction accumulate'. With these steps complete, you should be able to run a simulation that produces cherenkov light when the incident proton passes through the radiator volume.
        </p>
        <br>
        <h2>Adding Photosensors</h2>
        <br>
        <p>
        To being creating a detector we need to create the detector volumes, this will begin in the 'construction.cc' and 'construction.hh' files. Here we aim to create an array of 100*100 sensors, which will be able to detect the location of incident radiation. First we define what each sensor looks like using the G4Box class, each will be called solidDetector. Note, the arguments passed to this definition represent the half width of each detector, in this case 0.005m (5mm), the full width will be 1cm per detector and will fill the entire mother volume. Next we need to define our logical volume, however the sensitive detector that we will define late will need to refer to this. As a result, we need to access our logical detector outside of our construction volume. To work around this problem, we define our logical volume in the overall class definition (within the header file). Once complete, we can define logicDetector within the consturction in the normal manner.
        </p>
        <br>
        <p>
        To create the physical instances of our detectors we use two for loops to lay out each sensor. Aside from the loops, this definition process remains similar to those covered previously. The contents of the loops included in this example is derived geometrically, ensuring all elements of the detector volumes fall within the mother volume. Lastly, it's worth noting that we need to define the index of each detector within this definition, this needs to remain a function of the indicies that are being used in the overall definition, this ensures we have a seperate definition for each detector cell. With these steps complete, we can re-compile and test the code to ensure the simulation works. As an interest piece, the terminal readout whilst running the simulation comes from the function definition to check for overlaps, if you wish to turn this off it can be change within the physDetector arguments.
        </p>
        <br>
        <p>
        At this point, the simulation can run and produce cherenkov light, but the positions of the light detected has not been stored. To store these values we need to create a new class called 'detector.hh' and 'detector.cc'. Each of these begin with the usual definition steps. The detector class is named MySensitiveDetector and is derived from the public GEANT4 class G4VSensitiveDetector. One point to note, the constructor and destructor definitions include the argument G4String, the reasoning for this will be explained in the following steps. Once the header is setup we need to add one function to the header called ProcessHits (this is used to complete the detection). The arguments passed to this function are named G4Step and G4TouchableHistory. 
        </p>
        <br>
        <p>
        Moving to 'detector.cc', this also begins with the usual setup including both constructor and destructor. Then we move to define out ProcessHits function. Our arguments here are named aStep and ROhist. Note, within the arguments for the constructor you also need to reference the class from which we're inhereting and provide the name of our detector. Moving back to our construction we define another function in the header file, this is called ConstructSDandField. Lastly, ensure you include the detector header file within the construction header file. 
        </p>
        <br>
        <p>
        Moving back to the actual detector construction we can begin to define the it's output. After defining our detector and calling it sensDet we can tell our logicDetector that this is the actual detector. With these steps complete, the simulationcan be tested again but this still shouldn't give any detail on the results as we've not asked the detector to produce anything. This is what we will do next.
        </p>
        <br>
        <p>
        Moving back to 'detector.cc', first we need to access the track of the particle, we do this by pulling from the G4Track class and defining our variable 'track', this uses the aStep argument from earlier. We can also access the particle start and end points using the G4StepPoints class and defining each into a seperate variable, here called preStepPoint and postStepPoint. These denote the positiion when the particle enters and leaves the detector respectively. We can also get direct access to the position of the photon by defining the G4ThreeVector posPhoton and using the same preStepPoint function to find it. With these steps complete, you can output the position using the command G4cout, this will print all of the photon positions to the terminal. 
        </p>
        <br>
        <p>
        To avoid detection of photons that enter different detector volumes from the side, you can add the SetTrackStatus command to the detector construction. This will ensure that each photon will only be detected by a single detector volume - it will not propagate any further. This will also ensure the photons are detected on the immediate incident surface. In reality we do not have access to the position of the photon exactly, we would need to reconstruct the path from the cherenkov angle. As such, we can get access to our detector position by using the G4VTouchable argument defined earlier. The copyNo variable is used here to identify the individual detector where the photons are incident. The example here provides an option to output this copy number to the terminal. Alternatively if you want to know the position of your detector you can use the variable defined in this example as physVol. These three options give several methods to achieve similar information, the first one remains unphysical, however the second two are practically applicable. 
        </p>
    </article>
<?php
    include_once 'footer.php'
?> 