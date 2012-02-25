<?php
/**
 * Ρίχνεται όταν υπάρξει πρόβλημα στο χαμηλό επίπεδο, δηλαδή στο DataHandler.
 * (π.χ. αν ένα web service ή μια βάση δεδομένων έχουν πέσει). Οι κωδικοί
 * σφάλματος σε αυτό το Exception προτείνεται να έχουν την μορφή 1000x.
 * @author Dimosthenis Nikoudis <dnna@dnna.gr>
 */
class DataHandlerException extends Exception {}
?>