<?php


logoutgoogle();

header("Location: " . getUrl('?auth=logout'));
exit();