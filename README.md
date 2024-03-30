![ER Diagram](https://github.com/TTsonev/photography-dbs/blob/main/ER.png)

### Logical Design
**Fotograf**(ID, Vorname, Name, Leiter)
- PK: ID
- FK: Leiter ◊ Fotograf.ID

**Objektiv**(ObjNr, min_Blende, max_Blende)
- PK: ObjNr

**Kamera**(KameraNr, Typ, Aufloesungen)
- PK: KameraNr

**Sony_Kamera**(KameraNr, Modell, Zustand)
- PK: KameraNr
- FK: KameraNr ◊ Kamera.KameraNr

**Haben**(ObjNr, ID, KameraNr)
- PK: {ObjNr, ID}
- FK: ObjNr ◊ Objektiv.ObjNr
- FK: ID ◊ Fotograf.ID
- FK: KameraNr ◊ Kamera.KameraNr
- UNIQUE: (ObjektivNr, KameraNr)

**Foto**(Kennzahl, ID, Exposition, Zeit, Standort)
- PK: {Kennzahl, ID}
- FK: ID ◊ Fotograf.ID

**Model**(PersonalNr, Jahre, Geschlecht)
- PK: PersonalNr

**Zeigen**(PersonalNr, Kennzahl, ID)
- PK: {PersonalNr, Kennzahl, ID}
- FK: PersonalNr ◊ Model.PersonalNr
- FK: Kennzahl ◊ Foto.Kennzahl
- FK: ID ◊ Foto.ID
