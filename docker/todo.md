/etc/apache2/sites-enabled/vhosts.conf

<VirtualHost *:80>
ServerName filyasyontakip.com
ProxyRequests Off
ProxyPreserveHost On
# ProxyPass /  http://127.0.0.1:8080/
    #ProxyPassReverse / http://127.0.0.1:8080/
<Location />
                ProxyPass http://localhost:80/
                ProxyPassReverse http://localhost:80/
                Order allow,deny
                Allow from all
        </Location>
</VirtualHost>


sudo certbot --apache
remote acces to mysql
bind-address            = 0.0.0.0
ufw allow 3306
