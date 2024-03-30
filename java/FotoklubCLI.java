public class FotoklubCLI {

  public static void main(String args[]) {
    try {
      DatabaseHelper DB = new DatabaseHelper();

      if (args.length == 0) {
        DB.defaultData();
        DB.report();
        DB.close();
        return;
      }

      switch (args[0]) {
        case "report":
          DB.report();
          break;

        case "fotograf":
          DB.fotograf(args[1], args[2]);
          break;

        case "objektiv":
          DB.objektiv(args[1], args[2]);
          break;

        case "kamera":
          DB.kamera(args[1], args[2]);
          break;

        case "sony":
          DB.sony(args[1], args[2], args[3], args[4]);
          break;

        case "foto":
          DB.foto(args[1], args[2], args[3], args[4], args[5]);
          break;

        case "model":
          DB.model(args[1], args[2]);
          break;

        case "haben":
          DB.haben(args[1], args[2], args[3]);
          break;

        case "zeigen":
          DB.zeigen(args[1], args[2], args[3]);
          break;

        case "leiter":
          if (args.length == 1) DB.getLeiter();
          else DB.setLeiter(args[1]);
          break;

        default:
          DB.defaultData();
          DB.report();
      }

      DB.close();

    }
    catch (Exception e) {
      System.err.println("Error: " + e.getMessage());
    }
  }
}
