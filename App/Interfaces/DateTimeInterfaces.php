<?php

namespace PioCMS\Interfaces;

interface DateTimeInterfaces {

    public function createDateTime($input);

    public function formatDateTime(\DateTime $date);
}
