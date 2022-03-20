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
 * �ļ�������
 * Class File
 * @package willphp\cache\build
 */
class File implements InterfaceCache {
	private $dir; //����Ŀ¼	
	public function connect() {
		$this->dir(Config::get('cache.file.dir'));		
	}	
	//����
	public function dir($dir) {
		if (!$this->create($dir)) {
			throw new \Exception('Directory creation failed or is not writable.');
		}
		$this->dir = $dir;
		return $this;
	}	
	 //��������Ŀ¼
	private function create($dir, $auth = 0755) {
		if (!empty($dir)) {
			return is_dir($dir) or mkdir($dir, $auth, true);
		}
		return false;
	}	
	//��ȡ�����ļ�
	private function getFile($name) {
		return $this->dir.'/'.md5($name).'.php';
	}
	 //���û���
	public function set($name, $data, $expire = 0) {
		$file = $this->getFile($name);
		$expire = sprintf("%010d", $expire);
		$content = $expire.serialize($data);	
		$result = file_put_contents($file, $content);
		return $result? $data : false;
	}
	//��ȡ����
	public function get($name) {
		$file = $this->getFile($name);		
		if (!is_file($file) || !is_readable($file)) {
			return false;
		}
		$content = file_get_contents($file);
		$expire  = intval(substr($content, 0, 10));
		$mtime = filemtime($file);
		if ($expire > 0 && $mtime + $expire < time()) {
			if (is_file($file)) {
				unlink($file);
			}			
			return false;
		}		
		return unserialize(substr($content, 10));
	}	
	//��⻺���Ƿ����
	public function has($name) {
		$file = $this->getFile($name);
		if (!is_file($file) || !is_readable($file)) {
			return false;
		}
		return true;
	}
	//ɾ������
	public function del($name) {
		$file = $this->getFile($name);
		if (is_file($file)) {
			return unlink($file);
		}		
		return true;
	}	
	//��������
	public function flush() {
		$dir = $this->dir;
		if (!is_dir($dir)) {
			return true;
		}
		$files = array_diff(scandir($dir), ['.', '..']);
		foreach ($files as $file) {
			(is_dir("$dir/$file")) ? $this->del("$dir/$file") : unlink("$dir/$file");
		}		
		return rmdir($dir);
	}
}