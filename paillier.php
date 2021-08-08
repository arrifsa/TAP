<?php
function paillierKey() {
	//Rumus

	// Mencari Prima p dan q
	$p = primaNumber()[0];
	$q = primaNumber()[1];

	// Mencari nilai n
	$n = $p * $q;

	// Mencari nilai h / Lambda
	$h = lcm($p - 1, $q - 1);

	// // Mencari nilai g
	$g = rand(1, 100);

	// Mencari nilai u
	$u = pow($g, $h) % pow($n, 2);

	// Mencari nilai L(u)
	$kelipatan = kelipatanBiner($h); //Kombinasi Kelipatan Biner
	$mikro = kelipatanBinerX($h, $g, pow($n, 2), $kelipatan, $n);

	$publicKey = array($n, $g);
	$privateKey = array($h, $mikro);
	//$h = $gLambda
	//$m = $gMu atau $mikro


	return array($publicKey, $privateKey);
}

function primaNumber(){
	$prima = array();
	$k = 0;
	for ($i=1; $i <= 100; $i++) {
	    $a = 0; 
        for ($j=1; $j <= $i ; $j++) {
            if ($i % $j == 0) {
                $a++;
            }
        }
	    if ($a == 2) {
	    	$prima[$k] = $i;
	        $k++;
	    }
	}
	$p = $prima[array_rand($prima)];
	$q = $prima[array_rand($prima)];

	return array($p, $q);
}

function lcm($x, $y){
	//Rumus mencari LCM
	$p = $x;
	$q = $y;

	while ($x != $y) {
	  if ($x > $y)
	    $x = $x - $y;
	  else
	    $y = $y - $x;
	}

	return ($p*$q) / $x;
}

function kelipatanBiner($data){
	//Membuat Kelipatan Biner yang memungkinkan
	$biner = array();
	$k = 0;
	for($i = 1; $i <= $data; $i+=$i){
		$biner[$k] = $i;
		$k++;
	}

	$length = count($biner) - 1;

	$kelipatan = array();
	$k = 0;
	for($i = $length; $i >= 0; $i--){
		if($biner[$i] <= $data){
			$data = $data - $biner[$i];
			$kelipatan[$k] = $biner[$i];
			$k++;
		}
	}

	return $kelipatan;
}

function kelipatanBinerX($h, $g, $nn, $kelipatan, $n){
	$biner = array();
	for($i = 1; $i <= $h; $i+=$i){
		if($i == 1){
			$biner[$i] = $g % $nn;
			$g = $biner[$i];
		}
		else{
			$biner[$i] = pow($g, 2) % $nn;
			$g = $biner[$i];
		}
	}

	$total = 1;
	for($i = 0; $i < count($kelipatan); $i++){
		$total = (int)$total * (int)$biner[$kelipatan[$i]];
	}
	$mod = (int)$total % $nn;
	$Lu = ($mod - 1) / $n;

	$mikro = pow($Lu, -1) * 100000 % $n;

	return abs($mikro); //Disini ada minus
}

//Nilai Desimal to binner
    //   decbin($color);
    //   $conBiner ='';
    //   for($i=0; $i<$color; $i++ ){
    //     $conBiner .= array($i);
    //   }
    //   $valBiner = strlen($conBiner);
    //   $b = rand(1,100);
    //   $prameterb = pow(2, $b)<=$n;
    //   if($valBiner % $parameterb ==0){
    //     subBlockM($conBiner);
    //   }
    //   else{
    //     $tambah = $b-($valBiner % $b);
    //     $tambahNol ='';
    //     for ($i=0; $i <$tmabah ; $i++) { 
    //       $tambahNol='0';
    //     }
    //     subBlockM($conBiner.$tambahNol);
    //   }
?>