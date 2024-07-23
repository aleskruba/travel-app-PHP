<?php
    require_once 'partials/header.php';
    $_SESSION['authentication'] = 'login';
    require_once './Core/redirect.php';



    if (isset($_GET['update']) && $_GET['update'] === 'success') {
   
  
        echo "<script>
          setTimeout(()=>{
            Toastify({
              text: 'Update proběhl úspěšně',
              duration: 1500, // Duration in milliseconds
              gravity: 'top', // Display position: 'top', 'bottom', 'left', 'right'
              backgroundColor: 'linear-gradient(to right, #00b09b, #96c93d)', // Background color
              callback: function() {
                  if (history.replaceState) {
                      history.replaceState({}, document.title, window.location.pathname);
                  }
              }
          }).showToast();
    
           },200)
    
        </script>";
    }
    
    if (isset($_GET['update']) && $_GET['update'] === 'error') {
       
      
      echo "<script>
      setTimeout(()=>{
        Toastify({
          text: 'Update nebyl úspěšný',
          duration: 3000, // Duration in milliseconds
          gravity: 'top', // Display position: 'top', 'bottom', 'left', 'right'
          backgroundColor: 'linear-gradient(to right, #ff4d4d, #ff8080)',
          callback: function() {
              if (history.replaceState) {
                  history.replaceState({}, document.title, window.location.pathname);
              }
          }
      }).showToast();
    
       },200)
    
    </script>";
    }
?>

<div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 overflow-y-auto ">
      
    <div class='flex flex-wrap items-center  overflow-y-auto min-h-[500px] mt-20'>
        <div class="relative bg-white p-2 rounded-lg flex items-center justify-center flex-col w-[350px] min-w-[350px] h-full max-h-[400px] md:w-[450px] md:h-[550px] ">
        <div class='absolute text-2xl top-2 right-2  text-gray-500 hover:text-gray-700 cursor-pointer' id="closeButton">
    <i class="fa fa-times" aria-hidden="true"></i>
</div>
           
             <h1 class='mt-4 poppins-extrabold text-3xl'>Příhlášení</h1>

          <div id="chooseLoginMethod" class="w-full flex flex-col justify-center items-center ">
            <div id="emailDiv"  class='mt-4 w-[80%] py-2  flex items-center justify-center bg-email rounded-lg cursor-pointer'>E-mail</div>
            
                   <div class=' mt-4 w-[80%]  bg-gray-200 flex items-center justify-center rounded-lg cursor-pointer'>
                <a 
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 rounded text-center"
                    href="<?=  $client->createAuthUrl()?>"
                    style="width: 100%;" 
                >  Přihlásit s Google 🚀 </a>
                </div>


                </div>
          <h5 class='pt-4'>Ještě nemáš účet? 
              <a class='text-gray-600 underline cursor-pointer'
              href="<?= getUrl('signup')  ?>" 
              >Zaregistrovat se
                </a>  
            </h5>
            <h5>Zapomenuté heslo : <a class='text-gray-600 underline cursor-pointer'
            href="<?= getUrl('forgottenpassword')  ?>" 
           >Klikni zde
            </a>  </h5>
            




          <form method="post" id='formDiv' action="<?= getUrl('login') ?>" class="hidden flex flex-col space-y-4 items-center w-[350px] relative">
                <input type="email" name="email" id="email" placeholder="Email" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                <?php if (isset($errors['email'])) : ?>
                    <div class="text-red-500"><?php echo $errors['email']; ?></div>
                <?php endif; ?>

                <input type="password" name="password" id="password" placeholder="Heslo" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500" required>
                <div class="w-10 h-10 absolute top-10 right-2 text-black cursor-pointer" id="eye">
                  <img src="./public/eye1.png" alt="eye" id="image" class="w-full h-full object-cover" />
                </div>
                <?php if (isset($errors['password'])) : ?>
                    <div class="text-red-500"><?php echo $errors['password']; ?></div>
                <?php endif; ?>

                <?php if (isset($backendError)) : ?>
                    <div class="text-red-500"><?php echo $backendError; ?></div>
                <?php endif; ?>

                <div class="flex space-x-4">
                    <input type="submit" name="submit" value="Přihlásit" class="px-4 py-2 bg-blue-500 text-white rounded-md cursor-pointer hover:bg-blue-600 transition duration-300 w-[120px]">
                    <input type="button" id='backButton' value="Zpět" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md cursor-pointer hover:bg-gray-400 transition duration-300 w-[120px]">
                </div>
                <div id="errors" class="">
                <?php
        if (isset($_SESSION['errors']) && isset($_SESSION['errors']['emailnotexists'])) {
            echo "<script>document.getElementById('chooseLoginMethod').classList.add('hidden'); document.getElementById('formDiv').classList.remove('hidden');</script>";
            echo '<div class="text-red-500 text-xs" > ' . $_SESSION['errors']['emailnotexists'] . '</div>';
            unset($_SESSION['errors']['emailnotexists']);
        }
        ?>
        </div>
         </form>

                <img class='flex mt-4 h-auto  min-h-[60px] w-full' src="./public/lide.svg" alt="lide" />
   
                </div>
    </div>
    </div>
    <?php if (isset( $errorMessage)): ?>
    <?= $errorMessage ?>
<?php endif; ?>

    <script>

        const chooseLoginMethod = document.getElementById('chooseLoginMethod');
        const formDiv = document.getElementById('formDiv');
        const emailDiv = document.getElementById('emailDiv');            
        const backButton = document.getElementById('backButton');
        const errors = document.querySelectorAll('#errors');

        emailDiv.addEventListener('click',function(){
            chooseLoginMethod.classList.add('hidden');
            formDiv.classList.remove('hidden');
            errors.forEach(function(error) {
                    error.classList.add('hidden');
                });
        })


        backButton.addEventListener('click',function(){
            email.value = '' ;   
            errors.forEach(function(error) {
                    error.classList.add('hidden');
                });
            chooseLoginMethod.classList.remove('hidden');
            formDiv.classList.add('hidden');
        })


        document.addEventListener("DOMContentLoaded", function() {
        var closeButton = document.getElementById("closeButton");
        <?php unset($_SESSION['errors']); ?>
        closeButton.addEventListener("click", function() {
            window.location.href = '/travel';

    });
});


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