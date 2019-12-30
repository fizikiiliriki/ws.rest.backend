<?

define(DOCUMENT_ROOT, '/ws');

class Request {

	function __construct() {

		$className=str_replace(DOCUMENT_ROOT, '', $_SERVER['REQUEST_URI']);
		$className=preg_replace('/[0-9]+/', 'INT', $className);
		$className=$_SERVER['REQUEST_METHOD'].preg_replace('/[^A-z]/', '', $className);

		if (class_exists($className)) {

			$Processor = new $className;

			if ($Processor->checkLogin) $this->checkLogin();
			if ($Processor->requiredFields) $this->checkRequired($Processor->requiredFields);
			if ($Processor->checkByEXP) $this->chekByEXP($Processor->checkByEXP);
			$Processor->process();

		} else Request::response(404, 'Not found', null);
	}

	function checkLogin () {

		if (NOT_LOGGED) {
			Request::response(403, 'Forbidden', ['message'=>'You need authorization']);
		}

	}

	function checkRequired ($fields) {
		foreach($fields as $key=>$value) {

		}
	}

	function checkByEXP ($fields) {
		foreach($fields as $key=>$value) {

		}
	}

	static function response ($httpCode, $httpStatus, $data) {
		header('Content-Type: application/json');
		header('HTTP/1.0 '.$httpCode.' '.$httpStatus);
		if ($data) echo json_encode($data);
		exit;
	}

}

class POSTsignup {

	public $requiredFields=[
		'first_name'=>'обязательное',
		'surname'=>'обязательное',
		'phone'=>'обязательное, уникальное, ровно 11 цифр, может быть с ведущими нулями',
		'password'=>'обязательное',
	];
	public $checkByEXP=[
		'first_name'=>'^[А-я]$',
		'surname'=>'^[А-я]$',
		'phone'=>'^[0-9]{11}$',
		'password'=>'.{6,}',
	];

	function process () {
		Request::response(201, 'Created', ['id'=>$id]);
	}

}

class POSTlogin {

	public $requiredFields=[
		'phone'=>'обязательное',
		'password'=>'обязательное',
	];

	function process () {

	}

}

class POSTlogout {

	public $checkLogin=true;

	function process () {
		Request::response(200, 'OK', null);
	}

}

class POSTphoto {

	public $checkLogin=true;
	public $requiredFields=[
		'photo'=>'обязательное, файл с изображением, только jpg, jpeg или png'
	];

	function process () {

	}

}

class POSTphotoINT {

	public $checkLogin=true;
	public $requiredFields=[
		'_method'=>'обязательное поле, со значением “patch”, без кавычек'
	];
	public $checkByEXP=[
		'_method'=>'^patch$',
	];

	function process () {

	}

}

class GETphoto {

	public $checkLogin=true;

	function process () {

	}

}

class GETphotoINT {

	public $checkLogin=true;

	function process () {

	}

}

class DELETEphotoINT {

	public $checkLogin=true;

	function process () {

	}

}

class POSTuserINTshare {

	public $checkLogin=true;
	public $requiredFields=[
		'photos'=>'массив с идентификаторами фотографий. В случае, если в массиве будет id фотографии которая уже была расшарена, то повторно она расшарена не будет'
	];

	function process () {

	}

}

class GETuser {

	public $checkLogin=true;
	public $requiredFields=[
		'search'=>'строка запроса, в которой указывается имя (или часть имени) и (или) фамилия (или часть фамилии) и (или) номер телефона (или часть номера телефона). Например: Иван Иванов 7951, И Иван 7'
	];

	function process () {

	}

}

$Request= new Request;