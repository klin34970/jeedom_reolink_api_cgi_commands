<div class="content">Bonjour à tous !<br>
Je voulais partager avec vous la façon dont j'utilise Reolink dans Domoticz.<br>
<br>
<br>
Je ne connaissais pas Reolink auparavant, je cherchais Dlink, Hikvision, Foscam, etc. et j'ai vu le Reolink RLC-420 (pack de 2).<br>
Pour le prix, elles sont vraiment biens et franchement elles font le job.<br>
Comme vous pouvez le voir, j'en ai acheté 4.<br>
<img src="doc/img/Plan.png" class="postimage" alt="Image"><br>
<br>
Je cherchais les commandes CGI et n'ai trouvé que ceci:<br>
How to Capture Live JPEG Image of Reolink Cameras via Web Browsers : <a href="https://support.reolink.com/hc/en-us/articles/360007011233-How-to-Capture-Live-JPEG-Image-of-Reolink-Cameras-via-Web-Browsers" class="postlink">https://support.reolink.com/hc/en-us/ar ... b-Browsers</a><br>
<br>
<br>
<span style="font-size:150%;line-height:116%">Je vais vous montrer comment utiliser toutes les commandes cgi.</span><br>
<br>
<strong class="text-strong"><span style="text-decoration:underline">Introduction</span></strong><br>
<strong class="text-strong">D'abord, vous avez besoin d'un jeton d'authentification (token).</strong>
<div class="codebox"><p>Code&nbsp;: <a href="#" onclick="selectCode(this); return false;">Tout sélectionner</a></p><pre><code>url = cgi-bin/api.cgi?cmd=Login&amp;token=null
payload = [{"cmd":"Login","action":0,"param":{"User":{"userName":"youruser","password":"yourpassword"}}}]</code></pre></div>

Lorsque vous avez le jeton, vous pouvez faire ce que vous voulez.<br>
Exemple:
<div class="codebox"><p>Code&nbsp;: <a href="#" onclick="selectCode(this); return false;">Tout sélectionner</a></p><pre><code>url = cgi-bin/api.cgi?cmd=SetAlarm&amp;token=azeazeaz65454
payload = [{"cmd":"SetAlarm","action":1,"param":{"Alarm":{"channel":0,"type":"md","sens":[{"beginHour":0,"endHour":23,"beginMin":0,"endMin":59,"id":0,"sensitivity":21},{"beginHour":23,"endHour":23,"beginMin":59,"endMin":59,"id":1,"sensitivity":21},{"beginHour":23,"endHour":23,"beginMin":59,"endMin":59,"id":2,"sensitivity":21},{"beginHour":23,"endHour":23,"beginMin":59,"endMin":59,"id":3,"sensitivity":21}]}}}]</code></pre></div>

Vous pouvez obtenir l'URL et le payload  avec la console du navigateur pour n'importe quels paramètres/commandes.<br>
<img src="doc/img/Reolink-Console.jpg" class="postimage" alt="Image"><br>
<br>
<strong class="text-strong"><span style="text-decoration:underline">Script</span></strong><br>
<span style="font-size:150%;line-height:116%">Script PHP pour activer / désactiver les e-mails et les notifications push: </span><a href="https://drive.google.com/open?id=1b-2iuqtYMRAOWp-CCSKzk8hOGqW-T4vu" class="postlink">https://drive.google.com/open?id=1b-2iu ... hOGqW-T4vu</a><br>
Ce script est fait pour mon usage et codé en 5min. Vous pouvez utiliser d'autres technologies et/ou l'améliorer pour vous. D'abord, je ne voulais que des notifications par courrier électronique et, dans un deuxième temps, j'ai ajouté des notifications push.<br>
<br>
<br>
<strong class="text-strong"><span style="text-decoration:underline">Practice</span></strong><br>
<span style="font-size:150%;line-height:116%">Comment j'utilise mon script sur Domoticz.</span><br>
<br>
Mon domoticz est installé sur mon syno, donc mon apache aussi.<br>
Je peux accéder à mon script par URL:<br>

<div class="codebox"><p>Code&nbsp;: <a href="#" onclick="selectCode(this); return false;">Tout sélectionner</a></p><pre><code>Turn on email
http://yoursynologyip:apacheport/?ip=ipofthecamera&amp;method=enableMotionEmail&amp;action=1
Turn off email
http://yoursynologyip:apacheport/?ip=ipofthecamera&amp;method=enableMotionEmail&amp;action=0
</code></pre></div>

<span style="font-size:85%;line-height:116%">yoursynologyip = l'ip de votre serveur syno ou apache si votre apache n'est pas sur votre syno.<br>
apacheport = apache port.<br>
ipofthecamera = ip de la caméra, vous devez associer l'adresse MAC à une adresse IP statique.</span><br>
<br>
<br>
Créer un switch virtuel on/off et mettre l'URL sur Action on et off<br>
<img src="doc/img/Create-Virtual.png" class="postimage" alt="Image"><br>
<br>
Maintenant vous pouvez faire ce que vous voulez.<br>
Lorsque je quitte ma maison, toutes les notifications des caméras s'activent par GPS ou par scénario.<br>
Idem quand je rentre à la maison.</div>

<img src="doc/img/Emplacement.png" class="postimage" alt="Image"><br>
<img src="doc/img/Scripts.png" class="postimage" alt="Image"><br>
<img src="doc/img/Scripts-Commands.png" class="postimage" alt="Image"><br>
<img src="doc/img/Virtuals-Commands.png" class="postimage" alt="Image"><br>
