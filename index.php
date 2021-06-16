<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Games Premiere Timeline</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>
</head>

<?php require_once 'vendor/autoload.php'; ?>
<?php $data = new \Timeline\Data(); ?>
<?php $games = $data->sortGamesByDate()->getGames(); ?>

<body>
  <h2>Games Premiere Timeline</h2>

<ul id='timeline'>
    <?php $i = 0; ?>
    <?php /** @var \Timeline\Game $game */ ?>
    <?php foreach($games as $key => $game) { ?>
  <li class='entry'>
    <input <?php if ($i == 0) { ?>checked='checked'<?php } ?> class='radio' id='trigger<?=$key?>' name='trigger' type='radio'>
    <label for='trigger<?=$key?>'>
      <span>
        <?=$game->getName()?>
      </span>
    </label>
      <span class='date'><?=$game->getDate()->format('d.m.Y')?></span>
    <span class='circle'></span>
    <div class='content'>
      <h3><?=$game->getName()?> (<?=$game->getDate()->format('d.m.Y')?>)</h3>
        <img src="<?=$game->getImg()?>" alt="<?=$game->getName()?>">
        <p>
            <?=$game->getDescription()?>
        </p>
    </div>
  </li>
    <?php $i++ ?>
    <?php } ?>
</ul>
</body>
</html>
