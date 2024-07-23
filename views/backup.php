
 <?php
       
?>

       <img id="profileImage" src="<?= isset($_SESSION['user']) ? htmlspecialchars($_SESSION['user']['image']) : getUrl('public/emoji.png') ?>" alt="Profile" class="w-full h-full rounded-full object-cover text-gray-300" />
       <input type="file" id="imageInput" class="hidden" />