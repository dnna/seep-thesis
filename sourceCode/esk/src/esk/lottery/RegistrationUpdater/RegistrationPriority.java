package esk.lottery.RegistrationUpdater;

/**
 * Δομή που περιέχει πληροφορίες για μια ειδική προτεραιότητα.
 * @author Dimosthenis Nikoudis
 */
public class RegistrationPriority {
    /**
     * Ο αριθμός της προτεραιότητας.
     */
    private Integer priority;
    /**
     * Περιγραφή της προτεραιότητας.
     */
    private String description;
    /**
     * Τρόπος με τον οποίο θα ανακτηθούν τα δεδομένα.
     * 1 - SQL query στη βάση archonInternal
     */
    private Integer datasource;
    /**
     * Οι παράμετροι που θα σταλούν στο datasource (πχ. το query).
     */
    private String parameters;
    
    /**
     * Δημιουργεί ένα αντικείμενο ειδικής προτεραιότητας.
     * @param priority Ο αριθμός της προτεραιότητας.
     * @param description Περιγραφή της προτεραιότητας.
     * @param datasource Τρόπος με τον οποίο θα ανακτηθούν τα δεδομένα.
     * @param parameters Οι παράμετροι που θα σταλούν στο datasource (πχ. το
     * query).
     */
    public RegistrationPriority(Integer priority, String description, Integer datasource, String parameters) {
        this.priority = priority;
        this.description = description;
        this.datasource = datasource;
        this.parameters = parameters;
    }

    /**
     * @return Ο αριθμός της προτεραιότητας.
     */
    public Integer getPriority() {
        return priority;
    }

    /**
     * @return Περιγραφή της προτεραιότητας.
     */
    public String getDescription() {
        return description;
    }

    /**
     * @return Τρόπος με τον οποίο θα ανακτηθούν τα δεδομένα.
     * 1 - SQL query στη βάση archonInternal
     */
    public Integer getDatasource() {
        return datasource;
    }

    /**
     * @return Οι παράμετροι που θα σταλούν στο datasource (πχ. το query).
     */
    public String getParameters() {
        return parameters;
    }
}
