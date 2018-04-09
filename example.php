<?php

require_once 'vendor/autoload.php';

try {
    // Instagram username
    $instagramUsername = 'brickzone';

    $phinstaScrape = new \PhinstaScrape\PhinstaScrape($instagramUsername);

    if ($phinstaScrape->getUser()->existsUsername()) {
        echo 'Username: ' . $phinstaScrape->getUser()->getUsername() . '<br />';
    }

    if ($phinstaScrape->getUser()->existsEdgeFollowedBy()) {
        echo 'Followers: ' . $phinstaScrape->getUser()->getEdgeFollowedBy()->getCount() . '<br />';
    }

    if ($phinstaScrape->getUser()->existsEdgeFollow()) {
        echo 'Following: ' . $phinstaScrape->getUser()->getEdgeFollow()->getCount() . '<br />';
    }

    if ($phinstaScrape->getUser()->existsEdgeOwnerToTimelineMedia()) {
        echo 'Posts: ' . $phinstaScrape->getUser()->getEdgeOwnerToTimelineMedia()->getCount() . '<br />';
    }

    echo '<br />';
    echo 'JSON: <br />' . $phinstaScrape->getData()->toJson();
} catch (Exception $e) {
    echo 'ERROR: ' . $e->getMessage();
}