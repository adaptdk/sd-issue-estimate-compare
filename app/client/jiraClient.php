<?php

namespace App\client;

use GuzzleHttp\Client;
class jiraClient

{
    private $user;
    private $token;

    private $url;

    private $client;

    const issuesJQL = 'project = ADP AND Sprint = %s ORDER BY priority DESC';

    const jiraUrl = 'https://sygeforsikringdk.atlassian.net/';

    public function __construct($user, $token)
    {
        $this->user = $user;
        $this->token = $token;
        $this->url = self::jiraUrl;

        $this->client = new Client(
            ['base_uri' => $this->url,
             'auth' => [$this->user, $this->token]
            ]
        );
    }

    public function getIssuesJQL($sprint) {
        return sprintf(self::issuesJQL, $sprint);
    }

    public function getJiraUrl() {
        return self::jiraUrl;
    }

    public function getIssueByKey($key) {
        $response = $this->client->get('rest/api/2/issue/'. $key);
        return json_decode($response->getBody());
    }

    public function getIssues($sprint, $count = 100) {
        $response = $this->client->get('rest/api/2/search', ['query' => ['jql' => $this->getIssuesJQL($sprint), 'maxResults' => $count]]);

        $data = json_decode($response->getBody());

        return $data->issues;
    }

    public function getSprintList($board = 'Sprint: Proces/System') {
        $response = $this->client->get('/rest/greenhopper/1.0/sprint/picker');

        $data = json_decode($response->getBody(), true);

        $list = [];
        $allSprints = array_merge($data['allMatches'], $data['suggestions']);
        foreach ($allSprints as $sprint) {
            if ($sprint['boardName'] === $board) {
                $list[$sprint['id']] = $sprint['name'];
            }
        }

        return $list;
    }

}