#!/bin/sh

cd /var/www/html/toocle/intl/prog/crontab/

php mkpage.php build_en_index
php mkpage.php build_cn_index
php mkpage.php build_jp_index
php mkpage.php build_kr_index
php mkpage.php build_ru_index
php mkpage.php build_vn_index
php mkpage.php build_fr_index
php mkpage.php build_sp_index
php mkpage.php build_las_index
php mkpage.php build_it_index

php mkpage.php build_en_product
php mkpage.php build_cn_product
php mkpage.php build_jp_product
php mkpage.php build_kr_product
php mkpage.php build_ru_product
php mkpage.php build_vn_product
php mkpage.php build_fr_product
php mkpage.php build_sp_product
php mkpage.php build_las_product
php mkpage.php build_it_product




