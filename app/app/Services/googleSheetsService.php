<?php

namespace App\Services;

use Google\Service\Sheets;
use \Google\Service\Sheets\ValueRange;
use Google\Client;

class googleSheetsService
{
    private $client;

    public function googleSheetsClient()
    {
        $this->client = new Client();
        $this->client->setApplicationName('Logt3ch');
        $this->client->setScopes([Sheets::SPREADSHEETS]);
        $this->client->setAuthConfig(base_path(env('GOOGLE_CREDENTIALS_PATH')));
        $this->client->setPrompt('');
        return $this->client;
    }
}
