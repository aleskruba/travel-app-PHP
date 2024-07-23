<?php
 //   $baseUri = '/travel/';



 $uri = parse_url($_SERVER['REQUEST_URI'])["path"];

    $countryParam = urldecode($_GET['param1']); 


    function compareById($a, $b) {
      return $b['id'] - $a['id'];
  }
  
  // Sort the messages array by 'id'
  usort($messages, 'compareById');
  
  if (isset($_GET['message']) && $_GET['message'] === 'error') {
       
      
    echo "<script>
    setTimeout(()=>{
      Toastify({
        text: 'Zpráva nebyla odeslána',
        duration: 3000, // Duration in milliseconds
        gravity: 'top', // Display position: 'top', 'bottom', 'left', 'right'
        backgroundColor: 'linear-gradient(to right, #ff4d4d, #ff8080)',
        callback: function() {
            if (history.replaceState) {
                history.replaceState({}, document.title, window.location.pathname);
            }
        }
    }).showToast();
  
     },200)
  
  </script>";
  }

  if (isset($_GET['vote']) && $_GET['vote'] === 'error') {
       
      
    echo "<script>
    setTimeout(()=>{
      Toastify({
        text: 'Nelze hodnotit sama sebe',
        duration: 3000, // Duration in milliseconds
        gravity: 'top', // Display position: 'top', 'bottom', 'left', 'right'
        backgroundColor: 'linear-gradient(to right, #ff4d4d, #ff8080)',
        callback: function() {
            if (history.replaceState) {
                history.replaceState({}, document.title, window.location.pathname);
            }
        }
    }).showToast();
  
     },200)
  
  </script>";
  }

?>


<?php foreach ($messages as $message) :?>
    
<div class="flex flex-col px-2 md:px-4 w-full mt-2">
<div class='  flex flex-col dark:bg-gray-500 dark:text-gray-100 px-2 py-2 shadow-2xl rounded-lg bg-gray-200 text-black'> 
    <div class="flex flex-col relative ">
      <div class="flex  gap-2  "> 
      
      <?php
        if ($message['user_id'] === $user['id']) {
        ?>
          <form method="POST" 
                action="<?= getUrl('traveltips/' . urlencode($countryParam) . '/destroymessage') ?>"
                class="absolute top-2 right-2"
                onsubmit="return confirm('Chceš opravdu smazat tuto zprávu?')">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="id" value="<?= $message['id'] ?>">
            
            <button type="submit" class="w-[25px] h-[25px] cursor-pointer rounded-lg hover:bg-red-400 dark:hover:bg-red-200">
              <img class="w-full h-full" src="../public/bin.png" alt="trash" />
            </button>
          </form>
        <?php
        }
        ?>

          
   <!--    <a href="<?= $uri ?>/message?id=<?= $message['id'] ?>"> -->

        <div class="w-12 h-12 md:w-14 md:h-14 overflow-hidden rounded-full">
      
          <img id="profileImage<?= $message['user_id'] ?>" 
               src="<?php echo isset($message['user_image']) ? $message['user_image'] : getUrl('public/emoji.png') ?>" 
               alt="Profile" 
               class="w-full h-full object-cover cursor-pointer" 
               data-user-image="<?php echo $message['user_image']; ?>"
               />

        </div>
