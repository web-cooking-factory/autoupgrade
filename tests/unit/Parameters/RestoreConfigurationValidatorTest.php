<?php

use PHPUnit\Framework\TestCase;
use PrestaShop\Module\AutoUpgrade\Backup\BackupFinder;
use PrestaShop\Module\AutoUpgrade\Parameters\RestoreConfiguration;
use PrestaShop\Module\AutoUpgrade\Parameters\RestoreConfigurationValidator;
use PrestaShop\Module\AutoUpgrade\UpgradeContainer;

class RestoreConfigurationValidatorTest extends TestCase
{
    /**
     * @var RestoreConfigurationValidator
     */
    private $validator;

    private $backupFinderMock;

    protected function setUp(): void
    {
        $this->container = new UpgradeContainer('/html', '/html/admin');

        $this->backupFinderMock = $this->createMock(BackupFinder::class);

        $this->validator = new RestoreConfigurationValidator(
            $this->container->getTranslator(),
            $this->backupFinderMock
        );
    }

    public function testValidateReturnsErrorWhenBackupNameIsMissing(): void
    {
        $errors = $this->validator->validate([]);

        $this->assertCount(1, $errors);
        $this->assertSame(['message' => 'Backup name is missing', 'target' => RestoreConfiguration::BACKUP_NAME], $errors[0]);
    }

    public function testValidateReturnsErrorWhenBackupDoesNotExist(): void
    {
        $backupName = 'non_existing_backup.zip';

        $this->backupFinderMock
            ->method('getAvailableBackups')
            ->willReturn(['existing_backup.zip']);

        $errors = $this->validator->validate([RestoreConfiguration::BACKUP_NAME => $backupName]);

        $this->assertCount(1, $errors);
        $this->assertSame(['message' => 'Backup non_existing_backup.zip does not exist', 'target' => RestoreConfiguration::BACKUP_NAME], $errors[0]);
    }

    public function testValidateReturnsNoErrorsWhenBackupIsValid(): void
    {
        $backupName = 'existing_backup.zip';

        $this->backupFinderMock
            ->method('getAvailableBackups')
            ->willReturn([$backupName]);

        $errors = $this->validator->validate([RestoreConfiguration::BACKUP_NAME => $backupName]);

        $this->assertCount(0, $errors);
    }
}
