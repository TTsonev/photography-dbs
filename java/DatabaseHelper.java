import java.io.File;
import java.sql.*;
import java.util.ArrayList;
import java.util.Random;
import java.util.Scanner;
import java.util.TreeSet;

class DatabaseHelper {
    private static final String DB_CONNECTION_URL = "...";
    private static final String USER = "...";
    private static final String PASS = "...";
    private static final String CLASSNAME = "oracle.jdbc.driver.OracleDriver";
    private static PreparedStatement prepStmt;
    private static Connection con;

    DatabaseHelper() {
        try {
            Class.forName(CLASSNAME);
            con = DriverManager.getConnection(DB_CONNECTION_URL, USER, PASS);
        }
        catch (Exception e) {
            e.printStackTrace();
        }
    }

    void defaultData() {
        try {
            Scanner s = new Scanner(new File("names.txt"));
            ArrayList<String> names = new ArrayList<String>();
            while (s.hasNext()) {
                names.add(s.next());
            }
            s.close();

            s = new Scanner(new File("surnames.txt"));
            ArrayList<String> surnames = new ArrayList<String>();
            while (s.hasNext()) {
                surnames.add(s.next());
            }
            s.close();

            Random rand = new Random();

            //Fotograf
            String insertFotograf = "INSERT INTO fotograf VALUES (DEFAULT, ?, ?, DEFAULT)";
            prepStmt = con.prepareStatement(insertFotograf);
            for (int i = 0; i < names.size(); i++) {
                prepStmt.setString(1, names.get(i));
                prepStmt.setString(2, surnames.get(i));
                prepStmt.addBatch();
            }
            prepStmt.executeBatch();
            prepStmt.clearParameters();

            //Objektiv
            String insertObj = "INSERT INTO objektiv VALUES(DEFAULT, ?, ?)";
            prepStmt = con.prepareStatement(insertObj);
            for (int i = 0; i < 3000; i++) {
                double blende1 = 1.0 + (rand.nextDouble() * 8.9);
                double blende2 = 1.0 + (rand.nextDouble() * 8.9);
                if (blende1 > blende2) {
                    blende1 += blende2;
                    blende2 = blende1 - blende2;
                    blende1 = blende1 - blende2;
                }
                prepStmt.setDouble(1, blende1);
                prepStmt.setDouble(2, blende2);
                prepStmt.addBatch();
            }
            prepStmt.executeBatch();
            prepStmt.clearParameters();

            //Kamera
            String[] kameras = {"DSLR", "Mirrorless", "Analog", "Instant"};
            String insertKamera = "INSERT INTO kamera VALUES(DEFAULT, ?, ?)";
            prepStmt = con.prepareStatement(insertKamera);
            for (int i = 0; i < 2000; i++) {
                prepStmt.setString(1, kameras[rand.nextInt(kameras.length)]);
                prepStmt.setInt(2, rand.nextInt(200000));
                prepStmt.addBatch();
            }
            prepStmt.executeBatch();
            prepStmt.clearParameters();

            //Sony_Kamera
            String[] zustand = {"gut", "mittelmaessig", "schlecht"};
            String[] colors = {"schwarz", "weiss", "grau"};
            String insertSony = "INSERT INTO sony_kamera VALUES(?, ?, ?)";
            prepStmt = con.prepareStatement(insertSony);
            ResultSet rs = con.prepareStatement("SELECT * FROM Kamera ORDER BY KAMERANR DESC FETCH FIRST 100 ROWS ONLY").executeQuery();
            while (rs.next()) {
                prepStmt.setInt(1,rs.getInt(1));
                prepStmt.setString(2, zustand[rand.nextInt(zustand.length)]);
                prepStmt.setString(3, colors[rand.nextInt(colors.length)]);
                prepStmt.addBatch();
            }
            rs.close();
            prepStmt.executeBatch();
            prepStmt.clearParameters();


            //Flavor
            /*
                Flavor PK (flavor_id, brand_id)

                String[] flavor_list = vanilla, chocolate, ....
                ResultSet brands = SQL...   // contains all entries in the Brand table 
                while (brands.hasnext) {
                    for(5) {
                        thingy 
                            -> flavor_id = default/random
                            -> taste = flavor_list[random number]
                            -> brand_id = brands.getInt(1)      // get brand_id of each entry in Brand
                        INSERT into FLAVOR thingy
                    }
                }

            */

            //Foto
            String[] locations = {"Wien", "Graz", "Salzburg", "Berlin", "Paris", "Madrid", "Barcelona", "Rom", "Sofia", "London", "New York", "Los Angeles", "Oslo", "Helsinki", "Cape Town", "Sydney", "Rio de Janeiro"};
            String insertFoto = "INSERT INTO foto VALUES(?, ?, ?, ?, ?)";
            prepStmt = con.prepareStatement(insertFoto);
            ResultSet ids = con.prepareStatement("SELECT ID FROM fotograf ORDER BY ID").executeQuery();
            while (ids.next()) {
                for (int j = 1; j <= 20; j++) {
                    double exp = -3.0 + (rand.nextDouble() * 6);
                    prepStmt.setInt(1, j);
                    prepStmt.setInt(2, ids.getInt(1));
                    prepStmt.setDouble(3, exp);
                    prepStmt.setTimestamp(4, new Timestamp (
                            Timestamp.valueOf("2010-01-01 00:00:00").getTime() +
                                    (long)(rand.nextDouble() * (Timestamp.valueOf("2022-12-12 00:00:00").getTime() - Timestamp.valueOf("2010-01-01 00:00:00").getTime())))
                    );
                    prepStmt.setString(5, locations[rand.nextInt(locations.length)]);
                    prepStmt.addBatch();
                }
            }
            ids.close();
            prepStmt.executeBatch();
            prepStmt.clearParameters();

            //Model
            char[] gender = {'M', 'W'};
            String insertModel = "INSERT INTO model VALUES(DEFAULT, ?, ?)";
            prepStmt = con.prepareStatement(insertModel);
            for (int i = 0; i < 200; i++) {
                prepStmt.setInt(1, (1 + rand.nextInt(100)));
                prepStmt.setString(2, String.valueOf(gender[rand.nextInt(gender.length)]));
                prepStmt.addBatch();
            }
            prepStmt.executeBatch();
            prepStmt.clearParameters();

            //Haben
            ids = con.prepareStatement("SELECT ID FROM fotograf ORDER BY ID").executeQuery();
            ResultSet kams = con.prepareStatement("SELECT KameraNr FROM kamera ORDER BY KameraNr").executeQuery();
            ResultSet objs = con.prepareStatement("SELECT ObjNr FROM objektiv ORDER BY ObjNr").executeQuery();
            String insertHaben = "INSERT INTO haben VALUES(?, ?, ?)";
            prepStmt = con.prepareStatement(insertHaben);
            if (kams.next()) {} //skip
            if (objs.next()) {}   //skip
            while (ids.next()) {
                if (kams.next()) {
                    for (int i = 0; i < 3; i++) {
                        if (objs.next()) {
                            prepStmt.setInt(1, ids.getInt(1));
                            prepStmt.setInt(2, kams.getInt(1));
                            prepStmt.setInt(3, objs.getInt(1));
                            prepStmt.addBatch();
                        }
                    }
                }
            }

            // 1 Photographer  :   1 Kamera    :   m(3)  Objektive
            // 1 Customer      :   1 Address   :   m(randomly generate m) Orders

            ids.close();
            kams.close();
            objs.close();
            prepStmt.executeBatch();
            prepStmt.clearParameters();

            //Zeigen
            String insertZeigen = "INSERT INTO zeigen VALUES(?, ?, ?)";
            prepStmt = con.prepareStatement(insertZeigen);
            ids = con.prepareStatement("SELECT ID FROM fotograf ORDER BY ID").executeQuery();
            while (ids.next()) {
                TreeSet<Integer> kenzahlen = new TreeSet<Integer>();
                for (int i = 0; i < 5; i++) {
                    kenzahlen.add(1 + rand.nextInt(20));
                }
                for (Integer j : kenzahlen) {
                    int m = 1000 + rand.nextInt(200);
                    prepStmt.setInt(1, m);
                    prepStmt.setInt(2, j);
                    prepStmt.setInt(3, ids.getInt(1));
                    prepStmt.addBatch();
                    if (j % 2 == 0) {
                        int m2 = 1000 + rand.nextInt(200);
                        while (m2 == m) m2 = 1000 + rand.nextInt(200);
                        prepStmt.setInt(1, m2);
                        prepStmt.setInt(2, j);
                        prepStmt.setInt(3, ids.getInt(1));
                        prepStmt.addBatch();
                    }
                }
            }
            ids.close();
            prepStmt.executeBatch();
            prepStmt.clearParameters();

        }
        catch (Exception e) {
            System.err.println("Error: " + e.getMessage() + e.getStackTrace());
        }
    }

