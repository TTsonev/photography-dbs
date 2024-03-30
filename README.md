ER Diagram


Requirements Analysis & Conceptual Design
Einem Fotoklub gehören Fotografen an. Jeder Fotograf hat einen Namen, einen Vornamen und ein eindeutiges ID. Einer von ihnen ist der Klubdirektor, der die anderen leitet. Fotografen haben eine Kamera und (eventuell mehrere) Objektive. Ein Objektiv hat eine eindeutige Objektivnummer, eine minimale und eine maximale Blendenöffnung. Kameras werden durch eine Kameranummer identifiziert und haben einen Typ (entweder DSLR, mirrorless, analog oder instant) und eine Anzahl an Auflösungen. Sony-Kameras haben zusätzlich einen Zustand (gut, mittelmäßig oder schlecht) und eine Frabe (schwarz, grau oder weiß). Fotographen machen Fotos. Fotos haben eine Kennzahl, die nur innerhalb der persönlichen Gallerie eines Fotografen eindeutig ist, einen Expostionswert (zw. -3 und +3), eine Zeit und einen Standort. Auf manchen Fotos sind ein oder mehrere Models abgebildet. Diese haben eine eindeutige Modelnummer, Alter, Geschlecht (W/M) und können eventuell in mehreren Fotos abgebildet werden.


Logical Design
Fotograf(ID, Vorname, Name, Leiter)
PK: ID
FK: Leiter ◊ Fotograf.ID

Objektiv(ObjNr, min_Blende, max_Blende)
PK: ObjNr

Kamera(KameraNr, Typ, Aufloesungen)
PK: KameraNr

Sony_Kamera(KameraNr, Modell, Zustand)
PK: KameraNr
FK: KameraNr ◊ Kamera.KameraNr

Haben(ObjNr, ID, KameraNr)
PK: {ObjNr, ID}
FK: ObjNr ◊ Objektiv.ObjNr
FK: ID ◊ Fotograf.ID
FK: KameraNr ◊ Kamera.KameraNr
UNIQUE: (ObjektivNr, KameraNr)

Foto(Kennzahl, ID, Exposition, Zeit, Standort)
PK: {Kennzahl, ID}
FK: ID ◊ Fotograf.ID

Model(PersonalNr, Jahre, Geschlecht)
PK: PersonalNr

Zeigen(PersonalNr, Kennzahl, ID)
PK: {PersonalNr, Kennzahl, ID}
FK: PersonalNr ◊ Model.PersonalNr
FK: Kennzahl ◊ Foto.Kennzahl
FK: ID ◊ Foto.ID
 Implementation
Java
FotoklubCLI.java – Command Line Interface zur Befüllung der Datenbank. Ausführung mit:
 - default / keine Parameter : befüllt die Tabellen automatisch mit vielen Daten
- sreport : gibt die Anzahl der Tupel in jeder Tabelle aus
o
 fotograf <vorame> <nachname> : inserts einen Fotografen mit den übergebenen Namen
java FotoklubCLI fotograf John Johnson
o
 objektiv <minBlende> <maxBlende>
java FotoklubCLI objektiv 1.2 3.6
o
 kamera <typ> <aufloesungen>
java FotoklubCLI kamera DSLR 21000
o
 sony <typ> <aufloesungen> <zustand> <farbe>: inserts Kamera + Sony_Kamera
java FotoklubCLI sony Mirrorless 12000 gut schwarz
o
 haben <id> <kameranr> <objektivnr>
java FotoklubCLI haben 1 101200 202000
o
 model <alter> <geschlecht>
java FotoklubCLI model 19 W
o
 foto <kennzahl> <id> <exp> <zeit> <standort>
java FotoklubCLI foto 21 1 -3 "12.11.2022" Wien
o
 zeigen <modelnr> <kennzahl> <id>
java FotoklubCLI zeigen 1001 12 1
o
 leiter: gibt das ID des Leiters aus
o
 leiter <ID>: setzt einen anderen Fotografen als Leiter
java FotoklubCLI leiter 32
DatabaseHelper.java:
- Verbindindung mit der Datenbank
- Ausführung der Befehle aus dem CLI
- Precomplied Anweisungen + ggf. Batch Excecution zur besseren Perfromance
names.txt / surnames.txt – Textdateien mit Listen von Vor- bzw. Nachnamen, die bei der
automatisierten Befüllung eingelesen werden.
Issues: FotklubCLI und DatabaseHelper funktionieren problemlos in IntelliJ nach Importieren vom
ojdbc11.jar (wie in der Moodle-Wiki), aber sind manchmal bei manueller Ausführung mit –classpath
problematisch.
- 3 -
Databasesystems Project
TSONEV, Trayan, 12127140
PHP
index.php – Hauptseite
DatabaseHelper.php – Verbindung zur Datenbank, Funktionalität
countFoto.php – ruft die countFoto-Funktion aus DatabaseHelper bzw. die p_count_foto
Prozedur an mit Parameter $standort (Zeichenkette) und gibt aus (echo) wie viele der Fotos
(Integer) aus diesem Standort sind
add___.php – ruft die entsprechende Funktion aus DatabaseHelper mit den übergegebenen
Parametern an, versucht ein INSERT-Statements auszuführen und gibt eine Erfolg-/Fehlermeldung
aus
updateKamera.php – ruft die updateKamera-Funktion aus DatabaseHelper an und setzt die
Auflösungen der Kamera mit PK $kameranr auf $aufloesungen bzw. auf 200000, falls
$aufloesungen größer ist (mittels Trigger trig_kamera_auf)
updateFoto.php – ruft die updateFoto-Funktion aus DatabaseHelper an und setzt die Exposition des
Fotos mit PK ($id, $kennzahl) auf $exposition
delete___.php – ruft die entsprechende Funktion aus DatabaseHelper mit den übergegebenen
Parametern an, versucht ein DELETE-Statements auszuführen und gibt eine Erfolg-/Fehlermeldung
aus
style.css – CSS Stylesheet
flaticon-camera.png – Favicon, Quelle: flaticon.com
dan-k-i0hKLkbNzoU-unsplash.jpeg: –Background image, Quelle: unsplash.com
