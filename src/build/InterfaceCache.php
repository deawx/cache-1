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
/**
 * 缓存处理接口
 * Interface InterfaceCache
 * @package willphp\cache\build
 */
interface InterfaceCache {
	public function connect();
	public function set($name, $value, $expire);
	public function get($name);
	public function del($name);
	public function has($name);
	public function flush();
}