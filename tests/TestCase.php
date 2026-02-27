<?php

namespace Sirgrimorum\JSLocalization\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Sirgrimorum\JSLocalization\JSLocalizationServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class TestCase extends OrchestraTestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->app['db']->connection()->getSchemaBuilder()->dropIfExists('users');
        $this->app['db']->connection()->getSchemaBuilder()->create('users', function ($table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->timestamps();
        });
    }

    protected function getPackageProviders($app): array
    {
        return [
            JSLocalizationServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('app.key', 'base64:yvS68vVrTk8vS68vVrTk8vS68vVrTk8vS68vVrTk8vS=');
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver'   => 'mysql',
            'host'     => '127.0.0.1',
            'port'     => '3306',
            'database' => 'sirgrimorum_test',
            'username' => 'root',
            'password' => '',
            'charset'  => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix'   => '',
        ]);
        $app['config']->set('sirgrimorum.jslocalization.default_base_var', 'translations');
        $app['config']->set('sirgrimorum.jslocalization.trans_group', '');
        $app['config']->set('sirgrimorum.jslocalization.default_lang_path', 'resources/lang');
    }
}
