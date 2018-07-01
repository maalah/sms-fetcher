<?php namespace SMSFetcher\Providers;

use SMSFetcher\Types\Number;

class ReceiveSmsOnlineInfo extends Provider implements ProviderInterface {
    const URL = 'https://www.receive-sms-online.info/';

    public function getNumbers() {
        $xpath  = $this->getXpath(self::URL);
        $data   = [];

        /** @var \DOMElement $node */
        foreach ($xpath->query('//div[@class="Cell"]//div') AS $i => $node) {
            $country    = $node->firstChild;
            $phone      = $country->nextSibling->nextSibling;
            $received   = explode(':', $phone->nextSibling->textContent);
            $number     = new Number();

            $number->setPhone($phone->textContent);
            $number->setCountry($country->textContent);
            $number->setUrl(self::URL.$phone->getAttribute('href'));
            $number->setReceived(end($received));

            $data[] = $number;
        }

        return $data;
    }
}