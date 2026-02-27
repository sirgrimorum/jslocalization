<?php

namespace Sirgrimorum\JSLocalization\Tests\Unit;

use Sirgrimorum\JSLocalization\Tests\TestCase;
use Sirgrimorum\JSLocalization\BindTranslationsToJs;
use PHPUnit\Framework\Attributes\CoversClass;
use App\User;

#[CoversClass(BindTranslationsToJs::class)]
class PutTest extends TestCase
{
    public function test_put_exports_eloquent_model_with_default_variable()
    {
        $user = new User(['name' => 'John Doe', 'email' => 'john@example.com']);
        $result = BindTranslationsToJs::put($user);

        $this->assertStringContainsString('<script>User = {"name":"John Doe","email":"john@example.com"};</script>', $result);
    }

    public function test_put_exports_eloquent_model_with_explicit_variable()
    {
        $user = new User(['name' => 'John Doe']);
        $result = BindTranslationsToJs::put($user, 'currentUser');

        $this->assertStringContainsString('<script>currentUser = {"name":"John Doe"};</script>', $result);
    }

    public function test_put_exports_array_with_default_variable()
    {
        $data = ['a' => 1, 'b' => 2];
        $result = BindTranslationsToJs::put($data);

        $this->assertStringContainsString('<script>varArray = {"a":1,"b":2};</script>', $result);
    }

    public function test_put_exports_array_with_explicit_variable()
    {
        $data = ['x' => 'y'];
        $result = BindTranslationsToJs::put($data, 'myData');

        $this->assertStringContainsString('<script>myData = {"x":"y"};</script>', $result);
    }

    public function test_put_returns_null_for_non_object_non_array()
    {
        $result = BindTranslationsToJs::put(42);
        $this->assertNull($result);
    }
}
