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
Soundcloud API Library to fetch and process data about users, tracks and playlists.

### Any dependencies?
Cirrus comes as an [composer](http://getcomposer.org/) package.  
Requirements are >= PHP 5.3, its CURL extension and a [CURL handler class](https://github.com/fightbulc/php_curl).  

Further, you need an API key from Soundcloud. [Register here](http://soundcloud.com/you/apps).

### Setup
- Download
- Run ```composer install```
- Start hacking

# Structure
All fetched results are wrapped in *value object* classes.
This means that you can access all response values by method call.  
```php
// print the username
echo $userVo->getUsername();

// or lets get all tracks from the user
// and then the title from the first track
$tracksVo = $userVo->getTracksVo();
echo $tracksVo[0]->getTitle();
````

In general VOs enable us to maintain our code much better.  
Especially if we dont have any influence on our reference as its the case with soundcloud's API.

More info? [Read on](http://jmatter.org/articles/2006/08/04/tip-of-the-week-value-objects).

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

**Expected response:**
```php
object(Cirrus\Users\UserVo)#3 (1) {
  ["_data":protected]=>
  array(21) {
    ["id"]=>
    int(428623)
    ["kind"]=>
    string(4) "user"
    ["permalink"]=>
    string(15) "laps-digitaline"
    ["username"]=>
    string(17) "LAPS / DIGITALINE"
    ["uri"]=>
    string(38) "http://api.soundcloud.com/users/428623"
    ["permalink_url"]=>
    string(37) "http://soundcloud.com/laps-digitaline"
    ["avatar_url"]=>
    string(66) "http://i1.sndcdn.com/avatars-000000788968-kgr595-large.jpg?e2f8ae2"
    ["country"]=>
    string(7) "Germany"
    ["full_name"]=>
    string(7) "Laurent"
    ["description"]=>
    string(0) ""
    ["city"]=>
    string(6) "Berlin"
    ["discogs_name"]=>
    string(15) "Laps+Digitaline"
    ["myspace_name"]=>
    string(14) "lapsdigitaline"
    ["website"]=>
    NULL
    ["website_title"]=>
    NULL
    ["online"]=>
    bool(false)
    ["track_count"]=>
    int(5)
    ["playlist_count"]=>
    int(1)
    ["public_favorites_count"]=>
    int(0)
    ["followers_count"]=>
    int(845)
    ["followings_count"]=>
    int(80)
  }
}
```

**How to get e.g. a user's full name:**
```php
// user's full name
echo $userVo->getFullName();

// or get all data for this user as an array
var_dump($userVo->getData());
```

### 2. Get user data and its relations
You can determine which relation data should be fetched as well. Its up to you which data you would like to fetch.
See below all possible options.

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
  ->fetchData();

var_dump($userVo);
```

### 3. Get only relationship data from a user
You could also just get e.g. tracks by a user's id.

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

**Expected response:**
```php
object(Cirrus\Tracks\TrackVo)#3 (1) {
  ["_data":protected]=>
  array(43) {
    ["kind"]=>
    string(5) "track"
    ["id"]=>
    int(64321366)
    ["created_at"]=>
    string(25) "2012/10/22 04:02:56 +0000"
    ["user_id"]=>
    int(55607)
    ["duration"]=>
    int(326090)
    ["commentable"]=>
    bool(true)
    ["state"]=>
    string(8) "finished"
    ["original_content_size"]=>
    int(86261404)
    ["sharing"]=>
    string(6) "public"
    ["tag_list"]=>
    string(0) ""
    ["permalink"]=>
    string(8) "kareemix"
    ["streamable"]=>
    bool(true)
    ["embeddable_by"]=>
    string(3) "all"
    ["downloadable"]=>
    bool(false)
    ["purchase_url"]=>
    NULL
    ["label_id"]=>
    NULL
    ["purchase_title"]=>
    NULL
    ["genre"]=>
    string(0) ""
    ["title"]=>
    string(8) "Kareemix"
    ["description"]=>
    string(26) "Remix Kareem & Cem Orlow!!"
    ["label_name"]=>
    string(0) ""
    ["release"]=>
    string(0) ""
    ["track_type"]=>
    string(0) ""
    ["key_signature"]=>
    string(0) ""
    ["isrc"]=>
    string(0) ""
    ["video_url"]=>
    NULL
    ["bpm"]=>
    NULL
    ["release_year"]=>
    NULL
    ["release_month"]=>
    NULL
    ["release_day"]=>
    NULL
    ["original_format"]=>
    string(3) "wav"
    ["license"]=>
    string(19) "all-rights-reserved"
    ["uri"]=>
    string(41) "http://api.soundcloud.com/tracks/64321366"
    ["user"]=>
    array(7) {
      ["id"]=>
      int(55607)
      ["kind"]=>
      string(4) "user"
      ["permalink"]=>
      string(7) "ka_reem"
      ["username"]=>
      string(17) "Kareem (OFFICIAL)"
      ["uri"]=>
      string(37) "http://api.soundcloud.com/users/55607"
      ["permalink_url"]=>
      string(29) "http://soundcloud.com/ka_reem"
      ["avatar_url"]=>
      string(66) "http://i1.sndcdn.com/avatars-000006357671-als3sx-large.jpg?e2f8ae2"
    }
    ["permalink_url"]=>
    string(38) "http://soundcloud.com/ka_reem/kareemix"
    ["artwork_url"]=>
    string(67) "http://i1.sndcdn.com/artworks-000032638740-ttuwkl-large.jpg?e2f8ae2"
    ["waveform_url"]=>
    string(39) "http://w1.sndcdn.com/Z5M4qTshGRvw_m.png"
    ["stream_url"]=>
    string(48) "http://api.soundcloud.com/tracks/64321366/stream"
    ["playback_count"]=>
    int(69)
    ["download_count"]=>
    int(0)
    ["favoritings_count"]=>
    int(1)
    ["comment_count"]=>
    int(0)
    ["attachments_uri"]=>
    string(53) "http://api.soundcloud.com/tracks/64321366/attachments"
  }
}
```

As you might notice the tracks data doesn't come with the complete user data.  
If you want to fetch all user details just fetch them as the following example shows:

```php
$trackVo = \Cirrus\Tracks\TracksCirrus::init()
  ->setClientId($clientId)
  ->setId($trackId)
  ->withCompleteUserData(TRUE)
  ->fetchData();
```

As a result you could now access the complete user details by ```$trackVo->getUserVo()```.

# Summary of all fetchable data?

### 1. User data
**Class:** \Cirrus\Users\UsersCirrus::init()

Fetchable Relationships:
- Tracks
- Playlists
- Followers
- Followings
- Favorites

### 2. Track data
**Class:** \Cirrus\Tracks\TracksCirrus::init()

Fetchable Relationships:
- Complete user data

### 3. Playlist data
**Class:** \Cirrus\Playlists\PlaylistsCirrus::init()

Fetchable Relationships:
- Complete user data

# Anything else?

Still in doubt how to use this library? Have a look at the ```test``` folder. I included there examples for all fetchable data.

Make sure that you rename the ```config.php.dist``` to ```config.php```. And don't forget to put your API Key.

# License
Cirrus is freely distributable under the terms of the MIT license.

Copyright (c) 2012 Tino Ehrich ([opensource@efides.com](mailto:opensource@efides.com))

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.