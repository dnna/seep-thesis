package esk.lottery.DataHandler;

import esk.lottery.*;
import esk.lottery.RegistrationUpdater.Registration;
import esk.lottery.RegistrationUpdater.RegistrationPriority;
import esk.lottery.Statistics.PreferenceBreakdown;
import java.net.UnknownHostException;
import java.sql.*;
import java.util.ArrayList;
import java.util.Collections;
import jess.*;

/**
 * Διεκπαιρεώνει low-level λειτουργίες που αφορούν την πρόσβαση δεδομένων.
 * Είναι singleton, δηλαδή μπορεί να υπάρχει μόνο ένα αντικείμενο από αυτή την
 * κλάση στο πρόγραμμα, και ο τρόπος για δημιουργηθεί το αντικείμενο ή να
 * ανακτηθεί το reference του είναι με τις στατικές μεθόδους get.
 * @author Dimosthenis Nikoudis
 */
public class DataHandlerLocal implements IDataHandler {

    /**
     * Το reference του έμπειρου συστήματος για να μπορεί να έχει πρόσβαση στο
     * configuration και να μπορεί να παράγει facts που αφορούν το συγκεκριμένο
     * σύστημα.
     */
    protected ESK es;

    /**
     * Το link για σύνδεση με τη βάση.
     */
    protected String connectionUrl;
    
    /**
     * Η σύνδεση με τη βάση δεδομένων.
     */
    protected Connection conn;

    /**
     * Cache - Το τρέχον εξάμηνο. Υπολογίζεται στον constructor και μπορεί να
     * ανακτηθεί με τη μέθοδο getCurSemester.
     */
    protected Integer curSemester;
    
    /**
     * Cache - Ο πίνακας με τις υπάρχουσες προτεραιότητες.
     */
    protected ArrayList<RegistrationPriority> rp;

    /**
     * Μεταβλητή που δείχνει αν ήταν επιτυχής η δημιουργία lock. Το lock είναι
     * ο τρόπος με τον οποίο εξασφαλίζεται ότι δεν θα τρέχουν περισσότερα από
     * 1 συστήματα κληρώσεων την ίδια στιγμή.
     */
    protected Boolean establishedLock = false;

    /**
     * Αρχικοποιεί το DataHandlerSQL με λειτουργίες όπως σύνδεση με την αποθήκη
     * δεδομένων, δημιουργία lock και εύρεση του τρέχοντος εξαμήνου. Παίρνει
     * σαν παράμετρο ένα reference του έμπειρου συστήματος για να μπορεί να έχει
     * πρόσβαση στο configuration.
     * @param tes Reference του έμπειρου συστήματος.
     */
    public DataHandlerLocal(ESK tes) {
        es = tes;
        try {
            System.out.print("Connecting to Database... ");
            connectionUrl = "jdbc:" + es.getConfig().getProperty("dbType") + "://" + es.getConfig().getProperty("dbHost") + "/" + es.getConfig().getProperty("dbName") + "?" +
                    "user=" + es.getConfig().getProperty("dbUser") + "&password=" + es.getConfig().getProperty("dbPass") + "";
            // Σύνδεση με τη βάση
            Class.forName("com." + es.getConfig().getProperty("dbType") + ".jdbc.Driver");
            conn = DriverManager.getConnection(connectionUrl);
            System.out.println("Done");
            establishedLock = establishLock(); // Δημιουργία του lock
            if(establishedLock != true) {
                // Η δημιουργία lock απέτυχε. Εμφανίζουμε το κατάλληλο μήνυμα και βγαίνουμε.
                System.err.println("Unable to establish a lock: Already locked.");
                System.exit(-10);
            }
            System.out.print("Finding the current semester: ");
            curSemester = getCurrentSemester();
            System.out.println(curSemester.toString());
        } catch (SQLException e) {
            System.err.println("SQL Exception: " + e.toString());
        } catch (ClassNotFoundException cE) {
            System.err.println("Class Not Found Exception: " + cE.toString());
        }
    }

