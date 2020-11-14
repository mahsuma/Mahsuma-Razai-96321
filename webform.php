<?php
	include_once("../include/header.php");

	// Processing form data when form is submitted
	if($_SERVER["REQUEST_METHOD"] == "POST" AND isset($_POST["rname"])){

		$param_rname = trim($_POST["rname"]);
		$param_remail = trim($_POST["remail"]);
		$param_rpassword = md5($_POST["rpassword"]);

	 	// Check input empty before inserting in database
	    if(!empty($param_rname) && !empty($param_remail) && !empty($param_rpassword)){

	        // Prepare an insert statement
	        $sql = "INSERT INTO users (name, email, password) VALUES (?, ?,?)";
	        if($stmt = mysqli_prepare($link, $sql)){
	            // Bind variables to the prepared statement as parameters
	            mysqli_stmt_bind_param($stmt, "sss", $param_rname, $param_remail, $param_rpassword);

	            $param_rname = trim($_POST["rname"]);
				$param_remail = trim($_POST["remail"]);
				$param_rpassword = md5($_POST["rpassword"]);

	            // Attempt to execute the prepared statement
	            if(mysqli_stmt_execute($stmt)){
	                // Redirect to login page
	                header("location: login.php?success");
	            } else{
	                header("location: login.php?exist");
	            }
	            // Close statement
	            mysqli_stmt_close($stmt);
	        }
	    }else{
	    	header("location: login.php?error");
	    }

	    // Close connection
	    mysqli_close($link);

	}



	// Processing form data when form is submitted
	if($_SERVER["REQUEST_METHOD"] == "POST" AND isset($_POST["lemail"])){

		$param_lemail = trim($_POST["lemail"]);
		$param_lpassword = md5($_POST["lpassword"]);

	 	// Check input empty before inserting in database
	    if(!empty($param_lemail) && !empty($param_lpassword)){

	        // Prepare an insert statement
	        $sql = "SELECT * FROM users WHERE email='$param_lemail' AND password='$param_lpassword' LIMIT 1";
	        $result = $link->query($sql);
	        if($result->num_rows>0){

	        	$result = $result->fetch_array();
	        	$_SESSION['user_id'] = $result['id'];
	        	$_SESSION['user_name'] = $result['name'];
	        	$_SESSION['user_email'] = $result['email'];

	            header("location: dashbord.php");
	            // Close statement
	            mysqli_stmt_close($stmt);
	        }else{
	        	header("location: login.php?lerror");
	        	mysqli_stmt_close($stmt);
	        }
	    }else{
	    	 header("location: login.php?lerror");
	    }

	    // Close connection
	    mysqli_close($link);

	}

?>
<!-- Header End====================================================================== -->
<div id="mainBody">
	<div class="container">
	<div class="row">

	<div class="span9">
    <ul class="breadcrumb">
		<li><a href="index.html">Home</a> <span class="divider">/</span></li>
		<li class="active">Login</li>
    </ul>
	<h3> Login</h3>
	<hr class="soft"/>

	<div class="row">
		<div class="span4">
			<div class="well">
			<h5> create Aount</h5><br/>
			Enter your e-mail address to create an account.<br/><br/><br/>
			<?php
				if(isset($_REQUEST['success'])){
					echo '<p style="color:black;">Your account successfully created</p>';
				}
				if(isset($_REQUEST['error'])){
					echo '<p style="color:red;">Error while creating your account</p>';
				}
				if(isset($_REQUEST['exist'])){
					echo '<p style="color:blue;">You have already an account with this email</p>';
				}
			?>
         //start form
			<form action="login.php" method="POST">

				<div class="control-group">
				<label class="control-label" for="name">Name</label>
				<div class="controls">
				  <input class="span3"  type="text" id="name" name="rname" placeholder="name" required="">
				</div>
			  </div>

			  <div class="control-group">
				<label class="control-label" for="email">E-mail address</label>
				<div class="controls">
				  <input class="span3"  type="email" id="email" name="remail" placeholder="Email" required>
				</div>
			  </div>

			  <div class="control-group">
				<label class="control-label" for="password">Password</label>
				<div class="controls">
				  <input class="span3"  type="password" id="password" name="rpassword" placeholder="Password" required>
				</div>
			  </div>

			  <div class="controls">
			  <button type="submit" class="btn block">Create Your Account</button>
			  </div>
			</form>
		</div>
		</div>
		<div class="span1"> &nbsp;</div>
		<div class="span4">
			<div class="well">
			<h5>ALREADY REGISTERED ?</h5>
			<?php
				if(isset($_REQUEST['lerror'])){
					echo '<p style="color:red;font-weight:bold;">Please enter valid email & password</p>';
				}
			?>
			<form action="login.php" method="POST">
			  <div class="control-group">
				<label class="control-label" for="lemail">Email</label>
				<div class="controls">
				  <input class="span3"  type="email" id="lemail" name="lemail" placeholder="Email">
				</div>
			  </div>
			  <div class="control-group">
				<label class="control-label" for="password">Password</label>
				<div class="controls">
				  <input type="password" class="span3"  id="password" name="lpassword" placeholder="Password">
				</div>
			  </div>
			  <div class="control-group">
				<div class="controls">
				  <button type="submit" class="btn">Sign in</button> <a href="#">Forget password?</a>
				</div>
				<?php
				$connect = new PDO('mysql:host=localhost;dbname= 'mahsuma','root','');
				function rowCount($connect, $query){
					$stmt = $connect->prepare($query);
					$stmt->execute();
					return $stmt->rowCount();
				}
				 ?>
				 <h4 style="color: limegreen"><?php echo rowCount($connect,"SELECT * FROM users")?> users are already registered</h4>
			  </div>
			</form>
		</div>
		</div>
	</div>

</div>
</div></div>
</div>

<?php
	include_once("../include/footer.php");
?>
