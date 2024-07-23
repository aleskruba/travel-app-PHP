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

<form class="space-y-4 dark:bg-gray-500 dark:text-gray-100 relative" method="post" action="<?= getUrl('updatepasswordreset') ?>">

<input type="hidden" name="_method" value="PATCH"/>
<input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>" />

<input type="password" placeholder="Nové heslo" name="password" id="password" class="w-full border rounded-md p-2 text-black" maxlength="20" />
<input type="password" placeholder="Potvrď nové heslo" name="confirmPassword" id="confirmPassword" class="w-full border rounded-md p-2 text-black" maxlength="20" />


<div class="w-10 h-10 absolute top-1 right-2 text-black cursor-pointer" id="eye">
<img src="./public/eye1.png" alt="eye" id="image" class="w-full h-full object-cover" />
</div>




<?php if (isset($_SESSION['pwderrors']['password'])) : ?>
  <div class="text-red-500 dark:text-red-300" id="profileErrors"><?php echo htmlspecialchars($_SESSION['pwderrors']['password']); ?></div>
<?php endif; ?>
<?php if (isset($_SESSION['pwderrors']['confirmPassword'])) : ?>
  <div class="text-red-500 dark:text-red-300" id="profileErrors"><?php echo htmlspecialchars($_SESSION['pwderrors']['confirmPassword']); ?></div>
<?php endif; ?>

<div class="flex justify-center space-x-4">
<button type="submit" id="submitPwdBtn" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded opacity-30 pointer-events-none">Uložit</button>
<a href="<?= getUrl('login') ?>" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Zpět</a>
</div>
</form>



</div>
        </body>

<script>

    const emailInput = document.getElementById('email');
  const passwordBtn = document.getElementById('passwordBtn');
  const passwordDiv = document.getElementById('passwordDiv');
  const passwordInput = document.getElementById('passwordInput');
  const submitPwdBtn = document.getElementById('submitPwdBtn');



  const changePasswordFunction = () => {
    <?php    unset($_SESSION['pwderrors']) ?>
    passwordDiv.classList.add('hidden');
    passwordInput.classList.remove('hidden');

  }



  
  function comparePasswords() {


            const currentValues = {
                password: document.getElementById('password').value,
                confirmPassword: document.getElementById('confirmPassword').value,
                  };


                  

            let isDifferent = false;

            if (currentValues.password.length > 5 && currentValues.confirmPassword.length > 5 && currentValues.password === currentValues.confirmPassword ) {
                isDifferent = true;
            }

            if (isDifferent) {
              submitPwdBtn.classList.remove('opacity-30', 'pointer-events-none')
            } else {
              submitPwdBtn.classList.add('opacity-30' ,'pointer-events-none')
            }
        }

        document.getElementById('password').addEventListener('input', comparePasswords);
        document.getElementById('confirmPassword').addEventListener('input', comparePasswords);
  
        const image = document.getElementById('image');
            const eye = document.getElementById('eye');

            const imageEye = "./public/eye2.png";
            const imageEyeCloses = "./public/eye1.png";

            eye.addEventListener('click', function() {
    if (image.src.endsWith(imageEye.replace('./', ''))) {
      password.type = 'password'
      confirmPassword.type = 'password'
      image.src = imageEyeCloses;
    } else {
      console.log('eye1');
      password.type = 'text';
      confirmPassword.type = 'text'
      image.src = imageEye;
    }
  });
  </script>
