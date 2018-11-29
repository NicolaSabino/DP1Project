<?php

class User {

	public $mail;
	protected $password_md5;

	public function __construct(){
		if (0 === func_num_args()) {
            //new user
    } else{
			$this->mail			= func_get_arg(0);
			$conn 					= createConnection();
			$res						= searchUser($this->mail,$conn);

			if($res == -1){
				errorRedirector("error while searching user". $this->mail );
			}
			$this->password_md5 = $res['password'];
		}
	}

	public function logIn(){
		$conn = createConnection();
		try {
			if (!isset ( $_POST ['email'] )
			|| !isset ( $_POST ['password']))
			{
				throw new InvalidArgumentException ( "Empty values" );
			}

			$email 		= sanitize( $conn, $_POST ['email'] );
			$password = sanitize( $conn, $_POST ['password'] );

			// back end validaion
			$reg_email	= '/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/';
			$reg_pass		= '/^(?=.{3})(?=.*[^0-9a-zA-Z])/';

			if (!preg_match ( $reg_email, $email ) || strlen ( $email ) == 0 || strlen ( $email ) > 50) {
				throw new Exception ( "Uncorrect email address" );
			}

			if (!preg_match($reg_pass,$password) || strlen ( $password ) <3 || strlen ( $password ) > 32){
				throw new Exception ( "Uncorrect password" );
			}

			$res = searchUser ($email,$conn);
			//print_r($res);
			//die();
			$password = md5($password);
			if($res == -1){
				throw new Exception ( " `SELECT` failure" );
			}else if($res == 0){
				// wrong username
				mysqli_close($conn);
				header("Location: LogIn.php?log=fail_uname");
			}else if ($password != $res["password"]) {
				// wrong password
				mysqli_close($conn);
				header("Location: LogIn.php?log=fail_pass");
			}else{
				// log in
				session_start();
				$_SESSION['username'] = $res["email"];
				$_SESSION['last_activity'] = time();
				mysqli_close($conn);
				header("Location: PersonalPage.php");
			}
		}catch ( Exception $e ){
			mysqli_rollback ( $conn );
			errorRedirector($e->getMEssage());
		}
		mysqli_close($conn);
	}


	public function signUp(){
		$conn = createConnection();
		try {
		mysqli_autocommit($conn,FALSE);

		if (!isset ( $_POST ['email'] )
		|| !isset ( $_POST ['password1'])
		|| !isset ( $_POST ['password2']))
		{
			throw new InvalidArgumentException ( "Empty values" );
		}

		$email 		= sanitize( $conn, $_POST ['email'] );
		$password1 = sanitize( $conn, $_POST ['password1'] );
		$password2 = sanitize( $conn, $_POST ['password2'] );

		// back end validaion
		$reg_email	= '/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/';
		$reg_pass		= '/^(?=.{3})(?=.*[^0-9a-zA-Z])/';

		if (!preg_match ( $reg_email, $email ) || strlen ( $email ) == 0 || strlen ( $email ) > 50) {
			throw new Exception ( "Uncorrect email address" );
		}

		if (!preg_match($reg_pass,$password1) || strlen ( $password1 ) <3 || strlen ( $password ) > 32){
			throw new Exception ( "Uncorrect password" );
		}

		if(strcmp($password1,$password2) != 0){
			throw new Exception ( "passwords don't match" );
		}

		// check if the user already exists
		$res = alredyExists($email,$conn);
		if($res == -1){
			throw new Exception ( " `SELECT` failure: " . mysqli_error($conn));
		}else if($res == 1){
			header ( "Location: SignUp.php?newUser=error");
		}else if($res == 0){ // ok
			$password1 = md5 ( $password1);	// Calculates the MD5 hash of str using the  RSA Data Security,
																			// Inc. MD5 Message-Digest Algorithm, and returns that hash.
			$res2 = insertUser($email,$password1,$conn);
			if( $res2 == -1){
				throw new Exception ( " `INSERT` failure: ". mysqli_error($conn));
			}
			header ( "Location: SignUp.php?newUser=done");
		}
	} catch ( Exception $e ) {
		mysqli_rollback ( $conn );
		errorRedirector($e->getMEssage());
	}
	mysqli_close ($conn);
	}

	public function undo(){
		$query1 = "SELECT * FROM Bricks WHERE owner='" . $this->mail . "' ORDER BY id DESC LIMIT 0, 1";
		$conn = createConnection();
		try {
			mysqli_autocommit($conn,FALSE);

			if (!$res = mysqli_query($conn, $query1)) {
				throw new Exception ( " `SELECT` failure: " . mysqli_error($conn));
			}


			$rowcount=mysqli_num_rows($res);

			if ($rowcount == 1) {
		    // output data of each row
				$result = mysqli_fetch_assoc($res);
				$query2 = "DELETE FROM Bricks WHERE id='" . $result['id'] ."'";
				if (mysqli_query($conn, $query2)) {
					if (!mysqli_commit($conn)) {
					    throw new Exception ( " `COMMIT` failure: " . mysqli_error($conn));
					}
					header ( "Location: PersonalPage.php?msg=undo");
				}else{
					throw new Exception ( " `DELETE` failure: " . mysqli_error($conn));
				}
			} else {
			  header ( "Location: PersonalPage.php?msg=no_res");
			}

		} catch (Exception $e) {
			mysqli_rollback($conn);
			errorRedirector($e->getMEssage());
		}

		mysqli_free_result ( $res );
		mysqli_close($conn);

	}


	}

 ?>
