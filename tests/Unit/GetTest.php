<?php

namespace Sirgrimorum\JSLocalization\Tests\Unit;

use Sirgrimorum\JSLocalization\Tests\TestCase;
use Sirgrimorum\JSLocalization\BindTranslationsToJs;
use PHPUnit\Framework\Attributes\CoversClass;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

#[CoversClass(BindTranslationsToJs::class)]
class GetTest extends TestCase
{
    private string $tempLangDir;
    private string $relativeLangPath = 'tests/temp_lang';

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->tempLangDir = base_path($this->relativeLangPath);
        if (!file_exists($this->tempLangDir . '/en')) {
            mkdir($this->tempLangDir . '/en', 0777, true);
        }
        if (!file_exists($this->tempLangDir . '/es')) {
            mkdir($this->tempLangDir . '/es', 0777, true);
        }

        file_put_contents(
            $this->tempLangDir . '/en/messages.php',
            '<?php return ["hello" => "world", "nested" => ["key" => "value"]];'
        );
        file_put_contents(
            $this->tempLangDir . '/es/messages.php',
            '<?php return ["hello" => "hola"];'
        );

        Config::set('sirgrimorum.jslocalization.default_lang_path', $this->relativeLangPath);
    }

    protected function tearDown(): void
    {
        $this->removeDir($this->tempLangDir);
        parent::tearDown();
    }

    private function removeDir($dir)
    {
        if (!file_exists($dir)) return;
        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? $this->removeDir("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }

    public function test_get_exports_full_lang_file_when_group_is_empty()
    {
        App::setLocale('en');
        // Passing null means use config default, which we set to "" in TestCase
        $result = BindTranslationsToJs::get('messages', null, 'myapp');

        $this->assertStringContainsString('window.myapp = window.myapp || {}', $result);
        $this->assertStringContainsString('myapp.messages = {"hello":"world","nested":{"key":"value"}}', $result);
    }

    public function test_get_exports_specific_group()
    {
        App::setLocale('en');
        $result = BindTranslationsToJs::get('messages', 'nested', 'myapp');

        $this->assertStringContainsString('myapp.messages = {"key":"value"}', $result);
    }

    public function test_get_uses_current_locale()
    {
        App::setLocale('es');
        $result = BindTranslationsToJs::get('messages', null, 'myapp');

        $this->assertStringContainsString('myapp.messages = {"hello":"hola"}', $result);
    }

    public function test_get_uses_default_config_values()
    {
        App::setLocale('en');
        Config::set('sirgrimorum.jslocalization.default_base_var', 'defaultVar');
        Config::set('sirgrimorum.jslocalization.trans_group', ''); // Full file

        $result = BindTranslationsToJs::get('messages');

        $this->assertStringContainsString('window.defaultVar', $result);
        $this->assertStringContainsString('defaultVar.messages = {"hello":"world"', $result);
    }
}
