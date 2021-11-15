<?php

//creates out python script
$answer = "#!/usr/bin/env python\n";	
$functionA = "def add(a,b):\n\treturn a + b\n";
$functionB = "def subtract(a,b):\n\treturn a - b\n";
$answer .= $functionA;
$answer .= $functionB;
$case1 = "print(add(5,3))\n";
$case2 = "print(subtract(5,3))";
$answer .= "\n";
$answer .= $case1;
$answer .= "\n";
$answer .= $case2;

//writes script to python file
//$answerFile = fopen(".\studentCD.py", "w+");
$answerFile = "studentCD.py";
file_put_contents($answerFile, $answer);//Write into the file
$output = null;
$retval = null;
exec('python studentCD.py', $output, $retval);
//echo $retval;
print_r($output);
$trial = "8";

?>