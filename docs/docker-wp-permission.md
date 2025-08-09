docker-compose.ymlを作成

```
docker compose up -d
```

コンテナビルド完了後の権限は以下のようになっている
```
wordpress/wp-content$ ls -la


drwxr-xr-x 4 www-data www-data 4096 Aug  9 09:23 .
drwxr-xr-x 5 www-data www-data 4096 Aug  9 09:23 ..
-rw-r--r-- 1 www-data www-data   28 Jan  9  2012 index.php
drwxr-xr-x 3 www-data www-data 4096 Feb  5  2025 plugins
drwxr-xr-x 5 www-data www-data 4096 Dec 21  2024 themes
```
<small>

| 種別 | 所有者 (user) | グループ (group) | その他 (others) |
|------|--------------|------------------|-----------------|
| `-` = ファイル<br>`d` = ディレクトリ<br>`l` = シンボリックリンク | r=4 / w=2 / x=1 | r=4 / w=2 / x=1 | r=4 / w=2 / x=1 |

</small>


ホストでWordPressのファイルを編集するために以下のようにする
所有者をusernameに変更

```
wordpress/wp-content$ sudo chown -R $USER:www-data .

ls -la

drwxr-xr-x 4 username www-data 4096 Aug  9 09:25 .
drwxr-xr-x 5 www-data www-data 4096 Aug  9 09:23 ..
-rw-r--r-- 1 username www-data   28 Jan  9  2012 index.php
drwxr-xr-x 3 username www-data 4096 Feb  5  2025 plugins
drwxr-xr-x 5 username www-data 4096 Dec 21  2024 themes
```

所有者を変更してもWordPress管理画面から操作可能にするため
グループ（www-data）読み書き可能に権限変更


```
sudo find . -type d -exec chmod 2775 {} \;
sudo find . -type f -exec chmod 664 {} \;

ls -la

drwxrwsr-x 4 ida      www-data 4096 Aug  9 09:25 .
drwxr-xr-x 5 www-data www-data 4096 Aug  9 09:23 ..
-rw-rw-r-- 1 ida      www-data   28 Jan  9  2012 index.php
drwxrwsr-x 3 ida      www-data 4096 Feb  5  2025 plugins
drwxrwsr-x 5 ida      www-data 4096 Dec 21  2024 themes

```

<small>

| 種別 | 所有者 (user) | グループ (group) | その他 (others) |
|------|--------------|------------------|-----------------|
| `-` = ファイル<br>`d` = ディレクトリ<br>`l` = シンボリックリンク | r=4 / w=2 / x=1 | r=4 / w=2 / x=1 | r=4 / w=2 / x=1 |

- **setgid (2xxx)** : 新規作成物が親ディレクトリのグループを継承（x が s に） 

</small>