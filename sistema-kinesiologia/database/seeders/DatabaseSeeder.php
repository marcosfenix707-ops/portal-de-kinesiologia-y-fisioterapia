<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Contenido;
use App\Models\Noticia;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Role::firstOrCreate(['nombre' => 'administrador'], ['descripcion' => 'Dirección de carrera: acceso total al sistema']);
        Role::firstOrCreate(['nombre' => 'personal'], ['descripcion' => 'Personal autorizado: gestiona contenidos según permisos']);

        // Cambiar esta contraseña inmediatamente después del primer ingreso.
        $usuario = User::firstOrCreate(
            ['email' => 'admin@carrera.local'],
            ['name' => 'Administrador', 'password' => 'Admin2026!', 'role_id' => $admin->id, 'activo' => true]
        );

        foreach ([
            'Reglamentos' => 'Reglamentos y normas internas',
            'Resoluciones' => 'Resoluciones y actas',
            'Comunicados' => 'Comunicados y avisos oficiales',
            'Plan de estudios' => 'Plan de estudios y programas',
            'Convocatorias' => 'Convocatorias y requisitos',
            'Formularios' => 'Formularios y trámites',
        ] as $nombre => $descripcion) {
            Categoria::firstOrCreate(['nombre' => $nombre], ['descripcion' => $descripcion]);
        }

        $contenidos = [
            'presentacion' => ['Bienvenidos', 'Portal oficial de la Carrera de Kinesiología y Fisioterapia de la Universidad Nacional “Siglo XX”. Aquí encontrará información académica, documentos oficiales, noticias y avisos de la carrera, además de la preinscripción en línea.'],
            'mision' => ['Misión de la carrera', 'La Carrera de Kinesiología y Fisioterapia de la Universidad Nacional “Siglo XX” tiene la misión de formar profesionales orgánicos, competentes y comprometidos con la realidad sociopolítica del país, con sólida formación científica, humanista e intercultural. El programa integra la teoría, la investigación, la extensión y la Formación Político Sindical para desarrollar capacidades terapéuticas, preventivas, de rehabilitación y promoción de la salud en los sistemas osteomioarticular, neurotegumentario, cardiorrespiratorio y otros sistemas del cuerpo humano. Asimismo, busca que los futuros profesionales respondan éticamente a las necesidades del pueblo boliviano mediante la aplicación de métodos, técnicas, recursos y agentes físicos en los distintos niveles de atención en salud, bajo un enfoque biopsicosocial, comunitario y transdisciplinario.'],
            'vision' => ['Visión de la carrera', 'La Carrera de Kinesiología y Fisioterapia de la Universidad Nacional “Siglo XX” se proyecta como un programa académico de excelencia científica, humanista y revolucionaria, reconocido a nivel regional y nacional por la formación de profesionales orgánicos capaces de contribuir al desarrollo del Estado Plurinacional de Bolivia. La carrera aspira a consolidarse como líder en el estudio, aplicación e innovación de métodos terapéuticos y estrategias de rehabilitación integral, orientadas a resolver los problemas de salud prioritarios del país, promoviendo el bienestar biopsicosocial y fortaleciendo el nuevo orden político, económico, social y cultural del pueblo boliviano.'],
            'objetivos' => ['Objetivos de la carrera', "Objetivo general\nFormar profesionales kinesiólogos y fisioterapeutas orgánicos, competentes y con compromiso social, capaces de intervenir en procesos de promoción, prevención, protección, tratamiento, habilitación y rehabilitación de la salud en los diferentes niveles de atención, aplicando fundamentos científicos y humanísticos, y contribuyendo al fortalecimiento del Sistema de Salud del Estado Plurinacional de Bolivia.\n\nObjetivos específicos\n- Desarrollar competencias científicas, técnicas y humanistas para evaluar, diseñar y aplicar tratamientos físico-kinésicos en personas con deficiencias, discapacidades o limitaciones temporales o permanentes.\n- Fomentar la producción de conocimiento mediante una investigación metódica y contextualizada sobre las principales entidades nosológicas que afectan a la población boliviana.\n- Actualizar los contenidos curriculares incorporando innovaciones científicas y tecnológicas.\n- Formar profesionales integrales para la prevención, habilitación, tratamiento y rehabilitación, articulando el enfoque biopsicosocial y comunitario con las políticas nacionales de salud.\n- Promover el trabajo interdisciplinario e intercultural para responder a las necesidades socioculturales, económicas y sanitarias del país.\n- Aportar a la demanda de recursos humanos en salud, fortaleciendo los programas, políticas y estrategias del Sistema Nacional de Salud."],
            'perfil_profesional' => ['Perfil profesional', 'El licenciado o licenciada en Kinesiología y Fisioterapia es un profesional con formación científica, humanista y ética, orientado a comprender y atender las necesidades de salud de la población boliviana con pertinencia sociocultural. Su práctica se basa en la evaluación integral del movimiento humano y en la intervención terapéutica de las alteraciones funcionales de los sistemas osteomioarticular, neurotegumentario y cardiorrespiratorio, en los tres niveles de atención en salud, mediante métodos, técnicas y agentes físicos respaldados por evidencia científica. Desarrolla funciones clínicas, investigativas, formativas y de gestión, con un enfoque biopsicosocial, transdisciplinario, comunitario y ecológico.'],
            'campo_ocupacional' => ['Campo ocupacional', "Los egresados pueden desempeñarse en:\n- Hospitales y clínicas.\n- Centros de rehabilitación.\n- Programas comunitarios de salud.\n- El ámbito deportivo y consultorios privados.\n- Instituciones educativas y atención geriátrica.\n- Salud ocupacional, investigación y docencia."],
            'modalidades_admision' => ['Modalidades de admisión', "El ingreso a la carrera se realiza mediante:\n- Prueba de Suficiencia Académica (PSA).\n- Admisión especial (por excelencia académica, cultura y deporte).\n- Admisión por convenios, administrada por la Dirección General de Extensión.\n\nLos requisitos y fechas vigentes se publican en la sección de noticias y en los documentos de la carrera."],
            'modalidades_titulacion' => ['Modalidades de titulación', 'La modalidad de titulación de la carrera es el internado rotatorio.'],
            'plan_estudios' => ['Plan de estudios', "Primer año\nAnatomía humana, Histología, Biofísica, Fisioterapia I, Salud pública y deontología, Embriología, Metodología de la investigación, Inglés técnico I, Historia del movimiento obrero I y Filosofía.\n\nSegundo año\nFisiología, Biomecánica y kinesiología, Electroterapia, Nosología y semiología kinésica, Kinefilaxia, Bioestadística, Fisioterapia II, Inglés técnico II, Historia del movimiento obrero II y Economía política.\n\nTercer año\nFisioterapia III, Farmacología terapéutica, Fisioterapia y kinesiología traumatológica y ortopedia, Psicología general y evolutiva, Fisioterapia y kinesioterapia pediátrica, Radiología e imagenología, Técnicas kinésicas, Formación social boliviana, Legislación social boliviana y Política nacional.\n\nCuarto año\nGerencia en servicios de salud, Fisioterapia y kinesiología cardiopulmonar, Fisioterapia y kinesiología dermatofuncional y estética, Kinesiología deportiva, Neuropsicomotricidad, Fisioterapia y kinesioterapia neurológica, Órtesis y prótesis, Política económica nacional, Dirección política y Tesis política.\n\nNota: la carrera se encuentra en proceso de innovación curricular."],
            'carga_horaria' => ['Carga horaria', 'La carrera otorga el grado académico de licenciatura con una carga horaria de 6000 horas académicas.'],
            'plantel_docente' => ['Plantel docente', 'Información en actualización. La dirección de la carrera completará esta sección desde el panel de administración.'],
            'horarios' => ['Horarios de clases', 'Información en actualización. La dirección de la carrera publicará los horarios desde el panel de administración.'],
            'estructura_organizativa' => ['Estructura organizativa', "La carrera se organiza en:\n- Asamblea Docente-Estudiantil de la Carrera.\n- Consejo de Carrera.\n- Dirección de Carrera.\n- Jefatura Académica, Jefatura de Investigación, Jefatura de Extensión Universitaria, Jefatura de Gabinete y Jefatura de Internado.\n- Personal docente, personal administrativo (secretaría, portería y encargado de equipos de gabinete) y estudiantes.\n\nDirector de Carrera: Lic. Cristhian Gustavo Ortega Huaylla."],
        ];
        foreach ($contenidos as $clave => [$titulo, $texto]) {
            Contenido::firstOrCreate(['clave' => $clave], ['titulo' => $titulo, 'contenido' => $texto, 'user_id' => $usuario->id]);
        }

        Noticia::firstOrCreate(['titulo' => 'Nuevo portal de la carrera'], [
            'resumen' => 'La carrera cuenta ahora con un portal propio para información, documentos y avisos oficiales.',
            'contenido' => "La Carrera de Kinesiología y Fisioterapia presenta su portal institucional.\n\nDesde este espacio podrá consultar y descargar documentos oficiales, leer las noticias y avisos, y realizar la preinscripción en línea.",
            'publicada' => true,
            'fecha_publicacion' => now(),
            'user_id' => $usuario->id,
        ]);
    }
}
