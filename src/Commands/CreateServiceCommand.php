<?php namespace SPRIGS\Module\Creator\Commands;

class CreateServiceCommand extends BaseCommand
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'service:create {moduleName : The name of the module} {moduleDirectory : The directory of the module}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create service files';

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->files = [
            [
                'directory' => 'Service',
                'fileName' => '{{ModuleName}}Service.php.stub'
            ],
            [
                'directory' => 'Service' . DIRECTORY_SEPARATOR . 'Contract',
                'fileName' => '{{ModuleName}}ServiceInterface.php.stub'
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
        $this->createFiles($this->files, "Service");
    }
}
