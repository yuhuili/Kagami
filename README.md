# Kagami

![Yuhui Li](https://githubtools.yuhuili.com/kagami/yuhuili/Yuhui%20Li/)

Kagami (鏡) is a GitHub nameplate generator built in PHP.

## Setup
- Place `process.php` and `resources` folder inside the same directory, this readme assumes such directory is `kagami` under the site root
- Add the following to .htaccess so 404 goes to process.php, make sure the process.php is linked with absolute path
```
<IfModule mod_rewrite.c>
RewriteEngine On
ErrorDocument 404 /kagami/process.php
</IfModule>

DirectoryIndex process.php

Options -Indexes
```

- Add a folder named `cache` under same directory, generated images will be cached here
- Change configuration in `process.php` to fit your environment if needed
  - `$num_dir_from_root` Number of nested directory counted from site root
  - `$cache_dir` Cached images directory
  - `$restricted` To filter allowed users

## Usage
![Yuhui Li Lab](https://githubtools.yuhuili.com/kagami/yuhuili-lab/Yuhui%20Li%20Lab)

```
https://your-domain.com/kagami/GITHUB_USERNAME/NAME
```

![Yuhui Li](https://githubtools.yuhuili.com/kagami/yuhuili/Yuhui%20Li/)

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;To recolor icon to white for better apperance on top of a black background, add an extra slach at the end, this will trigger the recoloring process.

```
https://your-domain.com/kagami/GITHUB_USERNAME/NAME/
```

## Notes
- Cached images need to be manually deleted for new generation to occur. Kagami indicates whether or not if an image is from cache by sending an extra header `Kagami: New Image` or `Kagami: Cache`
