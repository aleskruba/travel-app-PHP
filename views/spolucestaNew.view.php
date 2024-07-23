<?php

    require 'partials/header.php';
?>
<body>
<?php
    require 'partials/navbar.php';

?>
<style>
        .dropdown {
            position: absolute;
            width: calc(100% - 32px);
            background: white;
            border: 1px solid #ddd;
            max-height: 200px;
            overflow-y: auto;
            display: none;
            z-index: 1000;
        }
        .dropdown-item {
            padding: 10px;
            cursor: pointer;
        }
        .dropdown-item:hover {
            background: #f0f0f0;
        }
    </style>

    <div class="text-black dark:text-white dark:bg-darkBackground pb-10">
    <div class=" px-4 py-8 >
        <h1 class="text-3xl font-bold text-center mb-8">Jak vytvořit Spolucestu</h1>
        <h2 class="text-xl font-semibold mb-4">1. Začněte Registrací:</h2>
        <p class="mb-4">Pokud jste již zaregistrovaní uživatelé, můžete tento krok přeskočit. Pokud ne, zaregistrujte se na našem webu a vytvořte si účet. Tím se vám umožní spravovat vaše nabídky spolucesty a komunikovat s ostatními uživateli.</p>
        <h2 class="text-xl font-semibold mb-4">2. Přihlaste se:</h2>
        <p class="mb-4">Po registraci nebo pokud už máte účet, přihlaste se pomocí svého uživatelského jména a hesla.</p>
        <h2 class="text-xl font-semibold mb-4">3. Vyplňte Formulář:</h2>
        <p class="mb-4">Po přihlášení klikněte na tlačítko "Vytvořit novou nabídku spolucesty". Vyplňte formulář s následujícími informacemi:</p>
        <ul class="list-disc ml-8 mb-4">
            <li><strong>Destinace:</strong> Kam se chystáte? Uveďte místo, které plánujete navštívit.</li>
            <li><strong>Příbližný termín</strong> Kdy plánujete odjet? Uveďte příbližný termín.</li>
            <li><strong>Typ cesty:</strong> Jaký druh cesty plánujete? Moře, hory, výlety, atd. Zde můžete specifikovat typ vaší dobrodružné plánované cesty.</li>
            <li><strong>Koho hledáte:</strong> Jakého spolucestujícího hledáte? Zadejte požadavky na pohlaví, věk, zájmy, atd.</li>
            <li><strong>Informace o sobě:</strong> Napište krátký popis o sobě. Zahrňte vaše zájmy, preference a vše, co si myslíte, že by měli ostatní uživatelé vědět.</li>
        </ul>
    </div>

    <div class=" px-4 py-8">
        <h1 class="text-3xl font-bold text-center mb-8">Vytvoř spolucestu</h1>
        <div>
            <form method="POST" action="<?= getUrl('spolucesta/createtour') ?>" >
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2" for="destination">Destinace:</label>
                <div class="relative w-full px-2">
                    <input
                        type="text"
                        id="destination"
                        name="destination"
                        placeholder="vyber zemi"
                        class="w-full border rounded px-4 py-2 focus:outline-none text-black font-bold bg-blue-100 focus:bg-white"
                    />
                    <div id="dropdown" class="dropdown text-black"></div>
                </div>
            </div>

            <div class="flex gap-4 items-center mt-4">
                    <label class="block text-sm font-bold" for="date">Začátek cesty:</label>
                    <input
                        type="text"
                        id="date"
                        name="date"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        placeholder="MM/YYYY"
                    />
                    <label class="block text-sm font-bold" for="dateend">do:</label>
                    <input
                        type="text"
                        id="dateend"
                        name="dateend"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        placeholder="MM/YYYY"
                    />
                </div>


                <div class="mb-4 text-sm mt-4">
                <label class="block text-sm font-bold mb-2" for="journey-type">Typ cesty:</label>
                <div class="flex flex-wrap gap-3">
                    <?php foreach ($typeOfTourObjects as $index => $type): ?>
                        <div class="mb-2 flex items-center w-[180px]">
                            <input class="mr-2 hidden" id="journey-type-<?= $index ?>" type="checkbox" value="<?= htmlspecialchars($type->value) ?>" name="journey_type[]">
                            <label for="journey-type-<?= $index ?>" class="relative flex cursor-pointer">
                                <div class="w-6 h-6 border border-gray-300 rounded-md flex items-center justify-center bg-white mr-2">
                                    <!-- Checkbox SVG icon -->
                                    <svg class="w-4 h-4 text-red-900 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="5" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <?= htmlspecialchars($type->label) ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2" for="looking-for">Koho hledáte:</label>
                    <textarea
                        id="looking-for"
                        name="looking_for"
                        rows="5"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:bg-gray-700 dark:text-gray-200 leading-tight focus:outline-none focus:shadow-outline"
                        placeholder="Jakého spolucestujícího hledáte? Zadejte požadavky na pohlaví, věk, zájmy, atd. Omezte se na 500 znaků."
                        maxlength="500"
                        style="resize: none;"
                    ></textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2" for="about-me">Informace o sobě:</label>
                    <textarea
                        id="about-me"
                        name="about_me"
                        rows="5"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:bg-gray-700 dark:text-gray-200 leading-tight focus:outline-none focus:shadow-outline"
                        placeholder="Napište krátký popis o sobě. Zahrňte vaše zájmy, preference a vše, co si myslíte, že by měli ostatní uživatelé vědět. Omezte se na 500 znaků."
                        maxlength="500"
                        style="resize: none;"
                    ></textarea>
                </div>

                <div class="text-lightError pb-4 text-xl"><?= isset($errors) ? htmlspecialchars($errors) : '' ?></div>
                <button
                        id="submit-button"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline opacity-30 pointer-events-none"
                        type="submit"
                    >
                        Odeslat
                    </button>


                <?php if (isset($backendError)): ?>
                    <p class="text-red-500"><?= htmlspecialchars($backendError) ?></p>
                <?php endif; ?>
            </form>
        </div>
    </div>
    </div>

 

    <script>
        document.addEventListener('DOMContentLoaded', function() {
          
            document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const svg = this.nextElementSibling.querySelector('svg');
                    if (this.checked) {
                        svg.classList.remove('hidden');
                    } else {
                        svg.classList.add('hidden');
                    }
                });
            });

            
        });

    </script>

