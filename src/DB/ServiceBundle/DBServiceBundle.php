<?php

namespace DB\ServiceBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class DBServiceBundle extends Bundle {
    
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