<!--        </a>  -->
        <div class="flex flex-row gap-4 md:gap-2"> 

        <p class="  font-semibold"><?=htmlspecialchars($message['user_firstName']) ?></p>
        <?php
            $date = new DateTime($message['date']);
            $formattedDate = $date->format('d.m H:i');
            ?>
        <p class=" shrink-0 flex nowrap text"><?= $formattedDate ?></p>
      <!--   <p class=" shrink-0 flex nowrap text">message id <?= $message['id'] ?></p> -->
        </div>
      </div>

        <div class="md:px-4 " >
          <p class="ml-8"><?= htmlspecialchars($message['message'])?> </p>

        <div class="flex items-center gap-4">
       <?php

       ?>
   
        <!--      <form action="<= getUrl('traveltips/' . urlencode($countryParam) . '/createvote') ?>" method="POST"> -->
            <input type="hidden" id="message_id" name="message_id" value="<?= $message['id'] ?>">
            <input type="hidden" id="message_user_id" name="message_user_id" value="<?= $message['user_id'] ?>">

            <div class='flex gap-2 text-xs'>
                <div class="flex flex-col">
                    <button type="button" 
                            name="vote_type" 
                            value="thumb_up"
                            id="message_thumb_up_<?= $message['id'] ?>" 
                            class="material-symbols-outlined text-sm <?= $message['user_id'] === $user['id'] 
                            ? 'opacity-30 pointer-events-none' : 'hover:text-yellow-500 cursor-pointer' ?>">
                        thumb_up
                    </button>

                    <div id="total_message_thumb_up_<?= $message['id'] ?>"><?= $message['thumbs_up_count'] ?></div>
                </div>

                <div class="flex flex-col">
                    <button type="button" 
                            name="vote_type" 
                            value="thumb_down"
                            id="message_thumb_down_<?= $message['id'] ?>"  
                            class="material-symbols-outlined text-sm <?= $message['user_id'] === $user['id']  ? 'opacity-30 pointer-events-none' : 'hover:text-yellow-500 cursor-pointer' ?>">
                        thumb_down
                    </button>
                    <div id="total_message_thumb_down_<?= $message['id'] ?>"><?= $message['thumbs_down_count'] ?></div>
                </div>
        
            </div>

      <!--      </form> -->

         

            <div>
            <?php
                if ($user['id'] !== $message['user_id']) {
                ?>
                    <button class='mt-2 bg-gray-300 text-gray-700 px-4 py-1 text-sm rounded-full hover:bg-gray-400 focus:outline-none focus:ring focus:border-gray-500'
                            id="answerButton"
                            onclick="toggleAnswers(<?= $message['id'] ?>)">
                        Odpověz
                    </button>
                <?php
                }
                ?>
            </div>

          </div>

            <div class="hidden" id="replyAnswerDiv<?= $message['id'] ?>">
                <?php require "createReply.php"; ?> 
            </div>

            <script>
       

                function toggleAnswers(id) {
            
                  const replyDivs = document.querySelectorAll("[id^='replyAnswerDiv']");

                  replyDivs.forEach(div => {
                    if (div.id !== "replyAnswerDiv" + id) {
                        div.classList.remove("block");
                        div.classList.add("hidden");
                    }
                  });

                    const replyAnswerDiv = document.getElementById("replyAnswerDiv" + id);
               
                    if (replyAnswerDiv.classList.contains('hidden')) { 
                       replyAnswerDiv.classList.remove("hidden");
                      replyAnswerDiv.classList.add("block");

                    } else {
               
                      replyAnswerDiv.classList.remove("block");
                      replyAnswerDiv.classList.add("hidden");
                    }
                }


        </script>

            </script>

          


            <div class="w-full flex p-4 relative">
                    <!-- Triangle Down -->
                    <div class=" w-0 h-0 border-l-4 border-r-4 border-t-8 border-transparent dark:border-t-white border-t-black cursor-pointer" 
                         id="triangleDown<?= $message['id'] ?>" 
                         onclick="toggleTriangles(<?= $message['id'] ?>)">

                         <div class="text-xs italic absolute top-3 left-8">   <?=  empty($message['replies']) ? 'zatím žádná odpověď' : '' ?>      </div>
                         <?php foreach ($message['replies'] as $reply): ?>
                          <div class="text-xs italic absolute top-3 left-8"> 
                             
                                 <?php echo count($message['replies']) ?> 

                                  <?=  count($message['replies']) > 1 ? ' odpovědí' :' odpověď' ?>
    
                                </div>
                               <?php endforeach; ?>  
                    </div>
                    <!-- Triangle Up (initially hidden) -->
                    <div class="hidden  w-0 h-0 border-l-4 border-r-4 border-b-8 border-transparent dark:border-b-white  border-b-black cursor-pointer" 
                         id="triangleUp<?= $message['id'] ?>" 
                         onclick="toggleTriangles(<?= $message['id'] ?>)">
                            <?php foreach ($message['replies'] as $reply): ?>
                                 <div class="text-xs italic absolute top-3 left-8"> 
                                    <?php echo count($message['replies']) ?> 
                                    <?=  count($message['replies']) > 1 ? ' odpovědí' :' odpověď' ?>
                                  </div>
                               <?php endforeach; ?>        
                    </div>

              
                </div>

               <div class="hidden answers" id="answers<?= $message['id'] ?>">
                <div class="">
                     <?php if (count($message['replies']) > 0): ?>
                          <?php foreach ($message['replies'] as $reply): ?>
                              <div class="flex flex-col shadow-2xl px-4 border-b-2 border-indigo-500 py-1 relative">

                              <?php
                                    if ($reply['reply_user_id'] === $user['id']) {
                                    ?>
                                      <form method="POST" 
                                            action="<?= getUrl('traveltips/' . urlencode($countryParam) . '/destroyreply') ?>"
                                            class="absolute top-2 right-2"
                                            onsubmit="return confirm('Chceš opravdu smazat tuto zprávu?')">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="id" value="<?= $reply['reply_id'] ?>">
                                        
                                        <button type="submit" class="w-[25px] h-[25px] cursor-pointer rounded-lg hover:bg-red-400 dark:hover:bg-red-200">
                                          <img class="w-full h-full" src="../public/bin.png" alt="trash" />
                                        </button>
                                      </form>
                                    <?php
                                    }
                                    ?>

                                  <div class="flex gap-2 items-center">
                                    <div class="w-12 h-12 md:w-14 md:h-14 overflow-hidden rounded-full ">
                                      <img 
                                            id="profileImage<?= $reply['reply_user_id'] ?>"     
                                            src="<?= htmlspecialchars($reply['reply_user_image']) ?>" 
                                            alt="Reply User Image"
                                            class="w-full h-full object-cover"
                                            data-user-image="<?php echo $reply['reply_user_image']; ?>"
                                            >
                                      </div>

                                     <!--  <div><?= $reply['reply_id'] ?></div> -->
                                  <div> <?= htmlspecialchars($reply['reply_user_firstName']) ?></div>

                                  <?php
                                      $date = new DateTime($reply['reply_date']);
                                      $formattedDate = $date->format('d.m H:i');
                                      ?>
                                  <div> <?= htmlspecialchars($formattedDate) ?></div>
                              

                                  
                                  </div>
                                  <div class="ml-8"><?= htmlspecialchars($reply['reply_content']) ?></div>



            <input type="hidden" id="reply_id" name="reply_id" value="<?= $reply['reply_id'] ?>">
            <input type="hidden" id="reply_user_id" name="reply_user_id" value="<?= $reply['reply_user_id'] ?>">
            <input type="hidden" id="reply_message_id_<?= $reply['reply_id'] ?>" name="reply_message_id" value="<?= $reply['reply_message_id'] ?>">

            <div class='flex gap-2 text-xs'>

                                  <!--   <p class="text-red-800"><?= $reply['reply_message_id'] ?> </p> -->

                <div class="flex flex-col">
                    <button type="button" 
                            name="vote_reply_type" 
                            value="thumb_up"
                            id="reply_thumb_up_<?= $reply['reply_id'] ?>" 
                            class="material-symbols-outlined text-sm <?= $reply['reply_user_id'] === $user['id'] 
                            ? 'opacity-30 pointer-events-none' : 'hover:text-yellow-500 cursor-pointer' ?>">
                        thumb_up
                    </button>
                    <div id="total_reply_thumb_up_<?= $reply['reply_id'] ?>"><?= $reply['reply_thumbs_up_count'] ?></div>
                </div>

                <div class="flex flex-col">
                    <button type="button" 
                            name="vote_reply_type" 
                            value="thumb_down"
                            id="reply_thumb_down_<?= $reply['reply_id'] ?>"  
                            class="material-symbols-outlined text-sm <?= $reply['reply_user_id'] === $user['id'] ? 'opacity-30 pointer-events-none' : 'hover:text-yellow-500 cursor-pointer' ?>">
                        thumb_down
                    </button>
                    <div id="total_reply_thumb_down_<?= $reply['reply_id'] ?>"><?= $reply['reply_thumbs_down_count'] ?></div>
                </div>
            </div>


  
                                </div>
                          <?php endforeach; ?>
                      <?php else: ?>
                          <div class="text-xs	italic">staň se prvím který odpoví</div>
                      <?php endif; ?>
                  </div>
                </div>
    
    
