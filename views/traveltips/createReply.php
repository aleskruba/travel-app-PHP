<?php
// Retrieve session data or set default values
$reply = isset($_SESSION['reply']) ? trim($_SESSION['reply']) : '';
$reply = $reply === '' ? '' : $reply;
$countryParam = isset($countryParam) ? $countryParam : ''; // Ensure $countryParam is defined
?>

<form id="replyForm" method="POST" action="<?= getUrl('traveltips/' . urlencode($countryParam) . '/createreply')?>">
 
    <input type="hidden" name="messageId" value="<?= $message['id'] ?>">

    <div class="flex justify-between items-center dark:text-lighTextColor gap-4 dark:bg-gray-400 px-2 py-2 md:rounded-lg shadow-md mt-2">
        <div class="hidden md:flex items-center gap-2">
            <div class="w-14 h-14 overflow-hidden rounded-full">
                <img src="<?php echo isset($user['image']) ? $user['image'] : getUrl('public/emoji.png'); ?>" alt="Profile" class="w-full h-full object-cover" />
            </div>
        </div>
        <div class="flex-1 md:flex">
            
        <textarea name="message" 
    rows="6"
    class="w-full py-2 px-4 bg-gray-100 dark:bg-gray-200 rounded-lg text-black focus:outline-none focus:ring focus:border-blue-500 resize-none" 
    placeholder="Odpověz zde (max 400 znaků)" 
    maxlength="400"
    id="replyTextarea<?= $message['id']?>"
>
<?php echo $reply; ?>
</textarea>

<script type="text/javascript">
    $(document).ready(function() {
        // Initialize emojioneArea
        var emojiArea = $('#replyTextarea<?= $message['id'] ?>').emojioneArea({
            pickerPosition: 'bottom'
        });

        // Handle emoji click events
        emojiArea[0].emojioneArea.on("emojibtn.click", function(button, event) {
            console.log(button[0].dataset.name); // Logs the emoji code
            emptyInputFunction();
        });

        // Handle input events from emojioneArea
        emojiArea[0].emojioneArea.on("keyup", function() {
            emptyInputFunction();
        });

        // Original input event listener
        document.getElementById("replyTextarea<?= $message['id']?>").addEventListener('input', emptyInputFunction);

        function emptyInputFunction() {
            // Get the value from emojioneArea
            var value = emojiArea[0].emojioneArea.getText();
            console.log(value);

            const replyTextarea = value.trim();
            const submitReplyButton = document.getElementById('submitReplyButton<?= $message['id']?>');

            if (replyTextarea) {
                submitReplyButton.classList.remove('opacity-30', 'pointer-events-none');
            } else {
                submitReplyButton.classList.add('opacity-30', 'pointer-events-none');
            }
        }
    });
</script>


        </div>



        <div class="flex flex-col gap-2">
            <div >
                <button 
                    type="submit" 
                    class="w-[60px] py-1 px-1 text-sm flex justify-center bg-green-500 text-white rounded-lg shadow-md opacity-30 pointer-events-none"
                    id="submitReplyButton<?= $message['id']?>" 
                    ><i class="material-icons">send</i>
                </button>
            </div>
            <div >
                <button  
                    type="button"
                    class="w-[60px] py-1 px-4 text-sm flex justify-center bg-gray-500 text-white rounded-lg shadow-md hover:bg-gray-600 focus:outline-none focus:ring focus:border-gray-700"
                    onclick="backButton(<?= $message['id'] ?>)"    
                    >Zpět
                </button>
            </div>
        </div>

        

        <script>
        function backButton(id) {
            const replyAnswerDiv = document.getElementById("replyAnswerDiv" + id);
            const errorTextReply = document.getElementById('errorTextReply');
            replyAnswerDiv.classList.remove("block");
            replyAnswerDiv.classList.add("hidden");
            errorTextReply.classList.add('hidden'); 
        }


        </script>
    </div>

    <p id="errorTextReply" class="dark:text-red-100 text-red-500 text-xs mt-2 hidden">musí obsahovat text</p>
    <div>
    <?php
        if (isset($_SESSION['errorsReply']) && $_SESSION['errorsReply']) {
            foreach ($_SESSION['errorsReply'] as $key => $val) {
                echo "<p class='text-red-500 text-xs mt-2'>$val</p>";
            }
            unset($_SESSION['errorsReply']);
        } else {
            echo '';
        }
    ?>
    
    </div>
</form>
