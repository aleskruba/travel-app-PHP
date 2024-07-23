<?php


    require 'partials/header.php';
    
  //  $baseUri = '/travel/';
  //   $uri = parse_url($_SERVER['REQUEST_URI'])["path"];

    include '../travel/controllers/messages/create.php';

   // var_dump(__DIR__.'/traveltips/traveltips.view.php');
// echo isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : ''; 



?>



<body class="dark:bg-darkBackground dark:text-lightBackground light:text-darkBackground   light:bg-lightBackground">
<?php
    require 'partials/navbar.php';
    

?>
 <div class="flex flex-col md:flex-row pb-16">


      <div class="w-full h-[90%] md:w-[250px] md:bg-transparent md:border-r md:border-gray-300 md:rounded   pt-4 flex items-center flex-col">

        <div class="w-full px-1">
           <div class="mb-4 ">
            <?php require 'traveltips/comboBox.php' ?>
            
          </div >
          <div class="md:block hidden">
         <?php require 'traveltips/countries.php' 
         
         ?>
         </div>
        </div>
      </div>
  
      <div class="flex-1 ">

      <?php
          

      ?>
        <div class="flex flex-col justify-center py-4 dark:text-white px-2">
        <?php if (!$emptyParam) {

          require "../travel/views/traveltips/countryDetail.php";
  
            require "../travel/views/traveltips/createMessage.php";


          

          require "../travel/views/traveltips/messages.php";
          
        } 

        else 
        
        {echo "Vyber zemi ";} ?>


        </div>

      </div>
</div>



<?php
    require 'partials/footer.php';
?>

</body>
</html>