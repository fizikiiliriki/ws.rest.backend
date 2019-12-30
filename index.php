<?

define(DOCUMENT_ROOT, '/api');

$className=str_replace(DOCUMENT_ROOT, '', $_SERVER['REQUEST_URI']);
$className=preg_replace('/[0-9]+/', 'INT', $className);
$className=$_SERVER['REQUEST_METHOD'].preg_replace('/[^A-z]/', '', $className);

if (class_exists($className)) {
	$Processor = new $className;
	$Processor->process();
} else Request::response(404, 'Not found', null);

class Request {

	function __construct() {

			if ($this->checkLogin) $this->checkLogin();
			if ($this->requiredFields) $this->checkRequired($Processor->requiredFields);
			if ($this->checkByEXP) $this->chekByEXP($Processor->checkByEXP);

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
		header('HTTP/1.1 '.$httpCode.' '.$httpStatus);
		if ($data) echo json_encode($data);
		exit;
	}

}

class POSTsignup extends Request {

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

class POSTlogin extends Request {

	public $requiredFields=[
		'phone'=>'обязательное',
		'password'=>'обязательное',
	];

	function process () {

	}

}

class POSTlogout extends Request {

	public $checkLogin=true;

	function process () {
		Request::response(200, 'OK', null);
	}

}

class POSTphoto extends Request {

	public $checkLogin=true;
	public $requiredFields=[
		'photo'=>'обязательное, файл с изображением, только jpg, jpeg или png'
	];

	function process () {

	}

}

class POSTphotoINT extends Request {

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

class GETphoto extends Request {

	//public $checkLogin=true;

	function process () {

	}

}

class GETphotoINT extends Request {

	public $checkLogin=true;

	function process () {

	}

}

class DELETEphotoINT extends Request {

	public $checkLogin=true;

	function process () {

	}

}

class POSTuserINTshare extends Request {

	public $checkLogin=true;
	public $requiredFields=[
		'photos'=>'массив с идентификаторами фотографий. В случае, если в массиве будет id фотографии которая уже была расшарена, то повторно она расшарена не будет'
	];

	function process () {

	}

}

class GETuser extends Request {

	public $checkLogin=true;
	public $requiredFields=[
		'search'=>'строка запроса, в которой указывается имя (или часть имени) и (или) фамилия (или часть фамилии) и (или) номер телефона (или часть номера телефона). Например: Иван Иванов 7951, И Иван 7'
	];

	function process () {

	}

}