<?php
@mkdir(__DIR__ . '/dist', 0777, true);

foreach (glob(__DIR__ . '/articles/*/*.md') as $chemin) {
    $student = basename(dirname($chemin));
    $file    = basename($chemin);

    $params = ['student' => $student, 'file' => $file];
    $code   = '$_GET = ' . var_export($params, true) . '; include "article.php";';
    $html   = shell_exec('php -r ' . escapeshellarg($code));

    // Le lien « Retour » doit pointer vers la page générée
    $html = str_replace('href="index.php"', 'href="index.html"', $html);

    $sortie = __DIR__ . "/dist/article-$student-" . basename($file, '.md') . '.html';
    file_put_contents($sortie, $html);
}