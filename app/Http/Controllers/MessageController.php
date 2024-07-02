<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Pusher\ApiErrorException;
use Pusher\Pusher as Pusher;
use Pusher\PusherException;

class MessageController extends Controller
{
    /**
     * @throws PusherException
     * @throws GuzzleException
     * @throws ApiErrorException
     */
    public function index(Request $request)
    {
        $options = array(
            'cluster' => 'eu',
            'useTLS' => true
        );
        $pusher = new Pusher(
            config('services.pusher.app_key'),
            config('services.pusher.app_secret'),
            config('services.pusher.app_id'),
            $options
        );

        $data['message'] = $request->message;
        $data['user'] = Auth::check() ? $request->user() : 'anonymous';
        $data['time'] = Carbon::now()->format('H:i:s');
        $pusher->trigger('my-channel', 'my-event', $data);
    }
}