    /**
     * {@inheritDoc}
     */
    public final Boolean establishLock() {
        try {
            System.out.print("Establishing lock... ");
            Statement lockStatusStmt = conn.createStatement();
            ResultSet lockStatusRs = lockStatusStmt.executeQuery("SELECT lockTime FROM concurrencyLock;");
            if(lockStatusRs.next()) {
                Timestamp lockTime = lockStatusRs.getTimestamp("lockTime"); // Εύρεση της ώρας του τελευταίου κλειδώματος
                long TwentyFourHoursAfter = lockTime.getTime() + 86400000; // Οι 24 ώρες είναι 86400000 milliseconds
                if (System.currentTimeMillis() <= TwentyFourHoursAfter) { // Συγκρίνουμε τις ημερομηνίες για να δούμε αν το lock που υπάρχει είναι έγκυρο.
                    return false;
                }
            }
            // Αφού έχει εξασφαλιστεί ότι δεν υπάρχει ήδη έγκυρο lock προχωράμε να βάλουμε το δικό μας
            Statement lockStmt = conn.createStatement();
            java.net.InetAddress i = java.net.InetAddress.getLocalHost();
            lockStmt.addBatch("INSERT INTO concurrencyLock(lotID, last_lock_hostname, last_lock_ip) VALUES(" + es.getLotteryID().toString() + ", '" + i.getHostName() + "', '" + i.getHostAddress() + "');");
            lockStmt.executeBatch();
            // Shutdown hook για να διαγράφει το lock όταν κλείνει η εφαρμογή
            Runtime.getRuntime().addShutdownHook(new Thread() {
                @Override
                public void run() {
                    IDataHandler datahandler = es.getDataHandler();
                    if(datahandler != null && datahandler.hasEstablishedLock() == true) {
                        if(datahandler.removeLock() != true) {
                            System.err.println("Unable to remove the lock: Not locked.");
                        }
                    }
                };
            });
            System.out.println("Done");
            return true; // Αν φτάσουμε εδώ σημαίνει ότι δεν υπήρξε exception, άρα όλα πήγαν καλά.
        } catch (SQLException e) {
            System.err.println("SQL Exception: " + e.toString());
        } catch (UnknownHostException e) {
            System.err.println("UnknownHost Exception: " + e.toString());
        }
        return false; // Αν φτάσαμε εδώ τότε κάτι πήγε στραβά
    }

    /**
     * {@inheritDoc}
     */
    public final Boolean removeLock() {
        try {
            if (hasEstablishedLock() != true) {
                return false;
            }
            System.out.print("Removing the lock... ");
            Statement lockStmt = conn.createStatement();
            lockStmt.addBatch("DELETE FROM concurrencyLock");
            lockStmt.executeBatch();
            System.out.println("Done");
            return true;
        } catch (SQLException e) {
            System.err.println("SQL Exception: " + e.toString());
        }
        return false; // Αν φτάσαμε εδώ τότε κάτι πήγε στραβά
    }

    /**
     * {@inheritDoc}
     */
    public void removeSameLotFails() {
        try {
            PreparedStatement removeSameLotFailedCourseStmt = conn.prepareStatement(es.getConfig().getProperty("removeSameLotFailedCourse"));
            removeSameLotFailedCourseStmt.setInt(1, es.getLotteryID());
            removeSameLotFailedCourseStmt.execute();
            PreparedStatement removeSameLotFailedLabStmt = conn.prepareStatement(es.getConfig().getProperty("removeSameLotFailedLab"));
            removeSameLotFailedLabStmt.setInt(1, es.getLotteryID());
            removeSameLotFailedLabStmt.execute();
        } catch (SQLException e) {
            System.err.println("SQL Exception: " + e.toString());
        }
    }

    /**
     * {@inheritDoc}
     */
    public Boolean hasEstablishedLock() {
        return establishedLock;
    }

    /**
     * {@inheritDoc}
     */
    public ArrayList<RegistrationPriority> getRegistrationPriorities() {
        if(rp == null) {
            try {
                rp = new ArrayList<RegistrationPriority>();
                Statement registrationPrioritiesStmt = conn.createStatement();
                ResultSet registrationPrioritiesRs = registrationPrioritiesStmt.executeQuery(es.getConfig().getProperty("registrationPrioritiesQuery"));
                while(registrationPrioritiesRs.next()) {
                    Integer rpPrio = registrationPrioritiesRs.getInt(1);
                    String rpDescription = registrationPrioritiesRs.getString(2);
                    Integer rpDatasource = registrationPrioritiesRs.getInt(3);
                    String rpParameters = registrationPrioritiesRs.getString(4);

                    rp.add(new RegistrationPriority(rpPrio, rpDescription, rpDatasource, rpParameters));
                }
            } catch (SQLException e) {
                System.err.println("SQL Exception: " + e.toString());
            }
        }
        return rp;
    }

