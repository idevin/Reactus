<?php

namespace App\Console\Commands;

use App\Models\Section;
use App\Models\UserSession;
use Illuminate\Console\Command;

class SessionsIndex extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sessions:index';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Переиндексация сессий';

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $sessions = UserSession::all();
        foreach ($sessions as $session) {
            $location = null;

            if (is_string($session->location)) {
                $location = json_decode($session->location, true);
            } elseif (is_array($session->location)) {
                $location = $session->location;
            }

            if ($location) {
                $session->update([
                    'country_string' => $location['country']
                ]);
            }
        }

        return;
    }
}