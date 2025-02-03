<?php

namespace PrestaShop\Module\AutoUpgrade\Router\Middlewares;

use PrestaShop\Module\AutoUpgrade\Router\Routes;

class RestoreLogExists extends AbstractMiddleware
{
    public function process(): ?string
    {
        if ($this->upgradeContainer->getLogsState()->getActiveRestoreLogFile() === null) {
            return Routes::HOME_PAGE;
        }

        return null;
    }
}
