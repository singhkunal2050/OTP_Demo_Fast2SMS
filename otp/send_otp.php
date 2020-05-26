<?php
session_start();
?>
<html>
    <style>

      input::-webkit-outer-spin-button,
      input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
      }

    </style>
    <head>
        <title>send otp</title>
    </head>
    <body>
        <form action = "send_otp.php" method = "post">
          <label for="phoneno">Enter Phone no::</label> <br>
          <input type="number" name = "phoneno"> <br>
          <input type = "submit" name = "send" value = "send">
        </form>
    </body>
</html>
<?php
if(isset($_POST['send']) && isset($_POST['phoneno']))
{
    $phoneno = $_POST['phoneno'];
    $otp = rand(10000,99999);
    echo $otp;
    $_SESSION["otp"] = $otp;
    echo $_SESSION["otp"];

    $field = array(
        "sender_id" => "FSTSMS",
        "language" => "english",
        "route" => "qt",
        "numbers" => "$phoneno",
        "message" => "28363",                         // message tempalate id 
        "variables" => "{#AA#}",
        "variables_values" => "$otp"
    );
    
    $curl = curl_init();
    
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://www.fast2sms.com/dev/bulk",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_SSL_VERIFYHOST => 0,
      CURLOPT_SSL_VERIFYPEER => 0,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => json_encode($field),
      CURLOPT_HTTPHEADER => array(
        "authorization: CM9PjNmqh6gr5KAT8sXZeO0wpBxtavcIW3JdVlQnUELHSDo2f4jsge25yCdGiSWvk0MubxRzoJI43qfY",
        "cache-control: no-cache",
        "accept: */*",
        "content-type: application/json"
      ),
    ));
    
    $response = curl_exec($curl);
    $err = curl_error($curl);
    
    curl_close($curl);
    
    if ($err) {
      echo "cURL Error #:" . $err;
    } else {
      echo $response;
    }

    header('Location: ./recive_otp.php');
}
?>