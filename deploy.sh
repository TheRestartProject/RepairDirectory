# script for remote deployment when deploying via FTP
unzip -o repairmap.zip -d public_html/repairmap \
    && cat auth.htaccess public_html/repairmap/public/.htaccess > temp && mv temp public_html/repairmap/public/.htaccess \
    && cp -r public_html/repairmap/public public_html/public/map \
    && sed -i 's|/../bootstrap/|/../../repairmap/bootstrap/|' public_html/public/map/index.php \
    && cp -r public_html/repairmap/public/css/map/ public_html/public/css/ \
    && cp -r public_html/repairmap/public/js/map/ public_html/public/js/ \
    && cp -r public_html/repairmap/public/images/map/ public_html/public/images/ \
    && cp -r public_html/repairmap/public/fonts/* public_html/public/fonts/
