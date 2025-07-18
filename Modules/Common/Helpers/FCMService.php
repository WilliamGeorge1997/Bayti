<?php

namespace Modules\Common\Helpers;

use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Throwable;

class FCMService
{
    protected $messaging;

    public function __construct()
    {
        $path = env('FCM_CREDENTIALS_PATH', 'public/bayti-f5489-firebase-adminsdk-fbsvc-9d46895f25.json');
        $serviceAccountPath = base_path($path);
        $firebase = (new Factory)
            ->withServiceAccount($serviceAccountPath)
            ->createMessaging();

        $this->messaging = $firebase;
    }

    /**
     * Send a FCM notification to the given tokens.
     *
     * @param array $tokens
     * @param string $body
     * @param string $title
     * @param array $payload
     * @param string|null $image
     * @return void
     */
    public function sendNotification(array $data, array $tokens)
    {
        if (count($tokens) == 0) {
            Log::notice('no tokens');
            return;
        }
        $payload['title'] = $data['title'];
        $payload['description'] = $data['description'];
        $payload['image'] = $data['image'] ?? null;

        $notification = Notification::create($data['title'], $data['description'], $payload['image']);
        $message = CloudMessage::new()->withNotification($notification)->withData($payload);
        $report = null;
        // Log::notice('this is the  tokens', [$tokens]);
        try {
            $report = $this->messaging->sendMulticast($message, $tokens);
            // if ($report->hasFailures()) {
            //     Log::error('fcm error', ['res Failed sends: ' => $report->failures()->getItems()]);
            // }
            Log::notice('fcm', ['res Successful sends: ' => $report->successes()->count() . PHP_EOL]);
            Log::notice('fcm unknown targets', ['res from fcm : ' => $report->unknownTokens()]);
            Log::notice('fcm invalid targets', ['res from fcm : ' => $report->invalidTokens()]);

            if ($report->hasFailures()) {
                Log::error('fcm error', ['res Failed sends: ' => $report->failures()->getItems()]);
            }

        } catch (Throwable $th) {
            Log::error('FCM response', ['response_error' => $th->getMessage()]);

            if ($report) {
                Log::error('fcm error', ['res Failed sends: ' => $report->failures()->count() . PHP_EOL]);
                if ($report->hasFailures()) {
                    Log::error('fcm error', ['res Failed sends: ' => $report->failures()->getItems()]);
                }
            }

            throw $th;

            // Log::error('fcm error', ['res Failed sends: ' => $report->failures()->count() . PHP_EOL]);
            // Log::error('FCM response', ['response_error' => $th->getMessage()]);
            // if ($report->hasFailures()) {
            //     Log::error('fcm error', ['res Failed sends: ' => $report->failures()->getItems()]);
            // }
            // throw $th;
        }
    }

    public function sendToTopic(string $topic, string $body, array $payload = [], string $title = '', $image = null)
    {
        // Construct the notification and data payload
        $message = CloudMessage::fromArray([
            'topic' => $topic,
            'notification' => [
                'title' => $title,
                'body' => $body,
                'image' => $image, // Ensure your SDK version supports 'image' here
            ],
            'data' => $payload,
        ]);

        try {
            $this->messaging->send($message);
            Log::info('FCM Sent to Topic', ['topic' => $topic]);
        } catch (Throwable $th) {
            Log::error('FCM Topic Send Error', ['error' => $th->getMessage()]);
        }
    }

    public function subscribeToTopic(array $tokens, $topic)
    {
        if (count($tokens) == 0) {
            return;
        }

        try {
            $this->messaging->subscribeToTopic($topic, $tokens);
            Log::info('FCM Subscribed to Topic', ['topic' => $topic, 'tokens' => $tokens]);
        } catch (Throwable $th) {
            Log::error('FCM Subscription Error', ['error' => $th->getMessage()]);
        }
    }
}
