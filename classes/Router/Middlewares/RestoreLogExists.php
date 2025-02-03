<?php

namespace PrestaShop\Module\AutoUpgrade\Router\Middlewares;

use PrestaShop\Module\AutoUpgrade\Router\Routes;
use PrestaShop\Module\AutoUpgrade\Task\TaskType;

class RestoreLogExists extends AbstractMiddleware
{
    public function process(): ?string
    {
        $activeRestoreLogPath = $this->upgradeContainer->getLogsService()->getLogsPath(TaskType::TASK_TYPE_RESTORE);

        if ($activeRestoreLogPath === null
            || !$this->upgradeContainer->getFileSystem()->exists($activeRestoreLogPath)) {
            return Routes::HOME_PAGE;
        }

        return null;
    }
}
