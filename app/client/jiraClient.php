<?php

namespace App\client;

use GuzzleHttp\Client;
class jiraClient

{
    private $user;
    private $token;

    private $url;

    private $client;

    const issuesJQL = 'project = ADP AND Sprint = 40 ORDER BY priority DESC';

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

    public function getIssuesJQL() {
        return self::issuesJQL;
    }

    public function getJiraUrl() {
        return self::jiraUrl;
    }

    public function getIssueByKey($key) {
        $response = $this->client->get('rest/api/2/issue/'. $key);
        return json_decode($response->getBody());
    }

    public function getIssues($count = 100) {
        $response = $this->client->get('rest/api/2/search', ['query' => ['jql' => self::issuesJQL, 'maxResults' => $count]]);

        $data = json_decode($response->getBody());

        return $data->issues;
    }





}