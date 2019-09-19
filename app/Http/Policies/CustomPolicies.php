<?php

namespace App\Http\Policies;

use Spatie\Csp\Directive;
use Spatie\Csp\Policies\Basic;
use Spatie\Csp\Keyword;

class CustomPolicies extends Basic
{
    public function configure()
    {
        parent::configure();
        
        $this->addDirective(Directive::STYLE, 'fonts.googleapis.com');
        $this->addDirective(Directive::DEFAULT, 'fonts.gstatic.com');
        $this->reportOnly();
    }
}