<script>
    function toggleTriangles(id) {
        const triangleDown = document.getElementById('triangleDown' + id);
        const triangleUp = document.getElementById('triangleUp' + id);
        const answers = document.getElementById('answers' + id);

        // Toggle visibility of triangles
        if (triangleDown.classList.contains('hidden')) {
            triangleDown.classList.remove('hidden');
            triangleUp.classList.add('hidden');

            answers.classList.remove('block');
            answers.classList.add('hidden');
        } else {
            triangleDown.classList.add('hidden');
            triangleUp.classList.remove('hidden');

            answers.classList.remove('hidden');
            answers.classList.add('block');
        }
    }
</script>

        </div>



     </div>


    </div>
</div>
<?php endforeach; ?>
  
<!-- <div id="imageDialog" class="dialog" >
    <div class="dialog-content ">
        <span id="closeDialog" class="close">&times;</span>
        <img id="dialogImage" src="" alt="Profile" class="dialog-image" />
    </div>
</div> -->

<script>
document.addEventListener('DOMContentLoaded', (event) => {
    // Function to send AJAX request using fetch
    const sendVoteRequest = (messageId, voteType) => {
        const url = '<?php echo getUrl('traveltips/{countryParam}/createvote'); ?>'; // Adjust URL as per your application

         const data = {
            messageId: messageId.toString(),
            voteType: voteType.toString(),
        }
 
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body:  JSON.stringify({ data: data }),
                })
        .then(response => {
            console.log(response)
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('Vote request succeeded with JSON response:', data);
            // Optionally handle UI updates based on server response
        })
        .catch(error => {
            console.error('Vote request failed:', error);
        });
    };

    // Add event listeners for all thumb up buttons
    document.querySelectorAll("[id^='message_thumb_up_']").forEach(button => {
        button.addEventListener('click', function() {
            const messageId = button.id.replace('message_thumb_up_', '');
            console.log('Thumb up clicked for message id: ' + messageId);
            
            let countElement = document.getElementById('total_message_thumb_up_' + messageId);
            let currentCount = parseInt(countElement.innerHTML, 10);
            countElement.innerHTML = currentCount + 1;

            const thumbDownButton = document.getElementById('message_thumb_down_' + messageId);
            if (thumbDownButton.classList.contains('opacity-30')) {
                let countElementThumbDown = document.getElementById('total_message_thumb_down_' + messageId);
                let currentCountThumbDown = parseInt(countElementThumbDown.innerHTML, 10);
                countElementThumbDown.innerHTML = currentCountThumbDown - 1;
            }

            thumbDownButton.classList.remove('opacity-30', 'pointer-events-none');
            button.classList.add('opacity-30', 'pointer-events-none');

            sendVoteRequest(messageId, 'thumb_up');
        });
    });

    // Add event listeners for all thumb down buttons
    document.querySelectorAll("[id^='message_thumb_down_']").forEach(button => {
        button.addEventListener('click', function() {
            const messageId = button.id.replace('message_thumb_down_', '');
            console.log('Thumb down clicked for message id: ' + messageId);
            
            let countElement = document.getElementById('total_message_thumb_down_' + messageId);
            let currentCount = parseInt(countElement.innerHTML, 10);
            countElement.innerHTML = currentCount + 1;

            const thumbUpButton = document.getElementById('message_thumb_up_' + messageId);
            if (thumbUpButton.classList.contains('opacity-30')) {
                let countElementThumbUp = document.getElementById('total_message_thumb_up_' + messageId);
                let currentCountThumbUp = parseInt(countElementThumbUp.innerHTML, 10);
                countElementThumbUp.innerHTML = currentCountThumbUp - 1;
            }

            thumbUpButton.classList.remove('opacity-30', 'pointer-events-none');
            button.classList.add('opacity-30', 'pointer-events-none');

            sendVoteRequest(messageId, 'thumb_down');
        });
    });
});

           
           </script>


