<?php

  $error = "";
  $weather = "";

  if (array_key_exists("city", $_GET) && $_GET['city']) {

    $urlContents = "API URL";

    if ($_GET['city'] == "") {
        $error = "Please enter the name of a city";
      }
  
      $file_headers = @get_headers($urlContents);
      if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
          $error = "City could not be found!";
      }
      else {
          $api = file_get_contents($urlContents);
          $weatherArray = json_decode($api, true);
      
          if ($weatherArray['cod'] == 200) {
        
            $weather = "The weather in ".$_GET['city'].", ".$weatherArray['sys']['country'].", is currently '".$weatherArray['weather'][0]['description']."'.";
      
            $tempInCelcius = intval($weatherArray['main']['temp'] - 273);
      
            $weather .= " The temperature is ".$tempInCelcius."&deg;C and the wind speed is ".$weatherArray['wind']['speed']."m/s.";
      
          }
           else {
            $error = "City could not be found!";
          } 
      }
  }

?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Weather Forecast</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="/css/bootstrap.min.css">
  <link rel="stylesheet" href="/css/jquery-ui.css">
  <link rel="stylesheet" href="/css/style.css">
</head>

<body>

  <div class="container text-center">

    <h1 class="fw-bold">What's the weather?</h1>

    <p id="error"></p>

    <form method="GET">
      <label for="city" class="fw-medium">Enter the name of a city.</label>
      <input type="text" name="city" id="city" class="form-control my-3"
        value="<?php if($_GET){echo $_GET['city'];} ?>" />
      <input type="submit" value="Submit" class="btn btn-primary mb-2" />
    </form>

    <p id="result">
      <?php 
        if ($error) {
          echo "<div class='alert alert-danger text-danger text-start'>".$error."</div>";
        } else if ($weather) {
          echo "<div class='alert alert-success text-success text-start'>".$weather."</div>";
        }
      ?>
    </p>

  </div>

  <div id="footer" class="text-center text-white py-2">Designed by <a href="https://github.com/zealfemi"
      style="text-decoration: none;">Mackie</a>
  </div>

  <script src="/js/bootstrap.min.js" async defer></script>
  <script src="/js/jquery.min.js"></script>
  <script src="/js/jquery-ui.js"></script>

  <script type="text/javascript">
  $("form").submit(function() {

    if ($("#city").val() == "") {
      $("#error").html("<div class='alert alert-danger text-danger'>Please enter a city</div>")
      return false;
    } else {
      return true;
    }
  })
  </script>
</body>

</html>
