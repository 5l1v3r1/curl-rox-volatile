<?php

require __DIR__ . '/../vendor/autoload.php';

use CurlRox\Curl;
$pool = new Pool(2);
foreach(['http://google.com', 'http://twitter.com'] as $url) {
    $anonClass = new class(new Curl, $url) extends Threaded {
        public $curl;

        public function __construct($curl, $url) {
            $this->curl = $curl;
            $this->url = $url;
        }

        public function run() {
            $this->curl->setUri($this->url); //
            $this->curl->setPostPayload(['name' => 'Rodrigo', 'language' => 'C']); //
            //$this->curl->getRequest(); //
            $this->curl->postRequest();
            var_dump($this->curl->getHttpRequest());
        }
    };

    $pool->submit($anonClass);
}

while ($pool->collect()) continue;
$pool->shutdown();