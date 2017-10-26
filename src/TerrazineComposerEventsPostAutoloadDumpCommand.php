<?php

namespace Terrazine\ComposerEvents;

use Illuminate\Console\Command;

class TerrazineComposerEventsPostAutoloadDumpCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'terrazine:composer-events:post-autoload-dump';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = self::class;

    /**
     * Create a new command instance.
     *
     * @return void
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
        $closures = event( new PostAutoloadDump );

        foreach ($closures as $closure) {
            $closure($this->input, $this->output);
        }
    }
}
