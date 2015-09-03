To download the project "market" and to run it on your local server
follow the steps below 

<br>
1. $ git clone git@github.com:ara-martirossyan/market.git
<br>
2. $ composer global require "fxp/composer-asset-plugin:~1.0.0"
<br>
3. then put composer.phar into market folder manualy 
<br>
4. $ php composer.phar update (this will update vendor according to composer.json)
<br>
5. create market database manualy
<br>
6. $ yii migrate
<br>
7. go to market.com and sign up
<br>
8. to have access to the backend.market.com open phpMyAdmin and change the role from 10(user) to 30(super user) or to 20(admin)
