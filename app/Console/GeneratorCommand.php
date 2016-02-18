<?php

namespace App\Console;

use Illuminate\Console\Command;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;

abstract class GeneratorCommand extends Command {

    /**
     * The Laravel application instance.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $laravel;

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Application $app, Filesystem $files)
    {
        $this->laravel = $app;
        $this->files = $files;

        parent::__construct();
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = str_replace($this->laravel->getNamespace(), '', $name);

        return $this->laravel['path'].'/'.str_replace('\\', '/', $name).'.php';
    }

    /**
     * Get the full namespace name for a given class.
     *
     * @param  string  $name
     * @return string
     */
    protected function getNamespace($name)
    {
        return trim(implode('\\', array_slice(explode('\\', $name), 0, -1)), '\\');
    }

    /**
     * Parse the name and format according to the root namespace.
     *
     * @param  string  $name
     * @return string
     */
    protected function parseName($name) {
        $rootNamespace = $this->laravel->getNamespace();

        if (Str::startsWith($name, $rootNamespace)) {
            return $name;
        }

        if (Str::contains($name, '/')) {
            $name = str_replace('/', '\\', $name);
        }

        return $this->parseName($this->getDefaultNamespace(trim($rootNamespace, '\\')).'\\'.$name);

    }

    /**
     * Determine if the class already exists.
     *
     * @param  string  $rawName
     * @return bool
     */
    protected function alreadyExists($rawName)
    {
        $name = $this->parseName($rawName);

        return $this->files->exists($this->getPath($name));
    }

    /**
     * Build the directory for the class if necessary.
     *
     * @param  string  $path
     * @return string
     */
    protected function makeDirectory($path)
    {
        if (! $this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0777, true, true);
        }
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->parseName($this->getNameInput());

        $path = $this->getPath($name);

        if ($this->alreadyExists($this->getNameInput())) {
            $this->error($this->type . ' already exists!');

            return false;
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->buildClass($name));

        $this->info($this->type . ' created successfully.');

    }

    /**
     * Replace the dummy namespace of the stub class
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replaceDummyNamespace($stub, $name) {
        return str_replace(
            'DummyNamespace', $this->getNamespace($name), $stub
        );
    }

    /**
     * Replace the dummy root namespace of the stub class
     *
     * @param  string  $stub
     * @return string
     */
    protected function replaceDummyRootNamespace($stub) {
        return str_replace(
            'DummyRootNamespace', $this->laravel->getNamespace(), $stub
        );
    }

    /**
     * Replace the dummy class of the stub file
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replaceDummyClass($stub, $name) {
        $class = str_replace($this->getNamespace($name).'\\', '', $name);

        return str_replace(
            'DummyClass', $class, $stub
        );
    }

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        return $this->replaceDummies($stub, $name);
    }

    protected abstract function getNameInput();
    protected abstract function getDefaultNamespace($rootNamespace);
    protected abstract function replaceDummies($stub, $name);

}