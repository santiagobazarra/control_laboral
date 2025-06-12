<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    RolController,
    DepartamentoController,
    UsuarioController,
    FichajeController,
    JornadaController,
    SolicitudController,
    EventoCalendarioController,
    ParticipanteEventoController,
    NotificacionController,
    AuthController
};

Route::post('login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('roles', RolController::class);
    Route::apiResource('departamentos', DepartamentoController::class);
    Route::apiResource('usuarios', UsuarioController::class);
    Route::apiResource('fichajes', FichajeController::class);
    Route::apiResource('jornadas', JornadaController::class);
    Route::apiResource('solicitudes', SolicitudController::class);
    Route::apiResource('eventos', EventoCalendarioController::class);
    Route::apiResource('notificaciones', NotificacionController::class);
    
    Route::patch('notificaciones/{id}/leer', [NotificacionController::class, 'marcarComoLeida']);
    Route::get('eventos/{id}/participantes', [ParticipanteEventoController::class, 'index']);
    Route::post('eventos/{id}/participantes', [ParticipanteEventoController::class, 'store']);
    Route::get('eventos/{id}/participantes', [ParticipanteEventoController::class, 'participantesPorEvento']);
    Route::delete('eventos/{id}/participantes/{usuario_id}', [ParticipanteEventoController::class, 'destroy']);

    Route::post('logout', [AuthController::class, 'logout']);
});