    void getLeiter() {
        try {
            ResultSet rs = con.prepareStatement("SELECT COUNT(DISTINCT leiter) FROM fotograf").executeQuery();
            if (rs.next()) {
                int count = rs.getInt(1);
                if (count != 1) {
                    System.err.println("Error: getLeiter");
                    return;
                }
            }
            rs = con.prepareStatement("SELECT leiter FROM fotograf").executeQuery();
            if (rs.next()) {
                int leiterID = rs.getInt(1);
                System.out.println("Leiter hat ID: " + leiterID);
            }
            rs.close();
        }
        catch (Exception e) {
            System.err.println("Error: " + e.getMessage() + e.getStackTrace());
        }
    }

    void setLeiter(String id) {
        try {
            String updateLeiter = "UPDATE fotograf SET leiter =  " + id;
            con.prepareStatement(updateLeiter).executeUpdate();
            getLeiter();
        }
        catch (Exception e) {
            System.err.println("Error: " + e.getMessage());
        }
    }

    void report() {
        try {
            ResultSet rs = con.prepareStatement("SELECT COUNT(*) FROM fotograf").executeQuery();
            if (rs.next()) {
                int count = rs.getInt(1);
                System.out.println("Fotografen: " + count);
            }

            rs = con.prepareStatement("SELECT COUNT(*) FROM objektiv").executeQuery();
            if (rs.next()) {
                int count = rs.getInt(1);
                System.out.println("Objektive: " + count);
            }

            rs = con.prepareStatement("SELECT COUNT(*) FROM kamera").executeQuery();
            if (rs.next()) {
                int count = rs.getInt(1);
                System.out.println("Kameras: " + count);
            }

            rs = con.prepareStatement("SELECT COUNT(*) FROM sony_kamera").executeQuery();
            if (rs.next()) {
                int count = rs.getInt(1);
                System.out.println("Sony Kameras: " + count);
            }

            rs = con.prepareStatement("SELECT COUNT(*) FROM haben").executeQuery();
            if (rs.next()) {
                int count = rs.getInt(1);
                System.out.println("Haben-Beziehungen: " + count);
            }

            rs = con.prepareStatement("SELECT COUNT(*) FROM foto").executeQuery();
            if (rs.next()) {
                int count = rs.getInt(1);
                System.out.println("Fotos: " + count);
            }

            rs = con.prepareStatement("SELECT COUNT(*) FROM model").executeQuery();
            if (rs.next()) {
                int count = rs.getInt(1);
                System.out.println("Models: " + count);
            }

            rs = con.prepareStatement("SELECT COUNT(*) FROM zeigen").executeQuery();
            if (rs.next()) {
                int count = rs.getInt(1);
                System.out.println("Zeigen-Beziehungen: " + count);
            }

            rs.close();
        }
        catch(Exception e) {
            System.err.println("Error: " + e.getMessage());
        }
    }

