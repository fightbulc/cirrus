<pre>
                      iiii
                     i::::i
                      iiii

    cccccccccccccccciiiiiiirrrrr   rrrrrrrrr   rrrrr   rrrrrrrrr   uuuuuu    uuuuuu      ssssssssss
  cc:::::::::::::::ci:::::ir::::rrr:::::::::r  r::::rrr:::::::::r  u::::u    u::::u    ss::::::::::s
 c:::::::::::::::::c i::::ir:::::::::::::::::r r:::::::::::::::::r u::::u    u::::u  ss:::::::::::::s
c:::::::cccccc:::::c i::::irr::::::rrrrr::::::rrr::::::rrrrr::::::ru::::u    u::::u  s::::::ssss:::::s
c::::::c     ccccccc i::::i r:::::r     r:::::r r:::::r     r:::::ru::::u    u::::u   s:::::s  ssssss
c:::::c              i::::i r:::::r     rrrrrrr r:::::r     rrrrrrru::::u    u::::u     s::::::s
c:::::c              i::::i r:::::r             r:::::r            u::::u    u::::u        s::::::s
c::::::c     ccccccc i::::i r:::::r             r:::::r            u:::::uuuu:::::u  ssssss   s:::::s
c:::::::cccccc:::::ci::::::ir:::::r             r:::::r            u:::::::::::::::uus:::::ssss::::::s
 c:::::::::::::::::ci::::::ir:::::r             r:::::r             u:::::::::::::::us::::::::::::::s
  cc:::::::::::::::ci::::::ir:::::r             r:::::r              uu::::::::uu:::u s:::::::::::ss
    cccccccccccccccciiiiiiiirrrrrrr             rrrrrrr                uuuuuuuu  uuuu  sssssssssss
</pre>

# Cirrus

### What is Cirrus?
Soundcloud API Reader Library to fetch and process data about users, tracks and playlists.

