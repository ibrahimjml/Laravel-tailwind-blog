<?php

namespace App\Console\Commands\Make;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeClassCommand extends Command
{
    protected $signature = 'make:class {name}';
    protected $description = 'Create a new class file';
    protected $type = 'Class';

    public function handle()
    {
        $name = $this->argument('name');
        $classPath = str_replace('\\', '/', $name);
        $filePath = app_path($classPath . '.php');

        if (File::exists($filePath)) {
            $this->error("{$this->type} already exists!");
            return;
        }

        File::ensureDirectoryExists(dirname($filePath));

        $namespace = 'App\\' . trim(str_replace('/', '\\', dirname($classPath)), '/');
        $className = class_basename($name);

        $stub = <<<EOT
<?php

namespace {$namespace};

class {$className}
{
    //
}

EOT;

        File::put($filePath, $stub);
        $this->info("{$this->type} created: {$filePath}");
    }
}
