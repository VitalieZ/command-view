<?php

namespace Viro\Crud\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class MyView extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud:view 
                {name : The name of the view ex: `product`}            
                {path? : The name of the path view ex: `users`},
                {--resource : Resource views index,create,show,edit ex: `--resource`}
                {--extends= : Extends blade ex: `--extends=layouts.app`}
                {--section= : Section ex: `--section=content`}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create CRUD View';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if ($this->argument('name') || $this->argument('path')) {
            $this->writeView();
        }
    }

    /**
     * Get the view name relative to the components directory.
     *
     * @return string view
     */
    protected function getView()
    {
        $path = str_replace('\\', '/', $this->argument('path') ?? '/');

        return collect(explode('/', $path))
            ->map(function ($part) {
                return Str::kebab($part);
            })
            ->implode('.');
    }

    /**
     * Write the view for the component.
     *
     * @return void
     */
    protected function writeView()
    {
        $path = $this->pathResources();
        if (is_array($path)) {
            foreach ($path as $item) {
                if (!$this->files->isDirectory(dirname($item))) {
                    $this->files->makeDirectory(dirname($item), 0777, true, true);
                }
                if ($this->files->exists($item)) {
                    $this->error('View already exists!');

                    return;
                }
                echo $this->info('Created view ' . $item);
                $this->htmlPage($item);
            }
        } else {
            if (!$this->files->isDirectory(dirname($path))) {
                $this->files->makeDirectory(dirname($path), 0777, true, true);
            }

            if ($this->files->exists($path)) {
                $this->error('View already exists!');

                return;
            }
            echo $this->info('Created view ' . $path);
            $this->htmlPage($path);
        }
        return $this->info('Views created successfully.');
    }


    public function htmlPage($path, $resource = null)
    {
        $extends = $this->option('extends') ?? 'layouts.app';
        $section = $this->option('section') ?? 'content';
        file_put_contents(
            $path,
            '@extends("' . $extends . '")
@section("' . $section . '")
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">' . ucfirst($this->bladeName($path)) . '</div>
                    <div class="card-body">
                    ' . $path . '
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection'
        );
    }

    public function pathResources()
    {
        if ($this->option('resource')) {
            if ($this->argument('path')) {
                $files = ['index', 'create', 'edit', 'show'];
                $path = array();
                foreach ($files as $file) {
                    $path[] = $this->viewPath(
                        str_replace('.', '/', $this->getView() . '.' . $file) . '.blade.php'
                    );
                }
            }
        } else {
            if ($this->argument('name') and $this->argument('name') != 'resource') {
                $path = $this->viewPath(
                    str_replace('.', '/', $this->getView() . '.' . $this->argument('name')) . '.blade.php'
                );
            } else {
                $path = $this->viewPath(
                    str_replace('.', '/', $this->getView() . '.index') . '.blade.php'
                );
            }
        }
        return $path;
    }

    public function bladeName($blade)
    {
        $ex = explode('/', $blade);
        $filename = explode('.', $ex[1]);
        return $filename[0];
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return $this->option('pivot')
            ? $this->resolveStubPath('/stubs/model.pivot.stub')
            : $this->resolveStubPath('/stubs/model.stub');
    }
}
