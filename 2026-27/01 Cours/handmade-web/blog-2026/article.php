<?php
$base = "articles";
$students = array_diff(scandir($base), [".", ".."]);

require_once "assets/Parsedown.php";

$student = $_GET['student'];
$file = $_GET['file'];

$path = "articles/$student/$file";

if (!file_exists($path)) {
    die("Article introuvable.");
}

// Parse front matter
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

list($meta, $mdContent) = parseFrontMatter($path);

$title = $meta['title'] ?? pathinfo($file, PATHINFO_FILENAME);
$date = $meta['date'] ?? '';
$tags = $meta['tags'] ?? '';

$Parsedown = new Parsedown();
$htmlContent = $Parsedown->text($mdContent);

$mdContent = preg_replace(
    '/\!\[(.*?)\]\((images\/.*?)\)/i',
    '![$1](articles/' . $student . '/$2)',
    $mdContent
);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($title) ?></title>
    <script src="assets/script-article.js" defer></script>
    <link rel="stylesheet" href="themes/<?= htmlspecialchars($student) ?>.css">
</head>
<body>

<a href="index.php">← Retour</a>

<div id="themes">
  <legend>Changer le thème :</legend>
  <?php foreach ($students as $student): ?>
            <div>
                <input type="radio" name="theme" value="<?= htmlspecialchars($student) ?>" onChange="changeTheme()" checked/>
                <label><?= ucfirst(htmlspecialchars($student)) ?></label>
            </div>
    <?php endforeach; ?>
  </div>

<header>
    <p class="title"><?= htmlspecialchars($title) ?></p>
    <?php if ($date): ?>
        <p class="date"><?= htmlspecialchars($date) ?></p>
    <?php endif; ?>
    <?php if ($tags): ?>
        <p class="tags">
            <?php foreach (explode(',', $tags) as $tag): ?>
                <span class="tag"><?= htmlspecialchars(trim($tag)) ?></span>
            <?php endforeach; ?>
        </p>
    <?php endif; ?>
</header>

<article>
    <?php echo $Parsedown->text($mdContent); ?>
</article>

</body>
</html>