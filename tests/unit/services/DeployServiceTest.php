<?php
/**
 * @author Maksim Rodikov
 */
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use whotrades\RdsBuildAgent\services\Deploy\Exceptions\UseConfigLocalErrorException;
use \whotrades\RdsBuildAgent\services\Deploy\Exceptions\UseProjectVersionErrorException;
use \whotrades\RdsSystem\Message\ProjectConfig;
use \whotrades\RdsSystem\Message\UseTask;
use \whotrades\RdsBuildAgent\services\DeployService;
use \org\bovigo\vfs\vfsStream;
use \PHPUnit\Framework\MockObject\MockBuilder;
use \PHPUnit\Framework\MockObject\MockObject;
use \whotrades\RdsSystem\lib\CommandExecutor;

class DeployServiceTest extends TestCase
{
    private $root;

    public function setUp(): void
    {
        $this->root = \org\bovigo\vfs\vfsStream::setup();
    }

    public function tearDown(): void
    {
        $this->root = null;
    }

    /**
     * @throws UseConfigLocalErrorException
     */
    public function testUseProjectConfigLocal()
    {
        $projectConfig = $this->getProjectConfigMockBuilder()->getMock();
        $projectConfig->expects($this->once())->method('accepted');

        $deployService = $this->getDeployServiceMock();
        $deployService->method('getCommandExecutor')->willReturn($this->getCommandExecutorMock());
        $output = $deployService->useProjectConfigLocal($projectConfig);
        $this->assertStringStartsWith($deployService->getTemporaryScriptPath($projectConfig), $output);
    }

    /**
     * @throws UseConfigLocalErrorException
     */
    public function testEmptyUploadScript()
    {
        $this->expectException(UseConfigLocalErrorException::class);
        $this->expectExceptionCode(UseConfigLocalErrorException::ERROR_EMPTY_UPLOAD_SCRIPT);

        $projectConfig = $this->getProjectConfigMockBuilder()
            ->setConstructorArgs([null, [], null, [], null])
            ->getMock();

        $deployService = $this->getDeployServiceMock();
        $deployService->useProjectConfigLocal($projectConfig);
    }

    /**
     * @throws UseConfigLocalErrorException
     */
    public function testCreateDirectoryFailure()
    {
        $this->expectException(UseConfigLocalErrorException::class);
        $this->expectExceptionCode(UseConfigLocalErrorException::ERROR_CREATE_DIR);

        $projectConfig = $this->getProjectConfigMockBuilder()->getMock();
        $projectConfig->expects($this->once())->method('accepted');

        $deployService = $this->getDeployServiceMock();
        $deployService->method('getCommandExecutor')->willReturn($this->getCommandExecutorMock());
        $this->root->getChild("config-local")->chmod(0000);
        $deployService->useProjectConfigLocal($projectConfig);
    }

    /**
     * @throws UseConfigLocalErrorException
     */
    public function testWriteConfigFileFailure()
    {
        $this->expectException(UseConfigLocalErrorException::class);
        $this->expectExceptionCode(UseConfigLocalErrorException::ERROR_WRITE_FILE);

        $projectConfig = $this->getProjectConfigMockBuilder()->getMock();
        $projectConfig->expects($this->once())->method('accepted');

        $deployService = $this->getDeployServiceMock();

        $projectDir = $deployService->getProjectDirectoryPath($projectConfig);
        mkdir($projectDir, 0777, true);
        $this->root->getChild(vfsStream::path($projectDir))->chmod(0000);
        @$deployService->useProjectConfigLocal($projectConfig); // @ - ignore stream open failure warning
    }

    /**
     * @throws UseConfigLocalErrorException
     */
    public function testWriteScriptFileFailure()
    {
        $this->expectException(UseConfigLocalErrorException::class);
        $this->expectExceptionCode(UseConfigLocalErrorException::ERROR_WRITE_FILE);

        $projectConfig = $this->getProjectConfigMockBuilder()->getMock();
        $projectConfig->expects($this->once())->method('accepted');

        $deployService = $this->getDeployServiceMock();

        $projectDir = $deployService->getProjectDirectoryPath($projectConfig);
        mkdir($projectDir, 0777, true);
        $this->root->getChild("config-local")->chmod(0000);

        @$deployService->useProjectConfigLocal($projectConfig); // @ - ignore stream open failure warning
    }

