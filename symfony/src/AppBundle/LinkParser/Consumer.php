<?php

namespace AppBundle\LinkParser;

use Fusonic\Linq\Linq;
use Fusonic\OpenGraph\Objects\ObjectBase;
use Fusonic\OpenGraph\Objects\Website;
use Fusonic\OpenGraph\Property;
use GuzzleHttp\Adapter\AdapterInterface;
use GuzzleHttp\Client;
use Symfony\Component\CssSelector\CssSelectorConverter;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Consumer that extracts Open Graph data from either a URL or a HTML string.
 */
class Consumer extends \Fusonic\OpenGraph\Consumer
{

    private $client;

    /**
     * @param   AdapterInterface    $adapter        Guzzle adapter to use for making HTTP requests.
     */
    public function __construct(AdapterInterface $adapter = null)
    {
        $this->client = new Client(
            [
                "timeout" => 10,
                "allow_redirects" => true,
                "adapter" => $adapter,
            ]
        );
    }

    /**
     * Fetches HTML content from the given URL and then crawls it for Open Graph data.
     *
     * @param   string  $url            URL to be crawled.
     *
     * @return  Website
     */
    public function loadUrl($url)
    {
        // Fetch HTTP content using Guzzle
        $response = $this->client->get($url);

        $data = $this->loadHtml($response->getBody()->__toString(), $url);

        if (false !== strpos($response->getHeader('Content-Type')[0], 'image')) {
            $data->type = 'image';
        } else if (false !== strpos($url, 'https://x-team.slack.com/files/')) {
            $data->type = 'image';
            $data->url = $this->loadSlackImage($response->getBody()->__toString());
            var_dump($url);die();
        } else {
            try {
                if (null == $data->title) {
                    $data->title = $this->loadTitle($response->getBody()->__toString());
                }
                if (null == $data->description) {
                    $data->description = $this->loadDescription($response->getBody()->__toString());
                }
            } catch (\Exception $e) {

            }
        }

        $data->description = htmlspecialchars($data->description);
        $data->description = urlencode($data->description);

        return $data;
    }

    private function loadTitle($content)
    {
        $crawler = new Crawler($content);

        /** @var Crawler $ogMetaTags */
        $ogMetaTags = $crawler->filter("title");

        return $ogMetaTags->text();
    }


    private function loadDescription($content)
    {
        $crawler = new Crawler($content);

        return $crawler->filterXpath('//meta[@name="description"]')->attr('content');
    }


    private function loadSlackImage($content)
    {
//        $crawler = new Crawler($content);

        //@todo download image from slack
        throw new \Exception('Slack images not implemented yet');

        return '';
    }
}
//file_page_image