<?php
namespace tzfrs\LongURL;

/**
 * Class Config
 *
 * This class used as global Config file
 *
 * @package madwings\LongURL\Config
 * @author MadWings
 * @license MIT License
 */
class Config {
	/**
	 * Wheter to use cache for services
	 *
	 * @var bool
	 */
	public $useCacheGetServices = true;
	
	/**
	 * Wheter to use cache for short urls
	 *
	 * @var bool
	 */
	public $useCacheIsShort = false;
	
	/**
	 * Wheter to use cache for expanded urls
	 *
	 * @var bool
	 */
	public $useCacheExpandUrl = false;
	
	/**
	 * Cache path
	 *
	 * @var string
	 */
	public $cachePath = '/tmp/';

	/**
	 * Custom Services XML file path, set null if not used
	 *
	 * @var string
	 */
	public $servicesPath = null;

	// --------------------------------------------------------------------

	/**
	 * Class constructor
	 *
	 * @param	array	$params
	 *
	 * @return	void
	 */
	public function __construct(array $params = null) {
		if ( ! empty($params)) {
			foreach ($params as $key => $value) {
				$this->$key = $value;
			}
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Set custom services filepath
	 *
	 * @param	string	$filePath
	 *
	 * @return	void
	 */
	public function setCustomServices($filePath) {
		$this->servicesPath = $filePath;
	}

	// --------------------------------------------------------------------

	/**
	 * Set cache filepath
	 *
	 * @param	string	$filePath
	 *
	 * @return	void
	 */
	public function setCachePath($filePath) {
		$this->cachePath = $filePath;
	}
}
