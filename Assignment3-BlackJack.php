<?php
/**
 * Mike Kipp
 * Student # 200609745
 * 11/18/2024
**/
//The array of cards by suits and values
$suitNames = array("Spades","Hearts","Clubs","Diamonds");
$cardValues = array("2","3","4","5","6","7","8","9","10","J","Q","K","A");
//empty arrays to be used later
$cardsOnTable = array();
$dealersCards = array();
$playersCards = array();
$money = array(0,0,0); // Amount bet, amount have
$isGameOver = false;
$isDealerDone = false;
$isDealerTurn = false;
$isFirstBet = false;
//returns true if card is in play
function CardsInPlay($cardToPlay){

    global $cardsOnTable;

    //Goes through all the cards on the table and checks
    foreach($cardsOnTable as $card){
        if($card == $cardToPlay){
            return true;
        }
    }
    return false;
}

//The play card function
function playCard($isPlayer)
{
    global $cardsOnTable;
    global $playersCards;
    global $dealersCards;
    global $suitNames;
    global $cardValues;
    global $isDealerDone;

    //Random Card
    $cardSuit = $suitNames[array_rand($suitNames)];
    $cardValue = $cardValues[array_rand($cardValues)];
    $card = array($cardSuit,$cardValue);

    //gets new card if the cards already on the table
    while (CardsInPlay($card)){
        global $card;
        //Random Card
        $cardSuit = $suitNames[array_rand($suitNames)];
        $cardValue = $cardValues[array_rand($cardValues)];
        $card = array($cardSuit,$cardValue);
    }

    //adds the card to the cards played on the table
    $cardsOnTable[] = $card;

    //sets the card to the correct person
    if($isPlayer)
    {
        $playersCards[]=$card;
    }
    else{
        $currentAmountForDealer = 0;
        foreach ($dealersCards as $card) {
            if ($card[1] == 'J' || $card[1] == 'Q' || $card[1] == 'K') {
                $currentAmountForDealer += 10;
            } elseif ($card[1] == 'A') {
                $currentAmountForDealer += 11;
            } else {
                $currentAmountForDealer += $card[1];
            }
        }
        if($currentAmountForDealer <= 17)
        {
            $dealersCards[]=$card;
        }
        else{
            $isDealerDone = true;
        }

    }
}

function whoWon()
{
    global $dealersCards;
    global $playersCards;
    global $money;
    global $isDealerTurn;
    global $isDealerDone;

    $playerAmount = 0;
    $dealerAmount = 0;

    foreach ($playersCards as $card) {
        if ($card[1] == 'J' || $card[1] == 'Q' || $card[1] == 'K') {
            $playerAmount += 10;
        } elseif ($card[1] == 'A') {
            $playerAmount += 11;
        } else {
            $playerAmount += $card[1];
        }
    }
    foreach ($dealersCards as $card) {
        if ($card[1] == 'J' || $card[1] == 'Q' || $card[1] == 'K') {
            $dealerAmount += 10;
        } elseif ($card[1] == 'A') {
            $dealerAmount += 11;
        } else {
            $dealerAmount += $card[1];
        }
    }

    if($playerAmount > $dealerAmount)
    {
        echo "You Beat Dealer!";
        $money[0] += $money[2];
    }
    else {
        echo "You lose to dealer";
    }

    $isDealerTurn = false;
    $isDealerDone = false;

}

