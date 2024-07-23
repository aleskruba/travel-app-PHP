<?php
    $user = false;
    $visible = true;
   // $baseUri = '/travel/';
    //$uri = parse_url($_SERVER['REQUEST_URI'])["path"];

?>

<nav  class="top-0 z-10 flex justify-between gap-4 items-center dark:bg-darkBackground  dark:text-navbarTextColor py-4 px-4 md:px-8 poppins-medium">
    
<a href="<?=  getUrl('') ?>" class="flex items-center">
<span class="text-lightAccent text-2xl poppins-extrabold-italic cursor-pointer" style="-webkit-text-stroke: 0.1px pink;">
Rady na cesty</span>
</a>


<div class="hidden md:flex space-x-2">
    <a href="<?= getUrl('traveltips') ?>" class="<?= urlIs('/travel/traveltips') ? 'bg-lightAccent text-darkBackground' : 'darK:text-white';?>  hover:bg-lightAccent hover:text-darkBackground  hover:transition duration-100 cursor-pointer border dark:border-white px-3 py-1 rounded-lg">TravelTips</a>
    <a href="<?= getUrl('spolucesty') ?>" class="<?= urlIs('/travel/spolucesty') ? 'bg-lightAccent text-darkBackground' : 'darK:text-white';?>  hover:bg-lightAccent hover:text-darkBackground hover:transition duration-100 cursor-pointer border dark:border-white px-3 py-1 rounded-lg">Spolucesty</a>
</div>

    <div class="flex items-center space-x-2">

    <?php if (!isset($_SESSION['user'])): ?>
    <a class="hidden md:block dark:text-white bg-transparent border cursor-pointer hover:bg-lightAccent hover:text-darkBackground hover:transition duration-100 border-white px-3 py-1 rounded-lg" 
    href="<?= getUrl('signup')  ?>">Registrace</a>
    <a class="hidden md:block dark:text-white bg-transparent border cursor-pointer hover:bg-lightAccent hover:text-darkBackground hover:transition duration-100 border-white px-3 py-1 rounded-lg" 
    href="<?= getUrl('login') ?>">Přihlásit</a>
<?php else: ?>
    <a href="<?= getUrl('profile')  ?>" 
        class="hidden md:flex md:justify-between md:text-base min-w-[100px] text-center dark:text-white bg-transparent border cursor-pointer hover:bg-lightAccent hover:text-darkBackground hover:transition duration-100 dark:border-white px-3 py-1 rounded-lg">Profil
        <div class='w-6 h-6'>
       <?php  echo isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : ''; ?> 
<!--             <img src="" alt="profile" class='w-full h-full rounded-full object-cover' />
 -->        </div>
    </a>
    <a href="<?= getUrl('logout') ?>" class="hidden md:block dark:text-white bg-transparent border cursor-pointer hover:bg-lightAccent hover:text-darkBackground hover:transition duration-100 dark:border-white px-3 py-1 rounded-lg">
    Odhlásit
</a>
<?php endif; ?>

<div class="flex gap-2 w-[30px]">
<i id='sun'  class="fa fa-sun cursor-pointer hover:text-sky600 "></i>
<i id='moon' class="fa fa-moon cursor-pointer hover:text-sky600 "></i>
</div>
</div>



<div class="<?php echo $visible ? 'md:hidden z-30 fixed bg-darkAccent bottom-1 border rounded-lg shadow-lg left-1/2 transform -translate-x-1/2 w-[95%] md:w-[50%]' : 'fixed bg-darkAccent bottom-1 border rounded-lg shadow-lg left-1/2 transform -translate-x-1/2 w-[95%] md:w-[60%]'; ?>">
    <div class="flex justify-between w-full px-2 py-4 text-white text-xs">
        <div class="flex gap-2 md:gap-6">
            <a href="<?= getUrl('traveltips') ?>" class="hover:bg-lightAccent hover:text-darkBackground hover:transition duration-100 cursor-pointer border border-white px-1 py-1 rounded-lg">TravelTips</a>
            <a href="<?= getUrl('spolucesty') ?>" class="hover:bg-lightAccent hover:text-darkBackground hover:transition duration-100 cursor-pointer border border-white px-1 py-1 rounded-lg">Spolucesty</a>
        </div>
        <?php if (isset($user)): ?>
            <div class="flex ml-4 gap-2 md:gap-6">
                <a href="<?= getUrl('signup')?>"  class="hover:bg-lightAccent hover:text-darkBackground hover:transition duration-100 cursor-pointer border border-white px-1 py-1 rounded-lg"  >Registrace</a>
                <a href="<?= getUrl('login') ?>" class="hover:bg-lightAccent hover:text-darkBackground hover:transition duration-100 cursor-pointer border border-white px-1 py-1 rounded-lg" >Přihlásit</a>
   
        <?php else: ?>
            <div class="flex ml-4 gap-2 md:gap-6">
                <a href="<?= getUrl('profile')?>" class="hover:bg-lightAccent min-w-[60px] text-center hover:text-darkBackground hover:transition duration-100 cursor-pointer border border-white px-1 py-1 rounded-lg">Profil</a>
                <div class="hover:bg-lightAccent hover:text-darkBackground hover:transition duration-100 cursor-pointer border border-white px-1 py-1 rounded-lg" onclick="<?php echo htmlspecialchars($logOutFunction); ?>">Odhlásit</div>
            </div>
        <?php endif; ?>
    </div>
</div>


</nav>
<script>
        let theme = localStorage.getItem('theme') || 'light'; // Retrieve the theme preference from localStorage

        // Function to set the theme based on the current value of 'theme'
        const setTheme = (theme) => {
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        };

        // Call setTheme function initially
        setTheme(theme);

        const sun = document.getElementById('sun');
        const moon = document.getElementById('moon');

        // Event listener for sun (light mode) click
        sun.addEventListener('click', function () {
            localStorage.setItem('theme', 'light'); // Store 'light' theme in localStorage
            setTheme('light'); // Set theme to light
        });

        // Event listener for moon (dark mode) click
        moon.addEventListener('click', function () {
            localStorage.setItem('theme', 'dark'); // Store 'dark' theme in localStorage
            setTheme('dark'); // Set theme to dark
        });
    </script>
