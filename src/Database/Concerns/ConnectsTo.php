<?php

namespace Mahmoud\ScandiwebTask\Database\Concerns;

use Mahmoud\ScandiwebTask\Database\Managers\Contracts\DatabaseManager;

trait ConnectsTo
{
	public static function connect(DatabaseManager $manager)
    {
        return $manager->connect();
    }
}