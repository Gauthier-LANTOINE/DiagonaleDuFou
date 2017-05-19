<?php

namespace GL\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class GLUserBundle extends Bundle {

    public function getParent() {
        return 'FOSUserBundle';
    }
}
