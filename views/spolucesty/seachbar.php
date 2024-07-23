
<div class="container mx-auto max-w-3xl   rounded  text-black">
    <div class="flex gap-2 flex-col md:flex-row items-center justify-between mb-4 ">
        <select id="select-country" class="w-[70%] md:w-1/4 px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:border-blue-500">
            <option value="">Vyber zemi</option>
            <?php foreach ($uniqueDestinations as $destination): ?>
                <option value="<?= htmlspecialchars($destination) ?>"><?= htmlspecialchars($destination) ?></option>
            <?php endforeach; ?>
        </select>
        
        <select id="select-trip-type" class="w-[70%]  md:w-1/4  px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:border-blue-500">
            <option value="">Vyber typ cest</option>
            <?php foreach ($typeOfTour as $tour): ?>
                <option value="<?= htmlspecialchars($tour) ?>"><?= htmlspecialchars($tour) ?></option>
            <?php endforeach; ?>
        </select>
        
        <?php
$czechMonths = ['leden', 'únor', 'březen', 'duben', 'květen', 'červen', 'červenec', 'srpen', 'září', 'říjen', 'listopad', 'prosinec'];

$currentMonth = date('n');
$currentYear = date('Y');

$options = [];

for ($i = 0; $i < 12; $i++) {

    $month = ($currentMonth + $i - 1) % 12 + 1; 
    $year = $currentYear + floor(($currentMonth + $i - 1) / 12);


    $formattedMonth = $czechMonths[$month - 1]; 
    $formattedYear = $year;


    $optionText = "{$formattedMonth} {$formattedYear}";

    $optionValue = sprintf('%d-%02d', $year, $month);

    $options[] = [
        'value' => htmlspecialchars($optionValue),
        'text' => htmlspecialchars($optionText)
    ];
}
?>

<select id="select-trip-date" class="w-[70%] md:w-1/4 px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:border-blue-500">
    <option value="">Termin cesty</option>
    <?php foreach ($options as $option): ?>
        <option value="<?= $option['value'] ?>"><?= $option['text'] ?></option>
    <?php endforeach; ?>
</select>
        
        <div class="flex gap-2 md:ml-2 mt-2 md:mt-0">
        <button 
            id="search-button" 
            class="bg-blue-500 text-white px-4 py-1 rounded-lg shadow-md hover:bg-blue-600 focus:outline-none"
            >Hledat
        </button>
        
        <button id="reset-button" 
                class="bg-gray-500 text-white px-4 py-1 rounded-lg shadow-md hover:bg-gray-600 focus:outline-none  whitespace-nowrap"
                >Zrusit filtry
        </button>
        </div>
    
    
    </div>
</div>

</div>




<script>$(document).ready(function() {
    // Initialize select2 for dropdowns
    $('#select-country').select2({
        placeholder: 'Vyber zemi',
        allowClear: true,
        theme: 'classic'
    });

    $('#select-trip-type').select2({
        placeholder: 'Vyber typ cest',
        allowClear: true,
        theme: 'classic'
    });

    $('#select-trip-date').select2({
        placeholder: 'Termin cesty',
        allowClear: true,
        theme: 'classic'
    });

    // Function to parse query parameters from URL
    function getQueryParams() {
        var params = {};
        var url = window.location.href;
        var queryStartIndex = url.indexOf('?');
        if (queryStartIndex !== -1) {
            var queryStr = url.substring(queryStartIndex + 1);
            var pairs = queryStr.split('&');
            pairs.forEach(function(pair) {
                var keyValue = pair.split('=');
                params[keyValue[0]] = decodeURIComponent(keyValue[1]);
            });
        }
        return params;
    }

    // Function to set dropdown selections based on query parameters
    function setDropdownSelections() {
        var queryParams = getQueryParams();
        
        // Set country dropdown
        if (queryParams.hasOwnProperty('destination')) {
            $('#select-country').val(queryParams['destination']).trigger('change');
        }

        // Set trip type dropdown
        if (queryParams.hasOwnProperty('tourtype')) {
            $('#select-trip-type').val(queryParams['tourtype']).trigger('change');
        }

        // Set trip date dropdown
        if (queryParams.hasOwnProperty('date')) {
            // Convert date from 'květen2024' to 'yyyy-mm' format
            var dateStr = queryParams['date'];
            var monthName = dateStr.substring(0, dateStr.length - 4).trim();
            var year = dateStr.substring(dateStr.length - 4);

            // Reverse lookup month name to month number
            let czechMonths = ['leden', 'únor', 'březen', 'duben', 'květen', 'červen', 'červenec', 'srpen', 'září', 'říjen', 'listopad', 'prosinec'];
            var month = czechMonths.findIndex(function(m) {
                return m === monthName;
            }) + 1;

            var formattedDate = year + '-' + (month < 10 ? '0' + month : month);
            $('#select-trip-date').val(formattedDate).trigger('change');
        }
    }

    // Call setDropdownSelections function on page load
    setDropdownSelections();

    // Event handler for reset button
    $('#reset-button').click(function() {
        // Reset dropdown selections
        $('#select-country').val(null).trigger('change');
        $('#select-trip-type').val(null).trigger('change');
        $('#select-trip-date').val(null).trigger('change');

        // Clear URL parameters and redirect to the base URL
        baseUrl = 'http://localhost/travel/spolucesty';
        // var baseUrl ='https://travel.dokram.cz/spolucesty'
        window.location.href = baseUrl;
    });

    // Event handler for search button
    $('#search-button').click(function() {
        var destination = $('#select-country').val();
        var tourType = $('#select-trip-type').val();
        var date = $('#select-trip-date').val();

        // Construct the URL based on selected filters
      var baseUrl = 'http://localhost/travel/spolucesty';
      //    var baseUrl ='https://travel.dokram.cz/spolucesty'
        var queryParams = [];

        if (destination) {
            queryParams.push('destination=' + encodeURIComponent(destination));
        }
        if (tourType) {
            queryParams.push('tourtype=' + encodeURIComponent(tourType));
        }
        if (date) {
            // Convert date format to 'květen2024'
            var dateParts = date.split('-');
            var year = dateParts[0];
            var month = dateParts[1];

            let czechMonths = ['leden', 'únor', 'březen', 'duben', 'květen', 'červen', 'červenec', 'srpen', 'září', 'říjen', 'listopad', 'prosinec'];
            var formattedMonth = czechMonths[parseInt(month) - 1];

            var formattedDate = formattedMonth + year;

            queryParams.push('date=' + encodeURIComponent(formattedDate));
        }

        var finalUrl = baseUrl + (queryParams.length > 0 ? '?' + queryParams.join('&') : '');

        // Redirect to the constructed URL
        window.location.href = finalUrl;
    });
});

</script>
