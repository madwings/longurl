<?php
namespace tzfrs\LongURL\Endpoints;

use GuzzleHttp\Psr7\Stream;
use tzfrs\LongURL\Client;
use tzfrs\LongURL\Exceptions\ServicesException;

/**
 * Class Services
 *
 * This class is used to make requests to the Services endpoint of the longURL API
 *
 * @package madwings\LongURL\Services
 * @author tzfrs
 * @license MIT License
 */
class Services extends Client
{
	/**
	 * The endpoint that is used for requests to the API
	 * @var string
	 */
	protected $endpoint = 'services';

	/**
	 * This method lists the services from the LongURL Endpoint, which it supports.
	 *
	 * @param string $format
	 * @return mixed
	 * @throws ServicesException
	 */
	public function getServices($format = 'json')
	{
		$cacheName = md5(__FUNCTION__ . $format);

		$customServices = null;
		if ($this->config->servicesPath) {
			$customServices = $this->parseXML(file_get_contents($this->config->servicesPath));
		}

		if ($this->config->useCacheGetServices) {
			$content = $this->cache->get_cache($cacheName);
			if ($content !== false) {
				return $this->formatServices($content, $customServices, $format);
			}
		}

		$stream = $this->request([], $format);
		if ($stream instanceof Stream) {
			$content = $stream->getContents();
			if ($this->config->useCacheGetServices === true) {
				$this->cache->set_cache($cacheName, $content);
			}
			return $this->formatServices($content, $customServices, $format);
		}
		throw new ServicesException($stream);
	}

	/**
	 * This method checks wheter an URL is shortened or a long version
	 *
	 * This method gets the url as a parameter, then gets all the services that are supported by LongURL.
	 * The method then checks if the url has parts of a url shortener service in it and returns a boolean accordingly
	 * @param $url
	 * @return bool
	 * @throws ServicesException
	 */
	public function isShortURL($url)
	{
		$cacheName  = md5(__FUNCTION__ . $url);

		if ($this->config->useCacheIsShort === true) {
			$data = $this->cache->get_cache($cacheName);
			if ($data !== false) {
				return $data === '1';
			}
		}

		$services = $this->getServices();
		$isShortURL = false;
		$domain = str_ireplace('www.', '', parse_url($url, PHP_URL_HOST));
		foreach ($services as $service => $info) {
			if ($service === $domain) {
				$isShortURL = true;
				break;
			}
		}
		
		if ($this->config->useCacheIsShort === true) {
			$this->cache->set_cache($cacheName, $isShortURL);
		}
		
		return $isShortURL;
	}

	/**
	 * Proper formating of the services result
	 *
	 * @param array $services
	 * @param array $customServices
	 * @param string $format
	 * @return array
	 */
	private function formatServices($services, $customServices, $format) {
		$services = $format === 'json' ? json_decode($services, true) : $this->parseXML($services, true);
		if ( ! empty($customServices)) {
			$services = array_merge($services, $customServices);
		}

		return $services;
	}
}
