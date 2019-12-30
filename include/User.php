<?

class User {

	function __construct () {

		global $DB;

		$this->DB = $DB;

		session_start();

		if ($_POST['login'] && $_POST['password']) $this->signin();
		$this->data=$_SESSION['user'];

	}

	function signin () {

		$users=$this->DB->select('users', ['login'=>$_POST['login'], 'password'=>md5($_POST['password'])]);

		foreach ($users as $user) {
			$_SESSION['user']=$user;
		}

	}

	function checkRoles ($roles) {

	}

}

$User = new User;