    /**
     * @throws UseConfigLocalErrorException
     */
    public function testCommandExecutorFailure()
    {
        $this->expectException(UseConfigLocalErrorException::class);
        $this->expectExceptionCode(UseConfigLocalErrorException::ERROR_COMMAND_EXECUTOR);

        $projectConfig = $this->getProjectConfigMockBuilder()->getMock();
        $projectConfig->expects($this->once())->method('accepted');

        /** @var \PHPUnit\Framework\MockObject\MockObject|DeployService $deployService */
        $deployService = $this->getDeployServiceMock();

        $commandExecutor = $this->createMock(\whotrades\RdsSystem\lib\CommandExecutor::class);
        $e = new \whotrades\RdsSystem\lib\CommandExecutorException("command", "message", 0, "output");
        $commandExecutor->method('executeCommand')->will($this->throwException($e));
        $deployService->method('getCommandExecutor')->willReturn($commandExecutor);

        $deployService->useProjectConfigLocal($projectConfig);
    }

    /**
     * @throws UseProjectVersionErrorException
     */
    public function testUseVersionCommandExecutorFailure()
    {
        $this->expectException(UseProjectVersionErrorException::class);
        $this->expectExceptionCode(UseProjectVersionErrorException::ERROR_COMMAND_EXECUTOR);

        $useTask = $this->getUseTaskMockBuilder()->getMock();
        $useTask->expects($this->once())->method('accepted');

        /** @var \PHPUnit\Framework\MockObject\MockObject|DeployService $deployService */
        $deployService = $this->getDeployServiceMock();

        $commandExecutor = $this->createMock(\whotrades\RdsSystem\lib\CommandExecutor::class);
        $e = new \whotrades\RdsSystem\lib\CommandExecutorException("command", "message", 0, "output");
        $commandExecutor->method('executeCommand')->will($this->throwException($e));
        $deployService->method('getCommandExecutor')->willReturn($commandExecutor);

        $deployService->useProjectVersion($useTask);
    }

    /**
     * Test UseProjectVersionErrorException returns valid attributes
     */
    public function testUseVersionExceptionHasRelevantAttributes()
    {
        $releaseRequestId = 42;
        $initiatorUserName = 'phpunit';
        $e = new UseProjectVersionErrorException("message", 0, null, $releaseRequestId, $initiatorUserName);
        $this->assertEquals($releaseRequestId, $e->getReleaseRequestId());
        $this->assertEquals($initiatorUserName, $e->getInitiatorUserName());
    }

    /**
     * @throws UseProjectVersionErrorException
     */
    public function testUseVersionWriteScriptFailure()
    {
        $this->expectException(UseProjectVersionErrorException::class);
        $this->expectExceptionCode(UseProjectVersionErrorException::ERROR_WRITE_FILE);

        $useTask = $this->getUseTaskMockBuilder()->getMock();
        $useTask->expects($this->once())->method('accepted');

        $deployService = $this->getDeployServiceMock();

        $this->root->chmod(0000);

        @$deployService->useProjectVersion($useTask); // @ - ignore stream open failure warning
    }

    /**
     * @throws UseProjectVersionErrorException
     */
    public function testUseVersionEmptyUseScript()
    {
        $this->expectException(UseProjectVersionErrorException::class);
        $this->expectExceptionCode(UseProjectVersionErrorException::ERROR_EMPTY_USE_SCRIPT);

        $useTask = $this->getUseTaskMockBuilder()
            ->setConstructorArgs([null, null, '', '', '', []])
            ->getMock();

        $deployService = $this->getDeployServiceMock();
        $deployService->useProjectVersion($useTask);
    }

    /**
     * @throws UseProjectVersionErrorException
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
     * @return DeployService
     */
    protected function getDeployServiceMock(): DeployService
    {
        $directory = new \org\bovigo\vfs\vfsStreamDirectory("config-local");
        $this->root->addChild($directory);

        /** @var DeployService|\PHPUnit\Framework\MockObject\MockObject $deployService */
        $deployService = $this->getMockBuilder(\whotrades\RdsBuildAgent\services\DeployService::class)
            ->onlyMethods([
                'getTmpDirectory',
                'getCommandExecutor',
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
        $commandExecutor = $this->createMock(\whotrades\RdsSystem\lib\CommandExecutor::class);
        $commandExecutor->method('executeCommand')->willReturnArgument(0);
        return $commandExecutor;
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
                ['localhost']
            ])
            ->setMethodsExcept(['getProjectServers']);
    }

}