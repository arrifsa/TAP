<?php 
    session_start();
	require_once("config.php");

	$code = $_GET['code'];
	$sql  = "SELECT * FROM data WHERE kode='$code'";
	$records = $db->query($sql);
	$records->setFetchMode(PDO::FETCH_ASSOC);

	//testing
	// require_once("paillier.php");

	// $paillier = paillierKey();
 //    $publicKey = array($paillierKey[0][0],$paillierKey[0][1]);
 //    $privateKey = array($paillierKey[1][0],$paillierKey[1][1]);
 //    echo "Public Key : (". $paillier[0][0]. "," . $paillier[0][1] . ")" . "<br>";
 //    echo "Private Key : (". $paillier[1][0]. "," . $paillier[1][1] . ")" . "<br>";

 //    $kelipatanN = kelipatanBiner($paillier[0][0]);

    // $testing = $_SESSION['colors'];
    // $varfirst = array();
    // for($x = 0; $x < 434; $x++) {
    //   for($y = 0; $y < 300; $y++) {
    //     if($varfirst == $testing[$x][$y]){

    //     }
    //     else{
    //         if($x != 0 && $y != 0){
    //             $xy = " x : ".$x." y : ".$y;
    //             var_dump($testing[$x][$y]['alpha']);
    //             echo $xy;
    //             echo "<br/>";
    //         }
    //     }
    //     $varfirst = $testing[$x][$y];
    //   }
    // }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>PHP MySQL Query Data Demo</title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
    </head>
    <body>
        <?php 
        while ($row = $records->fetch()){
            echo "Username : ".$row['username']."<br>";
            echo "Email : ".$row['email']."<br>";
            echo "Location File : ".$row['signature']."<br>";
            echo "File : ".'<img src="data:image/jpeg;base64,'.base64_encode( $row['file'] ).'"/>'."<br>";
        }
        ?>
    </body>
</div>
</html>



<!-- 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Info Timeline</title>

    <link rel="stylesheet" href="css/bootstrap.min.css" />
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row">
        <div class="col-md-4">

            <div class="card">
                <div class="card-body text-center">
                	<img src="result.php?code=nvNqpgYBed" alt="">

                </div>
            </div>

            
        </div>
    </div>
</div>

</body>
</html> -->