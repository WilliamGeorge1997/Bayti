<?php

namespace Modules\Client\App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Client\App\Models\Client;
use Modules\Notification\App\Models\Notification;

class NotificationController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:client');
    }

    public function index()
    {
        return returnMessage(true, 'Client Notifications', Auth::user()->notifications()->select('id', 'title', 'description', 'image', 'created_at', 'read_at')->orderByDesc('id')->paginate(5));
    }
    public function allow_notification()
    {
        $user = Auth::user();
        $user->allow_notification = !$user->allow_notification;
        $user->save();
        return returnMessage(true, 'Client Updated Successfully');
    }

    public function readNotification(Request $request)
    {
        Notification::whereIn('id', $request['notifications_ids'])->update(['read_at' => Carbon::now()]);
        return returnMessage(true, 'Notification read successfully');
    }

    public function unReadNotificationsCount()
    {
        $unReadCount = Notification::whereNull('read_at')->whereHasMorph('notifiable', [Client::class], function ($query) {
            $query->where('notifiable_id', Auth::id());
        })->count();
        return returnMessage(true, 'Unread Notifications Count', $unReadCount);
    }
}
