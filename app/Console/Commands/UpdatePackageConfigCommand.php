<?php

namespace App\Console\Commands;

use Throwable;
use App\Models\Package;
use Illuminate\Bus\Batch;
use App\Models\ChildProject;
use Illuminate\Console\Command;
use App\Jobs\UpdateChildConfigJob;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;

class UpdatePackageConfigCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:packageConfig {packageId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for send updated package configurations to child projects';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $packageId = $this->argument('packageId');
        $package = Package::find($packageId);
        if ($package) {
            $projects = ChildProject::with('package')->where('package_id',$packageId)->get();
            $jobs=[];
            $delaySeconds=0;
            foreach ($projects as $key => $project) {
                $jobs[] = (new UpdateChildConfigJob($project))->delay(now()->addSeconds($delaySeconds));
                $delaySeconds++;
            }
        }

        Bus::batch($jobs)
        ->name("Package_update_job")
        ->then(function (Batch $batch) {
            // Log::info("All jobs in batch [{$batch->id}] completed successfully.");
        })
        ->catch(function (Batch $batch, Throwable $e) {
           Log::error("Batch [{$batch->id}] failed: " . $e->getMessage());
        })
        ->finally(function (Batch $batch) {
            // Log::info("Batch [{$batch->id}] finished processing.");
        })
        ->dispatch();

        $this->info("Batch dispatched with " . count($jobs) . " jobs");

        return Command::SUCCESS;
    }
}
