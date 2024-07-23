
<?php
    require './views/partials/header.php';
 //   $baseUri = '/travel/';
 //   $uri = parse_url($_SERVER['REQUEST_URI'])["path"];
?>

<body class="dark:bg-darkBackground dark:text-lightBackground light:text-darkBackground light:bg-lightBackground">
<?php
    require './views/partials/navbar.php';
?>
 <div class="flex flex-col m pb-16">

<?php if ($message): ?>
    <h1>MESSAGE <?= htmlspecialchars($messageId) ?></h1>
    <br>
    <p>Autor <?= htmlspecialchars($message['firstName']) ?></p>
    <p><?= htmlspecialchars($message['message']) ?></p>

   
  <?php
      $countryParam = urldecode($_GET['param1']); 
  ?> 
    
    <form method="POST" action="<?= getUrl('traveltips/' . urlencode($countryParam) . '/destroymessage')?>">

    <input type="hidden" name="_method" value="DELETE">
    <input type="hidden" name="id" value="<?= $message['id'] ?>">


    
    <button type="submit" class="text-sm text-red-500 mt-4 dark:text-lightBackground">
        Delete
    </button>

    
    <a href="./editmessage?id=<?= $message['id'] ?>"  class="text-sm text-blue-500 mt-4 dark:text-lightBackground">
        Edit
    </a>
    
</form>


<?php else: ?>
    <h1>THIS MESSAGE DOES NOT EXIST</h1>
<?php endif; ?>

<a href="../<?php echo urlencode($countryParam); ?>" id='backButton' class="mt-4 underlinet text-blue-500">go back</a>
</div>

<?php
     require './views/partials/footer.php';
?>

</body>
</html>
