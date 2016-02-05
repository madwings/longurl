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
}
