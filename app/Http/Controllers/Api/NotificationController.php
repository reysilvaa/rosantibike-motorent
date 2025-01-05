<?php
// app/Http/Controllers/Api/NotificationController.php

namespace App\Http\Controllers\Api;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    protected $messaging;

    public function __construct()
    {
        $factory = (new Factory)->withServiceAccount(config('firebase.credentials'));
        $this->messaging = $factory->createMessaging();
    }

    public function sendNotification(Request $request)
    {
        $validated = $request->validate([
            'token' => 'required|string',
            'title' => 'required|string',
            'body' => 'required|string',
            'transaction_id' => 'required|string',
            'motor_type' => 'required|string',
        ]);

        try {
            $message = CloudMessage::withTarget('token', $validated['token'])
                ->withNotification(Notification::create($validated['title'], $validated['body']))
                ->withData([
                    'transaction_id' => $validated['transaction_id'],
                    'motor_type' => $validated['motor_type'],
                    'click_action' => 'FLUTTER_NOTIFICATION_CLICK'
                ]);

            $this->messaging->send($message);

            return response()->json([
                'status' => 'success',
                'message' => 'Notifikasi berhasil dikirim'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengirim notifikasi: ' . $e->getMessage()
            ], 500);
        }
    }
}
