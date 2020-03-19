<?php namespace SPRIGS\Module\Creator\Commands;

use Illuminate\Support\Facades\File;

class CreateModuleCommand extends BaseCommand
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new module';

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->moduleName = $this->ask("What will the module be called?");

        if(!filled($this->moduleName)) {
            $this->error('Module name is missing are missing!');
        }
        $this->createModuleDirectory();
        $this->handleCreation();

    }

    public function handleCreation(): void
    {
        $_moduleName = $this->moduleName;
        $_moduleDirectory = $this->moduleDirectory;

        if ($this->confirm('Do you want to create service files?')) {
            $this->call('service:create', [
                'moduleName' => $_moduleName,
                'moduleDirectory' =>  $_moduleDirectory
            ]);
        }

        if ($this->confirm('Do you want to create the repository files?')) {
            $this->call('repository:create', [
                'moduleName' => $_moduleName,
                'moduleDirectory' =>  $_moduleDirectory
            ]);
        }
    }

    private function createModuleDirectory()
    {
        $this->moduleDirectory = $this->getModuleDirectory($this->moduleName);
        if( !file_exists( $this->moduleDirectory ) ){
            \File::makeDirectory($this->moduleDirectory, 0775, true);
        }
    }
}
