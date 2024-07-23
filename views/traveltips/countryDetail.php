<?php
    require_once './constants/constants.php';

    $countryName = $countryParam;
    $countryDetails = null;
foreach ($countriesData as $country) {
    if ($country['name'] === $countryName) {
        $countryDetails = $country;
        break; // Stop the loop once the country is found
    }
}

?>

<div class='dark:text-lighTextColor  py-2 md:py-4 w-full'>
<?php if ($countryDetails !== null): ?>
        <div>

        <div class='flex justify-around items-center '>
          <div class=' text-2xl font-extrabold'><?= $countryParam ?></div>
          <div> <img src=<?=$countryDetails['flag'] ?> class='w-[50px] h-auto' alt="" /></div>
        </div>
        <div class='flex flex-col md:flex-row pt-4 '>

        <div class='flex md:flex-1 flex-col justify-center items-center'>
             <div class='flex justify-between w-full md:w-1/2 px-4'>
                <div>Kontinent </div>
                <div><?=$countryDetails['continent'] ?></div>
             </div>
             <div class='flex justify-between w-full md:w-1/2 px-4'>
                <div>Hlavní město </div>
                <div><?= $countryDetails['capital']?></div>
             </div>
   
  
          </div>
          
          <div class='flex md:flex-1 flex-col justify-center items-center '>
            <div class='flex justify-between w-full md:w-1/2 px-4'>
              <div>Počet obyvatel</div>
              <div><?=$countryDetails['population'] ?></div>
            </div>
            <div class='flex justify-between w-full md:w-1/2 px-4'>
              <div>Rozloha</div>
              <div><?= $countryDetails['area']?></div>
           </div>
           <div class='flex justify-between w-full md:w-1/2 px-4'>
              <div>jazyk</div>
              <div><?=$countryDetails['language'] ?></div>
            </div>
           <div class='flex justify-between w-full md:w-1/2 px-4'>
              <div>Měna</div>
              <div><?= $countryDetails['currency']?></div>
            </div>
          </div>


      
        </div>
        </div>
        <?php else: ?>
        <div>Country details not found.</div>
    <?php endif; ?>

</div>