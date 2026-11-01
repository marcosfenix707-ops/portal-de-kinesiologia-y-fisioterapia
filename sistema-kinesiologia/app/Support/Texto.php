<?php

namespace App\Support;

class Texto
{
    /**
     * Convierte texto plano en HTML seguro: escapa todo el contenido,
     * agrupa líneas en párrafos y las que empiezan con "- " en listas.
     */
    public static function html(?string $texto): string
    {
        $texto = trim(str_replace(["\r\n", "\r"], "\n", (string) $texto));
        if ($texto === '') {
            return '';
        }

        $html = '';
        foreach (preg_split("/\n{2,}/", $texto) as $bloque) {
            $parrafo = [];
            $lista = [];
            $cerrarParrafo = function () use (&$parrafo, &$html) {
                if ($parrafo) {
                    $html .= '<p>'.implode('<br>', $parrafo).'</p>';
                    $parrafo = [];
                }
            };
            $cerrarLista = function () use (&$lista, &$html) {
                if ($lista) {
                    $html .= '<ul><li>'.implode('</li><li>', $lista).'</li></ul>';
                    $lista = [];
                }
            };

            foreach (explode("\n", $bloque) as $linea) {
                $linea = trim($linea);
                if ($linea === '') {
                    continue;
                }
                if (str_starts_with($linea, '- ')) {
                    $cerrarParrafo();
                    $lista[] = e(substr($linea, 2));
                } else {
                    $cerrarLista();
                    $parrafo[] = e($linea);
                }
            }
            $cerrarParrafo();
            $cerrarLista();
        }

        return $html;
    }
}
