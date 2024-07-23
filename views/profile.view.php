<?php
    require_once 'partials/header.php';
    require_once './env/cloudinary.inc.php';
  
    use Models\User;
    use Core\App;
    use Core\Database;
    
    $db = App::resolve(Database::class);

    $user = new User($db);

    $userId = isset($_SESSION["user"]) ? $_SESSION["user"]['id'] : null;

    $user = $user->finduser($userId);

    if ($user) {
      $userId = $user->id;
      $username = $user->username;
      $firstName = $user->firstName;
      $lastName = $user->lastName;
      $email = $user->email;
      $googleEmail = $user->googleEmail;
  } else {
      $username = '';
      $firstName = '';
      $lastName = '';
      $email = '';
      $googleEmail = '';
  }


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

<body>
<body class="dark:bg-darkBackground dark:text-lightBackground light:text-darkBackground   light:bg-lightBackground ">
<?php
    require 'partials/navbar.php';
?>

<div class="flex flex-col gap-4 justify-center items-center pt-8 pb-8">

<a href="<?= getUrl('tvojespolucesty')  ?>" 
   class="flex justify-center flex-col items-center cursor-pointer bg-gray-100 dark:bg-gray-700 dark:text-gray-100 p-6 rounded-lg shadow-md w-96">
Moje spolucesty
</a>

<div class="flex justify-center flex-col items-center bg-gray-100 dark:bg-gray-700 dark:text-gray-100 p-6 rounded-lg shadow-md w-96">
  <label for="photo" class="text-lg font-semibold mb-2">Foto</label>
  <div class="mt-2 flex items-center gap-x-3 w-full justify-center">
    <div class="w-16 h-16">
    <img id="profileImage" 
             src="<?= isset($_SESSION['user'])  && !empty(htmlspecialchars($_SESSION['user']['image'])) ? htmlspecialchars($_SESSION['user']['image']) : getUrl('public/profile.jpg') ?>" 
             alt="Profile" 
             class="w-full h-full rounded-full object-cover text-gray-300 cursor-pointer" 
             data-user-image="<?php echo $_SESSION['user']['image'] ?>"
        />
    </div>
    <label for="imageInput" class="cursor-pointer">
      <span class="relative">
        <form id="imageForm" method="POST" enctype="multipart/form-data">
          <input type="file" id="imageInput" name="imageInput" accept="image/jpeg, image/jpg, image/png" class="hidden">
          <label for="imageInput" class="bg-gray-200 dark:bg-gray-600 dark:text-white hover:bg-gray-300 dark:hover:bg-gray-500 py-2 px-4 rounded-md cursor-pointer">
            Vyber novou fotku
          </label>
        </form>
      </span>
    </label>
  </div>
</div>
<!-- <div id="imageDialog" class="dialog" >
    <div class="dialog-content ">
        <span id="closeDialog" class="close">&times;</span>
        <img id="dialogImage" src="" alt="Profile" class="dialog-image" />
    </div>
</div> -->
<script>
  const imageInput = document.getElementById('imageInput');
  const profileImage = document.getElementById('profileImage');

  imageInput.addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
      // Check if the file type is valid
      if (!isValidFileType(file)) {
        alert('Prosím pouze  soubory JPG, JPEG, or PNG');
        return; // Stop further execution
      }

      const reader = new FileReader();
      reader.onload = function(e) {
        profileImage.src = e.target.result;
        profileImage.setAttribute('data-user-image', e.target.result);
      }
      reader.readAsDataURL(file);

      // Create FormData object to send the file
      const formData = new FormData();
      formData.append('imageInput', file);

      // Perform AJAX request to the server
      fetch('<?= getUrl('upload') ?>', {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        if (data.status === 'success') {
          console.log('Image uploaded successfully:', data.imageUrl);
    
        } else {
          console.error('Error:', data.message);
        }
      })
      .catch(error => console.error('Error:', error));
    }
  });

  function isValidFileType(file) {
    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
    return allowedTypes.includes(file.type);
  }
</script>


  <div class="bg-gray-100 dark:bg-gray-500 dark:text-gray-100 p-6 rounded-lg shadow-md w-96">
    <div id="profile" class="block">
      <div class="mb-2">Username: <?= $username ?></div>
      <div class="mb-2">Jméno: <?= $firstName ?></div>
      <div class="mb-2">Příjmění: <?= $lastName ?></div>
      <div class="mb-2">Email: <?= $googleEmail ? $googleEmail :$email  ?></div>
      <div class="flex justify-center" id="profileBtn">
        <button onclick="changeFunction()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Upravit</button>
      </div>
    </div>
    <div id="profileInput" class="hidden">
   
    <form class="space-y-4 dark:bg-gray-500 dark:text-gray-100 relative" method="post" action="<?= getUrl('updateprofile') ?>">

