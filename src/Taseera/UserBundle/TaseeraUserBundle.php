<?php

namespace Taseera\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class TaseeraUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
