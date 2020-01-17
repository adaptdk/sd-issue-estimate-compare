<?php
/**
 * Created by PhpStorm.
 * User: rune
 * Date: 2020-01-14
 * Time: 21:38
 */

namespace App\repository;

use App\client\jiraClient;
use App\model\issue;
use App\service\configuration;

class issueRepository
{

    public $issues;

    private $client;

    public function __construct(configuration $configuration)
    {
        $this->client =  new jiraClient($configuration->get('jira.user'), $configuration->get('jira.token'));
    }

    public function getJiraClient() {
        return $this->client;
    }


    public function getIssueByKey($key) {

    }

    public function getIssues($sprint) {

        $issues = [];
        foreach ($this->client->getIssues($sprint) as $issue) {

            $linkedIssues = [];
            foreach ($issue->fields->issuelinks as $link) {
                if (isset($link->outwardIssue)) {
                    // Filter by linked AU issues
                    if (strpos($link->outwardIssue->key, 'AU') === 0) {
                        $linkedIssue = $this->client->getIssueByKey($link->outwardIssue->id);
                        $linkedIssues[] = new issue($linkedIssue->fields->summary, $linkedIssue->id, $linkedIssue->key, [], $linkedIssue->fields->timeoriginalestimate);
                    }
                }

            }
            $issues[] = new issue($issue->fields->summary, $issue->id, $issue->key, $linkedIssues, $issue->fields->timeoriginalestimate);

        }

        return $this->issues = $issues;

    }
}