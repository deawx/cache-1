<?php
if (!function_exists('cache')) {
	/**
	 * 获取和设置缓存
	 * @param string	$name  参数名
	 * @param mixed		$value 参数值
	 * @param number	$expire 有效时间
     * @param string 	$driver 缓存驱动
	 * @return mixed
	 */
	function cache($name = '', $value = '', $expire = 0, $driver = 'file') {
		static $instance = null;
		if ($name == '') {
			return '';
		}
		if (is_null($instance)) {
			$instance = \willphp\cache\Cache::driver($driver);
		}
		if (is_null($name)) {
			return $instance->flush();
		}
		if ('' === $value) {
			return (0 === strpos($name, '?'))? $instance->has(substr($name, 1)) : $instance->get($name);
		}
		if (is_null($value)) {
			return $instance->del($name);
		}
		return $instance->set($name, $value, $expire);
	}
}