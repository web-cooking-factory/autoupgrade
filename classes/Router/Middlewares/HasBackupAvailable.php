<?php

namespace PrestaShop\Module\AutoUpgrade\Router\Middlewares;

use PrestaShop\Module\AutoUpgrade\Router\Routes;

class HasBackupAvailable extends AbstractMiddleware
{
    public function process(): ?string
    {
        $backups = $this->upgradeContainer->getBackupFinder()->getAvailableBackups();

        if (empty($backups)) {
            return Routes::HOME_PAGE;
        }

        return null;
    }
}