<input type="hidden" name="_method" value="PATCH"/>
<input type="hidden" name="id" value="<?= $userId ?>" />


    <input type="text" 
           placeholder="Username" 
           name="username" 
           id="username"
           class="w-full border rounded-md p-2 text-black"
           value="<?= isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : $username ?>"
           maxlength="20" />
           <?php if (isset($_SESSION['errors']['username'])) : ?>
            <div class="text-red-500 dark:text-red-200" id="profileErrors"><?php echo htmlspecialchars($_SESSION['errors']['username']); ?></div>
        <?php endif; ?>

    <input type="text" 
           placeholder="Jméno" 
           name="firstName" 
           id="firstName"
           class="w-full border rounded-md p-2 text-black" 
           value="<?= isset($_SESSION['firstName']) ? htmlspecialchars($_SESSION['firstName']) : $firstName ?>"
           maxlength="20" />

           <?php if (isset($_SESSION['errors']['firstName'])) : ?>
            <div class="text-red-500 dark:text-red-200" id="profileErrors"><?php echo htmlspecialchars($_SESSION['errors']['firstName']); ?></div>
        <?php endif; ?>

    <input type="text" 
           placeholder="Příjmení"
           name="lastName" 
           id="lastName"
           class="w-full border rounded-md p-2 text-black" 
           value="<?= isset($_SESSION['lastName']) ? htmlspecialchars($_SESSION['lastName']) : $lastName ?>"
           maxlength="20" />
           <?php if (isset($_SESSION['errors']['lastName'])) : ?>
            <div class="text-red-500 dark:text-red-300" id="profileErrors"><?php echo htmlspecialchars($_SESSION['errors']['lastName']); ?>
            <script> const usernameValue =  <?php echo htmlspecialchars($_SESSION['errors']['lastName']); ?>; </script></div>
        <?php endif; ?>

        <input type="email" 
            placeholder="Email" 
            name="email" 
            id="email"
            class="w-full border rounded-md p-2 <?= $googleEmail == '' ? 'text-black ' : 'pointer-events-none bg-gray-500 text-white' ?>" 
            value="<?= isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : $email ?>"
            maxlength="20" />
           <?php if (isset($_SESSION['errors']['email'])) : ?>
            <div class="text-red-500 dark:text-red-300" id="profileErrors"><?php echo htmlspecialchars($_SESSION['errors']['email']); ?></div>
           <?php unset($_SESSION['errors']['email']); ?>
            <?php endif; ?>

            <div class="flex justify-center space-x-4" >
            <button type="submit" id="submitBtn" class='bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded opacity-30 pointer-events-none'>Uložit</button>
            <button type="button" onclick="backFunction()" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Zpět</button>
          </div>
      </form>
      <?php if (isset( $errorMessage)): ?>
        <?= $errorMessage ?>
     <?php endif; ?>

    </div>
  </div>


  <div class="bg-gray-100 dark:bg-gray-500 dark:text-gray-100 p-6 rounded-lg shadow-md w-96 ">
  <?= $googleEmail == '' ? '
    <div id="passwordDiv" class="block">
           <h1>Heslo</h1>
      <div class="flex justify-center" id="passwordBtn">
        <button onclick="changePasswordFunction()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Změnit</button>
      </div>
      ' : ' <h1> příhlašen s Google účtem </h1>' ?>
    </div>
    <div id="passwordInput" class="hidden">
      <form class="space-y-4 dark:bg-gray-500 dark:text-gray-100 relative" method="post" action="<?= getUrl('updatepassword') ?>">

          <input type="hidden" name="_method" value="PATCH"/>
          <input type="hidden" name="id" value="<?= $userId ?>" />


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
          <button type="button" onclick="backPasswordFunction()" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Zpět</button>
        </div>
      </form>
    </div>
  </div>






<?php
    $errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : null;
    $pwderrors = isset($_SESSION['pwderrors']) ? $_SESSION['pwderrors'] : null;
?>




