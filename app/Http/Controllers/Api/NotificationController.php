<?php

namespace App\Http\Controllers\Api;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    protected $messaging;

    public function __construct()
    {
        try {
            Log::info('Initializing Firebase Messaging');
            $factory = (new Factory)->withServiceAccount(config('rosantibike-motorent.project.app.firebase.credentials'));
            dd($factory);
            $this->messaging = $factory->createDatabase();
            Log::info('Firebase Messaging initialized successfully');
        } catch (\Exception $e) {
            Log::error('Firebase initialization error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function sendNotification(Request $request)
    {
        Log::info('Received notification request', $request->all());

        $validated = $request->validate([
            'token' => 'required|string',
            'title' => 'required|string',
            'body' => 'required|string',
            'transaction_id' => 'required|string',
            'motor_type' => 'required|string',
        ]);

        Log::info('Validation passed', $validated);

        try {
            $message = CloudMessage::withTarget('token', $validated['token'])
                ->withNotification(Notification::create($validated['title'], $validated['body']))
                ->withData([
                    'transaction_id' => $validated['transaction_id'],
                    'motor_type' => $validated['motor_type'],
                    'click_action' => 'FLUTTER_NOTIFICATION_CLICK'
                ]);

            Log::info('Prepared message', [
                'token' => $validated['token'],
                'notification' => [
                    'title' => $validated['title'],
                    'body' => $validated['body']
                ],
                'data' => [
                    'transaction_id' => $validated['transaction_id'],
                    'motor_type' => $validated['motor_type']
                ]
            ]);

            $result = $this->messaging->send($message);
            Log::info('Notification sent successfully', ['result' => $result]);

            return response()->json([
                'status' => 'success',
                'message' => 'Notifikasi berhasil dikirim',
                'result' => $result
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send notification', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengirim notifikasi: ' . $e->getMessage()
            ], 500);
        }
    }
}