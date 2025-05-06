<?php

require_once __DIR__ . '/../bootstrap/bootstrap.php';
require_once __DIR__ . '/../app/Models/Pelicula.php';
require_once __DIR__ . '/../app/Models/Voto.php';
require_once __DIR__ . '/../app/Models/Usuario.php';

use App\Core\DB;
use App\Models\Voto;
use App\Models\Pelicula;
use App\Models\Usuario;


/*
echo "<h2>Películas votadas por admin (usuario_id=1) con su voto</h2>";
echo "<h3>Pelicula withOne Voto (1 consulta)</h3>";

$sql = "SELECT pelicula.id AS _id, pelicula.*, voto.*
        FROM peliculas AS pelicula
        JOIN votos AS voto ON voto.pelicula_id = pelicula.id
        WHERE voto.usuario_id = 1
        ORDER BY pelicula.titulo ASC, voto.id ASC";


$peliculas = DB::withOne(Pelicula::class, Voto::class, $sql, []);
echo"<ul>";
foreach ($peliculas as $pelicula) {
    echo "<li>{$pelicula->titulo} ({$pelicula->voto->puntuacion})</li>";
    
}
echo"<ul>";
*/

/*
echo "<h2>Películas con sus votos</h2>";
echo "<h3>Pelicula withMany Voto (1 consulta)</h3>";

$sql = "SELECT pelicula.id AS _id, pelicula.*, voto.*
        FROM peliculas AS pelicula
        JOIN votos AS voto ON voto.pelicula_id = pelicula.id
        ORDER BY pelicula.titulo ASC, voto.id ASC";


$peliculas = DB::withMany(Pelicula::class, Voto::class, $sql, []);

echo"<ul>";
foreach ($peliculas as $pelicula) {
    echo "<li>{$pelicula->titulo}<br>";
    echo "Puntuaciones: ";
    foreach($pelicula->votos as $voto){
        echo "{$voto->puntuacion}, ";
    }
    echo "</li><br>";
}
echo"<ul>";
*/

/*
echo "<h2>Películas con sus votos</h2>";
echo "<h3>Lazy loading (21 consultas)</h3>";

$peliculas = Pelicula::orderBy('titulo', 'ASC')->get();
echo"<ul>";
foreach ($peliculas as $pelicula) {
    echo "<li>{$pelicula->titulo}<br>";
    echo "Puntuaciones: ";
    foreach($pelicula->votos as $voto){
        echo "{$voto->puntuacion}, ";
    }
    echo "</li><br>";
}
echo"<ul>";
*/

/*
echo "<h2>Películas con sus votos y críticas de los usuarios</h2>";
echo "<h3>Lazy loading (127 consultas: 1 para obtener las pelis, 20 para los votos de cada peli, 106 para el usuario de cada voto)</h3>";

$peliculas = Pelicula::orderBy('titulo', 'ASC')->get();
echo"<ul>";
foreach ($peliculas as $pelicula) {
    echo "<li>{$pelicula->titulo}";

    foreach($pelicula->votos as $voto){
        echo "<p>Puntuación: {$voto->puntuacion}<br>";
        $critica = $voto->critica;
        if($critica){
            echo "{$critica}<br>";
        }
        echo "Votado por {$voto->usuario->nombre}</p>";
    }
    echo "</li><br>";
}
*/
/*
echo "<h2>Películas con sus usuarios y votos de los usuarios, usando usuarios()</h2>";
echo "<h3>Lazy loading (127 consultas: 1 para obtener las pelis, 20 para los votos de cada peli, 106 para el usuario de cada voto)</h3>";
$peliculas = Pelicula::orderBy('titulo', 'ASC')->get();
echo "<ul>";

foreach($peliculas as $pelicula){

    echo "<li>{$pelicula->titulo}";
    foreach ($pelicula->usuarios as $usuario) {
        echo "<p>Usuario: {$usuario->nombre}<br>";
        echo "Puntuación: {$usuario->pivot->puntuacion}<br>";
        echo "{$usuario->pivot->critica}</p>";
    }
    echo "</li><br>";
}
*/

