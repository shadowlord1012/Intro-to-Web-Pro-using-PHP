<?php

//include the database connect
include 'db_connect.php';

//Variables
global $userName;
global $dbName;
$rootUsers = array("root","mike");
$readOnlyUsers = array("readOnly","");
$isRootUser = false;
$isReadOnlyUser = false;

//A simplified list of help commands
function commandList(){
    global $dbName;
    echo "Database name: " . $dbName . "\n";
    echo "Create table: CT";
    echo "Insert table information: IT";
    echo "Select information of table: ST";
    echo "Delete information of table: DT";
    echo "Alter the table itself: AT";
    echo "Drop the table: TD";
    echo "Rename the table: RT";
    echo "exit program: exit";
}

//everythin the root user can use
function rootPrivileges(){
    global $isRootUser;
    if($isRootUser){
        $userExit = "";
        while ($userExit != "exit"){
            $userInput = readline("What would you like to do? type h for help: ");
            if($userInput == "h")
            {
                echo "Here is the list of commands you can do";
                commandList();
            }
            else {
                switch ($userInput) {
                    case "CT":
                        createTable();
                        break;
                    case "ST":
                        selectInformationFromTable();
                        break;
                    case "DT":
                        deleteInformationFromTable();
                        break;
                    case "AT":
                        alterInformationFromTable();
                        break;
                    case "TD";
                        dropTableFromDatabase();
                        break;
                    case "RT":
                        renamingTable();
                        break;
                    default:
                        echo "Invalid command input: $userInput";
                }
            }
        }
    }
}

//for the ones that dont have the access to root
function readOnlyPrivileges(){
    global $isReadOnlyUser;
    if($isReadOnlyUser){
        //Sets the inital value for the user input to start the loop
        $userInput= "";
        while($userInput != "exit"){
            //Displays the warning information
            echo "WARNING!";
            echo "You only have the ability to retrieve information";
            //Gets the users input and sends it to the select information function only
            $userInput = readline("To Exit Type exit");
            if($userInput != "exit"){
                selectInformationFromTable();
            }

        }
    }
}

//renaming the table
function renamingTable(){
    //Needs the connection var from the db_connect.php
    global $conn;

    //Askes the user for the table they want to rename
    $tableName = readline("What table would you like to rename? \n");

    //What is the newname
    $newTableName = readline("What would you like to rename the table to? \n");

    //Sends the query to the database and returns true if it's valid
    if($conn->query("RENAME TABLE $tableName TO $newTableName;")){
        echo "Table renaming complete";
    }
    //if false return the error message from the database
    else{
        echo "error renaming table: ".$conn->error."\n";
    }
}

//Drops a table from the database
function dropTableFromDatabase(){
    //Needs the connection var from the db_connect.php
    global $conn;

    //Which table do you want to drop
    $tableName = readline("Which table do you want to drop from the database? \n");

    //if the query returns true display the following
    if($conn->query("DROP TABLE IF EXISTS $tableName;") === TRUE){
        echo "Table $tableName has been droped from database\n";
    }
    //if false return the error message
    else {
        echo "Error: " . $conn->error . "\n";
    }
}


function alterInformationFromTable(){
    //Asks the user for the sql query for altering table data
    $query = readline("Enter in SQL query to alter table");
    //Regexs the query to make sure the user has entered in the correct SQL start
    if(preg_match("^ALTER", $query) == 1) {
        if (sqlQuery($query)) {
            echo "Table altered successfully";
        }
    }
    else{
        echo "Invalid SQL query for altering table information: $query";
    }
}


//Delete information in table
function deleteInformationFromTable(){
    //Asks the user for a sql query
    $query = readline("Enter in SQL query for delete \n");
    //Makes sure the user is asking for a DELETE query
    if(preg_match("^DELETE", $query) == 1) {
        if (sqlQuery($query)) {
            echo "Entry deleted";
        }
    }
    else{
        echo "Invalid SQL query for Deleting table information: $query";
    }
}

//Select information in function
function selectInformationFromTable(){
    //Need the Connection var from the dp_connect.php
    global $conn;

    //Asks te user for a SELECT query for SQL
    $query = readLine("Enter in SQL query for select:\n");
    if(preg_match("^SELECT", $query) == 1) {
        //Sends the query to the database
        if (sqlQuery($query)) {
            //Gets the results of the query in an array format
            $result = $conn->query($query);

            //Makes sure there are any values in the results array
            if ($result->num_rows > 0) {
                //goes through all the rows of the query
                while ($row = $result->fetch_assoc()) {
                    //display all values in the row
                    foreach ($row as $key => $value) {
                        echo $key . ": " . $value . "\n";
                    }
                }
            } else {
                echo "No results found";
            }
        }
    }
    else{
        echo "Invalid SQL query for selecting table information: $query";
    }
}

//Create table function
function createTable(){
    //Asks the user for a SQL query for creating tables
    $query = readline("Enter in SQL query to create a new table\n");
    //Did the start te query with a create table
    if(preg_match("^CREATE TABLE", $query) == 1) {
        if (sqlQuery($query)) {
            echo "Table created\n";
        }
    }
    else{
        echo "Invalid SQL query for creating table information: $query";
    }
}

//The Main query function
function sqlQuery($query){
    //Needs the database from the db_connect.php
    global $conn;
    //Attempts to do the query. if valid return true
    if($conn->query($query) === TRUE){
        return true;
    }
    //If false return the error message
    else{
        echo "Error: " . $query . "<br>" . $conn->error;
        return false;
    }
}

//Main program start

//Sets whether the user can change all information or only retrieve information
foreach($rootUsers as $rootUser){
    //Is the user a root user
    if($rootUser == $userName){
        //Sets te rootUser boolean to true
        $isRootUser = true;
        $isReadOnlyUser = false;
        echo "Full access";
    }
}

//If the username is only able to retrieve information from the database
foreach ($readOnlyUsers as $readOnlyUser) {
    if ($readOnlyUsers == $userName) {
        echo "Read-only access";
        $isRootUser = false;
        $isReadOnlyUser = true;
    }
}

//checks where the user is to go
if($isRootUser && !$isReadOnlyUser){
    rootPrivileges();
}
else if($isReadOnlyUser && !$isRootUser){
    readOnlyPrivileges();
}
//if there is no information on the user in the system
else
{
    echo "invalid information. program closing";
}




