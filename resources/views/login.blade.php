<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{{ $title }}}</title>
<link href="/css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link href='https://fonts.googleapis.com/css?family=Exo+2:400,100' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'>
</head>

<body id="loginpage">

<div id="loginpanel">
	<div id="loginbox">
		<h3>Hometeach Me</h3>
		<form action="/login" method="post">
			{!! csrf_field() !!}
			<input name="email" type="text" placeholder="email" />
			<input name="password" type="password" placeholder="password" />

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