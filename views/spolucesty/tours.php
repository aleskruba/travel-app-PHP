<?php
$uri = parse_url($_SERVER['REQUEST_URI'])["path"];    
?>


<?php foreach ($tours as $tour): ?>

     <a 
        href="<?= htmlspecialchars($uri) ?>/<?= urlencode($tour['id']) ?>"
        class="relative mt-4 rounded overflow-hidden shadow-lg bg-gray-200 dark:bg-gray-600 dark:text-gray-200 py-1 px-1 w-[300px] h-[270px] px-4 cursor-pointer"
    >
       
    <div class='flex items-center space-x-6 '>
          
        
        <div class='w-16 h-16'>
        <img 
             src="<?php echo $tour['user_image'] ?>" 
             alt="Profile" class="w-full h-full object-cover rounded-full cursor-pointer" 
             />

    </div>

        <div class="flex flex-col ">
              <div class="font-bold text-lg dark:text-white"><?= $tour['destination'] ?></div>


            <div>
                <h4 class='text-base font-thin dark:text-white'><?= $tour['user_firstName']  ?></h4>
            </div>
       </div>

    </div>
    <div>
    <div class='flex flex-col justify-end items-end leading-none mb-2'>
    <?php

            $tourStart = date('F', strtotime($tour['tourdate']));
            $tourEnd = date('F', strtotime($tour['tourdateEnd']));


            $czechMonths = ['leden', 'únor', 'březen', 'duben', 'květen', 'červen', 'červenec', 'srpen', 'září', 'říjen', 'listopad', 'prosinec'];

         //   echo date('n', strtotime($tour['tourdate'])) ;
            $tourStartCzech = $czechMonths[date('n', strtotime($tour['tourdate'])) - 1];
            $tourEndCzech = $czechMonths[date('n', strtotime($tour['tourdateEnd'])) - 1];

            if ($tourStartCzech !== $tourEndCzech) {
                echo "<div class='text-sm'>{$tourStartCzech} až {$tourEndCzech}</div>";
            } else {
                echo "<div class='text-sm'>{$tourEndCzech}</div>";
            }
            ?>

        
    </div>
    <div class="text-base italic flex flex-wrap">
        <?php
        // PHP equivalent of iterating over tourtype array
        $tourTypes = $tour['tourtype'];
        if (is_array($tourTypes)) {
            $count = count($tourTypes);
            foreach ($tourTypes as $index => $el) {
                echo "<div class='text-xs '>{$el}" . ($index < 1 && $count > 2 ? ',' : '...') . "</div>";
            }
            // Display '...' if there are more than 2 elements
            if ($count > 2) {
                echo "<div class='text-xs'>...</div>";
            }
        }
        ?>
    </div>
</div>

<div class='mt-2 text-xs'><p>Hledám</p>
    <?php echo strlen($tour['fellowtraveler']) > 55 ? substr($tour['fellowtraveler'], 0, 55) . '...' : $tour['fellowtraveler']; ?>
</div>

<div class='w-[90%] justify-center items-center absolute bottom-5'>
    <div class='px-2 py-2 shadow-lg text-center text-xl font-bold bg-gray-400 hover:bg-gray-500 hover:text-white rounded'>
        detail
    </div>
</div>


    </a>
<?php endforeach; ?>

