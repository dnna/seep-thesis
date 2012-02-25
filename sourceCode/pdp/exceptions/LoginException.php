<?php
/**
 * Ρίχνεται όταν υπάρξει κάποιο πρόβλημα στην αυθεντικοποίηση του χρήστη.
 * Να σημειωθεί ότι αν το πρόβλημα αυθεντικοποίησης βρίσκεται στο επίπεδο του
 * DataHandler τότε πετάγεται από εκεί Exception και όχι αυτό εδώ. Οι κωδικοί
 * σφάλματος σε αυτό το Exception προτείνεται να έχουν την μορφή 2000x.
 * @author Dimosthenis Nikoudis <dnna@dnna.gr>
 */
class LoginException extends Exception {}
?>