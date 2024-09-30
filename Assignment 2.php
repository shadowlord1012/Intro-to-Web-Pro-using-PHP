<?php
/*  Mike Kipp
    Student # 200609745
    09/30/2024
    6:53pm
*/

//The opening Statement
echo "Welcome to the job eligible questioner.\n";

//Defines what the eligible for the job is
$eligibleInformation = array("cp", "4", "2022", "php");

//Makes a empty array for the user input
$userInformationInput = array("","","","");

//All the user input for the array (strtolower - makes the users input to all lower case characters)
$userInformationInput[0] = strtolower(readline('Enter your two letter diploma Code: '));
$userInformationInput[1] = readline('Enter your years of experience: ');
$userInformationInput[2] = readline('Enter Your Graduation date: ');
$userInformationInput[3] = strtolower(readline('Enter Your skill need for the job '));

//The final checking array
$areYouTheOne = array(false, false, false, false);

//The Loop to check all the user input to the eligible
for ($counter = 0; $counter < count($eligibleInformation); $counter++) {
    //Do the values match
    if($eligibleInformation[$counter] == $userInformationInput[$counter])
        $areYouTheOne[$counter] = true;
}

//The final check of eligibility
if($areYouTheOne[0] and $areYouTheOne[1] and $areYouTheOne[2] and $areYouTheOne[3])
    //if you are the one
    echo "You are eligible for the job, your interview is in 1 week";
else
    //if you are not the one
    echo "We are sorry, we moved on with other candidates.";

?>