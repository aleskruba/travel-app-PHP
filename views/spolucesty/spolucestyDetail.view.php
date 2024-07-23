<?php
    require './views/partials/header.php';
 //   $baseUri = '/travel/';
 //   $uri = parse_url($_SERVER['REQUEST_URI'])["path"];
?>

<body class="dark:bg-darkBackground dark:text-lightBackground light:text-darkBackground light:bg-lightBackground">
<?php
    require './views/partials/navbar.php';
?>

<?php
    $czechMonths = ['leden', 'únor', 'březen', 'duben', 'květen', 'červen', 'červenec', 'srpen', 'září', 'říjen', 'listopad', 'prosinec'];

    // Function to convert date to Czech month and year
    function formatToCzechDate($date, $czechMonths) {
        $timestamp = strtotime($date);
        $month = date('n', $timestamp) - 1; // Month index (0-11)
        $year = date('Y', $timestamp);
        return "{$year} {$czechMonths[$month]}";
    }
    
    // Format the dates
    $tourStart = formatToCzechDate($tour['tour_tourdate'], $czechMonths);
    $tourEnd = formatToCzechDate($tour['tour_tourdateEnd'], $czechMonths);
    

    $tourInsertedDate = date('d.m Y', strtotime($tour['tour_date']));

    ?>


<div class="dark:text-white flex flex-col items-center justify-center ">
    <div class="flex items-center text-2xl font-semibold italic justify-center cursor-pointer hover:dark:text-gray-300 hover:text-gray-500">
        <a href="<?=  getUrl('spolucesty') ?>" class="ml-4">ZPĚT</a>
    </div>

    <div class="flex flex-col items-center justify-center w-full md:px-12 px-1 py-8 ">
        <div class="bg-gray-100 dark:bg-gray-800 rounded-lg min-w-[380px] w-full shadow-lg ">
            <div class="mb-4 px-1 md:text-base px-4">
                <div class="flex gap-4 items-center justify-center md:justify-start md:gap-24 py-4">
                    <div class="w-16 h-16 md:w-20 md:h-20">
                        <img id="profileImage<?= $tour['user_id'] ?>" 
                             src="<?= $tour['user_image'] ?>" 
                             alt="Profile" 
                             class="w-full h-full object-cover rounded-full cursor-pointer" 
                             data-user-image="<?= $tour['user_image']; ?>" 
                        />
                    </div>
                    <div>
                        <h3 class="flex flex-col items-center justify-center text-xl md:text-2xl font-semibold"><?= $tour['user_firstName'] ?></h3>
                    </div>
                </div>
                
                <div class="flex justify-between md:justify-start md:flex-row md:space-x-10 pt-2">
                    <div class="w-[130px] font-bold">Destinace:</div>
                    <div class="tracking-wide"><?= $tour['tour_destination'] ?></div>
                </div>
                <div class="flex justify-between md:justify-start md:flex-row md:space-x-10 pt-2">
                    <div class="w-[130px] font-bold">Vloženo dne:</div>
                    <div class="tracking-wide"><?= $tourInsertedDate ?></div>
                </div>
                <div class="flex justify-between md:justify-start md:flex-row md:space-x-10 pt-2">
             
                    <div class="w-[130px] font-bold">Termín:</div>
                    <div class="tracking-wide"><?= $tourStart ?> - <?= $tourEnd ?></div>
                </div>
                <div class="flex flex-col md:flex-row justify-start pt-2">
                    <div class="min-w-[100px] font-bold">Typ cesty:</div>
                    <div class="flex flex-col items-end md:items-start w-full md:pl-16">
                        <ul class="list-disc list-inside space-y-2 rounded-lg shadow-lg px-2 py-1 border dark:border-gray-600 bg-white dark:bg-gray-700">
                            <?php
                 
                            $tourTypes = $tour['tour_tourtype'];
                            if (is_array($tourTypes)) {
                                foreach ($tourTypes as $el) {
                                    echo "<li class='text-base font-medium tracking-wide'>$el</li>";
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
                <div class="max-w-[800px]">
                    <div class="flex flex-col md:flex-row md:space-x-10 pt-2 w-full break-words">
                        <div class="min-w-[100px] font-bold">Hledám:</div>
                        <div class="flex text-justify text-base tracking-wide break-all">
                            <?= $tour['tour_fellowtraveler'] ?>
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row md:space-x-10 pt-2 w-full break-words">
                        <div class="min-w-[100px] font-bold">O mně:</div>
                        <div class="flex text-justify text-base font-medium tracking-wide break-all">
                            <?= $tour['tour_aboutme'] ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex justify-center items-center border-t w-full py-4 dark:border-gray-700">
        </div>
    </div>
</div>

<?php
    require 'createMessage.php';
 
 ?> 

<?php
    require 'tourMessages.php';
 
 ?> 
 

<?php
     require './views/partials/footer.php';
?>

</body>
</html>
