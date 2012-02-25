package esk.lottery;

import esk.lottery.DataHandler.*;
import java.io.FileInputStream;
import java.io.IOException;
import java.util.ArrayList;
import java.util.Properties;

/**
 * Αυτή η κλάση είναι υπεύθυνη για την ανάκτηση, την επεξεργασία και την
 * επιστροφή των διαφόρων παραμέτρων του configuration της εφαρμογής.
 * @author Dimosthenis Nikoudis
 */
public class Config extends Properties {
    private static Config instance = null;
    
    /**
     * Το reference του DataHandlerMulti.
     */
    protected IDataHandler datahandler = null;
    
    /**
     * Επιστρέφει το τρέχον config για το πρόγραμμα. Αν δεν υπάρχει instance
     * τότε το δημιουργεί.
     * @return Το τρέχον config για το πρόγραμμα.
     */
    public static Config get(String name) {
        if(instance == null) {
            instance = new Config(name);
        }
        return instance;
    }
    
    /**
     * Επιστρέφει το τρέχον config για το πρόγραμμα. Επειδή δεν υπάρχει instance
     * τότε επιστρέφει null.
     * @return Το τρέχον config για το πρόγραμμα ή null αν δεν υπάρχει instance.
     */
    public static Config get() {
        return instance;
    }
    
    /**
     * Περιέχει τα ερωτήματα SQL για την ανάκτηση των προτιμήσεων κάθε
     * κατηγορίας φοιτητών.
     */
    protected ArrayList<String> studentPrefQueries;
    
    /**
     * Επιστρέφει το reference για το DataHandlerMulti. Αν δεν υπάρχει instance του
     * DataHandlerMulti τότε επιστρέφει null, γιατί δεν παίρνει το reference του
     * έμπειρου συστήματος, που είναι απαραίτητο για να δημιουργηθεί.
     * @return Το instance του DataHandlerMulti ή null αν δεν υπάρχει.
     */
    public IDataHandler getDataHandler() {
        if (datahandler == null) {
            return null;
        }
        return datahandler;
    }
    
    /**
     * Επιστρέφει το reference για το DataHandlerMulti. Αν δεν υπάρχει instance του
     * DataHandlerMulti τότε δημιουργείται με την κλήση αυτής της μεθόδου. Παίρνει
     * σαν παράμετρο ένα reference του έμπειρου συστήματος για να μπορεί να έχει
     * πρόσβαση στο configuration.
     * @param tes Reference του έμπειρου συστήματος.
     * @return Το instance του DataHandlerMulti.
     */
    public IDataHandler getDataHandler(ESK tes) {
        if (datahandler == null) {
            datahandler = new DataHandlerMulti(tes);
        }
        return datahandler;
    }

    /**
     * Αρχικοποιεί την κλάση με τις παραμέτρους που παίρνει από το αρχείο με το
     * configuration. Η δομή του αρχείου πρέπει να είναι αυτή των αρχείων
     * "properties" της Java.
     * @param configFilePath Η διαδρομή για το αρχείο με το configuration.
     */
    public Config(String configFilePath) {
        try {
            System.out.print("Reading Configuration... ");
            load(new FileInputStream(configFilePath));
            System.out.println("Done");
        } catch (IOException eio) {
            System.err.println(eio);
            System.exit(-15);
        }
    }
}