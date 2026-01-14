<?php
class Calculator {
    // This magic method is called whenever an undefined method is invoked
    public function __call($name, $arguments) {
        if ($name == "add") {
            $sum = 0;
            foreach ($arguments as $num) {
                $sum += $num;
            }
            echo "Sum of " . implode(", ", $arguments) . " = $sum <br>";
        } elseif ($name == "multiply") {
            $product = 1;
            foreach ($arguments as $num) {
                $product *= $num;
            }
            echo "Product of " . implode(", ", $arguments) . " = $product <br>";
        } else {
            echo "Method '$name' not found! <br>";
        }
    }
}

// Create object
$calc = new Calculator();

// Simulate function overloading
$calc->add(10, 20);           // Two arguments
$calc->add(5, 15, 25, 35);    // Four arguments
$calc->multiply(2, 3, 4);     // Three arguments
$calc->multiply(5, 5);        // Two arguments
$calc->subtract(10, 5);       // Method not defined
?>
