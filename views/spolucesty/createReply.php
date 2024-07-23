<?php

?>

<form id="replyForm" method="POST" action="<?= getUrl('spolucesty/' . urlencode($tourId) . '/createreply') ?>">

    <input type="hidden" name="tourmessage_id" value="<?= htmlspecialchars($message['message_id']) ?>">

    <div class="flex justify-between items-center dark:text-lighTextColor gap-4 dark:bg-gray-400 px-2 py-2 md:rounded-lg shadow-md mt-2">
        <div class="hidden md:flex items-center gap-2">
            <div class="w-14 h-14 overflow-hidden rounded-full">
                <img src="<?= isset($user['image']) ? htmlspecialchars($user['image']) : getUrl('public/emoji.png'); ?>" alt="Profile" class="w-full h-full object-cover" />
            </div>
        </div>
        <div class="flex-1 md:flex">
            <textarea name="message" 
                rows="6"
                class="w-full py-2 px-4 bg-gray-100 dark:bg-gray-200 rounded-lg text-black focus:outline-none focus:ring focus:border-blue-500 resize-none" 
                placeholder="Odpověz zde (max 400 znaků)" 
                maxlength="400"
                id="replyTextarea<?= htmlspecialchars($message['message_id']) ?>"
            ></textarea>
        </div>
        <div class="flex flex-col gap-2">
            <button 
                type="submit" 
                class="w-[60px] py-1 px-1 text-sm flex justify-center bg-green-500 text-white rounded-lg shadow-md opacity-30 pointer-events-none"
                id="submitReplyButton<?= htmlspecialchars($message['message_id']) ?>"
            ><i class="material-icons">send</i></button>
            <button  
                type="button"
                class="w-[60px] py-1 px-1 text-sm flex justify-center bg-gray-500 text-white rounded-lg shadow-md hover:bg-gray-600 focus:outline-none focus:ring focus:border-gray-700"
                onclick="backButton(<?= htmlspecialchars($message['message_id']) ?>)"
            >Zpět</button>
        </div>
    </div>

    <p id="errorTextReply" class="dark:text-red-100 text-red-500 text-xs mt-2 hidden">musí obsahovat text</p>
    <div>
    <?php
        if (isset($_SESSION['errorsReply']) && $_SESSION['errorsReply']) {
            foreach ($_SESSION['errorsReply'] as $key => $val) {
                echo "<p class='text-red-500 text-xs mt-2'>$val</p>";
            }
            unset($_SESSION['errorsReply']);
        }
    ?>
    </div>
</form>

<script type="text/javascript">
    $(document).ready(function() {
        var emojiArea = $('#replyTextarea<?= htmlspecialchars($message['message_id']) ?>').emojioneArea({
            pickerPosition: 'bottom'
        });

        emojiArea[0].emojioneArea.on("emojibtn.click", function(button, event) {
            emptyInputFunction();
        });

        emojiArea[0].emojioneArea.on("keyup", function() {
            emptyInputFunction();
        });

        document.getElementById("replyTextarea<?= htmlspecialchars($message['message_id']) ?>").addEventListener('input', emptyInputFunction);

        function emptyInputFunction() {
            var value = emojiArea[0].emojioneArea.getText();
            const replyTextarea = value.trim();
            const submitReplyButton = document.getElementById('submitReplyButton<?= htmlspecialchars($message['message_id']) ?>');

            if (replyTextarea) {
                submitReplyButton.classList.remove('opacity-30', 'pointer-events-none');
            } else {
                submitReplyButton.classList.add('opacity-30', 'pointer-events-none');
            }
        }
    });

    function backButton(id) {
        const replyAnswerDiv = document.getElementById("replyAnswerDiv" + id);
        const errorTextReply = document.getElementById('errorTextReply');
        replyAnswerDiv.classList.remove("block");
        replyAnswerDiv.classList.add("hidden");
        errorTextReply.classList.add('hidden');
    }
</script>
