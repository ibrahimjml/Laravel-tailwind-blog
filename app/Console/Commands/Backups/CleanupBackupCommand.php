<?php

namespace App\Console\Commands\Backups;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CleanupBackupCommand extends Command
{
    protected $signature = 'backup:cleanup {--days=7 : Delete backups older than N days}';

    protected $description = 'Delete old backup files from backups disk';

    public function handle(): int
    {
         $disk = Storage::disk('backups');

        if (!method_exists($disk, 'files')) {
            $this->error('Backups disk is not accessible.');
            return self::FAILURE;
        }

        $days = (int) $this->option('days');
        $threshold = Carbon::now()->subDays($days);

        $deleted = 0;

        foreach ($disk->files() as $file) {
            try {
                $lastModified = Carbon::createFromTimestamp(
                    $disk->lastModified($file)
                );

                if ($lastModified->lt($threshold)) {
                    $disk->delete($file);
                    $deleted++;
                }
            } catch (\Throwable $e) {
                $this->warn("Skipped: {$file}");
            }
        }

        $this->info("Deleted {$deleted} old backup file(s).");

        return self::SUCCESS;
    }
    }
