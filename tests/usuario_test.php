<?php

use App\Services\UsuarioService;
use Tests\Mocks\UsuarioRepositoryMock;

global $runner;

$runner->addTest(function() {
    $usuarioService = new UsuarioService(new UsuarioRepositoryMock());

    $usuarioService->buscaUsuarios();
}, "Busca usuários");