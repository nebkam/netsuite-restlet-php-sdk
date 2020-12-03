<?php

namespace Infostud\NetSuiteSdk;

use Eher\OAuth\Consumer;
use Eher\OAuth\HmacSha1;
use Eher\OAuth\OAuthException;
use Eher\OAuth\Request;
use Eher\OAuth\SignatureMethod;
use Eher\OAuth\Token;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Infostud\NetSuiteSdk\Model\CreateCustomerResponse;
use Infostud\NetSuiteSdk\Model\CustomerForm;
use Infostud\NetSuiteSdk\Model\DeleteCustomerResponse;
use Infostud\NetSuiteSdk\Model\SavedSearch\Customer;
use Infostud\NetSuiteSdk\Model\SuiteQL\GetLocationsResponse;
use Infostud\NetSuiteSdk\Model\SuiteQL\GetSubsidiariesResponse;
use Infostud\NetSuiteSdk\Model\SavedSearch\SavedSearchCustomersResponse;
use Infostud\NetSuiteSdk\Model\SuiteQL\Department;
use Infostud\NetSuiteSdk\Model\SuiteQL\GetDepartmentsResponse;
use Infostud\NetSuiteSdk\Model\SuiteQL\Location;
use Infostud\NetSuiteSdk\Model\SuiteQL\Subsidiary;
use Infostud\NetSuiteSdk\Model\SuiteQL\SuiteQLResponse;
use LogicException;
use RuntimeException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

