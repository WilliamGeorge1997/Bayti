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

class NotifyClientsAboutNewPropertyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $propertyId;
    protected $chunkSize = 300;

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

                        Log::info("Processed notification batch: saved " . count($clients) . " notifications, sent to " . count($clientTokens) . " devices");
                    } catch (\Exception $e) {
                        Log::error("Error processing notification batch: " . $e->getMessage());
                    }
                });

            Log::info("Notifications job completed for new property");
        } catch (\Exception $e) {
            Log::error("Error in NotifyClientsAboutNewPropertyJob: " . $e->getMessage());
        }
    }
}