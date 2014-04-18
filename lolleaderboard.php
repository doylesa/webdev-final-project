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
A leaderboard of the top summoners by champion kills:<br>
    
<?php     
    require('pw.php');
    $con = mysqli_connect("samdoylecs4550com.ipagemysql.com","samdoylecs4550",$dbpw['pw'],lol_db);
    
    if (mysqli_connect_errno())
        {
          echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $leaderboard = mysqli_query($con,"SELECT * FROM champkills ORDER BY champskilled DESC");
        
        echo "<table border='1'>";
        echo "<tr><td><b>Summoner Name</b></td><td><b>Champion Kills</b></td></tr>";
        
        while($row = mysqli_fetch_array($leaderboard))
        {
            echo "<tr><td>" . $row['sumname'] . "</td><td>" . $row['champskilled'] . "</td></tr>";
        }
    
        echo "</table>";
        
        mysqli_close($con);
        
?>

<!-- begin htmlcommentbox.com -->
 <div id="HCB_comment_box"><a href="http://www.htmlcommentbox.com">HTML Comment Box</a> is loading comments...</div>
 <link rel="stylesheet" type="text/css" href="commentstyle.css" />
 <script type="text/javascript" language="javascript" id="hcb"> /*<!--*/ if(!window.hcb_user){hcb_user={  };} (function(){s=document.createElement("script");s.setAttribute("type","text/javascript");s.setAttribute("src", "http://www.htmlcommentbox.com/jread?page="+escape((window.hcb_user && hcb_user.PAGE)||(""+window.location)).replace("+","%2B")+"&opts=470&num=10");if (typeof s!="undefined") document.getElementsByTagName("head")[0].appendChild(s);})(); /*-->*/ </script>
<!-- end htmlcommentbox.com -->

</div>

<div id="footer">
Cooked up by Sam Doyle <a href="http://www.twitter.com/northeastern"><img src="/images/twitter.png" alt="Northeastern University twitter page"></a></div>

</div>

</body>
</html>