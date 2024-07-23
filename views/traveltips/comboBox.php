<?php
    require_once './constants/constants.php';

?>
<style>
        .autocomplete-container {
            position: relative;
            width: 240px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .autocomplete-input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        .autocomplete-dropdown {
            position: absolute;
            color: black;
            width: 100%;
            background-color: lightcyan;
            max-height: 200px;
            overflow-y: auto;
            z-index: 10;
        }
        .autocomplete-item {
            padding: 8px;
            cursor: pointer;
        }
        .autocomplete-item:hover,
        .autocomplete-item.highlighted {
            background-color: #eee;
        }

        @media only screen and (max-width: 768px) {
            .autocomplete-container {
                width: 100%; 
                box-shadow: none; 
                padding-left: 1rem; 
                padding-right: 1rem; 
            }
 
}
    </style>

<div class="autocomplete-container">
        <input type="text" id="autocomplete-input" class="autocomplete-input text-black bg-gray-100 rounded" placeholder="vyber stát ....">
        <div id="autocomplete-dropdown" class="autocomplete-dropdown"></div>
    </div>


 <script>


let searchTerm = '';
let isOpen = false;
let highlightedIndex = -1;

const input = document.getElementById('autocomplete-input');
const dropdown = document.getElementById('autocomplete-dropdown');

input.addEventListener('input', handleInputChange);
input.addEventListener('keydown', handleKeyDown);
document.addEventListener('click', handleClickOutside);

function handleInputChange(e) {
    searchTerm = e.target.value;
    isOpen = true;
    highlightedIndex = -1;
    updateDropdown();
}

function handleKeyDown(e) {
    if (isOpen) {
        if (e.key === 'ArrowDown') {
            e.preventDefault();
            highlightedIndex = (highlightedIndex + 1) % filteredCountries.length;
            updateDropdown();
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            highlightedIndex = (highlightedIndex - 1 + filteredCountries.length) % filteredCountries.length;
            updateDropdown();
        } else if (e.key === 'Enter' && highlightedIndex >= 0) {
            selectCountry(filteredCountries[highlightedIndex]);
        }
    }
}

function handleClickOutside(e) {
    if (!dropdown.contains(e.target) && e.target !== input) {
        isOpen = false;
        updateDropdown();
    }
}

function updateDropdown() {
    dropdown.innerHTML = '';
    if (isOpen && searchTerm) {
        filteredCountries.forEach((country, index) => {
            const item = document.createElement('div');
            item.className = 'autocomplete-item' + (index === highlightedIndex ? ' highlighted' : '');
            item.textContent = country;
            item.addEventListener('click', () => selectCountry(country));
            dropdown.appendChild(item);
        });
    }
}

function selectCountry(country) {
    searchTerm = country;
    input.value = country;
    isOpen = false;
    updateDropdown();
    console.log('Selected country:', country);
       // Convert country name to a URL-friendly format
       const formattedCountry = encodeURIComponent(country).replace(/%20/g, '+');

// Construct the new URL
const newUrl = `http://localhost/travel/traveltips/${formattedCountry}`;

// Update the window location to the new URL
window.location.href = newUrl;

}

function normalizeString(str) {
    return str.normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase();
}

const maxDisplayedCountries = 15;
let filteredCountries = [];

function filterCountries() {
    const normalizedSearchTerm = normalizeString(searchTerm);
    filteredCountries = countryNames.filter(country => 
        normalizeString(country).includes(normalizedSearchTerm) ||
        country.toLowerCase().includes(searchTerm.toLowerCase())
    ).slice(0, maxDisplayedCountries);
}

input.addEventListener('input', () => {
    filterCountries();
    updateDropdown();
});

document.addEventListener('DOMContentLoaded', () => {
    filterCountries();
    updateDropdown();
});
 </script>   


<script>

    
const countryNames = [
    'Francie',
    'Španělsko',
    'Spojené státy',
    'Čína',
    'Itálie',
    'Mexiko',
    'Velká Británie',
    'Turecko',
    'Německo',
    'Thajsko',
    'Rakousko',
    'Řecko',
    'Japonsko',
    'Malajsie',
    'Rusko',
    'Portugalsko',
    'Kanada',
    'Saúdská Arábie',
    'Jižní Korea',
    'Austrálie',
    'Nizozemsko',
    'Egypt',
    'Indie',
    'Vietnam',
    'Indonésie',
    'Švýcarsko',
    'Argentina',
    'Švédsko',
    'Polsko',
    'Česká republika',
    'Belgie',
    'Norsko',
    'Dánsko',
    'Singapur',
    'Finsko',
    'Maroko',
    'Brazílie',
    'Spojené arabské emiráty',
    'Irsko',
    'Maďarsko',
    'Izrael',
    'Filipíny',
    'Chile',
    'Nový Zéland',
    'Jižní Afrika',
    'Peru',
    'Rumunsko',
    'Chorvatsko',
    'Keňa',
    'Srí Lanka',
    'Írán',
    'Kolumbie',
    'Hongkong',
    'Tanzanie',
    'Ukrajina',
    'Bulharsko',
    'Srbsko',
    'Katar',
    'Lucembursko',
    'Slovensko',
    'Lotyšsko',
    'Litva',
    'Estonsko',
    'Bahrajn',
    'Kypr',
    'Malta',
    'Černá Hora',
    'Omán',
    'Panama',
    'Arménie',
    'Bosna a Hercegovina',
    'Jordánsko',
    'Gruzie',
    'Albánie',
    'Mauricius',
    'Kuvajt',
    'Libanon',
    'Kostarika',
    'Uruguay',
    'Kazachstán',
    'Bolívie',
    'Guatemala',
    'Ekvádor',
    'Island',
    'Makedonie',
    'Nepál',
    'Paraguay',
    'Zimbabwe',
    'Ghana',
    'Ázerbájdžán',
    'Zambie',
    'Honduras',
    'Jamajka',
    'Etiopie',
    'Kamerun',
    'Madagaskar',
    'Kuba'
];
</script>