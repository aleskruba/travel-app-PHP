<?php

$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;

  ?>



<?php foreach ($tourmessages as $message) :?>


<div class="flex flex-col px-2 md:px-4 w-full mt-2">
    <div class='flex flex-col dark:bg-gray-500 dark:text-gray-100 px-2 py-2 shadow-2xl rounded-lg bg-gray-200 text-black'> 
        <div class="flex flex-col relative ">
            <div class="flex gap-2">
                <?php if ($message['user_id'] ==  $user['id']): ?>
                    <form method="POST" 
                          action="<?= getUrl('spolucesty/' . urlencode($tourId) . '/destroymessage') ?>"
                          class="absolute top-2 right-2"
                          onsubmit="return confirm('Chceš opravdu smazat tuto zprávu?')">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="id" value="<?= $message['message_id'] ?>">
                        <button type="submit" class="w-[25px] h-[25px] cursor-pointer rounded-lg hover:bg-red-400 dark:hover:bg-red-200">
                            <img class="w-full h-full" src="../public/bin.png" alt="trash" />
                        </button>
                    </form>
                <?php endif; ?>

                <div class="w-14 h-14 overflow-hidden rounded-full">
                    <img id="profileImage<?= $message['user_id'] ?>" 
                         src="<?= htmlspecialchars($message['user_image']) ?>" 
                         alt="Profile" 
                         class="w-full h-full object-cover cursor-pointer" 
                         data-user-image="<?= htmlspecialchars($message['user_image']) ?>" />
                </div>
                
                <div class="flex flex-row gap-4 md:gap-2">
                    <p class="font-semibold"><?= htmlspecialchars($message['user_firstName']) ?></p>
                    <?php
                        $date = new DateTime($message['message_date']);
                        $formattedDate = $date->format('d.m H:i');
                    ?>
                    <p class="shrink-0 flex nowrap text"><?= $formattedDate ?></p>
                    <p class="shrink-0 flex nowrap text">message id <?= $message['message_id'] ?></p>
                </div>
            </div>

            <div class="md:px-4">
                <p class="ml-8"><?= htmlspecialchars($message['message_text']) ?></p>
                <div class="flex items-center gap-4">
                    <?php if ($user['id'] !== $message['user_id']): ?>
                        <button class='mt-2 bg-gray-300 text-gray-700 px-4 py-1 text-sm rounded-full hover:bg-gray-400 focus:outline-none focus:ring focus:border-gray-500'
                                id="answerButton"
                                onclick="toggleAnswers(<?= $message['message_id'] ?>)">
                            Odpověz
                        </button>
                    <?php endif; ?>
                </div>

                <div class="hidden" id="replyAnswerDiv<?= htmlspecialchars($message['message_id']) ?>">
                    <?php
                        $id = $tourId;
                        include 'createReply.php';
                    ?>
                </div>
            
            </div>

            <div class="w-full flex p-4 relative">
                <!-- Triangle Down -->
                <div class="w-0 h-0 border-l-4 border-r-4 border-t-8 border-transparent dark:border-t-white border-t-black cursor-pointer"
                     id="triangleDown<?= $message['message_id'] ?>" 
                     onclick="toggleTriangles(<?= $message['message_id'] ?>)">
                    <div class="text-xs italic absolute top-3 left-8">
                        <?= empty($message['replies']) ? 'zatím žádná odpověď' : count($message['replies']) . (count($message['replies']) > 1 ? ' odpovědí' : ' odpověď') ?>
                    </div>
                </div>
                <!-- Triangle Up (initially hidden) -->
                <div class="hidden w-0 h-0 border-l-4 border-r-4 border-b-8 border-transparent dark:border-b-white border-b-black cursor-pointer"
                     id="triangleUp<?= $message['message_id'] ?>" 
                     onclick="toggleTriangles(<?= $message['message_id'] ?>)">
                    <div class="text-xs italic absolute top-3 left-8">
                        <?= count($message['replies']) . (count($message['replies']) > 1 ? ' odpovědí' : ' odpověď') ?>
                    </div>
                </div>
            </div>

            <div class="hidden answers" id="answers<?= $message['message_id'] ?>">
                <?php if (!empty($message['replies'])): ?>
                    <?php foreach ($message['replies'] as $reply): ?>
                        <div class="flex flex-col shadow-2xl px-4 border-b-2 border-indigo-500 py-1 relative">
                            <?php if ($reply['reply_user_id'] == $user['id']): ?>
                                <form method="POST" 
                                      action="<?= getUrl('spolucesty/' . urlencode($tourId) . '/destroyreply') ?>"
                                      class="absolute top-2 right-2"
                                      onsubmit="return confirm('Chceš opravdu smazat tuto zprávu?')">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="id" value="<?= $reply['reply_id'] ?>">
                                    <button type="submit" class="w-[25px] h-[25px] cursor-pointer rounded-lg hover:bg-red-400 dark:hover:bg-red-200">
                                        <img class="w-full h-full" src="../public/bin.png" alt="trash" />
                                    </button>
                                </form>
                            <?php endif; ?>

                            <div class="flex gap-2 items-center">
                                <div class="w-14 h-14 overflow-hidden rounded-full">
                                    <img id="profileImage<?= $reply['reply_user_id'] ?>"     
                                         src="<?= htmlspecialchars($reply['reply_user_image']) ?>" 
                                         alt="Reply User Image"
                                         class="w-full h-full object-cover"
                                         data-user-image="<?= htmlspecialchars($reply['reply_user_image']) ?>" />
                                </div>
                                <div><?= htmlspecialchars($reply['reply_user_firstName']) ?></div>
                                <?php
                                    $date = new DateTime($reply['reply_date']);
                                    $formattedDate = $date->format('d.m H:i');
                                ?>
                                <div><?= htmlspecialchars($formattedDate) ?></div>
                            </div>
                            <div class="ml-8"><?= htmlspecialchars($reply['reply_message']) ?></div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-xs italic">staň se prvím který odpoví</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>

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
    replyAnswerDiv.classList.toggle('hidden');
    replyAnswerDiv.classList.toggle('block');
}

function toggleTriangles(id) {
    const triangleDown = document.getElementById("triangleDown" + id);
    const triangleUp = document.getElementById("triangleUp" + id);
    const answers = document.getElementById("answers" + id);

    triangleDown.classList.toggle('hidden');
    triangleUp.classList.toggle('hidden');
    answers.classList.toggle('hidden');
    answers.classList.toggle('block');
}
</script>
