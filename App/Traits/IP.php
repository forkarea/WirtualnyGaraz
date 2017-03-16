<?php

namespace PioCMS\Traits;

trait IP {

    /** @var int */
    private $ip;

    function getIp() {
        return long2ip($this->ip);
    }

    function setIp($ip) {
        $this->ip = ip2long($ip);
    }

}
