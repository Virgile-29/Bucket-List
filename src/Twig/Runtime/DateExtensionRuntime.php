<?php

namespace App\Twig\Runtime;

use DateTime;
use Twig\Extension\RuntimeExtensionInterface;

class DateExtensionRuntime implements RuntimeExtensionInterface
{
    public function __construct()
    {
        // Inject dependencies if needed
    }

    public function dateFilterFr(DateTime $date )
    {
        dd($date);
    }
}
