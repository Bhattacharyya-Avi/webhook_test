<?php

namespace App\Jobs;

use App\Models\ChildProject;
use Illuminate\Bus\Batchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateChildConfigJob implements ShouldQueue
{
    use Queueable, Dispatchable, InteractsWithQueue, SerializesModels, Batchable;

    protected $project;

    /**
     * Create a new job instance.
     */
    public function __construct(ChildProject $project)
    {
        $this->project = $project;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $package = $this->project->package;
        $packageConfig = $package->config;

        $data = [
            'package_name' => $package->name,
            'max_active_members' => $packageConfig['maxMemberNo'],
        ];

        Log::info($this->project->project_url . '/webhook/update-config');
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->project->webhook_token,
            ])->post($this->project->project_url . '/webhook/update-config', $data);

            if ($response->failed()) {
                throw new \Exception('Webhook failed: ' . $response->body());
            }
        } catch (\Exception $e) {
            Log::error('Failed to update child project: ' . $e->getMessage());
            $this->fail($e);
        }
    }
}
