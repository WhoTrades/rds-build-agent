<?php
class RemoteModel
{
    private static $instance = null;

    private function __construct()
    {

    }

    public static function getInstance()
    {
        return self::$instance = self::$instance ?: new self();
    }

    private function sendRequest($action, $data, $isPost = false)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
        $url = "http://".Config::$rdsDomain."/api/$action";
        if ($isPost) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        } else {
            $url .= "?".http_build_query($data);
        }
        curl_setopt($ch, CURLOPT_URL, $url);

        echo date("r").": Requesting $url\n";
        if ($isPost) {
            echo "POST data: ".json_encode($data)."\n";
        }

        for ($i = 0; $i < 10; $i++) {
            $result = curl_exec($ch);

            $data = json_decode($result, true);

            if ($data === null && $data != json_encode(null)) {
                echo "Response: $result\n";
                if ($i < 10) {
                    echo "CURL error received, retry...\n";
                    continue;
                }
                throw new Exception("Can't send request to $url");
            }
            break;
        }

        return $data;
    }

    public function sendStatus($taskId, $status, $version = null, $attach = null)
    {
        return $this->sendRequest("sendStatus", array(
            'taskId' => $taskId,
            'status' => $status,
            'version' => $version,
            'attach' => $attach,
        ), true);
    }

    public function sendMigrations($taskId, $migrations)
    {
        return $this->sendRequest("sendMigrations", array(
            'taskId' => $taskId,
            'migrations' => $migrations,
        ));
    }

    public function sendCronConfig($taskId, $text)
    {
        return $this->sendRequest("sendCronConfig", array(
            'taskId' => $taskId,
            'text' => $text,
        ), true);
    }

    public function getNextTask($workerName)
    {
        return $this->sendRequest('getBuildTasks', array('worker' => $workerName));
    }

    public function getMigrationTask($workerName)
    {
        return $this->sendRequest('getMigrationTask', array('worker' => $workerName));
    }

    public function sendMigrationStatus($project, $version, $status)
    {
        return $this->sendRequest('sendMigrationStatus', array('project' => $project, 'version' => $version, 'status' => $status));
    }

    public function getUseTask($workerName)
    {
        return $this->sendRequest('getUseTasks', array('worker' => $workerName));
    }

    public function getKillTask($workerName)
    {
        return $this->sendRequest('getKillTask', array('worker' => $workerName));
    }

    public function setUseError($id, $text)
    {
        return $this->sendRequest('setUseError', array('id' => $id, 'text' => $text,));
    }

    public function setOldVersion($id, $version)
    {
        return $this->sendRequest('setOldVersion', array('id' => $id, 'version' => $version));
    }

    public function setUsedVersion($worker, $project, $version, $status)
    {
        return $this->sendRequest('setUsedVersion', array('worker' => $worker, 'project' => $project, 'version' => $version, 'status' => $status));
    }

    public function getCurrentStatus($taskId)
    {
        return $this->sendRequest('getCurrentStatus', array('id' => $taskId));
    }

    public function getProjects()
    {
        return $this->sendRequest('getProjects', array());
    }

    public function getProjectBuildsToDelete($allBuilds)
    {
        return $this->sendRequest('getProjectBuildsToDelete', array('builds' => $allBuilds), true);
    }

    public function removeReleaseRequest($projectName, $version)
    {
        return $this->sendRequest('removeReleaseRequest', array('projectName' => $projectName, 'version' => $version));
    }
}

function executeCommand($command)
{
    echo "Executing `$command`\n";
    exec($command, $output, $returnVar);
    $text = implode("\n", $output);

    if ($returnVar) {
        throw new \CommandException("Return var is non-zero", $returnVar, $text);
    }

    return $text;
}

class CommandException extends Exception
{
    public $output;

    public function __construct($message, $code, $output, $previous = null)
    {
        $this->output = $output;
        parent::__construct($message, $code, $previous);
    }
}