<script>

  const profile = document.getElementById('profile');
  const profileInput = document.getElementById('profileInput');
  const profileBtn = document.getElementById('profileBtn');
  const passwordBtn = document.getElementById('passwordBtn');
  const passwordDiv = document.getElementById('passwordDiv');
  const passwordInput = document.getElementById('passwordInput');
  const submitBtn = document.getElementById('submitBtn');
  const submitPwdBtn = document.getElementById('submitPwdBtn');

  const originalValues = {
            username: document.getElementById('username').value,
            firstName: document.getElementById('firstName').value,
            lastName: document.getElementById('lastName').value,
            email: document.getElementById('email').value
        };

        function compareValues() {
            const currentValues = {
                username: document.getElementById('username').value,
                firstName: document.getElementById('firstName').value,
                lastName: document.getElementById('lastName').value,
                email: document.getElementById('email').value
            };

            let isDifferent = false;

            for (const key in originalValues) {
                if (originalValues[key] !== currentValues[key]) {
                    isDifferent = true;
                    break;
                }
            }

            if (isDifferent) {
              submitBtn.classList.remove('opacity-30', 'pointer-events-none')
            } else {
              submitBtn.classList.add('opacity-30' ,'pointer-events-none')
            }
        }

        // Add event listeners to each input field to trigger compareValues on input
        document.getElementById('username').addEventListener('input', compareValues);
        document.getElementById('firstName').addEventListener('input', compareValues);
        document.getElementById('lastName').addEventListener('input', compareValues);
        document.getElementById('email').addEventListener('input', compareValues);


  var errors = <?php echo json_encode($errors); ?>;
  var pwderrors = <?php echo json_encode($pwderrors); ?>;

  
        if (errors) {
            document.getElementById('profile').classList.add('hidden');
            document.getElementById('profileInput').classList.remove('hidden');
            document.getElementById('passwordBtn').classList.add('hidden');
        }

     if (pwderrors) {
            document.getElementById('passwordDiv').classList.add('hidden');
            document.getElementById('passwordInput').classList.remove('hidden');
            document.getElementById('profileBtn').classList.add('hidden');
         
        }  

   const username = document.getElementById('username'); 
   const firstName = document.getElementById('firstName')
   const lastName = document.getElementById('lastName'); 
   const email = document.getElementById('email')

  const changeFunction = () => {
    <?php    unset($_SESSION['username']);  unset($_SESSION['errors']) ?>
    profile.classList.add('hidden');
    profileInput.classList.remove('hidden');
    passwordBtn.classList.add('hidden');
    submitBtn.classList.add('opacity-30', 'pointer-events-none')
  }

  const profileErrors = document.querySelectorAll('#profileErrors')
  
  const backFunction = () => {
    profile.classList.remove('hidden');
    profileInput.classList.add('hidden');
    passwordBtn.classList.remove('hidden');
    profileErrors.forEach(error => error.classList.add('hidden'));

   document.getElementById('username').value = "<?= $username ?>";
   document.getElementById('firstName').value = "<?= $firstName ?>";
   document.getElementById('lastName').value = "<?= $lastName ?>";
   document.getElementById('email').value = "<?= $email ?>";
  }

  const changePasswordFunction = () => {
    <?php    unset($_SESSION['pwderrors']) ?>
    passwordDiv.classList.add('hidden');
    passwordInput.classList.remove('hidden');
    profile.classList.remove('hidden');
    profileInput.classList.add('hidden');
    profileBtn.classList.add('hidden');
  }

  const backPasswordFunction = () => {
    passwordDiv.classList.remove('hidden');
    passwordInput.classList.add('hidden');
    profileBtn.classList.remove('hidden');
    profileErrors.forEach(error => error.classList.add('hidden'));
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


// update image
/* 
        const imageInput = document.getElementById('imageInput');
        const profileImage = document.getElementById('profileImage');

        imageInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    profileImage.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });


        

    var input = document.getElementById('imageInput');
    input.type = 'file';
    input.accept = 'image/jpeg, image/jpg, image/png';
    input.onchange = function(event) {
        var file = event.target.files[0];
        if (!file) return; // No file selected
        var extension = file.name.split('.').pop().toLowerCase();
        if (['jpg', 'jpeg', 'png'].indexOf(extension) === -1) {
            alert('Please select a JPG, JPEG, or PNG file.');
            return;
        }
        
        var reader = new FileReader();
        reader.onload = function() {
            document.querySelector('#profileImage').src = reader.result;
        }
        reader.readAsDataURL(file);
        
        // Create FormData object to send the file
        var formData = new FormData();
        formData.append('file', file);
        formData.append('upload_preset', 'schoolapp'); // Replace 'your_upload_preset' with your Cloudinary upload preset

        // Perform fetch request to Cloudinary upload API
        fetch('https://api.cloudinary.com/v1_1/<?php echo CLOUDINARY_CLOUD_NAME ?>/image/upload', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log('Uploaded image URL:', data.secure_url); // Log the URL of the uploaded image
            
    
            fetch('./controllers/auth/updateImage.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ data: data.secure_url })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json(); // Parse JSON response
            })
            .then(data => {
                // Handle the response data here
                console.log(data); // Log the response data to console
            })
            .catch(error => {
                console.error('Error:', error);
            });


        })
        .catch(error => console.error('Error:', error));
    };
    input.click();
 */
   
</script>



</body>
</html>