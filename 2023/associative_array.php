<?php
$students = array(
      "Anshis" => array(
        "Operating System" => 85,
        "Scripting" => 90,
        "Numerical Method" => 75,
        "DBMS" => 80,
        "Software Engineering" => 88
    ),
    "Jayanti" => array(
        "Operating System" => 78,
        "Scripting" => 85,
        "Numerical Method" => 82,
        "DBMS" => 88,
        "Software Engineering" => 90
    ),
    "Niraj" => array(
        "Operating System" => 92,
        "Scripting" => 88,
        "Numerical Method" => 84,
        "DBMS" => 79,
        "Software Engineering" => 85
    )
);
foreach($students as $student => $subject){
    $total = 0;
    foreach($subject as $key => $value){
        $total = $total+=$value;
    }

    $average = $total/5;
    echo "The average marks of $student is $average. <br> ";
}

?>