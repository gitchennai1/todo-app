<?php
require_once 'db.php';

$dir = __DIR__ . '/migrations';
$files = glob("$dir/*.sql");
sort($files);

foreach ($files as $file) {
    $name = basename($file);

    // Check if this migration has already been run
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM schema_migrations WHERE migration = ?");
    $stmt->execute([$name]);
    if ($stmt->fetchColumn() > 0) {
        echo "✅ Already applied: $name\n";
        continue;
    }

    echo "🚀 Applying: $name...\n";
    $sql = file_get_contents($file);

    try {
        $pdo->beginTransaction();
        $pdo->exec($sql);
        $pdo->prepare("INSERT INTO schema_migrations (migration) VALUES (?)")->execute([$name]);
        $pdo->commit();
        echo "✅ Done: $name\n";
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo "❌ Failed: $name - " . $e->getMessage() . "\n";
        exit(1);
    }
}
?>