<script>
    // Custom function to normalize characters
    function normalizeCharacters(text) {
        return text
            .replace(/č/g, 'c')
            .replace(/š/g, 's')
            .replace(/ř/g, 'r')
            .replace(/ž/g, 'z');
    }

    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('destination');
        const dropdown = document.getElementById('dropdown');

        input.addEventListener('input', () => {
            const value = normalizeCharacters(input.value.trim().toLowerCase());
            dropdown.innerHTML = '';
            if (value) {
                const filteredCountries = countryNamesObjects.filter(country =>
                    normalizeCharacters(country.label.toLowerCase()).includes(value)
                );
                filteredCountries.forEach(country => {
                    const div = document.createElement('div');
                    div.classList.add('dropdown-item');
                    div.textContent = country.label;
                    div.addEventListener('click', () => {
                        input.value = country.label;
                        dropdown.innerHTML = '';
                        dropdown.style.display = 'none';
                    });
                    dropdown.appendChild(div);
                });
                dropdown.style.display = 'block';
            } else {
                dropdown.style.display = 'none';
            }
        });

        document.addEventListener('click', (e) => {
            if (!input.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.style.display = 'none';
            }
        });
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize flatpickr for start date input
        flatpickr("#date", {
            dateFormat: "Y-m-d", // Show year, month, and day
            mode: "range", // Allow selecting a range of dates
            minDate: "today", // Minimum date is today
            onChange: function(selectedDates, dateStr, instance) {
                // Example callback function
                console.log("Selected start date:", dateStr);
                // Set the value of the hidden input field for form submission
                const tourdate = document.getElementById('tourdate');
                if (tourdate) {
                    tourdate.value = dateStr;
                }
            }
        });

        // Initialize flatpickr for end date input
        flatpickr("#dateend", {
            dateFormat: "Y-m-d", // Show year, month, and day
            mode: "range", // Allow selecting a range of dates
            minDate: "today", // Minimum date is today
            onChange: function(selectedDates, dateStr, instance) {
                // Example callback function
                console.log("Selected end date:", dateStr);
                // Set the value of the hidden input field for form submission
                const tourdateEnd = document.getElementById('tourdateEnd');
                if (tourdateEnd) {
                    tourdateEnd.value = dateStr;
                }
            }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const submitButton = document.getElementById('submit-button');

        // Function to check form validity and update submit button state
        function validateForm() {
            const destination = document.getElementById('destination').value.trim();
            const date = document.getElementById('date').value.trim();
            const dateend = document.getElementById('dateend').value.trim();
            const lookingFor = document.getElementById('looking-for').value.trim();
            const aboutMe = document.getElementById('about-me').value.trim();
            const checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');

            // Enable submit button only if all fields are filled and at least one checkbox is checked
            if (destination !== '' && date !== '' && dateend !== '' && lookingFor !== '' && aboutMe !== '' && checkboxes.length > 0) {
                submitButton.classList.remove('opacity-30', 'pointer-events-none');
            } else {
                submitButton.classList.add('opacity-30', 'pointer-events-none');
            }
        }

        // Event listener for form submission
        form.addEventListener('submit', function(event) {
            // Validate destination input
            const destination = document.getElementById('destination');
            if (destination.value.trim() === '') {
                destination.focus();
                event.preventDefault();
                return false;
            }

            // Validate start date input
            const date = document.getElementById('date');
            if (date.value.trim() === '') {
                date.focus();
                event.preventDefault();
                return false;
            }

            // Validate end date input
            const dateend = document.getElementById('dateend');
            if (dateend.value.trim() === '') {
                dateend.focus();
                event.preventDefault();
                return false;
            }

            // Validate "looking for" textarea
            const lookingFor = document.getElementById('looking-for');
            if (lookingFor.value.trim() === '') {
                lookingFor.focus();
                event.preventDefault();
                return false;
            }

            // Validate "about me" textarea
            const aboutMe = document.getElementById('about-me');
            if (aboutMe.value.trim() === '') {
                aboutMe.focus();
                event.preventDefault();
                return false;
            }

            // Validate at least one checkbox checked
            const checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
            if (checkboxes.length === 0) {
                event.preventDefault();
                return false;
            }

            // Form is valid, allow submission
            return true;
        });

        // Event listener for form inputs change to validate dynamically
        form.addEventListener('input', validateForm);
    });
</script>




</body>
</html>
