<?php namespace SPRIGS\Module\Creator\Commands;

class CreateRepositoryCommand extends BaseCommand
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'repository:create {moduleName : The name of the module} {moduleDirectory : The directory of the module}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create repository files';

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->files = [
            [
                'directory' => 'Repository',
                'fileName' => '{{ModuleName}}Repository.php.stub'
            ],
            [
                'directory' => 'Repository'.DIRECTORY_SEPARATOR.'Contract',
                'fileName' => '{{ModuleName}}RepositoryInterface.php.stub'

            ]
        ];
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->initializeProperties();
        $this->createFiles($this->files, "Repository");
    }
}
