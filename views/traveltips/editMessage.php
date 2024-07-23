<?php

    require './views/partials/header.php';
  //  $baseUri = '/travel/';
  //  $uri = parse_url($_SERVER['REQUEST_URI'])["path"];

?>

<body class="dark:bg-darkBackground dark:text-lightBackground light:text-darkBackground light:bg-lightBackground">
<?php
    require './views/partials/navbar.php';
?>
<?php echo urldecode($countryParam); ?>

<div class="flex flex-col px-2 md:px-4 w-full mb-4">
    EDIT MESSAGE   <?= $message["message"] ?>
<form method="POST" action="<?= getUrl('traveltips/' . urlencode($countryParam) . '/updatemessage')?>">
    <input type="hidden" name="_method" value="PATCH"/>
    <input type="hidden" name="id" value="<?= $message['id'] ?>"/>

        <div class="flex justify-between items-center dark:text-lighTextColor gap-4 bg-gray-100 px-2 py-2 md:rounded-lg shadow-md mt-2">
            <div class="flex items-center gap-2">
                <div class="w-14 h-14 overflow-hidden rounded-full">
                <img src="<?php echo isset($user['image']) ? $user['image'] : getUrl('public/emoji.png') ; ?>" alt="Profile" class="w-full h-full object-cover" />
                </div>
            </div>
            <div class="flex-1  md:flex">
                <textarea name="message" 
                          class="w-full py-2 px-4 bg-gray-200 rounded-lg text-black focus:outline-none focus:ring focus:border-blue-500 resize-none" 
                          placeholder="Sdlej svůj názor (max 400 znaků)" 
                          maxlength="400"
                
                          ><?= $message["message"] ? trim($message["message"]) : ''; ?></textarea>
            </div>
                
            <div>
                <a href="./message?id=<?=urlencode($_GET['id'])?>" class="py-2 px-4 bg-gray-500 text-white rounded-lg shadow-md hover:bg-gray-600 focus:outline-none focus:ring focus:border-gray-700">Zpět</a>
            </div>
            <div>
                <button type="submit" class="py-2 px-4 bg-green-500 text-white rounded-lg shadow-md hover:bg-green-600 focus:outline-none focus:ring focus:border-green-700">Ulož</button>
            </div>
     
        </div>
 <!--        <h1>Error, <?php if (isset($err)){ echo $err;} ?>!</h1> -->
        <?php
                if (isset($_SESSION['errors']) && $_SESSION['errors']){
                    foreach ($_SESSION['errors'] as $key => $val){
                         echo "<p class='text-red-500 text-xs mt-2'> $val </p>";
                    }
         
                    unset($_SESSION['errors']);
                } else {
                    echo '';
                }
    ?>
    </form>

</div>

<?php
     require './views/partials/footer.php';
?>


</body>