### Any dependencies?
Cirrus comes as an [composer](http://getcomposer.org/) package. Requirements are >= PHP 5.3, its CURL extension and a [CURL handler class](https://github.com/fightbulc/php_curl). Also, you need an API key from Soundcloud. [Register here](http://soundcloud.com/you/apps).

### Setup
- Download
- Run ```composer install```
- Get Soundcloud API key
- Start hacking

# Structure
All fetched results are wrapped in *value object* classes. This means that you can access all response values by method call.

```php
// print the username
echo $userVo->getUsername();

// or lets get all tracks from the user
// and then the title from the first track
$tracksVo = $userVo->getTracksVo();
echo $tracksVo[0]->getTitle();
````

In general VOs enable us to maintain our code much better. Especially if we don't have any influence on the reference as its the case with soundcloud's API.

Need more input? [Have a look](http://jmatter.org/articles/2006/08/04/tip-of-the-week-value-objects) at this piece of text.

# Example: User

### 1. Get user data
```php
require __DIR__ . '/../vendor/autoload.php';

$clientId = '[YOUR API KEY]';
$userId = 428623;

$userVo = \Cirrus\Users\UsersCirrus::init()
  ->setClientId($clientId)
  ->setId($userId)
  ->fetchData();

var_dump($userVo);
```

**How to get e.g. a user's full name:**
```php
// user's full name
echo $userVo->getFullName();

// or get all data for this user as an array
var_dump($userVo->getData());
```

### 2. Get user data and its relations
Its up to you which data you would like to fetch. See below all possible options.

```php
require __DIR__ . '/../vendor/autoload.php';

$clientId = '[YOUR API KEY]';
$userId = 428623;

$userVo = \Cirrus\Users\UsersCirrus::init()
  ->setClientId($clientId)
  ->setId($userId)
  ->withTracksData(TRUE)
  ->withPlaylistsData(TRUE)
  ->withFollowersData(TRUE)
  ->withFollowingsData(TRUE)
  ->withFavoritesData(TRUE)
  ->withWebProfilesData(TRUE)
  ->fetchData();

var_dump($userVo);
```

### 3. Get only a certain type of a user's relation data
Just need e.g. a user's tracks? Here you go:

```php
require __DIR__ . '/../vendor/autoload.php';

$clientId = '[YOUR API KEY]';
$userId = 428623;

// get tracks by user id
$userTracksVoMany = \Cirrus\Users\UsersCirrus::init()
  ->setClientId($clientId)
  ->setId($userId)
  ->fetchTracksData();

var_dump($userTracksVoMany);

// or get all followers
$userFollowersVoMany = \Cirrus\Users\UsersCirrus::init()
  ->setClientId($clientId)
  ->setId($userId)
  ->fetchFollowersData();

var_dump($userFollowersVoMany);
```

# Example: Track
Fetching track data is based on the same principles as for the user data.

### 1. Get track data
```php
require __DIR__ . '/../vendor/autoload.php';

$clientId = '[YOUR API KEY]';
$trackId = 64321366;

$trackVo = \Cirrus\Tracks\TracksCirrus::init()
  ->setClientId($clientId)
  ->setId($trackId)
  ->fetchData();

var_dump($trackVo);
```

As you might notice the tracks data doesn't come with a complete set of user data. If you want to fetch all user details just add ```withCompleteUserData(TRUE)``` to your query:

```php
$trackVo = \Cirrus\Tracks\TracksCirrus::init()
  ->setClientId($clientId)
  ->setId($trackId)
  ->withCompleteUserData(TRUE)
  ->fetchData();
```

As a result you could now access the complete user details by ```$trackVo->getUserVo()```.

# Summary of all possible queries

### 1. User data
**Class:**  
```php
\Cirrus\Users\UsersCirrus
```

**Query:**  
```php
\Cirrus\Users\UsersCirrus::init()
  ->setClientId($clientId)
  ->setId($userId)
  ->fetchData();
```

**Relationships:**
- Tracks: ```withTracksData(TRUE)``` or via ```fetchTracksData()```
- Playlists: ```withPlaylistsData(TRUE)``` or via ```fetchPlaylistsData()```
- Followers: ```withFollowersData(TRUE)``` or via ```fetchFollowersData()```
- Followings: ```withFollowingsData(TRUE)``` or via ```fetchFollowingsData()```
- Favorites: ```withFavoritesData(TRUE)``` or via ```fetchFavoritesData()```

### 2. Track data
**Class:**
```php
\Cirrus\Tracks\TracksCirrus
```

**Query:**  
```php
\Cirrus\Users\TracksCirrus::init()
  ->setClientId($clientId)
  ->setId($trackId)
  ->fetchData();
```

**Relationships:**
- User data: ```withCompleteUserData(TRUE)```

### 3. Playlist data
**Class:**
```php
\Cirrus\Tracks\PlaylistsCirrus
```

**Query:**  
```php
\Cirrus\Users\PlaylistsCirrus::init()
  ->setClientId($clientId)
  ->setId($playlistId)
  ->fetchData();
```

**Relationships:**
- User data: ```withCompleteUserData(TRUE)```

# Artwork & Avatar image sizes
Soundcloud offers a couple of image sizes for track artwork- and user avatars.

```php
array(
  'original' => 'original',
  '500'      => 't500x500',
  '400'      => 'crop',
  '300'      => 't300x300',
  '100'      => 'large',
  '67'       => 't67x67',
  '47'       => 'badge',
  '32'       => 'small',
  '20'       => 'tiny_artworks', // only artworks
  '18'       => 'tiny_avatars',  // only avatars
  '16'       => 'mini',
);
```

Soundcloud's default size is set to ```large```. To choose from one of the above listed sizes you can make use of ```\Cirrus\Cirrus::getImageUrlBySize($imageUrl, $size)```.

### User avatar
```php
require __DIR__ . '/../vendor/autoload.php';

$clientId = '[YOUR API KEY]';
$userId = 428623;

$userVo = \Cirrus\Users\UsersCirrus::init()
  ->setClientId($clientId)
  ->setId($userId)
  ->fetchData();

// set image size to 400x400
\Cirrus\Cirrus::getImageUrlBySize($userVo->getUrlAvatar(), 400); // http://i1.sndcdn.com/avatars-000000788968-kgr595-crop.jpg?e2f8ae2
```

### Track artwork
```php
require __DIR__ . '/../vendor/autoload.php';

$clientId = '[YOUR API KEY]';
$trackId = 64321366;

$trackVo = \Cirrus\Tracks\TracksCirrus::init()
  ->setClientId($clientId)
  ->setId($trackId)
  ->fetchData();

// set image size to original size
\Cirrus\Cirrus::getImageUrlBySize($trackVo->getUrlAvatar(), 'original'); // http://i1.sndcdn.com/artworks-000032638740-ttuwkl-original.jpg?e2f8ae2
```

# Anything else?
Still in doubt how to use this library? Have a look at the ```test``` folder. I included there examples for all fetchable data. Make sure that you rename the ```config.php.dist``` to ```config.php```. And don't forget to put your API Key.

# License
Cirrus is freely distributable under the terms of the MIT license.

Copyright (c) 2012 Tino Ehrich ([opensource@efides.com](mailto:opensource@efides.com))

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.