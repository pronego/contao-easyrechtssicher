<?php
/**
 * Easyrechtssicher integration for Contao Open Source CMS.
 *
 * @author    Dr. Manuel Lamotte-Schubert <mls@pronego.com>
 * @copyright 2024, PRONEGO - https://www.pronego.com
 * @license   LGPL-3.0-or-later
 */
namespace Pronego\EasyrechtssicherBundle\Service;

use Contao\Config;
use Contao\Environment;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiService
{
    /** @var HttpClientInterface Client to execute CURL requests. */
    private HttpClientInterface $client;

    /** @var string The API URL scheme. */
    private string $apiUrlTemplate = 'https://er{type}.net/{apikey}/{lang}/{domain}.html?body';

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Replaces the placeholders and returns the final API URL.
     *
     * @param string $siteType The site type to query (imp=Impressum|dse=Datenschutzerklärung|wbl=Widerrufsbelehrung).
     * @param string|null $lang The language to use (default: 'de').
     *
     * @return string The full API URL.
     */
    public function generateApiUrl(string $siteType, ?string $lang = null): string
    {
        return strtr($this->apiUrlTemplate, [
            '{type}' => $siteType,
            '{apikey}' => Config::get('apikey'),
            '{lang}' => $lang ?? 'de',
            '{domain}' => $domain ?? Environment::get('host'),
        ]);
    }


    /**
     * Executes the CURL request and returns the result.
     *
     * @param  string  $url  The full API URL with resolved placeholders.
     * @param  array|null  $queryParams
     * @param  array|null  $headers
     *
     * @return string|null The (raw) response if successful, an error message or null, otherwise.
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function callApi(string $url, ?array $queryParams = [], ?array $headers = []): ?string
    {
        try {
            $response = $this->client->request('GET', $url, [
                'headers' => $headers,
                'query' => $queryParams,
            ]);

            if (200 === $response->getStatusCode()) {
                return $response->getContent();
            }
        } catch (\Exception $e) {
            return 'API-Fehler: ' . $e->getMessage();
        }

        return null;
    }
}