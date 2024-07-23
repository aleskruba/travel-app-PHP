<?php

    require 'partials/header.php';
?>
<body>
<?php
    require 'partials/navbar.php';

?>

<?php
      if (isset($_GET['message']) && $_GET['message'] === 'success') {
   
  
        echo "<script>
          setTimeout(()=>{
            Toastify({
              text: 'Spolucesta úspěšně uložena',
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
    
    if (isset($_GET['message']) && $_GET['message'] === 'error') {
       
      
      echo "<script>
      setTimeout(()=>{
        Toastify({
          text: 'Spolucesta nebyla uložena',
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

<div class="flex flex-col justify-center items-center px-2 py:2 md:px-6 md:py-6 dark:bg-darkBackground dark:text-lightBackground light:text-darkBackground   light:bg-lightBackground ">

<div class="flex flex-col justify-center items-center pb-4">

    <div>Přidat novou spolucestu <a href="<?=  getUrl('spolucesta') ?>" class="text-blue-500 underline">zde</a></div>
</div>

<?php
    require 'spolucesty/seachbar.php';
 
?>

<div class='pb-4 tour-listings flex flex-wrap items-center justify-center px-4 gap-2 dark:bg-darkBackground dark:text-lightBackground light:text-darkBackground light:bg-lightBackground'>

 <?php
    require 'spolucesty/tours.php';
 
?> 


<div class="pt-4 pb-4">
<?php
    if (count($tours)===0) {
        echo "<p class='text-xl '>žádný výsledek hledání</p>";
    }
?>
</div>

</div>



 
</div>
</body>

<?php
    require 'partials/footer.php';
?>


</html>