<?php
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
  ?>



<div class="flex flex-col px-2 md:px-4 w-full mb-4">


<?php
if ($user) {
?>
    <form id="messageForm" method="POST" action="<?= getUrl('spolucesty/' . urlencode($tourId) . '/createmessage')?>">

        <input type="hidden" name='tour_id' value=<?= $tourId ?> />

        
        <div class="flex justify-between items-center dark:text-lighTextColor gap-4 bg-gray-100 px-2 py-2 md:rounded-lg shadow-md mt-2">
            <div class="hidden md:flex items-center gap-2">
                <div class="w-14 h-14 overflow-hidden rounded-full">
                    <img src="<?php echo isset($user['image']) ? $user['image'] :getUrl('public/emoji.png')  ; ?>" alt="Profile" class="w-full h-full object-cover" />
                </div>
            </div>
            <div class="flex-1 md:flex">

                <textarea name="message" 
                        rows="5" 
                          class="w-full py-2 px-4 bg-gray-200 rounded-lg text-black focus:outline-none focus:ring focus:border-blue-500 resize-none" 
                          placeholder="Sdlej svůj názor (max 400 znaků)" 
                          maxlength="400"
                          id="messageTextarea">
            </textarea>
           <script type="text/javascript">
                $(document).ready(function() {
                    // Initialize emojioneArea
                    var emojiArea = $('#messageTextarea').emojioneArea({
                        pickerPosition: 'bottom'
                    });

        // Handle emoji click events
        emojiArea[0].emojioneArea.on("emojibtn.click", function(button, event) {
            console.log(button[0].dataset.name); // Logs the emoji code
            emptyInputMessageFunction();
        });

        // Handle input events from emojioneArea
        emojiArea[0].emojioneArea.on("keyup", function() {
            emptyInputMessageFunction();
        });


        document.getElementById("messageTextarea").addEventListener('input', emptyInputMessageFunction);

        function emptyInputMessageFunction() {
            // Get the value from emojioneArea
            var value = emojiArea[0].emojioneArea.getText();
            console.log(value);

            const messageTextarea = value.trim();
            const submitMessageButton = document.getElementById('submitMessageButton');

            if (messageTextarea) {
                submitMessageButton.classList.remove('opacity-30', 'pointer-events-none');
            } else {
                submitMessageButton.classList.add('opacity-30', 'pointer-events-none');
            }
        }
    });
</script>

            </div>

            <div>
                <button type="submit" 
                        class="py-1 px-2 bg-green-500 text-white rounded-lg shadow-md hover:bg-green-600 focus:outline-none focus:ring focus:border-green-700 opacity-30 pointer-events-none"
                        id="submitMessageButton"
                        >  <i class="material-icons">send</i>
                </button>
            </div>

            
        </div>
        
        <div>
            <?php
            if (isset($_SESSION['errors']) && $_SESSION['errors']) {
                foreach ($_SESSION['errors'] as $key => $val) {
                    echo "<p class='tark:text-red-100 text-red-500 text-xs mt-2'>$val</p>";
                }
                unset($_SESSION['errors']);
            } else {
                echo '';
            }
            ?>
             <p id="errorText" class="dark:text-red-100 text-red-500 text-xs mt-2 hidden">musí obsahovat text</p>
        </div>
    </form>
<?php
} else {
    echo "<p>Pouze přihlášení uživatelé mohou psát zprávy</p>";
}
?>


</div>

