<?php
    require_once 'partials/header.php';
    require_once './Core/redirect.php';

  //  $baseUri = '/travel/';
   // $uri = parse_url($_SERVER['REQUEST_URI'])["path"];
   // echo $uri;

?>

<div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 overflow-y-auto ">


    <div class='flex flex-wrap items-center  overflow-y-auto min-h-[500px] mt-20'>
        <div class="relative bg-white p-2 rounded-lg flex items-center justify-center flex-col w-[350px] min-w-[350px] h-full max-h-[400px] md:w-[450px] md:h-[550px] ">
        <div class='absolute text-2xl top-2 right-2  text-gray-500 hover:text-gray-700 cursor-pointer' id="closeButton">
                <i class="fa fa-times" aria-hidden="true"></i>
            </div>
             <h1 class='mt-2 poppins-extrabold text-3xl'>Registrace</h1>

          <div id="chooseLoginMethod" class="w-full flex flex-col justify-center items-center ">
            <div id="emailDiv"  class='mt-2 w-[80%] py-2  flex items-center justify-center bg-email rounded-lg cursor-pointer'>E-mail</div>
            
                <div class=' mt-4 w-[80%]  bg-gray-200 flex items-center justify-center rounded-lg cursor-pointer'>
                <a 
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 rounded text-center"
                    href="<?= $client->createAuthUrl()?>"
                    style="width: 100%;" 
                >  Registrovat s Google 🚀 </a>
                </div>
                <?php
                    if(isset($token['error'])) { ?> 
                    <div><?= print_r($token); ?> </div>
                    <?php  }
                ?>


                </div>
          <h5 class='pt-2'>Už máš účet? 
              <a class='text-gray-600 underline cursor-pointer'
                href="<?= getUrl('login') ?>"
              >Přihlásit se
                    </a>  
            </h5>
            <h5>Zapomenuté heslo : <a class='text-gray-600 underline cursor-pointer'
            href="<?= getUrl('forgottenpassword')  ?>" 
           >Klikni zde
            </a>  </h5>
 




        <form method="post" id='formDiv' action="<?= getUrl('signup') ?>" class="hidden flex flex-col space-y-2 items-center w-[350px] relative">
    <input type="email" name="email" id="email" placeholder="Email" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
   <div id="errors" class="">
    <?php
        if (isset($_SESSION['errors']) && isset($_SESSION['errors']['email'])) {
            echo "<script>document.getElementById('chooseLoginMethod').classList.add('hidden'); document.getElementById('formDiv').classList.remove('hidden');</script>";
            echo '<div class="text-red-500 text-xs" > ' . $_SESSION['errors']['email'] . '</div>';
            unset($_SESSION['errors']['email']);
        }
        ?>
    </div>

    <input type="password" name="password" id="password" placeholder="Heslo" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500" required>
    <div class="w-10 h-10 absolute top-12 right-2 text-black cursor-pointer" id="eye">
          <img src="./public/eye1.png" alt="eye" id="image" class="w-full h-full object-cover" />
        </div>
  
    <div id="errors" class="">
    <?php
        if (isset($_SESSION['errors']) && isset($_SESSION['errors']['password'])) {
            echo "<script>document.getElementById('chooseLoginMethod').classList.add('hidden'); document.getElementById('formDiv').classList.remove('hidden');</script>";
            echo '<div class="text-red-500 text-xs" >' . $_SESSION['errors']['password'] . '</div>';
            unset($_SESSION['errors']['password']);
        }
        ?>
    </div>

    <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Potvrď Heslo" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500" required>
  



    <div id="errors" >
   <?php
    if (isset($_SESSION['errors']) && isset($_SESSION['errors']['confirmPassword'])) {
        echo "<script>document.getElementById('chooseLoginMethod').classList.add('hidden'); document.getElementById('formDiv').classList.remove('hidden');</script>";
        echo '<div class="text-red-500 text-xs">' . $_SESSION['errors']['confirmPassword'] . '</div>';
        unset($_SESSION['errors']['confirmPassword']);
    }
    if (isset($_SESSION['errors']) && isset($_SESSION['errors']['userexists'])) {
        echo "<script>document.getElementById('chooseLoginMethod').classList.add('hidden'); document.getElementById('formDiv').classList.remove('hidden');</script>";
        echo '<div class="text-red-500 text-xs">' . $_SESSION['errors']['userexists'] . '</div>';
        unset($_SESSION['errors']['userexists']);
    }

    ?>
    </div>

    <div class="flex space-x-4">
        <input type="submit" name="submit" id="submitPwdBtn" value="Zaregistrovat" class="px-4 py-2 bg-blue-500 text-white rounded-md cursor-pointer hover:bg-blue-600 transition duration-300 w-[120px] opacity-30 pointer-events-none">
        <input type="button" id='backButton' value="Zpět" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md cursor-pointer hover:bg-gray-400 transition duration-300 w-[120px]">
    </div>
  


</form>


                <img class='flex mt-4 h-auto  min-h-[60px] w-full' src="./public/lide.svg" alt="lide" />
   
                </div>
    </div>
    </div>
    <?php if (isset($errorMessage)): ?>
    <?= $errorMessage ?>
<?php endif; ?>

    <script>

        const chooseLoginMethod = document.getElementById('chooseLoginMethod');
        const formDiv = document.getElementById('formDiv');
        const emailDiv = document.getElementById('emailDiv');            
        const backButton = document.getElementById('backButton');
        const errors = document.querySelectorAll('#errors');
        const email = document.getElementById('email');

        emailDiv.addEventListener('click',function(){
            chooseLoginMethod.classList.add('hidden');
            formDiv.classList.remove('hidden');
            errors.forEach(function(error) {
                    error.classList.add('hidden');
                });
        })


        backButton.addEventListener('click',function(){
            console.log('zpet');
            email.value = '' ;   
            errors.forEach(function(error) {
                    error.classList.add('hidden');
                });
            console.log(errors);
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