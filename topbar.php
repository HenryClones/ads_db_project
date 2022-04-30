<?php
# Start the session
session_start();
$directoryname = dirname($_SERVER['SCRIPT_NAME']);
$uri = urlencode($_SERVER['REQUEST_URI']);
$querystring .= "?redir=$uri";
include("$directoryname/api/v1/guard.php");
# Required for the username in the form currently
# Generate a CSRF nonce
$_SESSION['token'] = bin2hex(random_bytes(32));
# Relative path!

?>
<style>

#top-bar
{
    background-color: #141d26;
    color: #CCCCCC;
}

#top-bar *
{
    background-color: #141d26;
    color: #CCCCCC;
}

#top-bar button
{
    background-color: #262447;
    color: #CCCCCC;
}
</style>
<div class="top-bar" id="top-bar">
    <div class="top-bar-left">
        <ul class="dropdown menu" data-dropdown-menu>
            <li class="menu-text">ADS.com</li>
            <li>
                <a href="?type=recent">Offers</a>
                <ul class="menu vertical">
                    <li><a href="?type=renter&count=25">Renters</a></li>
                    <li><a href="?type=rentee&count=25">Clients</a></li>
                    <li><a href="?type=product&count=25">Products</a></li>
                    <li><a href="?type=service&count=25">Services</a></li>
                </ul>
            </li>
            <li><a href="features.php">Features</a></li>
            <li><a href="about.php">About Us</a></li>
        </ul>
    </div>
    <div class="top-bar-right">
        <ul class="menu">
            <!-- TODO: Add login option here with modal replaced with account dropdown -->
	    <li>

	    <div id="login-icon">
		<?php 
		    echo '
		    <img src="icon/icon-login.png" height="10">
		    ';
		?>
	    </div>
	    </li>
	    <li><input type="search" placeholder="Search listings"></li>
            <li><button type="button" class="button">Search</button></li>
        </ul>
    </div>
</div>

<div id="login-popup">
	<form action="<?php echo "https://" . $_SERVER["SERVER_NAME"] . 
		"$directoryname/api/v1/authenticate.php" ?>"
		class="login-form" action="" id="login-form" method="post" enctype="multipart/form-data">
		<input type="hidden" name="token" value="<?php
    		echo hash_hmac('sha256', "api/v1/authenticate.php", $_SESSION['token']);
		?>" />
		<input type="hidden" name="redir" value="<?php echo "https://" . $_SERVER["SERVER_NAME"] .
			$_SERVER['PHP_SELF'] . $_SERVER['QUERY_STRING']; ?>"/>
		<h1>Login</h1>
		<div>
			<div>
				<label>Email: </label><span id="userEmail-info"
					class="info"></span>
			</div>
			<div>
				<input type="text" id="userEmail" name="userEmail"
					class="inputBox" />
			</div>
		</div>
		<div>
			<div>
				<label>Password: </label><span id="userPassword"
					class="info"></span>
			</div>
			<div>
				<input type="password" id="userPassword" name="userPassword"
					class="inputBox" />
			</div>
		</div>
		<div>
			<input type="submit" id="login" name="login" value="Login" />
		</div>
		<div>
			<input type="submit" id="register" name="register" value="Register" />
		</div>
	</form>
</div>
<script>
$(document).ready(function () {
    $("#login-icon").click(function () {
	$("#login-popup").show();
    });
    //Login Form validation on click event
    $("#login-form").submit(function(event) {
	    if(event.originalEvent.submitter.name == 'login') { 
	    var valid = true;
	    $(".info").html("");
	    $("inputBox").removeClass("input-error");

	    var userName = $("#userName").val();
	    var userEmail = $("#userEmail").val();

	    if (userName == "") {
		$("#userName-info").html("required.");
		$("#userName").addClass("input-error");
	    }
	    if (userEmail == "") {
		$("#userEmail-info").html("required.");
		$("#userEmail").addClass("input-error");
		valid = false;
	    }
	    if (!userEmail.match(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/))
	    {
		$("#userEmail-info").html("invalid.");
		$("#userEmail").addClass("input-error");
		valid = false;
	    }
	    return valid;
	    }
	    
    	});
    $(document).on("click", function(event) {
	if((!$(event.target).closest("#login-form").length && $("#login-popup").is(":visible") && !$(event.target).closest("#login-icon").length)) {
	    $("#login-popup").hide();
	} 
    });
});
</script>

