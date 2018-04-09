# PhinstaScrape
PHP class for scraping data from any Instagram profile. Only thing needed is an Instagram username. No password required.

# Usage
```
$instagramUsername = 'brickzone';
$phinstaScrape = new \PhinstaScrape\PhinstaScrape($instagramUsername);

echo 'Followers: ' . $phinstaScrape->getUser()->getEdgeFollowedBy()->getCount();

echo 'Following: ' . $phinstaScrape->getUser()->getEdgeFollow()->getCount();
