<?php
/**
 * Created by PhpStorm.
 * User: rune
 * Date: 2020-01-15
 * Time: 19:18
 */

namespace App\service;

use Seld\CliPrompt\CliPrompt;


class bootstrap
{
    private $keychain;

    private $configuration;

    const keystoreName = 'sygeforsikringdk-jira';

    public function __construct(configuration $configuration)
    {
        $this->configuration = $configuration;
        $this->keychain = new KeyChain();
        date_default_timezone_set('Europe/Copenhagen');
    }

    public function init() {

        $credentials = $this->keychain->get_password(self::keystoreName);


        if (empty($credentials)) {


            print "Jira email\n\r";
            $user = CliPrompt::prompt();
            print "Generate a token on the page that will open next\n\r";
            sleep(4);
            exec('open https://id.atlassian.com/manage/api-tokens');
            print "Jira token\n\r";
            $token = CliPrompt::hiddenPrompt();

            $credentials = implode(':', [$user, $token]);
            if (!empty($user) && !empty($token)) {
               $this->keychain->set_password(self::keystoreName, $credentials);
            }

        }
        else {
            list($user, $token) = explode (':', $credentials);
        }

        $this->configuration->set('jira.user', $user);
        $this->configuration->set('jira.token', $token);

    }
}