/*
echo "<h2>Películas con sus votos y críticas de los usuarios</h2>";
echo "<h3>Pelicula withManyToMany Voto Usuario (1 consulta)</h3>";

$sql = "
    SELECT 
        p.id AS __id, p.*,
        v.id AS _id, v.*,
        u.*
    FROM peliculas p
    JOIN votos v ON v.pelicula_id = p.id
    JOIN usuarios u ON u.id = v.usuario_id
    ORDER BY p.titulo ASC";

$peliculas = DB::withManyToMany(Pelicula::class, Voto::class, Usuario::class, $sql);

echo "<ul>";
foreach ($peliculas as $pelicula) {
    echo "<li>{$pelicula->titulo}";

    foreach ($pelicula->usuarios as $usuario) {
        $pivot = $usuario->pivot; // el voto es el pivot
        echo "<p>Puntuación: {$pivot->puntuacion}<br>";
        if ($pivot->critica) {
            echo "{$pivot->critica}<br>";
        }
        echo "Votado por {$usuario->nombre}</p>";
    }

    echo "</li><br>";
}
echo "</ul>";
*/

/*
echo "<h2>Usuarios con sus películas votadas</h2>";
echo "<h3>Usuario withManyToMany Voto Pelicula (1 consulta)</h3>";

$sql = "
    SELECT 
        u.id AS __id, u.*,
        v.id AS _id, v.*,
        p.*
    FROM usuarios u
    JOIN votos v ON v.usuario_id = u.id
    JOIN peliculas p ON p.id = v.pelicula_id
    ORDER BY u.nombre ASC, p.titulo ASC
";


$usuarios = DB::withManyToMany(Usuario::class, Voto::class, Pelicula::class, $sql, []);

echo "<ul>";
foreach ($usuarios as $usuario) {
    echo "<li>Usuario: {$usuario->nombre}<br>";

    foreach ($usuario->peliculas as $pelicula) {
        echo "<p>{$pelicula->titulo} ({$pelicula->pivot->puntuacion})<br>";
        echo "{$pelicula->pivot->critica}</p>";
    }
    echo "</li><br>";

}
echo "</ul>";

*/

/*
$sql = 
    "SELECT 
        peliculas.id,
        peliculas.titulo,
        COUNT(votos.id) AS num_votos,
        ROUND(AVG(votos.puntuacion), 2) AS puntuacion
    FROM peliculas
    LEFT JOIN votos ON votos.pelicula_id = peliculas.id
    GROUP BY peliculas.id, peliculas.titulo";
*/
/*
$sql = 
    "SELECT 
        peliculas.id,
        peliculas.titulo,
        COUNT(votos.id) AS num_votos,
        ROUND(AVG(votos.puntuacion), 2) AS puntuacion
    FROM peliculas
    JOIN votos ON votos.pelicula_id = peliculas.id
    GROUP BY peliculas.id, peliculas.titulo
    HAVING num_votos > 2 AND puntuacion > 8";

$peliculas = DB::query(Pelicula::class, $sql);
echo "<ul>";
foreach($peliculas as $pelicula){
    echo "<li> {$pelicula->titulo} ";
    $puntuacion = $pelicula->puntuacion ?? 'S/Votos';
    echo "($puntuacion)<br>";
    echo "{$pelicula->num_votos} votos<br></li>";
}
echo "</ul>";
*/

$peliculas = Pelicula::WithAggregates()->get();
echo "<ul>";
foreach ($peliculas as $pelicula) {
    echo "<li> {$pelicula->titulo} ";
    $puntuacion = $pelicula->puntuacion ?? 'S/Votos';
    echo "($puntuacion)<br>";
    echo "{$pelicula->num_votos} votos<br></li>";
}
echo "</ul>";



/*

$pelicula = Pelicula::find(1);

echo"<h1>{$pelicula->titulo}</h1>";

echo"<ul>";

foreach($pelicula->votos as $voto){
    echo "<li>Puntuación: {$voto->puntuacion}<br>";
    $critica = $voto->critica;
    if($critica){
        echo "{$critica}<br>";
    }
    echo "Votado por {$voto->usuario->nombre}</li>";
}

echo "</ul>";

*/
