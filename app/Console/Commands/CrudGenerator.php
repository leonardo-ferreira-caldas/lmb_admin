<?php

namespace App\Console\Commands;

use App\Console\GeneratorCommand;

class CrudGenerator extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:crud {name} {--table=} {--plain}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new crud class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Crud';

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getNameInput() {
        return $this->argument('name');
    }

    /**
     * Get the full namespace name for a given class.
     *
     * @param  string  $name
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace) {
        return $rootNamespace . '\Http\Cruds';
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub() {
        if ($this->option('plain')) {
            return base_path('resources/stubs/crud.plain.stub');
        }

        return base_path('resources/stubs/crud.stub');
    }

    /**
     * Replace the namespace for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return $this
     */
    protected function replaceDummies($stub, $name)
    {
        $stub = $this->replaceDummyNamespace($stub, $name);
        $stub = $this->replaceDummyRootNamespace($stub);
        $stub = $this->replaceDummyClass($stub, $name);

        if (!$this->option('plain') && $this->option('table')) {
            $stub = str_replace('DummyTable', $this->option('table'), $stub);
        }

        return $stub;
    }

}
