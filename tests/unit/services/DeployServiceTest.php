<?php
/**
 * @author Maksim Rodikov
 */
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use \whotrades\RdsSystem\lib\Exception\EmptyAttributeException;
use \whotrades\RdsSystem\lib\Exception\FilesystemException;
use whotrades\RdsSystem\lib\Exception\CommandExecutorException;
use whotrades\RdsSystem\lib\ScriptExecutor;
use whotrades\RdsSystem\Message\BuildTask;
use \whotrades\RdsSystem\Message\ProjectConfig;
use \whotrades\RdsSystem\Message\UseTask;
use \whotrades\RdsBuildAgent\services\DeployService;
use \org\bovigo\vfs\vfsStream;
use \PHPUnit\Framework\MockObject\MockBuilder;
use \PHPUnit\Framework\MockObject\MockObject;
use \whotrades\RdsSystem\lib\CommandExecutor;
use yii\base\Event;

class DeployServiceTest extends TestCase
{
    /** @var \org\bovigo\vfs\vfsStreamDirectory  */
    private $root;

    public function setUp(): void
    {
        $this->root = vfsStream::setup();
    }

    public function tearDown(): void
    {
        $this->root = null;
    }

    /**
     * @throws CommandExecutorException
     * @throws EmptyAttributeException
     * @throws FilesystemException
     */
    public function testUseProjectConfigLocal()
    {
        /** @var ProjectConfig|MockObject $projectConfig */
        $projectConfig = $this->getProjectConfigMockBuilder()->getMock();
        $projectConfig->expects($this->once())->method('accepted');

        $deployService = $this->getDeployServiceMock();
        $deployService->method('getCommandExecutor')->willReturn($this->getCommandExecutorMock());
        $output = $deployService->useProjectConfigLocal($projectConfig);
        $this->assertStringStartsWith($deployService->getTemporaryScriptPath($projectConfig->project), $output);
    }

    /**
     * @throws CommandExecutorException
     * @throws EmptyAttributeException
     * @throws FilesystemException
     */
    public function testEmptyUploadScript()
    {
        $this->expectException(EmptyAttributeException::class);

        $projectConfig = $this->getProjectConfigMockBuilder()
            ->setConstructorArgs([null, [], null, [], null])
            ->getMock();

        $deployService = $this->getDeployServiceMock();
        $deployService->useProjectConfigLocal($projectConfig);
    }

    /**
     * @throws CommandExecutorException
     * @throws EmptyAttributeException
     * @throws FilesystemException
     */
    public function testCreateDirectoryFailure()
    {
        $this->expectException(FilesystemException::class);
        $this->expectExceptionCode(FilesystemException::ERROR_WRITE_DIRECTORY);

        $projectConfig = $this->getProjectConfigMockBuilder()->getMock();
        $projectConfig->expects($this->once())->method('accepted');

        $deployService = $this->getDeployServiceMock();
        $deployService->method('getCommandExecutor')->willReturn($this->getCommandExecutorMock());
        $this->root->getChild("config-local")->chmod(0000);
        $deployService->useProjectConfigLocal($projectConfig);
    }

    /**
     * @throws CommandExecutorException
     * @throws EmptyAttributeException
     * @throws FilesystemException
     */
    public function testWriteConfigFileFailure()
    {
        $this->expectException(FilesystemException::class);
        $this->expectExceptionCode(FilesystemException::ERROR_WRITE_FILE);

        /** @var ProjectConfig|MockObject $projectConfig */
        $projectConfig = $this->getProjectConfigMockBuilder()->getMock();
        $projectConfig->expects($this->once())->method('accepted');

        $deployService = $this->getDeployServiceMock();

        $projectDir = $deployService->getProjectDirectoryPath($projectConfig->project);
        mkdir($projectDir, 0777, true);
        $this->root->getChild(vfsStream::path($projectDir))->chmod(0000);
        @$deployService->useProjectConfigLocal($projectConfig); // @ - ignore stream open failure warning
    }

    /**
     * @throws CommandExecutorException
     * @throws EmptyAttributeException
     * @throws FilesystemException
     */
    public function testWriteScriptFileFailure()
    {
        $this->expectException(FilesystemException::class);
        $this->expectExceptionCode(FilesystemException::ERROR_WRITE_FILE);

        /** @var ProjectConfig|MockObject $projectConfig */
        $projectConfig = $this->getProjectConfigMockBuilder()->getMock();
        $projectConfig->expects($this->once())->method('accepted');

        $deployService = $this->getDeployServiceMock();

        $projectDir = $deployService->getProjectDirectoryPath($projectConfig->project);
        mkdir($projectDir, 0777, true);
        $this->root->getChild("config-local")->chmod(0000);

        @$deployService->useProjectConfigLocal($projectConfig); // @ - ignore stream open failure warning
    }

