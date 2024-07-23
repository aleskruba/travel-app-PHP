<?php

    require_once 'partials/header.php';

?>
<body class="dark:bg-darkBackground dark:text-lightBackground light:text-darkBackground   light:bg-lightBackground">
<?php
    require 'partials/navbar.php';
?>
<div class='flex flex-col pt-10 items-center h-screen dark:bg-dkarkBackground'>

<a href="<?=  getUrl('') ?>" class="flex items-center">
<span class="text-lightAccent text-2xl poppins-extrabold-italic cursor-pointer" style="-webkit-text-stroke: 0.1px white;">
Rady na cesty</span>
</a>

<div>

<form action="<?= getUrl('sendpasswordreset') ?>"  method="POST" class="mt-8">
    <div>
        <label for="email">Zadej svůj email</label>
        <input type="email" 
               placeholder="Email" 
               name="email" 
               id="email"
               class="w-full border rounded-md p-2 text-black" 
                value="<?= isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : '' ?>"
               maxlength="20" />
        <?php if (isset($_SESSION['errors']['noemail'])) : ?>
            <div class="text-red-500 dark:text-red-300" id="profileErrors">
                <?php echo htmlspecialchars($_SESSION['errors']['noemail']); ?>
            </div>
        <?php endif; ?>
        <div class="flex justify-center space-x-4 mt-4">
          <button type="submit" id="submitPwdBtn" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded opacity-30 pointer-events-none">Odeslat</button>
          <a href="<?= getUrl('login') ?>" type="button"  class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Zpět</a>
        </div>
    </div>
</form>



</div>
        </body>

<script>

const emailInput = document.getElementById('email');
  const submitBtn = document.getElementById('submitPwdBtn');

  emailInput.addEventListener('input', function() {
    if (emailInput.value.trim() !== '') {
      submitBtn.classList.remove('opacity-30', 'pointer-events-none');
    } else {
      submitBtn.classList.add('opacity-30', 'pointer-events-none');
    }
  });



  </script>
