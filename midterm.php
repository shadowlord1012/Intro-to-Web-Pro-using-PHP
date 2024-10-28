<?php
/*  Mike Kipp
    Student # 200609745
    10/28/2024
    6:08Pm
 * */

/*  Question #1
Write a function named abs_val that returns the absolute value of an int
passed to it by value. You cannot use the abs() function library
*/

//Returns the absolute value of an int only
function abs_val($integerValue)
{
    //Makes sure that the value is int only convert
    if(intval($integerValue) < 0)
        return intval($integerValue * -1);
    else
        return intval($integerValue);
}


/*  Question # 2
Write a rangeSum Function which
    - Prompt the use for two positive integers a and b. (ask for input)
    - Write a separate function, rangeSum to compute the sum of the
      consecutive integers from a to b inclusive ( that includes both
      a and b).
    - the rangeSum function should only calculate the sum. It should print
      a, b, and sum.
    - Example: a = 5, b = 7. Output is a is 5, b is 7, sum is 18.
 * */


function rangeSum($valueOne, $valueTwo)
{
    //Placeholder for sum
    $sum = 0;
    /*Sets the count to the first value.
      will continue to add until the counter is at the last value
      includes both the first and last value
    */
    for($counter = $valueOne; $counter <= $valueTwo; $counter++)
    {
        $sum += $counter;
    }
    return 'The Output is as follows: a is ' . $valueOne . ', b is ' . $valueTwo . ', sum is ' . $sum;
}

//Prompts user for input and casts to an int to be used in the rangeSum function
$a = intval(readline('Enter a positive integer value: '));
$b = intval(readline('Enter another positive integer value: '));
echo (rangeSum($a, $b));

/*  Question # 3 (Short answers and theoretical questions

    a) What initial value should b assigned to b at line 6 so that the output of this program is 10

<?php

$sum= 0; $n=1;
$b;

// b =??;
while($n<$b)
{
    $sum += $n;
    $n += 1;
}

echo $sum;

?>

    Answer: b = 5

    b) What is the function prototype to declare a reference to the int "numPlayers"?

    Answer:  function numPlayers() : int

    c) What is the purpose of reference in PHP and when would you use it?

    Answer: The purpose of references in PHP is to access the same variable content but by different names.
            Example: $numPlayer = & $totalNumPlayers;

    d) What is the difference between an Array and List?

    Answer: The Main difference between an array and a list is:
            - A list contains multiple objects as different data types Example a list can contain multiply arrays
            - An array contains only one type Example: int array contains only integers or string array only contains strings

    e) What type of programming language is PHP. What is the difference between a server-side language and a
       client-side language?

    Answer: PHP is a serve-side programming language. The main difference between a server-side and a
            client-side language is a server-side language handles all the information behind what a user can see.
            Where a client-side language deals with what the user sees directly. Example would be entering your bank
            information onto a banking application (Client-side can be HTML or C) and having the application retrieve
            your information from a database at your bank ( PHP or mySQL).
*/


