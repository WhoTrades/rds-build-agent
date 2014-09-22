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
        $url = "http://".\Config::getInstance()->rdsDomain."/api/$action";
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

    /** @implemented \RdsSystem\Message\ReleaseRequestsRequest */
    /** @implemented \RdsSystem\Message\ReleaseRequestsReply */
    public function getReleaseRequests($project)
    {
        return $this->sendRequest('getReleaseRequests', array('project' => $project));
    }

    /** @implemented \RdsSystem\Message\ProjectBuildsToDeleteRequest */
    /** @implemented \RdsSystem\Message\ProjectBuildsToDeleteReply */
    public function getProjectBuildsToDelete($allBuilds)
    {
        return $this->sendRequest('getProjectBuildsToDelete', array('builds' => $allBuilds), true);
    }

    /** @implemented \RdsSystem\Message\RemoveReleaseRequest */
    public function removeReleaseRequest($projectName, $version)
    {
        return $this->sendRequest('removeReleaseRequest', array('projectName' => $projectName, 'version' => $version));
    }
}



