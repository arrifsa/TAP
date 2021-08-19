<?php 
session_start();
require_once("config.php");
require_once("paillier.php");

function generateKode() {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 10; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


if(isset($_POST['signaturesubmit'])){
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);

    // enkripsi password
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
 
    //parameter signature
    $signature = $_POST['signature'];
    $signatureFileName = uniqid().'.png';
    $signature = str_replace('data:image/png;base64,', '', $signature);
    $signature = str_replace(' ', '+', $signature);
    $data = base64_decode($signature);
    $file = 'signatures/'.$signatureFileName;
    file_put_contents($file, $data);

    $kode = generateKode();

    // Generate Key
    $publicKey = array(paillierKey()[0][0], paillierKey()[0][1]);
    $privateKey = array(paillierKey()[1][0], paillierKey()[1][1]);
    
    // ENKRIPSI
    //Mencari nilai Pixel
    $image = imagecreatefromstring($data);
    $width = imagesx($image);
    $height = imagesy($image);

    $colors = array();
    for($x = 0; $x < $width; $x++) {
        for($y = 0; $y < $height; $y++) {
            $rgb = imagecolorat($image, $x, $y);
            $colors = imagecolorsforindex($image, $rgb);
            // $alpha = $colors['alpha'];

        }
    }

    $_SESSION['colors'] = $colors;

    // DEKRIPSI


    //insert to database
    $sql = 'INSERT INTO data ( kode, username, email, password, signature, file, encrypt, decrypt) 
            VALUES ( :kode, :username, :email, :password, :signature, :file, :encrypt, :decrypt)';

    //create PDO connection 
    $stmt = $db->prepare($sql);

    $stmt->execute([
      'kode' => $kode,
      'username' => $username,
      'email' => $email,
      'password' => $password,
      'signature' => "signatures/".$signatureFileName,
      'file' => $data,
      'encrypt' => NULL,
      'decrypt' => NULL
    ]);

    $msg = "<div class='alert alert-success'>Signature Uploaded</div>";
    
    header("Location: result.php?code=$kode&imageX=$width&imageY=$height");  
} 
?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
        <style>
            #canvasDiv {
                position: relative;
                border: 2px dashed grey;
                height: 300px;
            }
        </style>

        <title>Pailler Cryptosystem</title>
    </head>
    <body>

        <!--Form Registrasi-->
        <div class="card mx-auto" style="width: 30rem;">
            <div class="card-body">
                <h5 class="card-title">Registrasi</h5>
                <p class="card-text text-danger">lengkapi data diri sesuai dengan identitas asli</p>
                <?php echo isset($msg0)?$msg0:''; ?>
                <form action="" method="POST" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="username">Username</label>
                        <input
                            type="text"
                            class="form-control"
                            id="username"
                            name="username"
                            placeholder="Username"
                            required="required">
                    </div>

                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input
                            type="email"
                            class="form-control"
                            id="email"
                            name="email"
                            aria-describedby="emailHelp"
                            placeholder="Enter email"
                            required="required">
                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input
                            type="password"
                            class="form-control"
                            id="password"
                            name="password"
                            placeholder="Password"
                            required="required">
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-md-offset-2">
                            <br>
                            <p>Tanda tangan dibawah ini</p>
                            <?php echo isset($msg)?$msg:''; ?>
                            <hr>
                            <div id="canvasDiv"></div>
                            <br>

                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="check" required="required">
                                <label class="form-check-label" for="check">
                                    I agree to terms</label>
                            </div>

                            <button type="button" class="btn btn-danger" id="reset-btn">Hapus TTD</button>
                            <button type="submit" class="btn btn-success " id="btn-save" name="create">SIMPAN TTD</button>
                        </div>
                        <!-- <form id="signatureform" action="" style="display:none" method="post"> -->
                        <input type="hidden" id="signature" name="signature">
                        <input type="hidden" name="signaturesubmit" value="1">
                    </form>

                </div>
            </div>
        </div>

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery-3.3.1.slim.min.js"></script>
        <script src="js/html2canvas.min.js"></script>
        <script src="js/jquery.js"></script>
        <script src="js/esignature.js"></script>
        <script src="js/pailler.js"></script>i
        <script></script>
    </body>
</html>