<?php //list of strings in array
$myarry = array(
    "text 1", "text 2", "text 3", "text 4",
    "text 5", "text 6", "text 7"
);

//randomize strings
$randomize1 = array_rand($myarry);
$randomize2 = array_rand($myarry);
$randomize3 = array_rand($myarry);

//prepare output array
$myvals = array(
    'satu' => '1.' . $myarry[$randomize1],
    'dua' => '2.' . $myarry[$randomize2],
    'tiga' => '3.' . $myarry[$randomize3]
);

//encode array with PHP json_encode and print output
echo json_encode($myvals);