    /**
     * {@inheritDoc}
     */
    public ArrayList<Fact> getStudentPreferences(RegistrationPriority curPriority) throws JessException {
        try {
            ArrayList<Fact> studentPreferenceAl = new ArrayList<Fact>();
            if(curPriority.getDatasource() == 1) {
                String studentPrefQuery = curPriority.getParameters();
                Statement studentPreferenceStmt = conn.createStatement();
                // Εκτέλεση ερωτήματος που φέρνει τις ώρες προτίμησης του φοιτητή
                ResultSet studentPreferenceRs = studentPreferenceStmt.executeQuery(studentPrefQuery);
                while (studentPreferenceRs.next()) {
                    String AM = studentPreferenceRs.getString("studAM");
                    String labID = studentPreferenceRs.getString("labID");
                    Integer PREFERENCE = Integer.parseInt(studentPreferenceRs.getString("Preference"));
                    // Κώδικας που δημιουργεί τη σχετική λιστα
                    Fact f = new Fact("studentPreference", es);
                    f.setSlotValue("AM", new Value(AM, RU.STRING));
                    f.setSlotValue("labID", new Value(labID, RU.STRING));
                    f.setSlotValue("PREFERENCE", new Value(PREFERENCE, RU.INTEGER));
                    f.setSlotValue("INITIAL-PREFERENCE", new Value(PREFERENCE, RU.INTEGER));
                    studentPreferenceAl.add(f);
                }
                studentPreferenceStmt.close();
                if (es.getConfig().getProperty("randomizeStudentOrder", "1").equals("1")) {
                    //System.out.print("Randomizing student order... ");
                    Collections.shuffle(studentPreferenceAl); // Ανακάτεμα των φοιτητών για να υπάρχει τυχαιότητα
                    //System.out.println("Done");
                }
            }
            return studentPreferenceAl;
        } catch (SQLException e) {
            System.err.println("SQL Exception: " + e.toString());
        }
        return null;
    }

    /**
     * {@inheritDoc}
     */
    public void addRegStudentFacts() throws JessException {
        try {
            Statement regStudentStmt = conn.createStatement();
            // Εκτέλεση ερωτήματος που φέρνει τα εργαστηριακά τμήματα για τα μαθήματα που είναι γραμμένος ο φοιτητής
            ResultSet regStudentRs = regStudentStmt.executeQuery(es.getConfig().getProperty("regStudentQuery").replaceFirst("\\+curSemester\\+", curSemester.toString()));
            while (regStudentRs.next()) {
                String AM = regStudentRs.getString("studAM");
                String courseID = regStudentRs.getString("lessonID");
                String labID = regStudentRs.getString("labID");

                // Κώδικας που τα περνάει σαν facts
                Registration reg = new Registration(AM, labID, courseID, 1, true);
                es.add(reg);
            }
            regStudentStmt.close();
        } catch (SQLException e) {
            System.err.println("SQL Exception: " + e.toString());
        }
    }

    /**
     * {@inheritDoc}
     */
    public void addLabHoursFacts() throws JessException {
        try {
            Statement labHoursStmt = conn.createStatement();
            // Εκτέλεση ερωτήματος που φέρνει τα εργαστηριακά τμήματα για τα μαθήματα που είναι γραμμένος ο φοιτητής
            ResultSet labHoursRs = labHoursStmt.executeQuery(es.getConfig().getProperty("labHoursQuery").replaceFirst("\\+curSemester\\+", curSemester.toString()));
            while (labHoursRs.next()) {
                String labID = labHoursRs.getString("labID");
                String day = labHoursRs.getString("dayID");
                Integer labStartTime = Integer.parseInt(labHoursRs.getString("timeFrom"));
                Integer labEndTime = Integer.parseInt(labHoursRs.getString("timeTo"));

                // Κώδικας που τα περνάει σαν facts
                Fact f = new Fact("labHours", es);
                f.setSlotValue("labID", new Value(labID, RU.STRING));
                f.setSlotValue("labDay", new Value(day, RU.STRING));
                f.setSlotValue("labStartTime", new Value(labStartTime, RU.INTEGER));
                f.setSlotValue("labEndTime", new Value(labEndTime, RU.INTEGER));
                es.assertFact(f);
            }
            labHoursStmt.close();
        } catch (SQLException e) {
            System.err.println("SQL Exception: " + e.toString());
        }
    }

