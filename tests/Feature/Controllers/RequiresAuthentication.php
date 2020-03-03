<?php

namespace Tests\Feature\Controllers;

use App\User;
use Illuminate\Testing\TestResponse;

/**
 * Contêm
 *
 * @package Tests\Feature\Controllers
 */
trait RequiresAuthentication {
    /**
     * @testdox Usuário não autenticado
     */
    public function testNotAthenticated() : void {
        $route  = $this->route();
        $method = static::Method;

        /** @var TestResponse $request */
        $request = $this->$method($route);
        $request->assertStatus(401);
    }

    /**
     * Gera um usuário para autenticar a API
     *
     * @return User
     */
    private function user() : User {
        return factory(User::class)->create();
    }
}
