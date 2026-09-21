<?php
@mkdir(__DIR__ . '/dist', 0777, true);

function reecrire_liens(string $html): string {
    $html = preg_replace_callback(
        '/article\.php\?student=([^&"\']+)&(?:amp;)?file=([^&"\']+)(?:&(?:amp;)?date=[^"\']*)?/',
        function ($m) {
            $student = rawurldecode($m[1]);
            $nom = basename(rawurldecode($m[2]), '.md');
            return "article-$student-$nom.html";
        },
        $html
    );
    // index.php → index.html
    return str_replace('href="index.php"', 'href="index.html"', $html);
}

function rendre(string $fichier, array $get = []): string {
    $code = '$_GET = ' . var_export($get, true) . '; include ' . var_export($fichier, true) . ';';
    return shell_exec('php -r ' . escapeshellarg($code));
}

file_put_contents(__DIR__ . '/dist/index.html', reecrire_liens(rendre('index.php')));

foreach (glob(__DIR__ . '/articles/*/*.md') as $chemin) {
    $student = basename(dirname($chemin));
    $file    = basename($chemin);

    $html = reecrire_liens(rendre('article.php', ['student' => $student, 'file' => $file]));
    file_put_contents(__DIR__ . "/dist/article-$student-" . basename($file, '.md') . '.html', $html);
}