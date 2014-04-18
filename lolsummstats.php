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
Search for summoner stats, by summoner:</div>
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
    $sumname = test_input($_POST["sumname"]);
    $key = $apikey['lolkey'];
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

        $url2 = "https://prod.api.pvp.net/api/lol/na/v1.3/stats/by-summoner/$suminfoid/summary?api_key=$key";
        
        $curl2 = curl_init();
        curl_setopt($curl2, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl2, CURLOPT_URL, $url2);
        $result2 = curl_exec($curl2);
        curl_close($curl2);
       
        $sumstats = json_decode($result2, true);
        
        $totalwins = $sumstats['playerStatSummaries'][8]['wins'];
        $totalchampkills = $sumstats['playerStatSummaries'][8]['aggregatedStats']['totalChampionKills'];
        $totalchampassists = $sumstats['playerStatSummaries'][8]['aggregatedStats']['totalAssists'];
        $totalminionkills = $sumstats['playerStatSummaries'][8]['aggregatedStats']['totalMinionKills'];
        $totalnminionkills = $sumstats['playerStatSummaries'][8]['aggregatedStats']['totalNeutralMinionsKilled'];
        $totalturretkills = $sumstats['playerStatSummaries'][8]['aggregatedStats']['totalTurretsKilled'];
        
        echo "<table border='1'>";
        
        echo "<tr><td>" . "Wins" . "</td><td>" . $totalwins . "</td></tr>";
        echo "<tr><td>" . "Champion Kills" . "</td><td>" . $totalchampkills . "</td></tr>";
        echo "<tr><td>" . "Champion Assists" . "</td><td>" . $totalchampassists . "</td></tr>";
        echo "<tr><td>" . "Minion Kills" . "</td><td>" . $totalminionkills . "</td></tr>";
        echo "<tr><td>" . "Monster Kills" . "</td><td>" . $totalnminionkills . "</td></tr>";
        echo "<tr><td>" . "Turret Kills" . "</td><td>" . $totalturretkills . "</td></tr>";
    
        echo "<tr><td>";
        echo "SQL says:";
        echo "</td><td>";
        
        
        $con = mysqli_connect("samdoylecs4550com.ipagemysql.com","samdoylecs4550",$dbpw['pw'],lol_db);
        
        if (mysqli_connect_errno())
            {
              echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }
        
        $sql="INSERT INTO champkills (sumname, champskilled)
        VALUES ('$sumname', '$totalchampkills')";
        
        if (!mysqli_query($con,$sql))
        {
          die('Error: ' . mysqli_error($con));
        }
        echo "1 record added";
        
        echo "</td></tr>";
        echo "</table>";
    }
  }
?>


<div id="footer">
Cooked up by Sam Doyle <a href="http://www.twitter.com/northeastern"><img src="/images/twitter.png" alt="Northeastern University twitter page"></a></div>

</div>

</body>
</html>