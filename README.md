# ZFDebug - a debug bar for Zend Framework
ZFDebug is a plugin for the Zend Framework for PHP5, providing useful debug information displayed in a small bar at the bottom of every page.

Time spent, memory usage and number of database queries are presented at a glance. Additionally, included files, a listing of available view variables and the complete SQL command of all queries are shown in separate panels:

![](http://jokke.dk/media/2011-zfdebug.png)

The available plugins at this point are:

  * Cache: Information on Zend_Cache, APC and Zend OPcache (for PHP 5.5).
  * Database: Full listing of SQL queries from Zend_Db and the time for each.
  * Exception: Error handling of errors and exceptions.
  * File: Number and size of files included with complete list.
  * Html: Number of external stylesheets and javascripts. Link to validate with W3C.
for custom memory measurements.
  * Log: Timing information of current request, time spent in action controller and custom timers. Also average, min and max time for requests.
  * Variables: View variables, request info and contents of `$_COOKIE`, `$_POST` and `$_SESSION`

Installation & Usage
------------
To install, place the folder 'ZFDebug' in your library path, next to the Zend
folder. Then add the following method to your bootstrap class (in ZF1.8+):

	protected function _initZFDebug()
	{
        $options = [
            'plugins' => [
                'Variables',
                'Database' => ['adapter' => Zend_Registry::getInstance()->get('db')],
                'File' => ['basePath' => constant('PORTAL_PATH')],
                'Cache' => ['backend' => $cache->getBackend()],
                'Exception',
            ],
        ];
        $debug = new \ZFDebug\Controller\Plugin\Debug($options);
	    $this->bootstrap('frontController');
	    $frontController = $this->getResource('frontController');
	    $frontController->registerPlugin($debug);
	}

Using Composer
--------------
You may now install ZFDebug using the dependency management tool Composer.

To use ZFDebug with Composer, add the following to the require list in your
project's composer.json file:

	"require": {
	    "vox-tecnologia/zfdebug": "~1.6"
	},

Run the install command to resolve and download the dependencies:

	composer install

Further documentation will follow as the github move progresses.
