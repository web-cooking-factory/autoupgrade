<?php

namespace PrestaShop\Module\AutoUpgrade\Router\Middlewares;

use PrestaShop\Module\AutoUpgrade\Router\Routes;

class RestoreConfigurationIsValid extends AbstractMiddleware
{
    public function process(): ?string
    {
        $restoreConfiguration = $this->upgradeContainer->getRestoreConfiguration();

        $errors = $this->upgradeContainer->getRestoreConfigurationValidator()->validate($restoreConfiguration->toArray());

        if (!empty($errors)) {
            return Routes::RESTORE_PAGE_BACKUP_SELECTION;
        }

        return null;
    }
}
