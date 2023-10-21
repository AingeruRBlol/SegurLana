# SegurLana

Taldekideak: Aingeru Ruiz, Álvaro Dono, Yeray López eta Unai González.

DOCKER BIDEZ HEDATZEKO INSTRUKZIOAK:

Gure proiektua daukan GitHub biltegia klonatu edo jaitsi:
1. $ git clone https://github.com/AingeruRBlol/SegurLana.git

Aurretik Docker esta Docker-compose instalatuta izanez:

2. $ sudo apt install docker
3. $ sudo apt install docker-compose

Gero, Ubuntu kontsolan:

4. Proiektuaren karpeta barruan kokatu terminalaren bidez (SegurLana barruan).

5. Behin barruan, $ sudo docker build -t="web" . komandoa exekutatu.
   
6. Behin aurreko komando amaituta, docker-compose up komandoa exekutatu.
   
7. PHPMyAdmin-en (http://localhost:8890, erabiltzailea: admin eta pasahitza: test izanez), datu basea inportatu lan karpetako database.sql fitxategia hautatuz.
    
8. Aurreko lau pausoak egindakoan, http://localhost:81 helbidean sartuz gero web orria agertuko da, index.php fitxategia.
    
9. Web orriarekin amaitutakoan, beste terminal bat zabaldu eta docker-compose down komando exekutatu.