    public void fotograf(String vorname, String nachname) {
        try {
            String insertFotograf = "INSERT INTO fotograf VALUES (DEFAULT, '" + vorname + "', '" + nachname + "', DEFAULT)";
            con.prepareStatement(insertFotograf).executeUpdate();
        }
        catch (Exception e) {
            System.err.println("Error: " + e.getMessage());
        }
    }

    public void objektiv(String minblende, String maxblende) {
        try {
            String insertObj = "INSERT INTO objektiv VALUES(DEFAULT," + minblende + "," + maxblende + ")";
            con.prepareStatement(insertObj).executeUpdate();
        }
        catch (Exception e) {
            System.err.println("Error: " + e.getMessage());
        }
    }

    public void kamera(String typ, String aufloes) {
        try {
            String insertKamera = "INSERT INTO kamera VALUES(DEFAULT," + "'" + typ + "'" + "," + aufloes + ")";
            con.prepareStatement(insertKamera).executeUpdate();
        }
        catch (Exception e) {
            System.err.println("Error: " + e.getMessage());
        }
    }

    public void sony(String typ, String aufloes, String zustand, String color) {
        try {
            String insertKamera = "INSERT INTO kamera VALUES(DEFAULT," + "'" + typ + "'" + "," + aufloes + ")";
            if (con.prepareStatement(insertKamera).executeUpdate() == 0) {throw new IllegalArgumentException("Sony Type");}
            ResultSet rs = con.prepareStatement("SELECT * FROM Kamera ORDER BY KAMERANR DESC FETCH FIRST 1 ROWS ONLY").executeQuery();
            if (rs.next()) {
                int knr = rs.getInt("KAMERANR");
                String insertSony = "INSERT INTO sony_kamera VALUES(" + knr + ",'" + zustand + "','" + color + "')";
                con.prepareStatement(insertSony).executeUpdate();
            }
            else {
                System.err.println("Error Sony");
            }

        }
        catch (Exception e) {
            System.err.println("Error: " + e.getMessage());
        }
    }

