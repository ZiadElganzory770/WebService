<?php
   require_once "vendor/autoload.php";

   $cities =get_cities();

   $flage=false;

   if(isset($_POST['submit']))
   {
     $flage=true;
     $data=get_weather();

     if ($data && isset($data['main'])) {
        $name_city=$data['name'];
        $timeZone=$data['timezone'];
        $temperature = $data['main']['temp'];
        $humidity = $data['main']['humidity'];
        $description=$data['weather'][0]['description'];            
        $windSpeedMetersPerSecond = $data['wind']['speed'];
        $wind = $windSpeedMetersPerSecond * 3.6;

        $currentDateTime = new DateTime('now');
        $currentDateTime->modify("$timeZone seconds");
        $date = $currentDateTime->format("l g:i a, jS F, Y");
       $information=[$name_city,$temperature,$humidity,$description,$wind,$data];

    } 
   }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport">
    <title>Lab 1</title>
    <link rel="stylesheet">
</head>
<body>

        <div>
            <div>
                <div>
                    <h2>Weather Report</h2>
                </div>
            </div>
            <?php if($flage){ ?>

                <div>
                   <div>
                   
                        <div>
                            <div >
                                <div>
                                    <div>
                                    <h3><?= $name_city; ?> Weather Status</h1>
                                        <h2><?= $description; ?></h2>
                                        <div>
                                            <p>Humidity: <?= $humidity; ?>%</p>
                                            <p>Temperature: <?= $temperature; ?>°C</p>
                                            <p>Wind: <?= $wind; ?> km/h</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php  }?>
            <div >
                <div>
                    <div>
                    <form method="post">
                        <label for="city">Choose a city:</label>
                        <select id="city" name="city">
                            <?php foreach ($cities as $city){
                            foreach($city as $id=> $name){ ?>
                                <option value="<?php echo $id; ?>"><?="IR>>".$name?></option>
                            <?php } }?>
                        </select>
                        <input type="submit" name="submit" value="Get Weather">
                    </form>
                    </div>
                </div>
            </div>
        </div>
       
   
</body>