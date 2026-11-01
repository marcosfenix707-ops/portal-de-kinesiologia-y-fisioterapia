<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;

class GenerarRespaldo extends Command
{
    protected $signature = 'respaldo:generar';

    protected $description = 'Genera una copia de seguridad de la base de datos con mysqldump';

    public function handle(): int
    {
        $cfg = config('database.connections.'.config('database.default'));

        if (($cfg['driver'] ?? '') !== 'mysql' && ($cfg['driver'] ?? '') !== 'mariadb') {
            $this->error('El respaldo con mysqldump requiere una conexión MySQL o MariaDB.');

            return self::FAILURE;
        }

        $disco = Storage::disk('local');
        $disco->makeDirectory('respaldos');
        $archivo = 'respaldos/respaldo_'.now()->format('Y-m-d_His').'.sql';

        $proceso = new Process([
            'mysqldump',
            '--host='.$cfg['host'],
            '--port='.$cfg['port'],
            '--user='.$cfg['username'],
            '--single-transaction',
            '--routines',
            '--result-file='.$disco->path($archivo),
            $cfg['database'],
        ], null, ['MYSQL_PWD' => $cfg['password'] ?? '']);
        $proceso->setTimeout(300);
        $proceso->run();

        if (! $proceso->isSuccessful()) {
            $this->error('No se pudo generar el respaldo: '.trim($proceso->getErrorOutput()));

            return self::FAILURE;
        }

        // Conserva solo los 14 respaldos más recientes.
        $antiguos = collect($disco->files('respaldos'))->sort()->values();
        $antiguos->slice(0, max($antiguos->count() - 14, 0))->each(fn ($f) => $disco->delete($f));

        $this->info('Respaldo generado: '.$archivo);

        return self::SUCCESS;
    }
}
