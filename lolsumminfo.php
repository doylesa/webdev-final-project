<!doctype html>

<html lang="en">
<head>
    <title>Sam's League of Legends Lookup Tool</title>
    <link rel="stylesheet" type="text/css" href="lolstyle.css">
</head>

<div id="container">

<div id="header">
<h1 style="margin-bottom:0;"><img src="images/Teemo.png" alt="Teemo"> Sam's League of Legends Lookup Tool <img src="images/Teemo.png" alt="Teemo"></div>

<div id="menu">
<?php include 'lolmenu.php'; ?>
</div>

<div id="content">
Search for summoner info, by summoner name:<br>
<?php 
// display form if user has not clicked submit
if (!isset($_POST["submit"]))
  {
  ?>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
Summoner Name: <input type="text" name="sumname" id="sumname"><br>
<input type="submit" name="submit" value="Search">
</form>
  <?php 
  }
else
  // the user has submitted the form
  {
        function test_input($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
    
    require('pw.php');
    $key = $apikey['lolkey'];
    $sumname = test_input($_POST["sumname"]);
    $url = "https://prod.api.pvp.net/api/lol/na/v1.4/summoner/by-name/$sumname?api_key=$key";
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_URL, $url);
    $result = curl_exec($curl);
    curl_close($curl);
    
    if ($result==FALSE)
    {
        echo "Invalid summoner name";
    }
    else
    {
        
        echo "<br>";
        
        $suminfo = json_decode($result, true);
        
        $suminfoid = $suminfo[$sumname]['id'];
        $suminfolvl = $suminfo[$sumname]['summonerLevel'];
        $suminfomils = $suminfo[$sumname]['revisionDate'];
        
        $seconds = $suminfomils / 1000;
        $suminfodate = date("d-m-Y", $seconds);
        
        echo "<table>";
        echo "<tr><td>" . "Your id is:" . "</td><td>" . $suminfoid . "</td></tr>";
        echo "<tr><td>" . "Your level is:" . "</td><td>" . $suminfolvl . "</td></tr>";
        echo "<tr><td>" . "Your account was last modified on:" . "</td><td>" . $suminfodate . "(d-m-y)" . "</td></tr>";
        echo "</table>";
        
    }
  }
?>

</div>

<div id="footer">
Cooked up by Sam Doyle <a href="http://www.twitter.com/northeastern"><img src="/images/twitter.png" alt="Northeastern University twitter page"></a></div>

</div>

</body>
</html>