    /**
     * @throws CommandExecutorException
     * @throws EmptyAttributeException
     * @throws FilesystemException
     */
    public function testCommandExecutorFailure()
    {
        $this->expectException(CommandExecutorException::class);

        $projectConfig = $this->getProjectConfigMockBuilder()->getMock();
        $projectConfig->expects($this->once())->method('accepted');

        /** @var \PHPUnit\Framework\MockObject\MockObject|DeployService $deployService */
        $deployService = $this->getDeployServiceMock();

        $commandExecutor = $this->createMock(CommandExecutor::class);
        $e = new CommandExecutorException("command", "message", 0, "output");
        $commandExecutor->method('executeCommand')->will($this->throwException($e));
        $deployService->method('getCommandExecutor')->willReturn($commandExecutor);

        $deployService->useProjectConfigLocal($projectConfig);
    }

    /**
     * @throws CommandExecutorException
     * @throws EmptyAttributeException
     * @throws FilesystemException
     */
    public function testUseVersionCommandExecutorFailure()
    {
        $this->expectException(CommandExecutorException::class);

        $useTask = $this->getUseTaskMockBuilder()->getMock();
        $useTask->expects($this->once())->method('accepted');

        /** @var \PHPUnit\Framework\MockObject\MockObject|DeployService $deployService */
        $deployService = $this->getDeployServiceMock();

        $commandExecutor = $this->createMock(CommandExecutor::class);
        $e = new CommandExecutorException("command", "message", 0, "output");
        $commandExecutor->method('executeCommand')->will($this->throwException($e));
        $deployService->method('getCommandExecutor')->willReturn($commandExecutor);

        $deployService->useProjectVersion($useTask);
    }

    /**
     * @throws CommandExecutorException
     * @throws EmptyAttributeException
     * @throws FilesystemException
     */
    public function testUseVersionWriteScriptFailure()
    {
        $this->expectException(FilesystemException::class);
        $this->expectExceptionCode(FilesystemException::ERROR_WRITE_FILE);

        $useTask = $this->getUseTaskMockBuilder()->getMock();
        $useTask->expects($this->once())->method('accepted');

        $deployService = $this->getDeployServiceMock();

        $this->root->chmod(0000);

        @$deployService->useProjectVersion($useTask); // @ - ignore stream open failure warning
    }

    /**
     * @throws CommandExecutorException
     * @throws EmptyAttributeException
     * @throws FilesystemException
     */
    public function testUseVersionEmptyUseScript()
    {
        $this->expectException(EmptyAttributeException::class);

        $useTask = $this->getUseTaskMockBuilder()
            ->setConstructorArgs([null, null, '', '', '', []])
            ->getMock();

        $deployService = $this->getDeployServiceMock();
        $deployService->useProjectVersion($useTask);
    }

    /**
     * @throws CommandExecutorException
     * @throws EmptyAttributeException
     * @throws FilesystemException
     */
    public function testUseVersion()
    {
        $useTask = $this->getUseTaskMockBuilder()->getMock();
        $useTask->expects($this->once())->method('accepted');

        $deployService = $this->getDeployServiceMock();
        $deployService->method('getCommandExecutor')->willReturn($this->getCommandExecutorMock());
        $output = $deployService->useProjectVersion($useTask);
        $this->assertStringStartsWith($deployService->getUseScriptPath(), $output);
    }

    /**
     *
     */
    public function testProjectFilenamePathMatchProjectDirectoryPath()
    {
        /** @var DeployService|\PHPUnit\Framework\MockObject\MockObject $deployService */
        $deployService = $this->getMockBuilder(DeployService::class)
            ->setConstructorArgs([])
            ->onlyMethods([
                'getTmpDirectory',
                'getCommandExecutor',
                'getTemporaryScriptPath',
                'getUseScriptPath',
            ])
            ->getMock();

        $this->assertStringContainsString($deployService->getProjectDirectoryPath('test'), $deployService->getProjectFilenamePath('test', 'config.local.php'), 'ProjectFilenamePath MUST contain ProjectDirectoryPath');
    }

