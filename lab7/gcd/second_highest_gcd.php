<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>GCD Calculator</title>
</head>
<body>

<h2>GCD Calculator</h2>
<form method="post">
    <input type="text" name="numbers" placeholder="Enter up to 6 numbers (comma-separated)" required>
    <input type="submit" value="Calculate GCD">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    function gcd($a, $b) {
        while ($b != 0) {
            $temp = $b;
            $b = $a % $b;
            $a = $temp;
        }
        return $a;
    }

    function calculateGCDs($numbers) {
        $gcds = [];
        $count = count($numbers);

        for ($i = 0; $i < $count; $i++) {
            for ($j = $i + 1; $j < $count; $j++) {
                $gcds[] = gcd($numbers[$i], $numbers[$j]);
            }
        }

        return array_unique($gcds);
    }

    function secondHighestGCD($gcds) {
        rsort($gcds);
        return isset($gcds[1]) ? $gcds[1] : null;
    }

    // Get user input and process it
    $input = trim($_POST['numbers']);
    $numbers = array_map('trim', explode(',', $input)); // Split by comma and trim spaces

    // Validate input
    if (count($numbers) > 6) {
        echo "<div class='result'>Please enter no more than 6 numbers.</div>";
    } else {
        $numbers = array_filter($numbers, 'is_numeric'); // Filter out non-numeric values

        if (count($numbers) < 2) {
            echo "<div class='result'>At least two numbers are required to calculate GCD.</div>";
        } else {
            $gcds = calculateGCDs($numbers);
            $secondHighest = secondHighestGCD($gcds);

            if ($secondHighest !== null) {
                echo "<div class='result'>The second highest GCD is: $secondHighest</div>";
            } else {
                echo "<div class='result'>Not enough unique GCDs to determine the second highest.</div>";
            }
        }
    }
}
?>

</body>
</html>
