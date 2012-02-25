<?php
/**
 * Ρίχνεται όταν ένα module αποτύχει να φορτωθεί (π.χ. γιατί ο χρήστης δεν είχε
 * πρόσβαση). Οι κωδικοί σφάλματος σε αυτό το Exception προτείνεται να έχουν την
 * μορφή 40x.
 * @author Dimosthenis Nikoudis <dnna@dnna.gr>
 */
class ModuleLoadException extends Exception {}
?>