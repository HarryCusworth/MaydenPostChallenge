



<!DOCTYPE html>
<html lang="en-GB">
<head>
<meta charset="UTF-8">
<title>Post Challenge</title>
</head>
<body>
<form action="post_challenge2.php" method="POST">
    <input type="number" step="0.01" name="gapLength" id="length"><label for="length">Give us the length of the gap and we will work out how many posts and panels you need</label>
      <input type="submit" value="calculate from length">
</form>

    <br>
<form action="post_challenge2.php" method="POST">
    <input type='number' name="numberPosts" id="posts"><label for="posts">How many posts do you have?</label>
    <input type="number" name="numberPanels" id="panels"><label for="panels">How many panels do you have?</label>
    <input type="submit" value="calculate from parts">

</form>
<br>
</body>
</html>


<?php

define ("POST",0.1);
define ("PANEL",1.5);
$pandr = POST + PANEL;

/**
* Calculates the number of poles and posts to span a gap
*@param float $getLength is the length of the space provided by the user
*@return string $feedBack is the number of posts and panels required,
* it has added functionality of saying if the gap is too small for a single panel fence.
* It also feeds back if the fence is exactly the right length or will be longer than the gap.
*/




function calculation_from_length(float $getLength){
    $pandr = POST + PANEL;
    $getLength -=  POST;
    $goodFit = fmod($getLength, $pandr);
    $dividedIntoPanels = $getLength / $pandr;
    $answer = ceil($dividedIntoPanels);

    if  ($getLength<$pandr) {
        $feedBack = "your gap is too small";
    } else if (abs(($goodFit-$pandr)/$pandr) < 0.00001||($goodFit=== 0)) {
        $feedBack = "  \n  The number of panels you need is " . $answer . " and the number of posts you need is  " . ($answer + 1) . ".";
        $feedBack .= "<br> the fence will span the gap exactly";
        } else {
            $feedBack = "  \n  The number of panels you need is " . $answer . " and the number of posts you need is  " . ($answer + 1) . ".";
             $feedBack  .= "<br> Your fence is going to be longer than the gap. hope that works out for you <br>";
        }

    return $feedBack; }




function calculation_from_parts ($noPosts = null, $noPanels = null) {
    $pandr = POST + PANEL;
    if ($noPosts == 1 && $noPanels == 0 || $noPosts == 2 && $noPanels == 0 || $noPosts == 1 && $noPanels == 1 || $noPosts < 0 || $noPanels < 0 ){
        $feedBack = "You don't have enough stuff to make even the smallest fence";
    }
    else if (!$noPanels) {
        $feedBack = "The maximum length of fence you can make is " . ((($noPosts - 1) * $pandr) + POST) . "m, for which you will need " . ($noPosts - 1) . " panels.";
    }
    else if (!$noPosts) {
        $feedBack = "The maximum length of fence you can make is " . (($noPanels * $pandr) + POST) . "m, for which you will need " . ($noPanels + 1). " posts.";
    }
    else if ($noPanels >= ($noPosts - 1)) {
        $feedBack = "The maximum length of fence you can make is " . ((($noPosts - 1) * $pandr) + POST) . "m, you will have " . ($noPanels - ($noPosts - 1)) . " panels spare.";
    }
    else if ($noPanels < ($noPosts - 1)) {
        $feedBack = "The maximum length of fence you can make is " . (($noPanels * $pandr) + POST) . "m, you will have " . (($noPosts - 1) - $noPanels) . " posts spare.";
    }
    return $feedBack;
}

if (isset($_POST['gapLength'])){
    $length =$_POST['gapLength'];
    echo calculation_from_length($length);}

if ((isset($_POST['numberPanels'])) || (isset($_POST['numberPosts']))) {
    $noPosts = $_POST['numberPosts'];
    $noPanels = $_POST['numberPanels'];
    echo calculation_from_parts($noPosts, $noPanels);}
else {
    echo "enter some values";
}
