<?php

class DatabaseHelper
{
    const username = 'a12127140';
    const password = 'Lami1DBS22'; 
    const con_string = '//oracle19.cs.univie.ac.at:1521/orclcdb';

    protected $conn;

    public function __construct()
    {
        try {
            $this->conn = oci_connect(
                DatabaseHelper::username,
                DatabaseHelper::password,
                DatabaseHelper::con_string
            );

            if (!$this->conn) {
                die("DB error: Connection can't be established!");
            }

        } catch (Exception $e) {
            die("DB error: {$e->getMessage()}");
        }
    }

    public function __destruct()
    {
        oci_close($this->conn);
    }

    public function selectAllFotografen($id, $nachname, $vorname)
    {
        if(empty($id)){
            $sql = "SELECT * FROM fotograf
            WHERE id LIKE '%{$id}%'
              AND upper(nachname) LIKE upper('%{$nachname}%')
              AND upper(vorname) LIKE upper('%{$vorname}%')
            ORDER BY ID ASC";
        }
        else{
            $sql = "SELECT * FROM fotograf
            WHERE id = $id
              AND upper(nachname) LIKE upper('%{$nachname}%')
              AND upper(vorname) LIKE upper('%{$vorname}%')
            ORDER BY ID ASC";
        }
        $statement = oci_parse($this->conn, $sql);
        oci_execute($statement);
        oci_fetch_all($statement, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        oci_free_statement($statement);
        return $res;
    }

    public function insertFotograf($vorname, $nachname)
    {
        $sql = "INSERT INTO fotograf VALUES (DEFAULT, '{$vorname}', '{$nachname}', DEFAULT)";
        $statement = oci_parse($this->conn, $sql);
        $success = oci_execute($statement) && oci_commit($this->conn);
        oci_free_statement($statement);
        return $success;
    }
    
    public function deleteFotograf($id)
    {
        $errorcode = 0;
        $sql = 'BEGIN P_DELETE_FOTOGRAF(:id, :errorcode); END;';
        $statement = oci_parse($this->conn, $sql);
        oci_bind_by_name($statement, ':id', $id);
        oci_bind_by_name($statement, ':errorcode', $errorcode);
        oci_execute($statement);
        //oci_commit($statement); 
        oci_free_statement($statement);
        return $errorcode;
    }

    // Objektiv
    public function selectAllObjektiv($objnr, $min_blende, $max_blende)
    {
        $sql = "SELECT * FROM objektiv";
        empty($objnr) ? $sql .= " WHERE objnr LIKE '%{$objnr}%'" : $sql .=" WHERE objnr = $objnr";
        empty($min_blende) ? $sql .= " AND min_blende LIKE '%{$min_blende}%'" : $sql .= " AND min_blende = $min_blende";
        empty($max_blende) ? $sql .= " AND max_blende LIKE '%{$max_blende}%'" : $sql .= " AND max_blende = $max_blende";
        $sql .= " ORDER BY OBJNR ASC";

        $statement = oci_parse($this->conn, $sql);
        oci_execute($statement);
        oci_fetch_all($statement, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        oci_free_statement($statement);
        return $res;
    }

    public function insertObjektiv($min_blende, $max_blende)
    {
        if ($max_blende < $min_blende)
            return 0;
        $sql = "INSERT INTO objektiv VALUES (DEFAULT, '{$min_blende}', '{$max_blende}')";
        $statement = oci_parse($this->conn, $sql);
        $success = oci_execute($statement) && oci_commit($this->conn);
        oci_free_statement($statement);
        return $success;
    }

    public function deleteObjektiv($objnr)
    {
        $errorcode = 0;
        $sql = 'BEGIN P_DELETE_OBJEKTIV(:objnr, :errorcode); END;';
        $statement = oci_parse($this->conn, $sql);
        oci_bind_by_name($statement, ':objnr', $objnr);
        oci_bind_by_name($statement, ':errorcode', $errorcode);
        oci_execute($statement);
        oci_free_statement($statement);
        return $errorcode;
    }


    // Kamera
    public function selectAllKamera($kameranr, $typ, $aufloesungen)
    {
        $sql = "SELECT * FROM kamera";
        empty($kameranr) ? $sql .= " WHERE kameranr LIKE '%{$kameranr}%'" : $sql .=" WHERE kameranr = $kameranr";
        empty($typ) ? : $sql .= " AND upper(typ) LIKE upper('%{$typ}%')";
        empty($aufloesungen) ? $sql .= " AND aufloesungen LIKE '%{$aufloesungen}%'" : $sql .= " AND aufloesungen <= $aufloesungen";
        $sql .= " ORDER BY KAMERANR ASC";

        $statement = oci_parse($this->conn, $sql);
        oci_execute($statement);
        oci_fetch_all($statement, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        oci_free_statement($statement);
        return $res;
    }

    public function insertKamera($typ, $aufloesungen)
    {
        $sql = "INSERT INTO kamera VALUES (DEFAULT, '{$typ}' , '{$aufloesungen}')";
        $statement = oci_parse($this->conn, $sql);
        $success = oci_execute($statement) && oci_commit($this->conn);
        oci_free_statement($statement);
        return $success;
    }

    public function updateKamera($kameranr, $aufloesungen)
    {
        $sql = "UPDATE kamera
            SET aufloesungen = $aufloesungen
            WHERE kameranr LIKE $kameranr ";

        $statement = oci_parse($this->conn, $sql);
        $success = oci_execute($statement) && oci_commit($this->conn);
        oci_free_statement($statement);
        return $success;
    }


    // Sony
    public function selectAllSony($kameranr, $farbe, $zustand, $typ, $aufloesungen)
    {
        $sql = "SELECT * FROM sony_is_a";
        empty($kameranr) ? $sql .= " WHERE kameranr LIKE '%{$kameranr}%'" : $sql .=" WHERE kameranr = $kameranr";
        empty($typ) ?  : $sql .= " AND upper(typ) LIKE upper('%{$typ}%')";
        empty($aufloesungen) ?  : $sql .= " AND aufloesungen <= $aufloesungen";
        empty($farbe) ?  : $sql .= " AND upper(farbe) LIKE upper('%{$farbe}%')";
        empty($zustand) ? : $sql .= " AND upper(zustand) LIKE upper('%{$zustand}%')";
        $sql .= " ORDER BY KAMERANR ASC";

        $statement = oci_parse($this->conn, $sql);
        oci_execute($statement);
        oci_fetch_all($statement, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        oci_free_statement($statement);
        return $res;
    }


    // Haben
    public function selectAllHaben($id, $kameranr, $objnr)
    {
        $sql = "SELECT * FROM haben";
        empty($id) ? $sql .= " WHERE id LIKE '%{$id}%'" : $sql .=" WHERE id = $id";
        empty($kameranr) ?  : $sql .= " AND kameranr = $kameranr";
        empty($objnr) ?  : $sql .= " AND objnr = $objnr";
        $sql .= " ORDER BY ID";

        $statement = oci_parse($this->conn, $sql);
        oci_execute($statement);
        oci_fetch_all($statement, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        oci_free_statement($statement);
        return $res;
    }


    // Zeigen
    public function selectAllZeigen($modelnr, $kennzahl, $id)
    {
        $sql = "SELECT * FROM zeigen";
        empty($id) ? $sql .= " WHERE id LIKE '%{$id}%'" : $sql .=" WHERE id = $id";
        empty($modelnr) ?  : $sql .= " AND modelnr = $modelnr";
        empty($kennzahl) ?  : $sql .= " AND kennzahl = $kennzahl";
        $sql .= " ORDER BY ID, KENNZAHL, MODELNR";

        $statement = oci_parse($this->conn, $sql);
        oci_execute($statement);
        oci_fetch_all($statement, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        oci_free_statement($statement);
        return $res;
    }

    
    // Fotos
    public function selectAllFoto($kennzahl, $id, $exposition, $zeit, $standort)
    {
        $sql = "SELECT * FROM foto";
        empty($id) ? $sql .= " WHERE id LIKE '%{$id}%'" : $sql .=" WHERE id = $id";
        empty($kennzahl) ?  : $sql .= " AND kennzahl = $kennzahl";
        empty($standort) ?  : $sql .= " AND upper(standort) LIKE upper('%{$standort}%')";
        empty($exposition) ?  : $sql .= " AND exposition = $exposition";
        $sql .= " ORDER BY ID ASC, KENNZAHL";

        $statement = oci_parse($this->conn, $sql);
        oci_execute($statement);
        oci_fetch_all($statement, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        oci_free_statement($statement);
        return $res;
    }

    public function countFoto($standort)
    {
        $count = 0;
        $sql = 'BEGIN P_COUNT_FOTO(:standort, :count); END;';
        $statement = oci_parse($this->conn, $sql);

        //  Bind the parameters
        oci_bind_by_name($statement, ':standort', $standort);
        oci_bind_by_name($statement, ':count', $count);

        oci_execute($statement);
        oci_free_statement($statement);
        return $count;
    }

    public function updateFoto($id, $kennzahl, $exposition) 
    {
        $sql = "UPDATE foto
            SET exposition = $exposition
            WHERE kennzahl LIKE $kennzahl
            AND id LIKE $id";

        $statement = oci_parse($this->conn, $sql);
        $success = oci_execute($statement) && oci_commit($this->conn);
        oci_free_statement($statement);
        return $success;
    }

    // Model
    public function selectAllModel($modelnr, $alter, $geschlecht)
    {
        $sql = "SELECT * FROM model";
        empty($modelnr) ? $sql .= " WHERE modelnr LIKE '%{$modelnr}%'" : $sql .=" WHERE modelnr = $modelnr";
        empty($alter) ?  : $sql .= " AND \"alter\" = $alter";
        empty($geschlecht) ?  : $sql .= " AND upper(geschlecht) LIKE upper('%{$geschlecht}%')";
        $sql .= " ORDER BY MODELNR";

        $statement = oci_parse($this->conn, $sql);
        oci_execute($statement);
        oci_fetch_all($statement, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        oci_free_statement($statement);
        return $res;
    }

    
}
