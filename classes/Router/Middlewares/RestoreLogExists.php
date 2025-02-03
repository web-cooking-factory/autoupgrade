<?php

namespace PrestaShop\Module\AutoUpgrade\Router\Middlewares;

use PrestaShop\Module\AutoUpgrade\Router\Routes;

class RestoreLogExists extends AbstractMiddleware
{
    public function process(): ?string
    {
        $activeRestoreLogFile = $this->upgradeContainer->getLogsState()->getActiveRestoreLogFile();
        $activeRestoreLogPath = $this->upgradeContainer->getProperty($this->upgradeContainer::LOGS_PATH) . DIRECTORY_SEPARATOR . $activeRestoreLogFile;

        if ($activeRestoreLogFile === null
            || !$this->upgradeContainer->getFileStorage()->exists($activeRestoreLogPath)) {
            return Routes::HOME_PAGE;
        }

        return null;
    }
}
