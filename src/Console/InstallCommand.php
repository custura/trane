<?php

namespace Custura\Trane\Console;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use RuntimeException;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Process\PhpExecutableFinder;
use Symfony\Component\Process\Process;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trane:install {stack : The development stack that should be installed (livewire)}
                                              {--dark : Indicate that dark mode support should be installed}
                                              {--api : Indicates if API support should be installed}
                                              {--verification : Indicates if email verification support should be installed}
                                              {--pest : Indicates if Pest should be installed}
                                              {--composer=global : Absolute path to the Composer binary which should be used to install packages}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Trane components and resources';

    /**
     * Execute the console command.
     *
     * @return int|null
     */
    public function handle()
    {
        if (! in_array($this->argument('stack'), ['livewire'])) {
            $this->components->error('Invalid stack. Supported stack are [livewire].');

            return 1;
        }

        // Publish...
        $this->callSilent('vendor:publish', ['--tag' => 'trane-config', '--force' => true]);
        $this->callSilent('vendor:publish', ['--tag' => 'trane-migrations', '--force' => true]);

        $this->callSilent('vendor:publish', ['--tag' => 'fortify-config', '--force' => true]);
        $this->callSilent('vendor:publish', ['--tag' => 'fortify-support', '--force' => true]);
        $this->callSilent('vendor:publish', ['--tag' => 'fortify-migrations', '--force' => true]);

        // Storage...
        $this->callSilent('storage:link');

        // "Home" Route...
        $this->replaceInFile('/home', '/dashboard', app_path('Providers/RouteServiceProvider.php'));

        if (file_exists(resource_path('views/welcome.blade.php'))) {
            $this->replaceInFile('/home', '/dashboard', resource_path('views/welcome.blade.php'));
            $this->replaceInFile('Home', 'Dashboard', resource_path('views/welcome.blade.php'));
        }

        // Fortify Provider...
        $this->installServiceProviderAfter('RouteServiceProvider', 'FortifyServiceProvider');

        // Configure Session...
        $this->configureSession();

        // Configure API...
        if ($this->option('api')) {
            $this->replaceInFile('// Features::api(),', 'Features::api(),', config_path('trane.php'));
        }

        // Configure Email Verification...
        if ($this->option('verification')) {
            $this->replaceInFile('// Features::emailVerification(),', 'Features::emailVerification(),', config_path('fortify.php'));
        }

        // Install Stack...
        if ($this->argument('stack') === 'livewire') {
            if (! $this->installLivewireStack()) {
                return 1;
            }
        }

        // Emails...
        (new Filesystem)->ensureDirectoryExists(resource_path('views/emails'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/resources/views/emails', resource_path('views/emails'));

        // Tests...
        $stubs = $this->getTestStubsPath();

        if ($this->option('pest')) {
            $this->removeComposerDevPackages(['phpunit/phpunit']);

            if (! $this->requireComposerDevPackages(['pestphp/pest:^2.0', 'pestphp/pest-plugin-laravel:^2.0'])) {
                return 1;
            }

            copy($stubs.'/Pest.php', base_path('tests/Pest.php'));
            copy($stubs.'/ExampleTest.php', base_path('tests/Feature/ExampleTest.php'));
            copy($stubs.'/ExampleUnitTest.php', base_path('tests/Unit/ExampleTest.php'));
        }

        copy($stubs.'/AuthenticationTest.php', base_path('tests/Feature/AuthenticationTest.php'));
        copy($stubs.'/EmailVerificationTest.php', base_path('tests/Feature/EmailVerificationTest.php'));
        copy($stubs.'/PasswordConfirmationTest.php', base_path('tests/Feature/PasswordConfirmationTest.php'));
        copy($stubs.'/PasswordResetTest.php', base_path('tests/Feature/PasswordResetTest.php'));
        copy($stubs.'/RegistrationTest.php', base_path('tests/Feature/RegistrationTest.php'));
    }

    /**
     * Configure the session driver for Trane.
     *
     * @return void
     */
    protected function configureSession()
    {
        if (! class_exists('CreateSessionsTable')) {
            try {
                $this->call('session:table');
            } catch (Exception $e) {
                //
            }
        }

        $this->replaceInFile("'SESSION_DRIVER', 'file'", "'SESSION_DRIVER', 'database'", config_path('session.php'));
        $this->replaceInFile('SESSION_DRIVER=file', 'SESSION_DRIVER=database', base_path('.env'));
        $this->replaceInFile('SESSION_DRIVER=file', 'SESSION_DRIVER=database', base_path('.env.example'));
    }

    /**
     * Install the Livewire stack into the application.
     *
     * @return bool
     */
    protected function installLivewireStack()
    {
        // Install Livewire...
        if (! $this->requireComposerPackages('livewire/livewire:^2.11')) {
            return false;
        }

        // Sanctum...
        (new Process([$this->phpBinary(), 'artisan', 'vendor:publish', '--provider=Laravel\Sanctum\SanctumServiceProvider', '--force'], base_path()))
                ->setTimeout(null)
                ->run(function ($type, $output) {
                    $this->output->write($output);
                });

        // Update Configuration...
        $this->replaceInFile('livewire', 'livewire', config_path('trane.php'));
        // $this->replaceInFile("'guard' => 'web'", "'guard' => 'sanctum'", config_path('auth.php'));

        // NPM Packages...
        $this->updateNodePackages(function ($packages) {
            return [
                '@tailwindcss/forms' => '^0.5.2',
                '@tailwindcss/typography' => '^0.5.0',
                'alpinejs' => '^3.0.6',
                '@alpinejs/focus' => '^3.10.5',
                'autoprefixer' => '^10.4.7',
                'postcss' => '^8.4.14',
                'tailwindcss' => '^3.1.0',
            ] + $packages;
        });

        // Tailwind Configuration...
        copy(__DIR__.'/../../stubs/livewire/tailwind.config.js', base_path('tailwind.config.js'));
        copy(__DIR__.'/../../stubs/livewire/postcss.config.js', base_path('postcss.config.js'));
        copy(__DIR__.'/../../stubs/livewire/vite.config.js', base_path('vite.config.js'));

        // Directories...
        (new Filesystem)->ensureDirectoryExists(app_path('Actions/Fortify'));
        (new Filesystem)->ensureDirectoryExists(app_path('Actions/Trane'));
        (new Filesystem)->ensureDirectoryExists(app_path('View/Components'));
        (new Filesystem)->ensureDirectoryExists(app_path('Events'));
        (new Filesystem)->ensureDirectoryExists(app_path('Policies'));
        (new Filesystem)->ensureDirectoryExists(resource_path('css'));
        (new Filesystem)->ensureDirectoryExists(resource_path('markdown'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/api'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/auth'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/components'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/layouts'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/profile'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/teams'));

        (new Filesystem)->deleteDirectory(resource_path('sass'));

        // Configuration...
        $this->replaceInFile('// Features::teams([\'invitations\' => true])', 'Features::teams([\'invitations\' => true])', config_path('trane.php'));

        // Policies...
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/app/Policies', app_path('Policies'));

        // Terms Of Service / Privacy Policy...
        copy(__DIR__.'/../../stubs/resources/markdown/terms.md', resource_path('markdown/terms.md'));
        copy(__DIR__.'/../../stubs/resources/markdown/policy.md', resource_path('markdown/policy.md'));

        // Service Providers...
        copy(__DIR__.'/../../stubs/app/Providers/TraneServiceProvider.php', app_path('Providers/TraneServiceProvider.php'));

        $this->installServiceProviderAfter('FortifyServiceProvider', 'TraneServiceProvider');

        //  Database Seeders...
        copy(__DIR__.'/../../database/seeders/DatabaseSeeder.php', database_path('seeders/DatabaseSeeder.php'));
        copy(__DIR__.'/../../database/seeders/PermissionRoleTableSeeder.php', database_path('seeders/PermissionRoleTableSeeder.php'));
        copy(__DIR__.'/../../database/seeders/PermissionsTableSeeder.php', database_path('seeders/PermissionsTableSeeder.php'));
        copy(__DIR__.'/../../database/seeders/RolesTableSeeder.php', database_path('seeders/RolesTableSeeder.php'));
        copy(__DIR__.'/../../database/seeders/RoleUserTableSeeder.php', database_path('seeders/RoleUserTableSeeder.php'));
        copy(__DIR__.'/../../database/seeders/UsersTableSeeder.php', database_path('seeders/UsersTableSeeder.php'));
        copy(__DIR__.'/../../database/seeders/TeamClientBindsTableSeeder.php', database_path('seeders/TeamClientBindsTableSeeder.php'));
        copy(__DIR__.'/../../database/seeders/TeamClientsTableSeeder.php', database_path('seeders/TeamClientsTableSeeder.php'));
        copy(__DIR__.'/../../database/seeders/TeamProjectBindsTableSeeder.php', database_path('seeders/TeamProjectBindsTableSeeder.php'));
        copy(__DIR__.'/../../database/seeders/TeamProjectsTableSeeder.php', database_path('seeders/TeamProjectsTableSeeder.php'));
        copy(__DIR__.'/../../database/seeders/TeamRolePermissionsTableSeeder.php', database_path('seeders/TeamRolePermissionsTableSeeder.php'));
        copy(__DIR__.'/../../database/seeders/TeamRolesTableSeeder.php', database_path('seeders/TeamRolesTableSeeder.php'));
        copy(__DIR__.'/../../database/seeders/TeamTaskBindsTableSeeder.php', database_path('seeders/TeamTaskBindsTableSeeder.php'));
        copy(__DIR__.'/../../database/seeders/TeamTasksTableSeeder.php', database_path('seeders/TeamTasksTableSeeder.php'));
        copy(__DIR__.'/../../database/seeders/TeamTemplateBindsTableSeeder.php', database_path('seeders/TeamTemplateBindsTableSeeder.php'));
        copy(__DIR__.'/../../database/seeders/TeamTemplatesTableSeeder.php', database_path('seeders/TeamTemplatesTableSeeder.php'));

        // Models...
        copy(__DIR__.'/../../stubs/app/Models/User.php', app_path('Models/User.php'));
        copy(__DIR__.'/../../stubs/app/Models/Team.php', app_path('Models/Team.php'));
        copy(__DIR__.'/../../stubs/app/Models/Membership.php', app_path('Models/Membership.php'));
        copy(__DIR__.'/../../stubs/app/Models/TeamInvitation.php', app_path('Models/TeamInvitation.php'));
        

        // Actions...
        copy(__DIR__.'/../../stubs/app/Actions/Fortify/CreateNewUser.php', app_path('Actions/Fortify/CreateNewUser.php'));
        copy(__DIR__.'/../../stubs/app/Actions/Fortify/UpdateUserProfileInformation.php', app_path('Actions/Fortify/UpdateUserProfileInformation.php'));
        copy(__DIR__.'/../../stubs/app/Actions/Trane/DeleteUser.php', app_path('Actions/Trane/DeleteUser.php'));
        copy(__DIR__.'/../../stubs/app/Actions/Trane/AddTeamMember.php', app_path('Actions/Trane/AddTeamMember.php'));
        copy(__DIR__.'/../../stubs/app/Actions/Trane/CreateTeam.php', app_path('Actions/Trane/CreateTeam.php'));
        copy(__DIR__.'/../../stubs/app/Actions/Trane/DeleteTeam.php', app_path('Actions/Trane/DeleteTeam.php'));
        copy(__DIR__.'/../../stubs/app/Actions/Trane/InviteTeamMember.php', app_path('Actions/Trane/InviteTeamMember.php'));
        copy(__DIR__.'/../../stubs/app/Actions/Trane/RemoveTeamMember.php', app_path('Actions/Trane/RemoveTeamMember.php'));
        copy(__DIR__.'/../../stubs/app/Actions/Trane/UpdateTeamName.php', app_path('Actions/Trane/UpdateTeamName.php'));
        
        // Factories...
        copy(__DIR__.'/../../database/factories/UserFactory.php', base_path('database/factories/UserFactory.php'));
        copy(__DIR__.'/../../database/factories/TeamFactory.php', base_path('database/factories/TeamFactory.php'));

        // Components...
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/livewire/resources/views/components', resource_path('views/components'));

        // View Components...
        copy(__DIR__.'/../../stubs/livewire/app/View/Components/AppLayout.php', app_path('View/Components/AppLayout.php'));
        copy(__DIR__.'/../../stubs/livewire/app/View/Components/GuestLayout.php', app_path('View/Components/GuestLayout.php'));

        // Layouts...
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/livewire/resources/views/layouts', resource_path('views/layouts'));

        // Single Blade Views...
        copy(__DIR__.'/../../stubs/livewire/resources/views/dashboard.blade.php', resource_path('views/dashboard.blade.php'));
		copy(__DIR__.'/../../stubs/livewire/resources/views/welcome.blade.php', resource_path('views/welcome.blade.php'));
        copy(__DIR__.'/../../stubs/livewire/resources/views/navigation-menu.blade.php', resource_path('views/navigation-menu.blade.php'));
        copy(__DIR__.'/../../stubs/livewire/resources/views/terms.blade.php', resource_path('views/terms.blade.php'));
        copy(__DIR__.'/../../stubs/livewire/resources/views/policy.blade.php', resource_path('views/policy.blade.php'));

        // Other Views...
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/livewire/resources/views/api', resource_path('views/api'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/livewire/resources/views/profile', resource_path('views/profile'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/livewire/resources/views/auth', resource_path('views/auth'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/livewire/resources/views/teams', resource_path('views/teams'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/livewire/resources/views/appointment', resource_path('views/appointment'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/livewire/resources/views/users', resource_path('views/users'));

        // Routes...
        $this->replaceInFile('auth:api', 'auth:sanctum', base_path('routes/api.php'));

        if (! Str::contains(file_get_contents(base_path('routes/web.php')), "'/dashboard'")) {
            (new Filesystem)->append(base_path('routes/web.php'), $this->livewireRouteDefinition());
        }

        // Assets...
        copy(__DIR__.'/../../stubs/resources/css/app.css', resource_path('css/app.css'));
        copy(__DIR__.'/../../stubs/livewire/resources/js/app.js', resource_path('js/app.js'));

        // Tests...
        $stubs = $this->getTestStubsPath();

        copy($stubs.'/livewire/ApiTokenPermissionsTest.php', base_path('tests/Feature/ApiTokenPermissionsTest.php'));
        copy($stubs.'/livewire/BrowserSessionsTest.php', base_path('tests/Feature/BrowserSessionsTest.php'));
        copy($stubs.'/livewire/CreateApiTokenTest.php', base_path('tests/Feature/CreateApiTokenTest.php'));
        copy($stubs.'/livewire/DeleteAccountTest.php', base_path('tests/Feature/DeleteAccountTest.php'));
        copy($stubs.'/livewire/DeleteApiTokenTest.php', base_path('tests/Feature/DeleteApiTokenTest.php'));
        copy($stubs.'/livewire/ProfileInformationTest.php', base_path('tests/Feature/ProfileInformationTest.php'));
        copy($stubs.'/livewire/TwoFactorAuthenticationSettingsTest.php', base_path('tests/Feature/TwoFactorAuthenticationSettingsTest.php'));
        copy($stubs.'/livewire/UpdatePasswordTest.php', base_path('tests/Feature/UpdatePasswordTest.php'));

        copy($stubs.'/livewire/CreateTeamTest.php', base_path('tests/Feature/CreateTeamTest.php'));
        copy($stubs.'/livewire/DeleteTeamTest.php', base_path('tests/Feature/DeleteTeamTest.php'));
        copy($stubs.'/livewire/InviteTeamMemberTest.php', base_path('tests/Feature/InviteTeamMemberTest.php'));
        copy($stubs.'/livewire/LeaveTeamTest.php', base_path('tests/Feature/LeaveTeamTest.php'));
        copy($stubs.'/livewire/RemoveTeamMemberTest.php', base_path('tests/Feature/RemoveTeamMemberTest.php'));
        copy($stubs.'/livewire/UpdateTeamMemberRoleTest.php', base_path('tests/Feature/UpdateTeamMemberRoleTest.php'));
        copy($stubs.'/livewire/UpdateTeamNameTest.php', base_path('tests/Feature/UpdateTeamNameTest.php'));
        copy($stubs.'/TransferTeamTest.php', base_path('tests/Feature/TransferTeamTest.php'));
        
        if (! $this->option('dark')) {
            $this->removeDarkClasses((new Finder)
                ->in(resource_path('views'))
                ->name('*.blade.php')
                ->filter(fn ($file) => $file->getPathname() !== resource_path('views/welcome.blade.php'))
            );
        }

        $this->installMiddlewareTrane();
        
        if (file_exists(base_path('pnpm-lock.yaml'))) {
            $this->runCommands(['pnpm install', 'pnpm run build']);
        } elseif (file_exists(base_path('yarn.lock'))) {
            $this->runCommands(['yarn install', 'yarn run build']);
        } else {
            $this->runCommands(['npm install', 'npm run build']);
        }

        $this->line('');
        $this->components->info('Livewire scaffolding installed successfully.');

        return true;
    }

    /**
     * Get the route definition(s) that should be installed for Livewire.
     *
     * @return string
     */
    protected function livewireRouteDefinition()
    {
        return <<<'EOF'

Route::middleware([
    'auth:sanctum',
    config('trane.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

EOF;
    }

    /**
     * Install the service provider in the application configuration file.
     *
     * @param  string  $after
     * @param  string  $name
     * @return void
     */
    protected function installServiceProviderAfter($after, $name)
    {
        if (! Str::contains($appConfig = file_get_contents(config_path('app.php')), 'App\\Providers\\'.$name.'::class')) {
            file_put_contents(config_path('app.php'), str_replace(
                'App\\Providers\\'.$after.'::class,',
                'App\\Providers\\'.$after.'::class,'.PHP_EOL.'        App\\Providers\\'.$name.'::class,',
                $appConfig
            ));
        }
    }

    /**
     * Install the middleware to a group in the application Http Kernel.
     *
     * @param  string  $after
     * @param  string  $name
     * @param  string  $group
     * @return void
     */
    protected function installMiddlewareAfter($after, $name, $group = 'web')
    {
        $httpKernel = file_get_contents(app_path('Http/Kernel.php'));

        $middlewareGroups = Str::before(Str::after($httpKernel, '$middlewareGroups = ['), '];');
        $middlewareGroup = Str::before(Str::after($middlewareGroups, "'$group' => ["), '],');

        if (! Str::contains($middlewareGroup, $name)) {
            $modifiedMiddlewareGroup = str_replace(
                $after.',',
                $after.','.PHP_EOL.'            '.$name.',',
                $middlewareGroup,
            );

            file_put_contents(app_path('Http/Kernel.php'), str_replace(
                $middlewareGroups,
                str_replace($middlewareGroup, $modifiedMiddlewareGroup, $middlewareGroups),
                $httpKernel
            ));
        }
    }

    private function installMiddlewareTrane(): void
    {
        $this->replaceInFile('\Illuminate\Routing\Middleware\SubstituteBindings::class,',
            '\Illuminate\Routing\Middleware\SubstituteBindings::class,
            \Custura\Trane\Http\Middleware\AuthGates::class,
            \Custura\Trane\Http\Middleware\TraneTeam::class,', app_path('Http/Kernel.php'));
    }

    /**
     * Returns the path to the correct test stubs.
     *
     * @return string
     */
    protected function getTestStubsPath()
    {
        return $this->option('pest')
            ? __DIR__.'/../../stubs/pest-tests'
            : __DIR__.'/../../stubs/tests';
    }

    /**
     * Installs the given Composer Packages into the application.
     *
     * @param  mixed  $packages
     * @return bool
     */
    protected function requireComposerPackages($packages)
    {
        $composer = $this->option('composer');

        if ($composer !== 'global') {
            $command = [$this->phpBinary(), $composer, 'require'];
        }

        $command = array_merge(
            $command ?? ['composer', 'require'],
            is_array($packages) ? $packages : func_get_args()
        );

        return ! (new Process($command, base_path(), ['COMPOSER_MEMORY_LIMIT' => '-1']))
            ->setTimeout(null)
            ->run(function ($type, $output) {
                $this->output->write($output);
            });
    }

    /**
     * Removes the given Composer Packages as "dev" dependencies.
     *
     * @param  mixed  $packages
     * @return bool
     */
    protected function removeComposerDevPackages($packages)
    {
        $composer = $this->option('composer');

        if ($composer !== 'global') {
            $command = [$this->phpBinary(), $composer, 'remove', '--dev'];
        }

        $command = array_merge(
            $command ?? ['composer', 'remove', '--dev'],
            is_array($packages) ? $packages : func_get_args()
        );

        return (new Process($command, base_path(), ['COMPOSER_MEMORY_LIMIT' => '-1']))
            ->setTimeout(null)
            ->run(function ($type, $output) {
                $this->output->write($output);
            }) === 0;
    }

    /**
     * Install the given Composer Packages as "dev" dependencies.
     *
     * @param  mixed  $packages
     * @return bool
     */
    protected function requireComposerDevPackages($packages)
    {
        $composer = $this->option('composer');

        if ($composer !== 'global') {
            $command = [$this->phpBinary(), $composer, 'require', '--dev'];
        }

        $command = array_merge(
            $command ?? ['composer', 'require', '--dev'],
            is_array($packages) ? $packages : func_get_args()
        );

        return (new Process($command, base_path(), ['COMPOSER_MEMORY_LIMIT' => '-1']))
            ->setTimeout(null)
            ->run(function ($type, $output) {
                $this->output->write($output);
            }) === 0;
    }

    /**
     * Update the "package.json" file.
     *
     * @param  callable  $callback
     * @param  bool  $dev
     * @return void
     */
    protected static function updateNodePackages(callable $callback, $dev = true)
    {
        if (! file_exists(base_path('package.json'))) {
            return;
        }

        $configurationKey = $dev ? 'devDependencies' : 'dependencies';

        $packages = json_decode(file_get_contents(base_path('package.json')), true);

        $packages[$configurationKey] = $callback(
            array_key_exists($configurationKey, $packages) ? $packages[$configurationKey] : [],
            $configurationKey
        );

        ksort($packages[$configurationKey]);

        file_put_contents(
            base_path('package.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT).PHP_EOL
        );
    }

    /**
     * Delete the "node_modules" directory and remove the associated lock files.
     *
     * @return void
     */
    protected static function flushNodeModules()
    {
        tap(new Filesystem, function ($files) {
            $files->deleteDirectory(base_path('node_modules'));

            $files->delete(base_path('pnpm-lock.yaml'));
            $files->delete(base_path('yarn.lock'));
            $files->delete(base_path('package-lock.json'));
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

    /**
     * Remove Tailwind dark classes from the given files.
     *
     * @param  \Symfony\Component\Finder\Finder  $finder
     * @return void
     */
    protected function removeDarkClasses(Finder $finder)
    {
        foreach ($finder as $file) {
            file_put_contents($file->getPathname(), preg_replace('/\sdark:[^\s"\']+/', '', $file->getContents()));
        }
    }

    /**
     * Get the path to the appropriate PHP binary.
     *
     * @return string
     */
    protected function phpBinary()
    {
        return (new PhpExecutableFinder())->find(false) ?: 'php';
    }

    /**
     * Run the given commands.
     *
     * @param  array  $commands
     * @return void
     */
    protected function runCommands($commands)
    {
        $process = Process::fromShellCommandline(implode(' && ', $commands), null, null, null, null);

        if ('\\' !== DIRECTORY_SEPARATOR && file_exists('/dev/tty') && is_readable('/dev/tty')) {
            try {
                $process->setTty(true);
            } catch (RuntimeException $e) {
                $this->output->writeln('  <bg=yellow;fg=black> WARN </> '.$e->getMessage().PHP_EOL);
            }
        }

        $process->run(function ($type, $line) {
            $this->output->write('    '.$line);
        });
    }
}