<!-- replies -->


  

<script>
document.addEventListener('DOMContentLoaded', (event) => {
    // Function to send AJAX request using fetch
    const sendVoteReplyRequest = (replyId,messageId, voteType) => {
        const url = '<?php echo getUrl('traveltips/{countryParam}/createreplyvote'); ?>'; // Adjust URL as per your application

         const data = {
            replyId: replyId.toString(),
            messageId: messageId.toString(),
            voteType: voteType.toString(),
        }
 
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body:  JSON.stringify({ data: data }),
                })
        .then(response => {
            console.log(response)
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('Vote request succeeded with JSON response:', data);
            // Optionally handle UI updates based on server response
        })
        .catch(error => {
            console.error('Vote request failed:', error);
        });
    };

    // Add event listeners for all thumb up buttons
    document.querySelectorAll("[id^='reply_thumb_up_']").forEach(button => {
        button.addEventListener('click', function() {

        
            const replyId = button.id.replace('reply_thumb_up_', '');
           
           const   messageId =    document.getElementById('reply_message_id_'+ replyId).value;

            console.log('Thumb up clicked for reply id: ' + replyId);
            
            let countElement = document.getElementById('total_reply_thumb_up_' + replyId);
            let currentCount = parseInt(countElement.innerHTML, 10);
            countElement.innerHTML = currentCount + 1;

            const thumbDownButton = document.getElementById('reply_thumb_down_' + replyId);
            if (thumbDownButton.classList.contains('opacity-30')) {
                let countElementThumbDown = document.getElementById('total_reply_thumb_down_' + replyId);
                let currentCountThumbDown = parseInt(countElementThumbDown.innerHTML, 10);
                countElementThumbDown.innerHTML = currentCountThumbDown - 1;
            }

            thumbDownButton.classList.remove('opacity-30', 'pointer-events-none');
            button.classList.add('opacity-30', 'pointer-events-none');

            sendVoteReplyRequest(replyId,messageId, 'thumb_up');
        });
    });

    // Add event listeners for all thumb down buttons
    document.querySelectorAll("[id^='reply_thumb_down_']").forEach(button => {
        button.addEventListener('click', function() {
            const replyId = button.id.replace('reply_thumb_down_', '');

            const   messageId =    document.getElementById('reply_message_id_'+ replyId).value;

            console.log('Thumb down clicked for reply id: ' + replyId);
            
            let countElement = document.getElementById('total_reply_thumb_down_' + replyId);
            let currentCount = parseInt(countElement.innerHTML, 10);
            countElement.innerHTML = currentCount + 1;

            const thumbUpButton = document.getElementById('reply_thumb_up_' + replyId);
            if (thumbUpButton.classList.contains('opacity-30')) {
                let countElementThumbUp = document.getElementById('total_reply_thumb_up_' + replyId);
                let currentCountThumbUp = parseInt(countElementThumbUp.innerHTML, 10);
                countElementThumbUp.innerHTML = currentCountThumbUp - 1;
            }

            thumbUpButton.classList.remove('opacity-30', 'pointer-events-none');
            button.classList.add('opacity-30', 'pointer-events-none');

            sendVoteReplyRequest(replyId,messageId, 'thumb_down');
        });
    });
});

           
           </script>