<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\ProductController;

class CleanupOrphanedImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:cleanup {--dry-run : Show what would be deleted without actually deleting}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up orphaned images from storage that are no longer referenced in the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $productController = new ProductController();
        
        if ($this->option('dry-run')) {
            $this->info('Running in DRY RUN mode - no files will be deleted');
            $stats = $productController->getStorageStats();
            
            $this->table(
                ['Metric', 'Value'],
                [
                    ['Total Files', $stats['total_files']],
                    ['Used Files', $stats['used_files']],
                    ['Orphaned Files', $stats['orphaned_files']],
                    ['Total Size (MB)', $stats['total_size_mb']],
                    ['Used Size (MB)', $stats['used_size_mb']],
                    ['Orphaned Size (MB)', $stats['orphaned_size_mb']],
                ]
            );
            
            if ($stats['orphaned_files'] > 0) {
                $this->warn("Found {$stats['orphaned_files']} orphaned files totaling {$stats['orphaned_size_mb']} MB");
                $this->info('Run without --dry-run to actually delete these files');
            } else {
                $this->info('No orphaned files found!');
            }
        } else {
            $this->info('Cleaning up orphaned images...');
            $result = $productController->cleanupOrphanedImages();
            
            $this->info($result['message']);
            
            if (!empty($result['errors'])) {
                $this->error('Some errors occurred during cleanup:');
                foreach ($result['errors'] as $error) {
                    $this->error("  - {$error}");
                }
            }
        }
    }
}