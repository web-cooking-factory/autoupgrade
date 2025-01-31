<?php

namespace PrestaShop\Module\AutoUpgrade\Parameters;

use PrestaShop\Module\AutoUpgrade\Backup\BackupFinder;
use PrestaShop\Module\AutoUpgrade\UpgradeTools\Translator;

class RestoreConfigurationValidator
{
    /**
     * @var Translator
     */
    private $translator;

    /**
     * @var BackupFinder
     */
    private $backupFinder;

    public function __construct(Translator $translator, BackupFinder $backupFinder)
    {
        $this->translator = $translator;
        $this->backupFinder = $backupFinder;
    }

    /**
     * @param array<string, mixed> $array
     *
     * @return array<array{'message': string, 'target': string}>
     */
    public function validate(array $array = []): array
    {
        $errors = [];

        $backupNameErrors = $this->validateBackupName($array);
        if ($backupNameErrors) {
            $errors[] = $backupNameErrors;

            return $errors;
        }

        $backupNameExistErrors = $this->validateBackupExist($array[RestoreConfiguration::BACKUP_NAME]);
        if ($backupNameExistErrors) {
            $errors[] = $backupNameExistErrors;
        }

        return $errors;
    }

    /**
     * @param array<string, mixed> $backupConfiguration
     *
     * @return string|null
     */
    private function validateBackupName(array $backupConfiguration): ?string
    {
        if (empty($backupConfiguration[RestoreConfiguration::BACKUP_NAME])) {
            return $this->translator->trans('Backup name is missing');
        }

        return null;
    }

    private function validateBackupExist(string $backupName): ?string
    {
        if (!in_array($backupName, $this->backupFinder->getAvailableBackups())) {
            return $this->translator->trans('Backup %s does not exist', [$backupName]);
        }

        return null;
    }
}
