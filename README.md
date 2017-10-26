```
\Illuminate\Support\Facades\Event::listen(\Terrazine\ComposerEvents\PreAutoloadDump::class, function () {
    return function (\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\output\OutputInterface $output){
        \Illuminate\Support\Facades\Artisan::call('down', [], $output);
    };
});

\Illuminate\Support\Facades\Event::listen(\Terrazine\ComposerEvents\PostAutoloadDump::class, function () {
    return function (\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\output\OutputInterface $output){
        \Illuminate\Support\Facades\Artisan::call('up', [], $output);
    };
});
```
