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
 * Memcache������
 * Class File
 * @package willphp\cache\build
 */
class Memcache implements InterfaceCache {
	protected $link;	
	//����
	public function connect() {		
		if (!class_exists('memcache')) {
			throw new \Exception('Memcache is not installed.');			
		}	
		$conf = Config::get('cache.memcache');	
		$this->link = new \Memcache();
		if (!$this->link) {
			throw new \Exception('Memcache connection failed.');
		} 
		$this->link->addServer($conf['host'], $conf['port']);
	}
	//���û���
	public function set($name, $value, $expire = 0) {
		return $this->link->set($name, $value, 0, $expire);
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
		return $this->link->flush();
	}
}