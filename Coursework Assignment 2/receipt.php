<?php 
/* Retrieving the form inputs */

// Customer's name
$customer = $_POST["customer"];

// Quantity of apple, orange and banana
$apple = $_POST["numberOfApple"];
$orange = $_POST["numberOfOrange"];
$banana = $_POST["numberOfBanana"];

// if any one of the fruits is not ordered, the quantity will be set to 0
if ($apple == ""){
    $apple = 0;
}
if ($orange == "") {
    $orange = 0;
}
if ($banana == "") {
    $banana = 0;
}

// Payment mode
$payment = $_POST["paymentMode"];

// calculate the cost of each fruit
$apple_cost = 0.69 * $apple;
$orange_cost = 0.59 * $orange;
$banana_cost = 0.39 * $banana;

// calculate the total cost 
$total_cost = $apple_cost + $orange_cost + $banana_cost;

/* Produce order receipt */
?>
<html lang="en">
    
    <head>
        <!--- Basic setup for CSS files ---->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="vendors/css/grid.css">
        <link rel="stylesheet" type="text/css" href="resources/css/style.css">
        <link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,300italic' rel='stylesheet' type='text/css'>
    </head>
    
     <body>
         <section class="section-order-receipt" id="receiptForm">
             <div class="col">
                 
             </div>   
             
             <div class="col">
                <h2>Order Receipt</h2>
                <div class="row"> 
                    <table>
                        <!-- Customer Information -->
                        <tr>
                            <th rowspan="2">Customer:</th>
                        </tr>
                        <tr>
                            <td colspan="3"><?php print ("$customer"); ?></td>
                        </tr>

                        <!-- Fruits Info -->
                        <tr>
                            <th rowspan="2">Total Fruits Ordered:</th>
                            <th>Apple(69 cents each)</th>
                            <th>Orange(59 cents each)</th>
                            <th>Banana(39 cents each)</th>
                        </tr>
                        <tr>
                            <td><?php print ("$apple"); ?></td>
                            <td><?php print ("$orange"); ?></td>
                            <td><?php print ("$banana"); ?></td>
                        </tr>

                        <tr>
                            <th rowspan="2">Unit Cost:</th>
                        </tr>

                        <tr>
                            <td><?php printf ("$ %4.2f", $apple_cost);?></td>
                            <td><?php printf ("$ %4.2f", $orange_cost);?></td>
                            <td><?php printf ("$ %4.2f", $banana_cost);?></td>
                        </tr>

                        <!-- Total Cost Information -->
                        <tr>
                            <th rowspan="2">Total Cost:</th>
                        </tr>

                        <tr>
                            <td colspan="3"><?php printf ("$ %5.2f", $total_cost); ?></td>
                        </tr>

                        <!-- Payment Mode Information -->
                        <tr>
                            <th rowspan="2">Payment Mode: </th>
                        </tr>
                        <tr>
                            <td colspan="3"><?php print ("$payment"); ?></td>
                        </tr>
                    </table>
                </div> 
            </div>
         </section>
    </body>
</html>


<?php
/* Updating order.txt */
$filename = 'order.txt';

// create a new order.txt if it does not exist yet
if (!file_exists($filename)) {              
    $output = "Total number of apples: ".$apple."\r\nTotal number of oranges: ".$orange."\r\nTotal number of bananas: ".$banana."\r\n";
    file_put_contents($filename, $output);
}else {
    $file = fopen($filename, 'r') or exit ("unable to open file ($filename)");
    for ($x = 0; !feof($file); ++$x) {
        $tmpLine = fgets($file);
        preg_match("/\d+/", $tmpLine, $matches);       // matching the digit from each line

        // Updating the total number for each type of fruit
        switch($x) {
            case 0:
                $output .= preg_replace("/\d+/", $matches[0] + $apple, $tmpLine);    
                break;
            case 1:
                $output .= preg_replace("/\d+/", $matches[0] + $orange, $tmpLine);
                break;
            case 2:
                $output .= preg_replace("/\d+/", $matches[0] + $banana, $tmpLine);
                break;
        }
    }
    fclose($file);
    file_put_contents($filename, $output);  
}
?>


<!--- table style --->
<style>
    table {
        font-family: 'Lato';
        border-collapse: collapse;
    }

    td, th {
        font-family: 'Lato';
        font-size: 12pt;
        padding: 15px;
        color: black;
        border: 2px solid #e67e22;
        text-align: center;
    }
}
</style>