    public function testDeployBuild()
    {
        /** @var MockObject | BuildTask $buildTask */
        $buildTask = $this->getBuildTaskMockBuilder()->getMock();
        $buildTask->expects($this->once())->method('accepted');

        $deployService = $this->getDeployServiceMock();
        $deployService->method('getScriptExecutor')->willReturn($this->getScriptExecutorMock());

        $deployService->deployBuild($buildTask, 'workah');
    }

    public function testDeployBuildEventsOrderAndQuantity()
    {
        $eventCounters = [];
        Event::on(DeployService::class, '*', function (Event $event) use (&$eventCounters) {
            $eventCounters[$event->name] = isset($eventCounters[$event->name]) ? $eventCounters[$event->name] + 1 : 1;
        });

        /** @var MockObject | BuildTask $buildTask */
        $buildTask = $this->getBuildTaskMockBuilder()->getMock();
        $buildTask->expects($this->once())->method('accepted');

        $deployService = $this->getDeployServiceMock();
        $deployService->method('getScriptExecutor')->willReturn($this->getScriptExecutorMock());

        $deployService->deployBuild($buildTask, 'workah');

        $this->assertEquals([
            DeployService::EVENT_DEPLOY_STATUS       => 2,
            DeployService::EVENT_MIGRATION_FINISH    => 3,
            DeployService::EVENT_CRON_CONFIG_UPDATE  => 1,
        ], $eventCounters);
    }

    //public function testDeployBuild

    /**
     * @return DeployService | MockObject
     */
    protected function getDeployServiceMock(): DeployService
    {
        $directory = new \org\bovigo\vfs\vfsStreamDirectory("config-local");
        $this->root->addChild($directory);

        /** @var DeployService|\PHPUnit\Framework\MockObject\MockObject $deployService */
        $deployService = $this->getMockBuilder(DeployService::class)
            ->setConstructorArgs([])
            ->onlyMethods([
                'getTmpDirectory',
                'getCommandExecutor',
                'getScriptExecutor',
                'getProjectDirectoryPath',
                'getTemporaryScriptPath',
                'getProjectFilenamePath',
                'getUseScriptPath',
            ])
            ->getMock();
        $deployService->method('getTmpDirectory')->willReturn($this->root->url());
        $deployService->method('getProjectDirectoryPath')->willReturn($directory->url() . "/project");
        $deployService->method('getTemporaryScriptPath')->willReturn($directory->url() . "/script.sh");
        $deployService->method('getUseScriptPath')->willReturn($this->root->url() . "/script.sh");
        $deployService->method('getProjectFilenamePath')->willReturnCallback(function ($project, $filename) use ($directory) {
            return $directory->url() . "/project/" . $filename;
        });

        return $deployService;
    }

    /**
     * @return CommandExecutor
     */
    protected function getCommandExecutorMock(): CommandExecutor
    {
        $commandExecutor = $this->createMock(CommandExecutor::class);
        $commandExecutor->method('executeCommand')->willReturnArgument(0);
        return $commandExecutor;
    }

    /**
     * @return ScriptExecutor
     */
    protected function getScriptExecutorMock(): ScriptExecutor
    {
        $scriptExecutor = $this->createMock(ScriptExecutor::class);
        $scriptExecutor->method('execute')->willReturn("TEST");
        return $scriptExecutor;
    }

    /**
     * @return MockBuilder
     */
    protected function getProjectConfigMockBuilder(): MockBuilder
    {
        return $this->getMockBuilder(ProjectConfig::class)
            ->setConstructorArgs([
                'TEST_PROJECT_NAME',
                ['config.local' => 'TEST_CONTENT'],
                'TESTCOMMAND',
                ['localhost'],
                null,
            ])
            ->setMethodsExcept(['getProjectServers']);
    }

    /**
     * @return MockBuilder
     */
    protected function getUseTaskMockBuilder(): MockBuilder
    {
        return $this->getMockBuilder(UseTask::class)
            ->setConstructorArgs([
                'TEST_PROJECT_NAME',
                42,
                '42.000.test',
                'phpunit',
                'TESTCOMMAND',
                ['localhost'],
            ])
            ->setMethodsExcept(['getProjectServers']);
    }

    /**
     * @return MockBuilder
     */
    protected function getBuildTaskMockBuilder(): MockBuilder
    {
        return $this->getMockBuilder(BuildTask::class)
            ->setConstructorArgs([
                1,
                'TEST_PROJECT_NAME',
                '42.000.test',
                'test',
                'SCRIPT_MIGRATION',
                'SCRIPT_BUILD',
                'SCRIPT_CRON',
                ['localhost'],
            ])
            ->setMethodsExcept(['getProjectServers']);
    }

}
