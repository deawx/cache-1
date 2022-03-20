<?php
/*--------------------------------------------------------------------------
 | Software: [WillPHP framework]
 | Site: www.113344.com
 |--------------------------------------------------------------------------
 | Author: no-mind <24203741@qq.com>
 | WeChat: www113344
 | Copyright (c) 2020-2022, www.113344.com. All Rights Reserved.
 |-------------------------------------------------------------------------*/
namespace willphp\cache\build;
use willphp\config\Config;
/**
 * Redis������
 * Class File
 * @package willphp\cache\build
 */
class Redis implements InterfaceCache {
	protected $link;	
	//����
	public function connect() {		
		if (!class_exists('redis')) {
			throw new \Exception('Redis is not installed.');			
		}	
		$conf = Config::get('cache.redis');	
		$this->link = new \Redis();
		if (!$this->link->connect($conf['host'], $conf['port'])) {
			throw new \Exception('Redis connection failed.');
		} 
		$this->link->auth($conf['password']);
		$this->link->select($conf['database']);		
	}
	//���û���
	public function set($name, $value, $expire = 3600) {
		if ($this->link->set($name, $value)) {
			return $this->link->expire($name, $expire);
		}
	}
	//��ȡ����
	public function get($name) {
		return $this->link->get($name);
	}
	//ɾ������
	public function del($name) {
		return $this->link->delete($name);
	}
	//��⻺���Ƿ����
	public function has($name) {
		return !$this->link->get($name)? false : true;
	}
	//��������
	public function flush() {
		return $this->link->flushall();
	}
}