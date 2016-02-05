<?php
namespace tzfrs\LongURL\Config;

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
	 * Wheter to use cache for expanded urls
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
	 * Wheter to use cache for expanded urls
	 *
	 * @var string
	 */
	public $cachePath = '/tmp/';
}