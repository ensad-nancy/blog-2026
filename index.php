<?php
$base = "articles";

// Ne garder que les dossiers dans "articles"
$students = array_filter(array_diff(scandir($base), [".", ".."]), function($item) use ($base) {
    return is_dir("$base/$item");
});

function parseFrontMatter($path) {
    $content = file_get_contents($path);
    $meta = [];

    if (preg_match('/^---\s*(.*?)\s*---/s', $content, $matches)) {
        $lines = explode("\n", $matches[1]);
        foreach ($lines as $line) {
            if (strpos($line, ":") !== false) {
                list($key, $value) = explode(":", $line, 2);
                $meta[trim($key)] = trim($value);
            }
        }
        $content = trim(substr($content, strlen($matches[0])));
    }

    return [$meta, $content];
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Index</title>
    <script src="assets/script-index.js" defer></script>
    <link rel="stylesheet" href="assets/default-styles.css">
</head>
<body>

    <div id="title">
        <h1>Blog des étudiant·es de l'ensad Nancy Communication</h1>
    </div>
    <p>Ce blog rassemble <span>les écrits des étudiant.es</span> de 3e année du département communication de l'ensad Nancy. Il est développé et alimenté dans le cadre d'un cours mené conjointement par Chloé Delchini et Quentin Astié. En cours de construction ...</p>

    <div id="themes">
        <legend>Changer le thème :</legend>
        <?php foreach ($students as $student): ?>
            <div>
                <input type="radio" name="theme" value="<?= htmlspecialchars($student) ?>" onChange="changeTheme()" checked/>
                <label><?= ucfirst(htmlspecialchars($student)) ?></label>
            </div>
        <?php endforeach; ?>
        </div>

    <div id="filtres">
        <h2>Filtres</h2>

        <div id="date">
            <p>Date</p>
            <input type="range" name="date" min="0" max="8" value="8" />
            <label for="date">Tout</label>
        </div>

        <div id="auteurices">
            <p>Auteur·ices</p>
            <select name="authors" id="authors">
                <option value="all">Tous les auteurs</option>
                <?php foreach ($students as $student): ?>
                    <option value="<?= htmlspecialchars($student) ?>"><?= ucfirst(htmlspecialchars($student)) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <main>
        <?php
        $allArticles = [];

        foreach ($students as $student): 
            $folder = "$base/$student";
            // Ne garder que les fichiers dans le dossier de l'étudiant
            $files = array_filter(array_diff(scandir($folder), [".", "..", "images"]), function($item) use ($folder) {
                return is_file("$folder/$item");
            });

            foreach ($files as $file):
                if (pathinfo($file, PATHINFO_EXTENSION) === "md"):
                    $path = "$folder/$file";
                    list($meta, $mdContent) = parseFrontMatter($path);
                    $allArticles[] = [
                        'student' => $student,
                        'file' => $file,
                        'title' => $meta['title'] ?? pathinfo($file, PATHINFO_FILENAME),
                        'date' => $meta['date'] ?? '0000-00-00',
                        'tags' => $meta['tags'] ?? '',
                        'preview' => isset($meta['preview']) ? "articles/$student/" . $meta['preview'] : ''
                    ];
                endif;
            endforeach;
        endforeach;

        // Trier par date (décroissant = plus récent en premier)
        usort($allArticles, function($a, $b) {
            return strtotime($b['date']) - strtotime($a['date']);
        });
        ?>
        <?php foreach ($allArticles as $article): ?>
            <a href="article.php?student=<?= urlencode($article['student']) ?>&file=<?= urlencode($article['file']) ?>&date=<?= urlencode($article['date']) ?>" data-author="<?= htmlspecialchars($article['student']) ?>" data-date="<?= htmlspecialchars($article['date']) ?>">
                <div>
                    <h3><?= htmlspecialchars($article['title']) ?></h3>
                    <footer>
                        <p><strong>Auteur·ice :</strong> <?= ucfirst(htmlspecialchars($article['student'])) ?></p>
                        <p><strong>Date :</strong> <?= htmlspecialchars($article['date']) ?></p>
                        <?php if ($article['tags']): ?>
                            <p><strong>Tags :</strong>
                            <?php foreach (explode(',', $article['tags']) as $tag): ?>
                                <span class="tag"><?= htmlspecialchars(trim($tag)) ?></span>
                            <?php endforeach; ?>
                            </p>
                        <?php endif; ?>
                    </footer>
                    <?php if ($article['preview']): ?>
                        <img src="<?= htmlspecialchars($article['preview']) ?>" alt="" class="thumb">
                    <?php endif; ?>
                </div>
            </a>
        <?php endforeach; ?>
    </main>

</body>
</html>