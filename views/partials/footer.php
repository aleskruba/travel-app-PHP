<footer class="dark:bg-gray-800 dark:text-gray-300 text-gray-400  pb-20">
    <div class="px-8 flex flex-around border-t border-white py-8">
        <div class="w-full flex justify-center mb-4">
            <div>
                <h3 class="text-lg font-bold mb-4 text-darkAccent">Odkazy</h3>
                <ul id='ulOdkazy'></ul>
            </div>
        </div>

        <div class="w-full flex justify-center mb-4">
            <div>
                <h3 class="text-lg font-bold mb-4 text-darkAccent">Podmínky</h3>
                <ul id='ulPodminky'></ul>
            </div>
        </div>
 
    </div>
</footer>

<script type="text/javascript">
    const footerItems = [
        'O NÁS',
        'BLOG',
        'INSTAGRAM',
        'FACEBOOK',
        'KONTAKT',
        'SPOLUPRÁCE',
        'ČLENSTVÍ'
    ];

    const footerConditions = [
        'Obchodní podmínky',
        'Ochrana osobních údajů',
        'Cookies'
    ];

    const ulOdkazy = document.getElementById('ulOdkazy');
    const ulPodminky = document.getElementById('ulPodminky');

    // Function to create and append list items
    const createAndAppendListItem = (list, items) => {
        items.forEach(item => {
            const li = document.createElement('li'); // Create <li> element
            li.className = "mb-2"; // Set class name
            const a = document.createElement('a'); // Create <a> element
            a.href = "#"; // Set href attribute
            a.classList.add("dark:hover:text-white", "hover:text-gray-800");
            a.textContent = item; // Set text content
            li.appendChild(a); // Append <a> to <li>
            list.appendChild(li); // Append <li> to <ul>
        });
    };

    // Call the function to populate the lists
    createAndAppendListItem(ulOdkazy, footerItems);
    createAndAppendListItem(ulPodminky, footerConditions);
</script>
