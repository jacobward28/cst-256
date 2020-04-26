<?php

namespace App\Providers;

use App\Services\Utility\MyLogger;
use Illuminate\Support\ServiceProvider;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class LoggingServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton('App\Services\Utility\ILoggerService', function($app) {
            $logger = new Logger('CLC');
            $stream = new StreamHandler('storage/logs/CLC.log', Logger::DEBUG);
            $stream->setFormatter(new LineFormatter("%datetime% : %level_name% : %message% %context%\n", "g:iA n/j/Y"));
            $logger->pushHandler($stream);
            return new MyLogger($logger);
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
