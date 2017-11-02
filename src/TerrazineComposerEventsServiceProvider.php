<?php

namespace Terrazine\ComposerEvents;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TerrazineComposerEventsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->makeSureEventsAreRegistered();
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([
            TerrazineComposerEventsPreAutoloadDumpCommand::class,
            TerrazineComposerEventsPostAutoloadDumpCommand::class,
        ]);

    }

    /**
     * todo: refractor using terrazine/composer-classloader * terrazine/composer-classfinder
     */
    public function makeSureEventsAreRegistered() {
        $composer = json_decode(
            file_get_contents(
                base_path('composer.json')
            )
        );

        $changed = false;

        if (!isset($composer->scripts->{'pre-autoload-dump'})) {
            $composer->scripts->{'pre-autoload-dump'} = [];
        }
        if (!isset($composer->scripts->{'post-autoload-dump'})) {
            $composer->scripts->{'post-autoload-dump'} = [];
        }

        if (!in_array('php artisan terrazine:composer-events:pre-autoload-dump || true', $composer->scripts->{'pre-autoload-dump'})) {
            array_push($composer->scripts->{'pre-autoload-dump'}, 'php artisan terrazine:composer-events:pre-autoload-dump || true');
            $changed = true;
        }

        if (!in_array('php artisan terrazine:composer-events:post-autoload-dump || true', $composer->scripts->{'post-autoload-dump'})) {
            array_push($composer->scripts->{'post-autoload-dump'}, 'php artisan terrazine:composer-events:post-autoload-dump || true');
            $changed = true;
        }

        if ($changed) {
            file_put_contents(
                base_path('composer.json'), json_encode(
                    $composer, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
                ). PHP_EOL
            );
        }
    }
}
