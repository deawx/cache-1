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
use willphp\framework\build\Provider;
class CacheProvider extends Provider {
	public $defer = false;  //ясЁы╪сть	 
	public function boot() {
		
	}
	public function register() {
		$this->app->single('Cache', function () {
			return new Cache();
		});
	}
}