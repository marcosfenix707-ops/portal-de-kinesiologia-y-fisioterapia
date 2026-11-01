<?php

use Illuminate\Support\Facades\Schedule;

// Copia de seguridad automática de la base de datos todos los días a las 02:00.
Schedule::command('respaldo:generar')->dailyAt('02:00');
