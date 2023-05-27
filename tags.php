<?php
$bdd = new PDO("mysql:host=localhost:8889;dbname=blog", "root", "root");
$tagStmt = $bdd->prepare("SELECT * FROM tags");
$tagStmt->execute();
$tags = $tagStmt->fetchAll(PDO::FETCH_ASSOC);
if(!$tags){
exit();
}
?>
<form action='/posts-filtered-by-tag.php' method='post'>
<?php
foreach ($tags as $tag) {
    echo "<input type='radio' name='tag' value='" . $tag['id'] . "'>
    <label for='tag'>" . $tag['tag'] . "</label>
";
}?>
<button type='submit'>Filtrer par tag</button>
</form>