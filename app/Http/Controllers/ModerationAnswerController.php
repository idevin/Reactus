<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Models\ModerationAnswer;
use App\Traits\Activity;
use Illuminate\Http\RedirectResponse;

class ModerationAnswerController extends Controller
{
    use Activity;

    public function __construct()
    {
        parent::__construct();
        $this->setSiteUserActivity();
    }

    public function confirm(int $id): RedirectResponse
    {
        $moderationAnswer = ModerationAnswer::find($id);

        if ($moderationAnswer) {
            $moderationAnswer->update(['confirmed_at' => date('Y-m-d H:i:s', strtotime('now'))]);
        }
        session()->flash('flash.success', 'Статья будет еще раз проверена и отправлена на публикацию.');
        return redirect()->back();
    }
}
