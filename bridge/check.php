
<?php
$arrayName = array( '1_0_hello' , '2_1_dude', '3_3_sorry' );
foreach ($arrayName as $mystring) {


$findme   = 1 . '_';
$pos = strpos($mystring, $findme);

$mystr = substr($mystring, $pos+2, 1);
$mynewstr = substr($mystring, $pos+2);
$retVal = ($mystr == 0) ? "True" : "False" ;
echo  "Returned =" . $retVal . "<br/>";
echo "Required String = ";
$required_str = substr($mynewstr, $pos+2);
echo $required_str . "<br/>";
echo "mystr = ". $mystr . "<br/>" ."position =".$pos."<br/>". "mynewstr =" . $mynewstr .  "<br/>" .
	 "mystring = ". $mystring .  "<br/><br/>";
if ($pos === false) {
    echo "The string '$findme' was not found in the string '$mystring'";
} else {
    echo "The string '$findme' was found in the string '$mystring'";
    echo " and exists at position $pos";
}
echo "<br/><br/>";
	
}


// Note our use of ===.  Simply == would not work as expected
// because the position of 'a' was the 0th (first) character.

?>
