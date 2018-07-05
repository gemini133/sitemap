<?php

namespace Helldar\Sitemap\Services;

class Xml
{
    /**
     * @var \DOMDocument
     */
    private $doc;

    /**
     * @var \DOMElement
     */
    private $root;

    /**
     * Xml constructor.
     *
     * @param string $root
     */
    public function __construct($root = 'urlset')
    {
        $this->doc = (new \DOMDocument('1.0', 'utf-8'));

        $this->root = $this->doc->createElement($root);

        $this->root->setAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');

        $this->doc->formatOutput = (bool) config('sitemap.formatOutput', true);
    }

    /**
     * Initialization Xml service from static sources.
     *
     * @param string $root
     *
     * @return \Helldar\Sitemap\Services\Xml
     */
    public static function init($root = 'urlset')
    {
        return new self($root);
    }

    /**
     * @param array $parameters
     * @param string $element_name
     */
    public function addItem($parameters = [], $element_name = 'url')
    {
        ksort($parameters);

        $section = $this->doc->createElement($element_name);

        foreach ($parameters as $key => $value) {
            $elem = $this->doc->createElement($key, $value);
            $section->appendChild($elem);
        }

        $this->root->appendChild($section);
    }

    /**
     * @return string
     */
    public function get()
    {
        $this->doc->appendChild($this->root);

        return $this->doc->saveXML();
    }
}
