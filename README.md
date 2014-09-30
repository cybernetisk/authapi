authapi
=======

Example of Virtual Host used :

<VirtualHost *:80>
    ServerAdmin apiauth@localhost
    DocumentRoot "C:/xampp/htdocs/authapi"
    ServerName api.test
	<Directory "C:/xampp/htdocs/authapi">
		Order allow,deny
		Allow from all
	</Directory>
</VirtualHost>