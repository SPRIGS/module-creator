<?php namespace SPRIGS\Module\Creator\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class BaseCommand extends Command
{
    const MODULE_ROOT = "Modules";

    protected $files = [];
    protected $moduleName = "";
    protected $moduleDirectory = "";

    protected $placeholders = [
        '{{AppNameSpace}}',

        '{{ModuleName}}',
        '{{moduleName}}',

        '{{ModelName}}',
        '{{modelName}}',
    ];

    protected $replacements = [
        '{{AppNameSpace}}' => '',

        '{{ModuleName}}' => '',
        '{{moduleName}}' => '',

        '{{ModelName}}' => '',
        '{{modelName}}' => '',
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function createDirectory($directory)
    {
        $_directory = $this->moduleDirectory . DIRECTORY_SEPARATOR . $directory;

        if (!file_exists($_directory)) {
            return \File::makeDirectory($_directory, 0775, true);
        }
    }

    public function createFiles($files, $entityName)
    {
        foreach ($files as $file) {
            if (!file_exists($this->createDirectory($file['directory']))) {
                $this->createFile($file);
            }
        }
        $this->info("{$entityName} files created!");
    }

    public function createFile($file)
    {
        $filePath = $this->getStubFilePath($file);
        File::put(
            $this->getFileDirectory($file) . $this->getProperFileName($file),
            $this->compile(file_get_contents($filePath))
        );
    }

    private function compile($content)
    {
        foreach ($this->placeholders as $placeholder) {
            $content = str_replace($placeholder, $this->getReplacement($placeholder), $content);
        }
        return $content;
    }

    private function getReplacement($placeholder)
    {
        return $this->replacements[$placeholder];
    }

    public function getModuleDirectory($moduleName)
    {
        return app_path() . DIRECTORY_SEPARATOR . self::MODULE_ROOT . DIRECTORY_SEPARATOR . $moduleName;
    }

    private function getFileDirectory($file)
    {
        return $this->getModuleDirectory($this->moduleName) . DIRECTORY_SEPARATOR . $file['directory'] . DIRECTORY_SEPARATOR;
    }

    private function getAbsoluteFilePath($file)
    {
        return $this->getModuleDirectory($this->moduleName) . DIRECTORY_SEPARATOR . $file['directory'] . DIRECTORY_SEPARATOR . $file['fileName'];
    }

    private function getStubFilePath($file)
    {
        $_path = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'stubs' . DIRECTORY_SEPARATOR . 'Module' . DIRECTORY_SEPARATOR .  $file['directory'] . DIRECTORY_SEPARATOR . $file['fileName'];
        return str_replace('{{ModuleName}}', 'Module', $_path);
    }

    private function getFileName($file)
    {
        return str_replace(
            [
                '{{ModuleName}}'
            ]
            ,
            [
                $this->getReplacement('{{ModuleName}}')
            ],
            $file['fileName']
        );
    }

    private function getProperFileName($file)
    {
        return str_replace(
            [
                '.stub',
                '{{ModuleName}}'
            ]
            ,
            [
                '',
                $this->getReplacement('{{ModuleName}}')
            ],
            $file['fileName']
        );
    }

    protected function initializeProperties()
    {
        $this->moduleName = $this->argument('moduleName');
        $this->moduleDirectory = $this->argument('moduleDirectory');

        $this->replacements['{{AppNameSpace}}'] = app()->getNamespace();

        $this->replacements['{{ModuleName}}'] = ucfirst($this->moduleName);
        $this->replacements['{{moduleName}}'] = strtolower($this->moduleName);

        $this->replacements['{{ModelName}}'] = ucfirst($this->moduleName);
        $this->replacements['{{modelName}}'] = strtolower($this->moduleName);
    }
}
