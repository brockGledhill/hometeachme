<?php
session_start();
if ($_REQUEST['cmd'] == 'logout') {
	unset($_SESSION['ward_logins']);
}
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Family</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link href='http://fonts.googleapis.com/css?family=Exo+2:400,100' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'>
</head>

<body id="loginpage">

<div id="loginpanel">
<div id="loginbox">
<h3>Hometeach Me</h3>
<form action="dashboard.php" method="post">

<input name="myusername" type="text" placeholder="email"/>
<input name="mypassword" type="password" placeholder="password"/>

<button type="submit" title="login">Login</button>

</form>
</div>
</div>

<div class="emptybackcontainer">

    <div class="middlepeice">
    
    <div class="topside">
    	<div class="lightheader">Report on the go</div>
        <div class="lightpara">Now reporting your hometeaching is easier than ever. Simply tap/click the month you visited your families and leave comments on how it went. </div>
    </div>
    <div class="bottomside">
    	
    </div>
    
    </div>
    
</div>

</body>
</html>