<?php


    require 'partials/header.php';
    
  //  $baseUri = '/travel/';
  //   $uri = parse_url($_SERVER['REQUEST_URI'])["path"];

    include '../travel/controllers/messages/create.php';

   // var_dump(__DIR__.'/traveltips/traveltips.view.php');
// echo isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : ''; 

$months = ['leden', 'únor', 'březen', 'duben', 'květen', 'červen', 'červenec', 'srpen', 'září', 'říjen', 'listopad', 'prosinec'];


?>

<?php
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



<body class="dark:bg-darkBackground dark:text-lightBackground light:text-darkBackground light:bg-lightBackground">

    <?php require 'partials/navbar.php'; ?>

    <div class="flex flex-col items-center pt-8">
    <h1 class="text-xl">Tvoje spolucesty</h1>
    <a class='px-2 py-2 mt-4 min-w-[100px] bg-gray-500 text-white hover:bg-gray-400 rounded text-center' 
        href="<?= getUrl('profile')  ?>">Zpět
    </a>

    <div class="flex flex-col md:flex-row flex-wrap items-center justify-center pb-16 gap-2 md:pt-6 pt-2">

        <?php foreach ($yourTours as $tour): ?>
            <div class='dark:text-white flex flex-col md:items-center border border-white w-[380px] h-[380px] md:text-base text-sm relative'>
                <div class='flex flex-col md:items-center'>
                    <div class='dark:bg-gray-800 rounded-lg p-6 shadow-lg'>
                        <div class='mb-4'>
                            <div class='flex flex-col items-center text-xl font-semibold'> 
                                <h3 class='text-xl font-semibold'>Destinace: <?php echo htmlspecialchars($tour['destination']); ?></h3>
                            </div>
                            <div class='flex flex-col md:flex-row md:space-x-10 pt-2 md:pt-8'>
                                <div class='min-w-[100px] font-extrabold'>Vloženo dne:</div> 
                                <div class='text-xs'><?php echo htmlspecialchars($tour['date']); ?></div>
                            </div>
                            <div class='flex flex-col md:flex-row md:space-x-10 pt-2'>
                            <div class='min-w-[100px] font-extrabold'>Termín do:</div> 
                            <div>
                                <?php
                                $tourDate = htmlspecialchars($tour['tourdate']);
                                $tourDateEnd = htmlspecialchars($tour['tourdateEnd']);
                                
                                // Extract month number from the tour date
                                $monthNumberStart = date('n', strtotime($tourDate));
                                $monthNumberEnd = date('n', strtotime($tourDateEnd));
                                
                                // Display the Czech month name from the $months array
                                $tourMonthStart = $months[$monthNumberStart - 1]; // Adjust month number to array index
                                $tourMonthEnd = $months[$monthNumberEnd - 1]; // Adjust month number to array index
                                
                                // Get the year
                                $yearEnd = date('Y', strtotime($tourDateEnd));
                                
                                if ($tourMonthStart===$tourMonthEnd) {
                                    echo "{$tourMonthEnd} {$yearEnd}";
                                } else {
                                echo "{$tourMonthStart}  - {$tourMonthEnd} {$yearEnd}";
                                }
                               ?>
                            </div>
                        </div>


                            <?php
                                $tourTypes = $tour['tourtype'];
                                $displayTourTypes = array_slice($tourTypes, 0, 2); // Get the first two tour types
                                $remainingCount = count($tourTypes) - count($displayTourTypes);
                                ?>
                                <div class='flex flex-col md:flex-row md:space-x-10 pt-2'>
                                    <div class='min-w-[100px] font-extrabold'>Typ cesty:</div> 
                                    <div class="flex flex-wrap">
                                        <?php echo htmlspecialchars(implode(', ', $displayTourTypes)); ?>
                                        <?php if ($remainingCount > 0): ?>...<?php endif; ?>
                                    </div>
                                </div>
                            <div class='flex flex-col md:flex-row md:space-x-10 pt-2'>
                                <div class='min-w-[100px] font-extrabold'>Hledám:</div> 
                                <div class='text-justify break-all text-xs'>
                                    <?php 
                                       $fellowtraveler = htmlspecialchars($tour['fellowtraveler']);
                                       echo mb_strlen($fellowtraveler) > 30 ? mb_substr($fellowtraveler, 0, 30) . '...' : $fellowtraveler; ?>
                                
                                </div>
                            </div>
                            <div class='flex flex-col md:flex-row md:space-x-10 pt-2'>
                                <div class='min-w-[100px] font-extrabold'>O mně:</div> 
                                <div class='text-justify break-all text-xs'>
                                <?php
                                    $aboutMe = htmlspecialchars($tour['aboutme']);
                                    echo mb_strlen($aboutMe) > 30 ? mb_substr($aboutMe, 0, 30) . '...' : $aboutMe;
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='flex justify-center items-center space-x-4 w-full mt-2 mb-2 absolute bottom-2'>
                        
                        <div>
                            <form action="<?= getUrl('spolucesta/deletetour') ?>" method="post" onsubmit="return confirmDelete()"> 

                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="id" value="<?= $tour['id'] ?>">
                                
                                <button class='px-2 py-2 min-w-[100px] bg-red-500 text-white hover:bg-red-400 rounded text-center' 
                                        id="deleteTourBtn"
                                        type="submit">
                                    Smaž tour
                                </button>
                            </form>
                        </div>

                        <script>
                            function confirmDelete() {
                                return confirm('Chcete opravdu smazat spolucestu?');
                            }
                            </script>

                        <div>
                             <a class='px-2 py-2 min-w-[100px] bg-green-500 text-white hover:bg-green-400 rounded text-center' 
                                href="<?= getUrl("spolucesta/edittour/".$tour['id']) ?>">
                               Aktualizovat
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        <?php endforeach; ?>
    </div>

 
    </div>
</body>
<?php require 'partials/footer.php'; ?>
</html>