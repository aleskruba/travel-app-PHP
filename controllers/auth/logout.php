<?php


logout();

header("Location: " . getUrl('?auth=logout'));
exit();