class ApiService
	{
	/**
	 * @var string
	 */
	private $account;
	/**
	 * @var string
	 */
	private $restletHost;
	/**
	 * @var Client
	 */
	private $client;
	/**
	 * @var Consumer
	 */
	private $consumer;
	/**
	 * @var Token
	 */
	private $accessToken;
	/**
	 * @var SignatureMethod
	 */
	private $signatureMethod;
	/**
	 * @var ApiSerializer
	 */
	private $serializer;
	/**
	 * @var int
	 */
	private $savedSearchCustomersId;
	/**
	 * @var int
	 */
	private $suiteQLId;
	/**
	 * @var int
	 */
	private $createDeleteCustomerId;

	/**
	 * @param string $configPath
	 */
	public function __construct(string $configPath)
		{
		$config = $this->readJsonConfig($configPath);

		$this->account                = $config['account'];
		$this->restletHost            = $config['account'] . '.restlets.api.netsuite.com';
		$this->client                 = new Client();
		$this->consumer               = new Consumer(
			$config['consumerKey'], $config['consumerSecret']
		);
		$this->accessToken            = new Token(
			$config['accessTokenKey'], $config['accessTokenSecret']
		);
		$this->signatureMethod        = new HmacSha1();
		$this->serializer             = new ApiSerializer();
		$this->savedSearchCustomersId = $config['restletIds']['savedSearchCustomers'];
		$this->suiteQLId              = $config['restletIds']['suiteQL'];
		$this->createDeleteCustomerId = $config['restletIds']['createDeleteCustomer'];
		}

	/**
	 * @param CustomerForm $customerForm
	 * @return int|null
	 * @throws ExceptionInterface
	 */
	public function createCustomer(CustomerForm $customerForm): ?int
		{
		$requestBody = $this->serializer->normalize($customerForm);
		$url         = $this->getRestletUrl($this->createDeleteCustomerId, 3);
		try
			{
			$guzzleResponse = $this->client->request('POST', $url, [
				RequestOptions::HEADERS => $this->buildHeaders('POST', $url),
				RequestOptions::JSON    => $requestBody
			]);
			if ($guzzleResponse->getStatusCode() === 200)
				{
				$contents = $guzzleResponse->getBody()->getContents();
				/** @var CreateCustomerResponse $apiResponse */
				$apiResponse = $this->serializer->deserialize($contents, CreateCustomerResponse::class);
				if ($apiResponse->isSuccessful()
					&& $apiResponse->getCustomerId())
					{
					return $apiResponse->getCustomerId();
					}
				}
			}
		catch (OAuthException $exception)
			{
			}
		catch (GuzzleException $exception)
			{
			}

		return null;
		}

	/**
	 * @param int $id
	 * @return bool
	 */
	public function deleteCustomer(int $id): bool
		{
		$url = $this->getRestletUrl($this->createDeleteCustomerId, 3, [
			'customerid' => $id
		]);
		try
			{
			$guzzleResponse = $this->client->request('DELETE', $url, [
				RequestOptions::HEADERS => $this->buildHeaders('DELETE', $url)
			]);
			if ($guzzleResponse->getStatusCode() === 200)
				{
				$contents = $guzzleResponse->getBody()->getContents();
				/** @var DeleteCustomerResponse $apiResponse */
				$apiResponse = $this->serializer->deserialize($contents, DeleteCustomerResponse::class);
				return $apiResponse->isSuccessful();
				}
			}
		catch (OAuthException $exception)
			{}
		catch (GuzzleException $exception)
			{}

		return false;
		}

	/**
	 * @param string $pib
	 * @return Customer|null
	 */
	public function findCustomerByPib(string $pib): ?Customer
		{
		$filters = [[
			'name'     => 'custentity_pib',
			'operator' => 'is',
			'values'   => [$pib]
		]];
		try
			{
			$results = $this->executeSavedSearchCustomers($filters);
			if (!empty($results->getCustomers()))
				{
				return $results->getCustomers()[0];
				}
			}
		catch (OAuthException $exception)
			{
			}
		catch (GuzzleException $e)
			{
			}

		return null;
		}

	/**
	 * @param string $pib
	 * @return Customer|null
	 */
	public function findCustomerByPibFragment(string $pib): ?Customer
		{
		$filters = [[
			'name'     => 'custentity_pib',
			'operator' => 'contains',
			'values'   => [$pib]
		]];
		try
			{
			$results = $this->executeSavedSearchCustomers($filters);
			if (!empty($results->getCustomers()))
				{
				return $results->getCustomers()[0];
				}
			}
		catch (OAuthException $exception)
			{
			}
		catch (GuzzleException $e)
			{
			}

		return null;
		}

	/**
	 * @param string $registryIdentifier
	 * @return Customer|null
	 */
	public function findCustomerByRegistryIdentifier(string $registryIdentifier): ?Customer
		{
		$filters = [[
			'name'     => 'custentity_matbrpred',
			'operator' => 'is',
			'values'   => [$registryIdentifier]
		]];
		try
			{
			$results = $this->executeSavedSearchCustomers($filters);
			if (!empty($results->getCustomers()))
				{
				return $results->getCustomers()[0];
				}
			}
		catch (OAuthException $exception)
			{
			}
		catch (GuzzleException $e)
			{
			}

		return null;
		}

	/**
	 * @return Subsidiary[]
	 */
	public function getSubsidiaries(): array
		{
		try
			{
			return $this->executeSuiteQuery(
				GetSubsidiariesResponse::class,
				'select parent, id , name from subsidiary'
			);
			}
		catch (OAuthException $exception)
			{
			}
		catch (GuzzleException $exception)
			{
			}

		return [];
		}

	/**
	 * @return Department[]
	 */
	public function getDepartments(): array
		{
		try
			{
			return $this->executeSuiteQuery(
				GetDepartmentsResponse::class,
				'select parent, id , name from department'
			);
			}
		catch (OAuthException $exception)
			{
			}
		catch (GuzzleException $exception)
			{
			}

		return [];
		}

	/**
	 * @return Location[]
	 */
	public function getLocations(): array
		{
		try
			{
			return $this->executeSuiteQuery(
				GetLocationsResponse::class,
				'select id, name, parent from location'
			);
			}
		catch (OAuthException $exception)
			{
			}
		catch (GuzzleException $exception)
			{
			}

		return [];
		}

	/**
	 * @param array $filters
	 * @return SavedSearchCustomersResponse
	 * @throws OAuthException
	 * @throws GuzzleException
	 */
	private function executeSavedSearchCustomers(array $filters): SavedSearchCustomersResponse
		{
		$requestBody    = [
			'filters' => $filters
		];
		$url            = $this->getRestletUrl($this->savedSearchCustomersId, 1);
		$clientResponse = $this->client->request('POST', $url, [
			RequestOptions::HEADERS => $this->buildHeaders('POST', $url),
			RequestOptions::JSON    => $requestBody
		]);

		if ($clientResponse->getStatusCode() === 200)
			{
			$contents = $clientResponse->getBody()->getContents();
			/** @var SavedSearchCustomersResponse $response */
			$response = $this->serializer->deserialize($contents, SavedSearchCustomersResponse::class);

			return $response;
			}

		throw new LogicException(
			sprintf('Unexpected response status code: %d', $clientResponse->getStatusCode())
		);
		}

	/**
	 * @param string|null $responseClass
	 * @param string $from
	 * @param string $where
	 * @param array $params
	 * @return array
	 * @throws GuzzleException
	 * @throws OAuthException
	 */
	public function executeSuiteQuery(
		?string $responseClass,
		string $from,
		$where = ' ',
		$params = []
	): array
		{
		$requestBody    = [
			'sql_from'  => $from,
			'sql_where' => $where,
			'params'    => $params
		];
		$url            = $this->getRestletUrl($this->suiteQLId, 1);
		$clientResponse = $this->client->request('POST', $url, [
			RequestOptions::HEADERS => $this->buildHeaders('POST', $url),
			RequestOptions::JSON    => $requestBody
		]);

		if ($clientResponse->getStatusCode() === 200)
			{
			$contents = $clientResponse->getBody()->getContents();
			if ($responseClass)
				{
				/** @var SuiteQLResponse $response */
				$response = $this->serializer->deserialize($contents, $responseClass);

				return !empty($response->getRows()) ? $response->getRows() : [];
				}

			return json_decode($contents, true);
			}

		throw new LogicException(
			sprintf('Unexpected response status code: %d', $clientResponse->getStatusCode())
		);
		}

	/**
	 * @param int $scriptId
	 * @param int $deploymentId
	 * @param array $additionalQueryParams
	 * @return string
	 */
	private function getRestletUrl(int $scriptId, int $deploymentId, $additionalQueryParams = []): string
		{
		$queryParams = array_merge([
			'script' => $scriptId,
			'deploy' => $deploymentId
		], $additionalQueryParams);

		return sprintf('https://%s.restlets.api.netsuite.com/app/site/hosting/restlet.nl?', $this->account)
			. http_build_query($queryParams);
		}

	/**
	 * @param string $method
	 * @param string $url
	 * @return array
	 * @throws OAuthException
	 */
	private function buildHeaders(string $method, string $url): array
		{
		$request   = new Request($method, $url, [
			'oauth_nonce'            => md5(mt_rand()),
			'oauth_timestamp'        => idate('U'),
			'oauth_version'          => '1.0',
			'oauth_token'            => $this->accessToken->key,
			'oauth_consumer_key'     => $this->consumer->key,
			'oauth_signature_method' => $this->signatureMethod->get_name(),
		]);
		$signature = $request->build_signature($this->signatureMethod, $this->consumer, $this->accessToken);
		$request->set_parameter('oauth_signature', $signature);
		$request->set_parameter('realm', $this->account);

		return [
			'Authorization' => substr($request->to_header($this->account), 15),
			'Host'          => $this->restletHost,
			'Content-Type'  => 'application/json'
		];
		}

	/**
	 * @param string $path
	 * @return array
	 * @throws RuntimeException
	 */
	private function readJsonConfig(string $path): array
		{
		if (!file_exists($path)
			|| !is_readable($path))
			{
			throw new RuntimeException(
				sprintf('File at `%s` doesn\'t exist or isn\'t readable', $path)
			);
			}

		$config = json_decode(file_get_contents($path), true);
		if (!$config)
			{
			throw new RuntimeException(sprintf(
				'Malformed JSON, see %s for reference',
				dirname(__DIR__) . '/sample.config.json'
			));
			}

		return $config;
		}
	}