    /**
     * {@inheritDoc}
     */
    public void addLabInfoFacts() throws JessException {
        try {
            //Deffacts labInfoDf = new Deffacts("regStudent", "regStudent", es);
            Statement curSizeStmt = conn.createStatement();
            Statement maxSizeStmt = conn.createStatement();
            // Εκτέλεση ερωτήματος που φέρνει πληροφορίες για κάθε εργαστηριακό τμήμα
            ResultSet maxSizeRs = maxSizeStmt.executeQuery(es.getConfig().getProperty("labInfoQuery").replaceFirst("\\+curSemester\\+", curSemester.toString()));
            while (maxSizeRs.next()) {
                String labID = maxSizeRs.getString("labID");
                String courseID = maxSizeRs.getString("lessonID");
                Integer maxSize = Integer.parseInt(maxSizeRs.getString("labSize"));
                Integer curSize;
                try {
                    curSize = Integer.parseInt(maxSizeRs.getString("curSize"));
                } catch (SQLException e) {
                    ResultSet curSizeRs = curSizeStmt.executeQuery(es.getConfig().getProperty("curSizeQuery").replaceFirst("\\+labID\\+", labID).replaceFirst("\\+curSemester\\+", curSemester.toString()));
                    curSizeRs.next();
                    curSize = Integer.parseInt(curSizeRs.getString("curSize"));
                }

                // Κώδικας που τα περνάει σαν facts
                Fact f = new Fact("labInfo", es);
                f.setSlotValue("labID", new Value(labID, RU.STRING));
                f.setSlotValue("courseID", new Value(courseID, RU.STRING));
                f.setSlotValue("curSize", new Value(curSize, RU.INTEGER));
                f.setSlotValue("maxSize", new Value(maxSize, RU.INTEGER));
                es.assertFact(f);
                //labInfoDf.addFact(f);
            }
            curSizeStmt.close();
            maxSizeStmt.close();
        } catch (SQLException e) {
            System.err.println("SQL Exception: " + e.toString());
        }
    }

