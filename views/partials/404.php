<?php
    require 'header.php';
?>


<body>
<?php
    require 'navbar.php';
?>


<div class="flex h-full flex-col justify-center items-center space-y-6 dark:bg-darkBackground dark:text-lighTextColor px-2 py:2 md:px-6 md:py-6 ">

    <h1 class="text-3xl">Stránka nenalezena</h1>

        <div class="flex justify-center">
        <img src="../../../public/emoji.png" class="w-[60%]" alt="404">
        </div>
    <h5>
    <div id="backButton" class="text-blue-300 hover:text-blue-400 underline">Zpět na hlavní stránku</div>
    </h5>
</div>




<?php
    require 'footer.php';
?>
<script>
    const backButton = document.getElementById('backButton');
    backButton.addEventListener('click', function(e) {
       history.back();
    })
</script>
</body>
</html>