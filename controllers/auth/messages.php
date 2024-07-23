<?php
 //   $baseUri = '/travel/';
    $uri = parse_url($_SERVER['REQUEST_URI'])["path"];
?>

<?php foreach ($messages as $message) :?>
<div class="flex flex-col px-2 md:px-4 w-full mt-2">
<div class='  flex flex-col dark:bg-gray-500 dark:text-gray-100 px-2 py-2 shadow-2xl rounded-lg bg-gray-200 text-black'> 
    <div class="flex flex-col md:flex-row md:items-center gap-4 ">
      <div class="flex  items-center gap-2"> 
               
                 <div class=' min-w-[25px] text-red-700  cursor-pointer hover:text-red-500'>
                    Trash
                  </div>
          
      <a href="<?= $uri ?>/message?id=<?= $message['id'] ?>">

        <div class="w-14 h-14 overflow-hidden rounded-full">
      
          <img src="<?php echo isset($user['image']) ? $user['image'] : getUrl('public/emoji.png') ?>" alt="Profile" class="w-full h-full object-cover" />

        </div>
       </a> 
        <div class="flex flex-row gap-4 md:gap-2"> <?=htmlspecialchars($message['user_id']) ?>
        <p class="  font-semibold"><?=htmlspecialchars($message['email']) ?></p>
        <p class=" w-[80px]">22.5.2024</p>
     
        </div>
      </div>
        <div class="md:px-4" >
          <p class=""><?= htmlspecialchars($message['message'])?> </p>
      </div>
     </div>
</div>
</div>
<?php endforeach; ?>
    