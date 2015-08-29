<?php
session_start();
?>

<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Sign-Up</title>
</head>
<body>
	<div id="signupHeader">
		Welcome!  Sign up below!
	</div>
	<div id="signupForm">
		<div id="firstNameSection">
			<label id="firstNameLabel" for="firstNameInput">First Name</label>
			<input id="firstNameInput"/>
		</div>
		<div>
        	<label id="lastNameLabel" for="lastNameInput">Last Name</label>
           <input id="lastNameInput"/>
		</div>
       <div>
       		<label id="phoneLabel" for="phoneInput">Phone Number</label>
           <input id="phoneInput"/>
       </div>
       <div>
       		<label id="wardLabel" for="wardInput">Ward Name</label>
           <input id="wardInput"/>
       </div>
       <div>
       		<label id="quorumLabel" for="quorumSelect">Quorum</label>
           <select id="quorumSelect">
           	<option>Elder</option>
            	<option>High Priest</option>
           </select>
       </div>
	</div>
</body>
</html>