function isOver($isPlayer){

    global $playersCards;
    global $dealersCards;
    global $money;

    $amountCurrent = 0;
    $amountToNotGoOver = 21;
    if($isPlayer) {
        foreach ($playersCards as $card) {
            if ($card[1] == 'J' || $card[1] == 'Q' || $card[1] == 'K') {
                $amountCurrent += 10;
            } elseif ($card[1] == 'A') {
                $amountCurrent += 11;
            } else {
                $amountCurrent += $card[1];
            }
        }
        if($amountCurrent > $amountToNotGoOver){
            echo "\nYou went over you lost bet";
            return true;
        }
        return false;
    }
    else{
        foreach ($dealersCards as $card) {
            if ($card[1] == 'J' || $card[1] == 'Q' || $card[1] == 'K') {
                $amountCurrent += 10;
            } elseif ($card[1] == 'A') {
                $amountCurrent += 11;
            } else {
                $amountCurrent += $card[1];
            }
        }
        if($amountCurrent > $amountToNotGoOver){
            echo "\nDealer Lost";
            $money[0] += $money[2];
            return true;
        }
        return false;
    }
}
//The Amount the user wants to bring to the table
function amountToTable()
{
    global $money;
    //reads in the users input
    $userInput = intval(readline("Enter amount your bringing to the table? "));

    //Keeps asking for a value that is greater then one
    while($userInput < 1){
        $userInput =intval(readline("Enter amount your bringing to the table? "));
    }

    //adds it to the bank he has
    $money[0] = $userInput;

    //debugging
    echo "$money[0] brought to table";
}

//checks to make sure there is enough left to bet
function isAmountEnough($amount)
{
    global $money;
    //checks to make sure you have enough to bet
    if($amount > $money[0]){
        return false;
    }
    return true;

}

//The function that handles all the betting amounts
function betting()
{
    global $money;

    //gets an input that should be a in value
    $userInput = intval(readline("\nEnter amount your want to bet? "));

    //will ask for a new value if an integer value is not entered
    while($userInput < 1){
        $userInput =intval(readline("\nEnter amount your want to bet? "));
    }

    //makes sure the is enough
    if(!isAmountEnough($userInput)){
        return 1;
    }

    //subtracts from the amount the users has
    $money[0] -= $userInput;
    //adds to the running total of bets
    $money[1] += $userInput;
    $money[2] = $userInput;

    return 0;
}

//The function that handles the first two cards being played for both dealer and player
function firstTwoCards(){

    global $playersCards;
    global $isFirstBet;

    $isFirstBet = true;

    playCard(true);
    playCard(false);
    playCard(true);
    playCard(false);
    foreach ($playersCards as $card2) {
        echo "\n$card2[0] value: $card2[1]";
    }
}

function playerInput()
{
    global $isDealerTurn;

    if(!$isDealerTurn) {
        $userInput = strtolower(readline("\nDo you want to hit or pass? (y/n):"));
        if ($userInput == "y") {
            echo "\nhit";
            $isDealerTurn = false;
        }
        else {
            echo "\npass";
            $isDealerTurn = true;
        }
    }
}
//The main play game function
function playGame(){

    global $money;
    global $isGameOver;
    global $isDealerTurn;
    global $playersCards;
    global $dealersCards;
    global $isFirstBet;

    $userInput = "y";

    amountToTable();
    //the game will keep playing until the user exits or is out of money
    while(!$isGameOver) {

        //continues until an amount is entered
        while (betting() > 0 && !$isFirstBet) {
            echo "\nTry a different Amount";
        }

        //The first two cards each
        if(!$isFirstBet) {
            firstTwoCards();
        }

        playerInput();

        //for the players hand
        if(!$isDealerTurn){
            playCard(true);
            if(isOver(true))
            {
                $userInput = strtolower(readline("\nContinue? (Y\N)"));
            }
        }
        //Will continue to run until the dealer is done
        while($isDealerTurn && !isOver(true)){
            playCard(false);
            if(isOver(false))
            {
                whoWon();
                $userInput = strtolower(readline("\nContinue? (Y\N)"));
            }
            else
            {
                whoWon();
                $userInput = strtolower(readline("\nContinue? (Y\N)"));
            }
        }

        echo "\nmoney: $money[0]\n";

        if($money[0] <= 0 || $userInput == "n") {
            $isGameOver = true;
            echo "Game Over";
        }
        else {
            $playersCards = array();
            $dealersCards = array();
            $isDealerTurn = false;
            $isFirstBet = false;
        }
    }
}

playGame();

echo "\nDid you have fun?";