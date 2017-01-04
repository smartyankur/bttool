<?php
/****************************************************
// Dodo's Quiz Script
// Copyrighted by Ying Zhang
// http://regretless.com/scripts
// No redistribution without authorization
// Script released under linkware
// that means LINK ME if you use it for your website
/****************************************************/

/********************************************************************************
Remember if you name this file quiz_1.php it will be quiz no. 1!
You will have to call this script by using
quiz.php?n=1
*********************************************************************************/
// Would you like to get get an email when someone takes this particular quiz?
$email_notify = 0;  // 1 = yes 0 = no
// if so
$admin_email = "you@domain.com";

// Your quiz question:
$quiz_question = "Are you the one for Dodo?";

// What you want your submit button to say?
$submit_button = "Are you the one?";

// Your quiz description:
$quiz_description = "This is a quiz that finds out your compatibility with Dodo ;) Have fun!";

// Do you want to make sure that all of your questions are answered before the results are calculated?
$all_questions_answer = 1; // 1 = yes 0 = no

// Now for each result, give it a description. Please make sure you put \ in front your quotations or you will get parse error!
// Put them as the result name => result description
// For example: "not_the_one" => "You are definitely not the one for Dodo. Too bad :(";
// WARNING: it's always possible to get the same two results so watch the order of these.
$results_array = array(
1 => "<div class=\"header\">Somewhat Close</div><div class=\"just\">You are somewhat close. You are probaby a very good friend. <br /><br />Add more your description here. blah blab blah blah blab blah blah blab blah blah blab blah blah blab blah blah blab blah blah blab blah blah blab blah blah blab blah blah blab blah blah blab blah </div>",
2 => "<div class=\"header\">THE ONE</div><div class=\"just\">You are THE ONE! WOW.. you are my soulmate! <br /><br />Add more your description here. blah blab blah blah blab blah blah blab blah blah blab blah blah blab blah blah blab blah blah blab blah blah blab blah blah blab blah blah blab blah blah blab blah </div>",
3 => "<div class=\"header\">EEK...</div><div class=\"just\">You are definitely not the one for me. Too bad :(<br /><br /> Add more your description here. blah blab blah blah blab blah blah blab blah blah blab blah blah blab blah blah blab blah blah blab blah blah blab blah blah blab blah blah blab blah blah blab blah </div>",
);

// Now your questions
$questions_array = array(
1=> "What color does dodo like?",
2=> "What season does dodo like?",
);

// your answers. MAKE SURE it's the same order as the questions. also gives which of the results is the answer corresponding to separated by the symbol |. One unique answer per line!

$answers_array = array(
1=> "Blue|3
Red|3
Pink|1
Black|3
Rainbow|2",
// above will print as answers
// 1. Blue (this corresponds to not the one)
// 2. Red (not the one)
// 3. Pink (sorta)
// 4. Rainbow (the one)
2=> "Spring|1
Summer|3
Fall|2
Winter|3",
// above will print as answers
// 1. Spring (sorta)
// 2. Summer (not the one)
// 3. Fall (the one)
// 4. Winter (not the one)

/*******************************************
 I hope you get the idea now.
 Just add more if you have more questions.
 Make sure to change the index numbers.
 For example, the next one should begin with
 3=> "blah|1
 blah|2
 blah|3",
 always end with a quotation and a comma!
 *******************************************/

);

######### END OF QUIZ 1 DATA ##################################################
?>