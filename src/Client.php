<?php

namespace tzfrs\LongURL;

use Gilbitron\Util\SimpleCache;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

/**
 * Class Client
 *
 * This class is the base class of the library. It handles requests, and has methods that are usable by multiple service
 * endpoints. It acts as a "wrapper" for all services.
 *
 * @package madwings\LongURL
 * @author MadWings
 * @license MIT License
 */
class Client
{
	/**
	 * The Base URL of the API
	 * @var string
	 */
	protected $baseURL	= 'http://api.longurl.org';

	/**
	 * The current API Version
	 * @var string
	 */
	protected $version	= 'v2';

	/**
	 * The endpoint that will be used for the API requests
	 * @var null
	 */
	protected $endpoint = null;

	/**
     * @var object
     */
    protected $config;

	/**
	 * @var null|SimpleCache
	 */
	protected $cache	= null;

	/**
	 * The constructor for the class defines if caching should be used
	 */
	public function __construct(Config $config = null)
	{
		if ($config === null) {
			$this->config = new Config();
		} else {
			$this->config = $config;
		}

		if ($this->config->useCacheGetServices === true ||
			$this->config->useCacheIsShort === true ||
			$this->config->useCacheExpandUrl === true) {
			$this->cache = new SimpleCache();
			$this->cache->cache_path = $this->config->cachePath;
		}
	}

	/**
	 * This method executes requests to the LongURL API.
	 *
	 * The method has two function arguments, parameters and url. The parameters are the  query parameters sent with
	 * the request, e.g. the URL that should be queried. The method builds a base URL by building a string with the
	 * API baseURL, version and the endpoint (which is set by the classes that are extending the base Class).
	 * Then Guzzle is used to make a request. If an error occurs, e.g. 400 or 404, and error message is thrown.
	 *
	 * @param array $parameters The parameters that are sent with the request
	 * @param string $format The format in which the response should be returned. Defaults to xml
	 * @return \Psr\Http\Message\StreamInterface|string
	 */
	protected function request(array $parameters = [], $format = 'json')
	{
		$url = $this->baseURL . '/' . $this->version . '/' . $this->endpoint;
		$parameters['format'] = $format;
		$client = new GuzzleClient;
		try {
			$result = $client->get($url, [
				'query' => $parameters
			]);
			return $result->getBody();
		} catch (ClientException $e) {
			return 'API-Request to: '. $e->getRequest()->getUri() . ' failed. ' . $e->getMessage();
		} catch (ServerException $e) {
			return 'LongURL-Server-Exception for: '. $e->getRequest()->getUri() . '. ' . $e->getMessage();
		}
	}

	/**
	 * This method gets XML and simply converts it into JSON
	 *
	 * The method takes an XML string and loads an SimpleXMLElement object while keeping CDATA values which would be
	 * lost without the last attribute. The method then encodes the XML and decodes it afterwards finally turning it
	 * into json. It's optional to get the JSON as array or as objects
	 *
	 * @param string $xml The XML that should be parsed
	 * @param bool $asArray If the result should be an array or an object
	 *
	 * @return mixed
	 */
	protected function parseXML($xml, $asArray = true)
	{
		$xml = new \SimpleXMLElement($xml, LIBXML_NOCDATA);
		$result = array();
		foreach ($xml->services->service as $service) {
			$result[(string)$service] = array('domain' => (string)$service, 'regex' => (string)$service['regex']);
		}

		return $asArray === true ? $result : (object)$result;
	}
}
