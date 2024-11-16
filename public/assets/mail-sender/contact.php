<?php


// Taking all values
$name 		= $_POST['name'];
$email 		= $_POST['email'];
$subject 	= $_POST['subject'];
$msg 		= $_POST['msg'];
$output 	= "Name: ".$name."\n\nSubject: ".$subject."\n\nMessage: ".$msg;
$to 		= 'demo@gmail.com';
$headers	= 'FROM: "'.$email.'"';

/* $send = mail($to, $name, $output."\n\n***This message has been sent from Berbar", $headers); */