    /**
     * {@inheritDoc}
     */
    public void updateRegistrations(ArrayList<Registration> registrations) {
        Connection tempConn = null;
        try {
            Class.forName("com." + es.getConfig().getProperty("dbType") + ".jdbc.Driver");
            tempConn = DriverManager.getConnection(connectionUrl);
            tempConn.setAutoCommit(false);
            PreparedStatement insertSuccessfulStmt = tempConn.prepareStatement(es.getConfig().getProperty("regStudentInsertQuery"));
            PreparedStatement insertFailedLabStmt = tempConn.prepareStatement(es.getConfig().getProperty("failedRegLabInsertQuery"));
            PreparedStatement insertFailedCourseStmt = tempConn.prepareStatement(es.getConfig().getProperty("failedRegCourseInsertQuery"));
            //System.out.print("Updating the database with student registrations... ");
            for(Registration registration : registrations) {
                if(registration.isSuccessful()) {
                    insertSuccessfulStmt.setString(1, registration.getAM());
                    insertSuccessfulStmt.setInt(2, es.getLotteryID());
                    insertSuccessfulStmt.setString(3, registration.getLabID());
                    insertSuccessfulStmt.addBatch();
                } else {
                    if(!registration.getLabID().equals("0")) {
                        insertFailedLabStmt.setString(1, registration.getAM());
                        insertFailedLabStmt.setInt(2, es.getLotteryID());
                        insertFailedLabStmt.setString(3, registration.getLabID());
                        insertFailedLabStmt.setString(4, registration.getDetails());
                        insertFailedLabStmt.addBatch();
                    } else {
                        insertFailedCourseStmt.setString(1, registration.getAM());
                        insertFailedCourseStmt.setInt(2, es.getLotteryID());
                        insertFailedCourseStmt.setString(3, registration.getCourseID());
                        insertFailedCourseStmt.setString(4, registration.getDetails());
                        insertFailedCourseStmt.addBatch();
                    }
                }
            }
            insertSuccessfulStmt.executeBatch();
            insertFailedLabStmt.executeBatch();
            insertFailedCourseStmt.executeBatch();
            tempConn.commit();
            //System.out.println("Done");
        } catch (SQLException e) {
            System.err.println("SQL Exception: " + e.toString());
        } catch (ClassNotFoundException e) {
            e.toString();
        } finally {
            try {
                tempConn.close();
            } catch (SQLException e) {
                System.err.println("SQL Exception: " + e.toString());
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public void removeOldPreferences() {
        try {
            System.out.print("Removing the old student preferences from database... ");
            Statement removeOldPrefsStmt = conn.createStatement();
            removeOldPrefsStmt.addBatch(es.getConfig().getProperty("removeOldQuery"));
            removeOldPrefsStmt.executeBatch();
            System.out.println("Done");
        } catch (SQLException e) {
            System.err.println("SQL Exception: " + e.toString());
        }
    }
    
    /**
     * {@inheritDoc}
     */
    public void markExecuted() {
        try {
            System.out.print("Marking this lottery as executed... ");
            PreparedStatement updateExecutedQueryStmt = conn.prepareStatement(es.getConfig().getProperty("updateExecutedQuery"));
            updateExecutedQueryStmt.setInt(1, es.getLotteryID());
            updateExecutedQueryStmt.addBatch();
            updateExecutedQueryStmt.executeBatch();
            System.out.println("Done");
        } catch (SQLException e) {
            System.err.println("SQL Exception: " + e.toString());
        }
    }

    /**
     * {@inheritDoc}
     */
    public void updateStatisticsPreferenceBreakdown(PreferenceBreakdown pb) {
        try{
            PreparedStatement updateStatisticsPreferenceBreakdownStmt = conn.prepareStatement(es.getConfig().getProperty("updateStatisticsPreferenceBreakdown"));
            int preference; for(preference = 0; preference < 12; preference++) {
                updateStatisticsPreferenceBreakdownStmt.setInt(1, preference + 1);
                updateStatisticsPreferenceBreakdownStmt.setInt(2, es.getLotteryID());
                updateStatisticsPreferenceBreakdownStmt.setInt(3, pb.getSuccessfulRegistrations()[preference]);
                updateStatisticsPreferenceBreakdownStmt.setInt(4, pb.getFailedRegistrations()[preference]);
                updateStatisticsPreferenceBreakdownStmt.setInt(5, pb.getTotalRegistrations()[preference]);
                updateStatisticsPreferenceBreakdownStmt.addBatch();
            }
            updateStatisticsPreferenceBreakdownStmt.executeBatch();
        } catch (SQLException e) {
            System.err.println("SQL Exception: " + e.toString());
        }
    }

    /**
     * Επιστρέφει το ID του τρέχοντος εξαμήνου. Στην πρώτη εκτέλεση της μεθόδου
     * ενδέχεται να χρειαστεί κάποια επικοινωνία με την αποθήκη δεδομένων για να
     * υπολογιστεί. Στις μεταγενέστερες κλήσεις ανακτάται η αποθηκευμένη τιμή.
     * @return Το ID του τρέχοντος εξαμήνου.
     */
    public final Integer getCurrentSemester() {
        if(curSemester != null) {
            return curSemester;
        } else {
            try {
                Statement getCurrentSemesterStmt = conn.createStatement();
                ResultSet getCurrentSemesterRs = getCurrentSemesterStmt.executeQuery(es.getConfig().getProperty("currentSemesterQuery"));
                while (getCurrentSemesterRs.next()) {
                    return getCurrentSemesterRs.getInt("curSemester");
                }
                return 1;
            } catch (SQLException e) {
                System.err.println("SQL Exception: " + e.toString());
            }
            return 1;
        }
    }
}