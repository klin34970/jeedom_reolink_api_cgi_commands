<?php
//echo '<pre>' . print_r($argv[2], true) . '</pre>';
header('Content-Type: application/json');
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

require_once('vendor/autoload.php');

class Reolink {
	
	private $user;
	private $password;
	
	private $method;
	private $action;
	private $ip;
	private $api = '/cgi-bin/api.cgi';
	
	public function __construct($argv){
		$this->user = $argv[2];
		$this->password = $argv[3];
		
		$this->method = $argv[4];
		$this->action = $argv[5];
		$this->ip = $argv[1];
		
		$this->init();
	}
	
	private function init(){
      	echo $this->method;
      
        if($this->method && is_numeric($this->action) && $this->ip){
            if(method_exists($this, $this->method)){      
                call_user_func([$this, $this->method], $this->action);
            }
        }
    }
	
	private function request($method, $cmd, $queries){
		$client = new \GuzzleHttp\Client([
			'base_uri' => 'http://' . $this->ip,
			'exceptions' => false,
            'CURLOPT_SSL_VERIFYPEER' => false,
			'headers'  => ['content-type' => 'application/json', 'Accept' => 'application/json'],
		]);
		$response = $client->request($method, $this->api . '?cmd=' . $cmd, $queries);
		return $response;
	}
		
	
	public function enableMotionEmail($action){
		//TOKEN
		$params = [
				'cmd' => 'Login',
				'action' => 0,
				'param' => [
					'User' => [
						'userName' => $this->user,
						'password' => $this->password
					]
				]
			
		];
		$response = $this->request('POST', 'Login', [
				'debug' => false,
				'json' => [
					$params
				]
			]
		);

		if($data = json_decode($response->getBody())){
			if(isset($data[0]->value->Token->name) && $token = $data[0]->value->Token->name){
				//EMAIL
				$params = [
					'cmd' => 'SetEmail',
					'action' => 0,
					'param' => [
						'Email' => [
							'smtpServer' => 'smtp.com',
							'nickName' => 'nickName',
							'smtpPort' => 587,
							'userName' => 'userName@smtp.com',
							'password' => 'password',
							'addr1' => 'addr1@smtp.com',
							'addr2' => 'addr2@smtp.com',
							'addr3' => 'addr3@smtp.com',
							'interval' => '30 Seconds',
							'ssl' => 1,
							'attachment' => 'picture',
							'schedule' => [
								'enable' => intval($action),
								'table' => '111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111'
							]
						]
					]
				];

				$response = $this->request('POST', 'SetEmail&token=' . $token, [
						'debug' => false,
						'json' => [
							$params
						]
					]
				);
				//PUSH
				$table = $action ? '111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111' : '000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000';
				$params = [
					'cmd' => 'SetPush',
					'action' => 0,
					'param' => [
						'Push' => [
							'schedule' => [
								'table' => $table
							]
						]
					]
				];

				$response = $this->request('POST', 'SetPush&token=' . $token, [
						'debug' => false,
						'json' => [
							$params
						]
					]
				);
				echo '<pre>' . print_r($response->getBody()->getContents(), true) . '</pre>';
				
			}
		}
	}
}

if(!isset($argv[1]) || !isset($argv[2]) || !isset($argv[3]) || !isset($argv[4]) || !isset($argv[5])){
	echo "Tout les arguments ne sont pas présents.";
}else{
	new Reolink($argv);
}
