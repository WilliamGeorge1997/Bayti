<?php

namespace Modules\Property\App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Modules\Client\App\Models\Client;
use Modules\Common\Helper\FCMService;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Modules\Property\App\Models\Property;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\Notification\Service\NotificationService;
use Modules\Notification\App\Notifications\ExpoNotification;

class NotifyClientsAboutNewPropertyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $propertyId;
    protected $chunkSize = 50;

    /**
     * Create a new job instance.
     */
    public function __construct($propertyId)
    {
        $this->propertyId = $propertyId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $property = Property::with('client')->find($this->propertyId);
            if (!$property) {
                Log::error("Property not found for notification job: {$this->propertyId}");
                return;
            }

            $title = 'عقار جديد';
            $description = 'تم إضافة عقار جديد';

            $notificationService = new NotificationService();

            // Send FCM notifications
            // $this->sendFCMNotifications($property, $title, $description, $notificationService);

            // Send Expo notifications
            $this->sendExpoNotifications($property, $title, $description, $notificationService);

            Log::info("Notifications job completed for new property");
        } catch (\Exception $e) {
            Log::error("Error in NotifyClientsAboutNewPropertyJob: " . $e->getMessage());
        }
    }

    /**
     * Send FCM notifications to clients
     */
    protected function sendFCMNotifications($property, $title, $description, $notificationService)
    {
        Client::query()
            ->where('is_active', 1)
            ->whereNotNull('fcm_token')
            ->where('id', '!=', $property->client_id)
            ->chunkById($this->chunkSize, function ($clients) use ($notificationService, $title, $description) {
                try {
                    foreach ($clients as $client) {
                        $data = [
                            'title' => $title,
                            'description' => $description,
                            'user_id' => $client->id,
                        ];
                        $notificationService->save($data, Client::class);
                    }

                    $fcm = new FCMService();
                    $clientTokens = $clients->pluck('fcm_token')->filter()->all();

                    if (count($clientTokens) > 0) {
                        $data = [
                            'title' => $title,
                            'description' => $description,
                        ];
                        $fcm->sendNotification($data, $clientTokens);
                    }

                    Log::info("Processed FCM notification batch: saved " . count($clients) . " notifications, sent to " . count($clientTokens) . " devices");
                } catch (\Exception $e) {
                    Log::error("Error processing FCM notification batch: " . $e->getMessage());
                }
            });
    }

    /**
     * Send Expo notifications to clients
     */
    protected function sendExpoNotifications($property, $title, $description, $notificationService)
    {
        Client::query()
            ->where('is_active', 1)
            ->whereNotNull('fcm_token')
            ->where('id', '!=', $property->client_id)
            ->chunkById($this->chunkSize, function ($clients) use ($notificationService, $title, $description, $property) {
                try {
                    // Save notifications to database
                    foreach ($clients as $client) {
                        $data = [
                            'title' => $title,
                            'description' => $description,
                            'user_id' => $client->id,
                        ];
                        $notificationService->save($data, Client::class);
                    }

                    // Send Expo notifications
                    $this->sendBulkExpoNotifications($clients, $title, $description, $property->id);

                    Log::info("Processed Expo notification batch: saved " . count($clients) . " notifications");
                } catch (\Exception $e) {
                    Log::error("Error processing Expo notification batch: " . $e->getMessage());
                }
            });
    }

    /**
     * Send Expo notifications to multiple clients
     */
    protected function sendBulkExpoNotifications($clients, $title, $description, $propertyId)
    {
        $validClients = $clients->filter(function ($client) {
            return !empty($client->fcm_token);
        });

        if ($validClients->isEmpty()) {
            return;
        }

        $data = [
            'title' => $title,
            'description' => $description,
            'property_id' => $propertyId,
        ];

        // Create a notification instance
        $notification = new ExpoNotification($title, $description, $data);

        // Send to each client individually using Laravel's notification system
        foreach ($validClients as $client) {
            try {
                $client->notify($notification);
            } catch (\Exception $e) {
                Log::error("Failed to send Expo notification to client {$client->id}: " . $e->getMessage());
            }
        }

        Log::info("Sent Expo notifications to " . $validClients->count() . " clients");
    }
}