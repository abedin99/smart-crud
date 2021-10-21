<?php

namespace Abedin99\SmartCrud\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;

class SmartCrudInstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'smartcrud:install {stack=blade : The development stack that should be installed.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the smart crud controllers, resources and routes.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        
        $this->header();

        $this->checkRequirements();
        
        $this->footer(true);
        
    }

    /**
     * Installs the given Composer Packages into the application.
     *
     * @param  mixed  $packages
     * @return void
     */
    protected function requireComposerPackages($packages)
    {
        $composer = $this->option('composer');

        if ($composer !== 'global') {
            $command = ['php', $composer, 'require'];
        }

        $command = array_merge(
            $command ?? ['composer', 'require'],
            is_array($packages) ? $packages : func_get_args()
        );

        (new Process($command, base_path(), ['COMPOSER_MEMORY_LIMIT' => '-1']))
            ->setTimeout(null)
            ->run(function ($type, $output) {
                $this->output->write($output);
            });
    }

    /**
     * Replace a given string within a given file.
     *
     * @param  string  $search
     * @param  string  $replace
     * @param  string  $path
     * @return void
     */
    protected function replaceInFile($search, $replace, $path)
    {
        file_put_contents($path, str_replace($search, $replace, file_get_contents($path)));
    }

    private function header()
    {
        $this->info("                        
#     ______  ____    __  __  ____   
#    / ____/ / __ \  / / / / / __ \  
#   / /     / /_/ / / / / / / / / /  
#  / /___  / _, _/ / /_/ / / /_/ /   
#  \____/ /_/ |_|  \____/ /_____/    
#                                                                                                                       
			");
        $this->info('----------------- :===: Welcome To Smart Crud :==: ----------------');
        $this->info('###################################################################');
        
        $this->info('--');
    }
    
    private function checkRequirements()
    {
        
        $this->info('--');
        $this->info('System Requirements Checking:');
        $system_failed = 0;
        $laravel = app();

        if ($laravel::VERSION >= 8.0) {
            $this->info('Laravel Version (>= 8.0.*) : [OK]');
        } else {
            $this->info('Laravel Version (>= 8.0.*) : [Downgrade] Yours: '.$laravel::VERSION);
            $system_failed++;
        }

        if (version_compare(phpversion(), '7.3.0', '>=')) {
            $this->info('PHP Version (>= 7.3.*)     : [OK]');
        } else {
            $this->comment('PHP Version (>= 7.3.*)     : [Downgrade] Yours: '.phpversion());
            $system_failed++;
        }

        if (extension_loaded('openssl')) {
            $this->info('OpenSSL extension          : [Enable]');
        } else {
            $this->comment('OpenSSL extension          : [Not enable]');
            $system_failed++;
        }

        if (extension_loaded('imap')) {
            $this->info('imap extension          : [Enable]');
        } else {
            $this->comment('imap extension             : [Not enable]');
            $system_failed++;
        }

        if (extension_loaded('pdo')) {
            $this->info('PDO extension              : [Enable]');
        } else {
            $this->comment('PDO extension              : [Not enable]');
            $system_failed++;
        }

        if (extension_loaded('xml')) {
            $this->info('XML extension              : [Enable]');
        } else {
            $this->comment('XML extension              : [Not enable]');
            $system_failed++;
        }

        if (extension_loaded('gd')) {
            $this->info('GD extension               : [Enable]');
        } else {
            $this->comment('GD extension               : [Not enable]');
            $system_failed++;
        }

        if (is_writable(base_path('public'))) {
            $this->info('public dir is writable     : [OK]');
        } else {
            $this->comment('public dir is writable     : [Permission denied]');
            $system_failed++;
        }

        if ($system_failed != 0) {
            $this->comment('Sorry unfortunately your system is not meet with our requirements !');
            $this->footer(false);
        }
        $this->info('--');
    }

    private function footer($success)
    {
        $this->info('--');
        $this->info('Homepage : https://www.abed.in');
        $this->info('Github : https://github.com/abedin99/smart-crud');
        $this->info('Documentation : https://www.abed.in/docs/smart-crud');
        $this->info('###################################################################');
        if ($success == true) {
            $this->info('------------------- :===: Completed !! :===: ----------------------');
        } else {
            $this->comment('------------------- :===: Failed !!    :===: ----------------------');
        }
        exit;
    }
}
