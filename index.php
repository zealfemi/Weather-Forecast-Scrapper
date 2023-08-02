<?php
  $error = "";
  $successMsg ="";
  
  if ($_GET) {
    if (array_key_exists('city', $_GET)) {
      $city = str_replace(" ", "", $_GET['city']);
  
      $cities = "https://www.weather-forecast.com/locations/". $city ."/forecasts/latest";
      
      if ($city == "") {
        $error = "Please enter the name of a city";
      }
  
      $file_headers = @get_headers($cities);
      if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
          $error = "<div class='alert alert-danger text-danger'>City could not be found!</div>";
      }
      else {
          $forecastPage = file_get_contents($cities);
      
          $pageArray = explode('3 days):</div><p class="location-summary__text"><span class="phrase">', $forecastPage);
  
          if (sizeof($pageArray) > 1) {
            $pageArray2 = explode('</span></p></div>', $pageArray[1]);
              
              if (sizeof($pageArray2) > 1) {
                $weather = $pageArray2[0];
                
                $successMsg = "<div class='alert alert-success text-success'>" . $weather . "</div>";
              } else {
                $error = "<div class='alert alert-danger text-danger'>City could not be found!</div>";
              }
          } else {
            $error = "<div class='alert alert-danger text-danger'>City could not be found!</div>";
          } 
      }
    }
  }
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Weather Forecast Scrapper</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="/css/bootstrap.min.css">
  <link rel="stylesheet" href="/css/jquery-ui.css">
  <style>
  html {
    background: url(/background.jpg) no-repeat center center fixed;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
  }

  body {
    background: none;
  }

  .container {
    padding-top: 100px;
    width: 450px;
  }
    
  #footer {
      position: fixed;
      bottom: 0;
      width: 100%;
  }
  </style>
</head>

<body>

  <div class="container m-0 m-auto text-center">
    <h1>What's The Weather?</h1>

    <form method="GET">
      <fieldset class="form-group">
        <label class="text-white">Enter the name of a city.</label>
        <input type="text" id="city" name="city" placeholder="Eg. Lagos, Ibadan" class="form-control my-4"
          value="<?php if($_GET){echo $_GET['city'];} ?>" />
        <input type="Submit" id="submitBtn" class="btn btn-primary mb-4" />
      </fieldset>
    </form>

    <div id="error">
      <?php 
        if ($successMsg) {
          echo $successMsg; 
        }
        else if ($error) {
          echo $error; 
        }
      ?>
    </div>
  </div>

  <div id="footer" class="text-center text-white py-3">Designed by <a href="https://github.com/zealfemi" style="text-decoration: none;">Mackie</a></div>

  <script src="/js/bootstrap.min.js" async defer></script>
  <script src="/js/jquery.min.js"></script>
  <script src="/js/jquery-ui.js"></script>

  <script type="text/javascript">
  $("form").submit(function() {
    var error = ""

    if ($("#city").val() == "") {
      error += "Please enter the name of a city"
    }

    if (error != "") {
      $("#error").html("<div class='alert alert-danger text-danger'>" + error + "</div>")

      return false;
    } else {
      return true;
    }
  })
  </script>
</body>

</html>
