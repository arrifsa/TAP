     
<?php 
require_once("config.php");
if(isset($_POST['register']))
  {
    $Username = filter_input(INPUT_POST, 'Username', FILTER_SANITIZE_STRING);
    // enkripsi password
    $Password = password_hash($_POST["Password"], PASSWORD_DEFAULT);
    $Email = filter_input(INPUT_POST, 'Email', FILTER_VALIDATE_EMAIL);


    // menyiapkan query
    $sql = "INSERT INTO users ( Username, Email, Password) 
            VALUES ( :Username, :Email, :Password)";
    $stmt = $db->prepare($sql);

    // bind parameter ke query
    $params = array(
        ":Username" => $Username,
        ":Password" => $Password,
        ":Email" => $Email,
    );
    // execution to save on database
    $saved = $stmt->execute($params);
    $msg0 = "<div class='alert alert-success'>Biodata Uploaded</div>";
  }
 
if(isset($_POST['signaturesubmit'])){ 
  //parameter signature
    $signature = $_POST['signature'];
    $signatureFileName = uniqid().'.png';
    $signature = str_replace('data:image/png;base64,', '', $signature);
    $signature = str_replace(' ', '+', $signature);
    $data = base64_decode($signature);
/**
 * 
 */
class algoritma
{
  public function __construct($signature){

    encrypt_file ($file = 'signatures/'.$signatureFileName,'secret-password');
    $descrypted = descrypt_file ($file = 'signatures/'.$signatureFileName,'secret-password');
    fpassthru($handle);

    function  encrypt_file($file, $destination, $passphrase){
      $handle = fopen($file, "rb") or die ("tidak ada data");
      $contents = fread($handle, filesize($file));
      fclose($handle);

      $iv = substr(md5("\x18\x3C\x58".$passphrase. true),0,8);
      $key = substr(md5("\x2D\xFC\xD8".$passphrase. true).md5("\x2D\xFC\xD8".$passphrase. true),0,24);
      $otps = array ('iv'=>$iv, 'key'=>$key);

      $fp = fopen ($destination, 'wb') or die  ("data tidak bisa dibuka untuk dibaca");
      stream_filter_append($fp,'mcrypt.tripledes', STREAM_FILTER_WRITE, $otps);
      fwrite($fp, $contents) or die  ("tidak bisa membaca file");
      fclose($fp);
    }

    function descrypt_file($file,$passphrase){
      $iv = substr(md5("\x18\x3C\x58".$passphrase. true),0,8);
      $key = substr(md5("\x2D\xFC\xD8".$passphrase. true).md5("\x2D\xFC\xD8".$passphrase. true),0,24);
      $otps = array ('iv'=>$iv, 'key'=>$key);
      $fp = fopen($file, 'rb');
      stream_filter_append($fp, 'mdecrypt_tripledes',STREAM_FILTER_READ, $opts);
      return $fp;
    }
  }
}
    file_put_contents($file, $data);

    //insert to database  
      $sql = "INSERT INTO users( Signature, File) 
              VALUES ( :Signature, :File)";
       $stnt = $db->prepare($sql);

          // bind parameter ke query
          $params = array(
              ":Signature" => $signatureFileName,
              ":File" => $data,
          );
          // execution to save on database
          $saved = $stnt->execute($params);

    $msg = "<div class='alert alert-success'>Signature Uploaded</div>";
     header("Location: login.php");
} 
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
          <style>
        #canvasDiv{
            position: relative;
            border: 2px dashed grey;
            height:300px;
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
          <form action="" method="POST" enctype="multipart/form-data" >

            <div class="form-group">
               <label for="Username">Username</label>
               <input type="text" class="form-control" id="Username" name="Username" placeholder="Username" required>
            </div>

            <div class="form-group">
              <label for="Email">Email address</label>
              <input type="email" class="form-control" id="Email" name="Email" aria-describedby="emailHelp" placeholder="Enter email" required>
               <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            </div>
            <div class="form-group">
               <label for="Password1">Password</label>
               <input type="password" class="form-control" id="Password" name="Password" placeholder="Password" required>
            </div>

                <button type="submit" class="btn btn-primary float-right " id="btn-save" name="register">Simpan</button>
            </form>
            <div class="row">
            <div class="col-md-12 col-md-offset-2">
                <br>
                <p>Tanda tangan dibawah ini</p>
                <?php echo isset($msg)?$msg:''; ?>
                <hr>
                <div id="canvasDiv"></div>
                <br>

            <div class="form-group form-check">
              <input type="checkbox" class="form-check-input" id="check" required>
              <label class="form-check-label" for="check"> I agree to terms</label>
            </div> 

                <button type="button" class="btn btn-danger" id="reset-btn">Hapus TTD</button>
                <button type="submit" class="btn btn-success " id="btn-save" name="create">SIMPAN TTD</button>
            </div>
            <form id="signatureform" action="" style="display:none" method="post">
                <input type="hidden" id="signature" name="signature">
                <input type="hidden" name="signaturesubmit" value="1">
           
        </div>
            </div>
        </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-3.3.1.slim.min.js"> </script>
    <script src="js/html2canvas.min.js"></script>
    <script src="js/jquery.js"></script>
    <script src="js/esignature.js"></script>
    <script src="js/pailler.js"></script>i
  </body>
</html>