    public void foto(String kennzahl, String id, String exp, String time, String location) {
        try {
            String insertFoto = "INSERT INTO foto VALUES(" + kennzahl + "," + id + "," + exp + ","
                    + "(to_timestamp('" + time + "','DD.MM.YYYY HH24:MI:SS')),'" + location + "')";
            con.prepareStatement(insertFoto).executeUpdate();
        }
        catch (Exception e) {
            System.err.println("Error: " + e.getMessage());
        }
    }

    public void model(String age, String gender) {
        try {
            String insertModel = "INSERT INTO model VALUES(DEFAULT, " + age + ",'" + gender + "')";
            con.prepareStatement(insertModel).executeUpdate();
        }
        catch (Exception e) {
            System.err.println("Error: " + e.getMessage());
        }
    }

    public void haben(String id, String kamera, String objektiv) {
        try {
            String insertHaben = "INSERT INTO haben VALUES(" + id + "," + kamera + "," + objektiv + ")";
            con.prepareStatement(insertHaben).executeUpdate();
        }
        catch (Exception e) {
            System.err.println("Error: " + e.getMessage());
        }
    }

    public void zeigen(String model, String kennzahl, String id) {
        try {
            String insertZeigen = "INSERT INTO zeigen VALUES(" + model + "," + kennzahl + "," + id + ")";
            con.prepareStatement(insertZeigen).executeUpdate();
        }
        catch (Exception e) {
            System.err.println("Error: " + e.getMessage());
        }
    }

    public void close() {
        try {
            con.close();
        }
        catch (Exception ignored) {}
    }

}
