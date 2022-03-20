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
 * Memcache»º´æÀà
 * Class File
 * @package willphp\cache\build
 */
class Memcache implements InterfaceCache {
	protected $link;	
	//Á¬½Ó
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
	//ÉèÖÃ»º´æ
	public function set($name, $value, $expire = 0) {
		return $this->link->set($name, $value, 0, $expire);
	}
	//»ñÈ¡»º´æ
	public function get($name) {
		return $this->link->get($name);
	}
	//É¾³ý»º´æ
	public function del($name) {
		return $this->link->delete($name);
	}
	//¼ì²â»º´æÊÇ·ñ´æÔÚ
	public function has($name) {
		return !$this->link->get($name)? false : true;
	}
	//Çå³ý»º´æ³Ø
	public function flush() {
		return $this->link->flush();
	}
}