<?php
/*--------------------------------------------------------------------------
 | Software: [WillPHP framework]
 | Site: www.113344.com
 |--------------------------------------------------------------------------
 | Author: no-mind <24203741@qq.com>
 | WeChat: www113344
 | Copyright (c) 2020-2022, www.113344.com. All Rights Reserved.
 |-------------------------------------------------------------------------*/
namespace willphp\cache;
use willphp\config\Config;
class Cache {
	protected $link = null;	
	 //ÉèÖÃ»º´æÇý¶¯
	public function driver($driver = null) {
		static $cache = [];		
		$driver = $driver? $driver : Config::get('database.driver', 'file');
		$class = '\willphp\cache\build\\'.ucfirst($driver);
		if (!class_exists($class)) {
			throw new \Exception('['.ucfirst($driver).'] cache driver does not exist.');
		}
		if ($driver == 'file' || !isset($cache[$driver])) {
			$cache[$driver] = new $class();
		}
		$this->link = $cache[$driver];	
		$this->link->connect();
		return $this;
	}	
	public function __call($method, $params) {		
		if (is_null($this->link)) {
			$this->driver();
		}
		if (method_exists($this->link, $method)) {
			return call_user_func_array([$this->link, $method], $params);
		}		
		return $this->link;
	}
	public static function __callStatic($name, $arguments) {
		return call_user_func_array([new static(), $name], $arguments);
	}
}