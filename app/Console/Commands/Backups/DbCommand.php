<?php

namespace App\Console\Commands\Backups;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;

class DbCommand extends Command
{

  protected $signature = 'backup:dbbackup';

  protected $description = 'Command description';

  /**
   * Execute the console command.
   */
  public function handle()
  {
    $filename = env('DB_DATABASE') . '-' . now()->format('Y-m-d-H-i-s') . '.sql.enc';
    $disk = Storage::disk('backups');
    $process = new Process([
      'mysqldump', 
      '--user=' . env('DB_USERNAME'), 
      '--password=' . env('DB_PASSWORD'), 
      '--host=' . env('DB_HOST'), 
      env('DB_DATABASE'),
      ]);
    $process->run();
    if (! $process->isSuccessful()) {
      $this->error($process->getErrorOutput());
      return self::FAILURE;
    }
    $sql = $process->getOutput();
  
    $encrypted = Crypt::encryptString($sql);

    $disk->put($filename, base64_encode($encrypted));

    $this->info('Encrypted database backup created: ' . $filename);
    return self::SUCCESS;
  }
}
