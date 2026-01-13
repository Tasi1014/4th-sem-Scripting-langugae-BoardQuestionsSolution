<?php
// Open a file in write mode ("w")
$file = fopen("students.csv", "w");

// Array of data to write
$students = [
    ["Name", "Age", "Grade"], // Header row
    ["Anshis", 20, "A"],
    ["Jayanti", 21, "B"],
    ["Niraj", 22, "A+"]
];

// Write each row to CSV
foreach($students as $student){
    fputcsv($file, $student); // write array as CSV line
}

// Close the file
fclose($file);

echo "CSV file created successfully.";

// Open CSV file in read mode
$file = fopen("students.csv", "r");

echo "<h3>Student Data:</h3>";

// Loop through each row
while (($row = fgetcsv($file)) !== false) {
    // $row is an array of values in this line
    echo implode(", ", $row) . "<br>";
}

// Close the file
fclose($file);

?>
