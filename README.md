# 缓存管理
cache组件提供了多种高效的缓存处理方式，包括File缓存、Memcache缓存和Redis缓存。

#开始使用

####安装组件
使用 composer 命令进行安装或下载源代码使用(依赖willphp/config组件)。

    composer require willphp/cache

> WillPHP 框架已经内置此组件，无需再安装。

####调用示例

    \willphp\config\Cache::driver('memcache')->get('cache'); //切换memcache的缓存获取cache

####缓存配置

`config/cache.php`配置文件示例如下：

	return [
		'driver' => 'file', //默认缓存类型
		'file' => [
			'dir' => RUNTIME_PATH.'/cache', //文件缓存目录
		],
		'memcache' => [
				'host' => '127.0.0.1',
				'port' => 11211,
		],
		'redis'    => [
				'host' => '127.0.0.1',
				'port' => 6379,
				'password' => '',
				'database' => 0,
		],
	];

####设置缓存

    Cache::set('app', 'willphp', 3600);  

####检测缓存

    Cache::has('app'); //是否存在缓存

####获取缓存

    Cache::get('app'); 

####删除缓存

    Cache::del('app'); 

####清空缓存

    Cache::flush(); //清除缓存池

#cache函数

####参数说明

  cache('[缓存名]', '[缓存数据]', [有效时间], '[缓存类型]');  

####获取缓存
	
    $cache= cache('app');

####设置缓存

    cache('app', 'willphp);

####检测缓存

    $bool= cache('?app');

####删除缓存

    cache('app', null);

####清空缓存

    cache(null);




