(import archon.lottery.RegistrationUpdater.*)

;(defglobal ?*regUpdater* = (new archon.lottery.RegistrationUpdater.RegistrationUpdater)) ; Δημιουργείται προγραμματιστικά από την Java

(deftemplate Registration
	(declare (from-class Registration)
			 (include-variables TRUE)
	)
)

(deftemplate MAIN::studentPreference
	"Δομή που αποθηκεύει την προτίμηση ενός σπουδαστή για ένα εργαστηριακό τμήμα."
	(slot AM (type STRING)) ; Ο αριθμός μητρώου του σπουδαστή.
	(slot labID (type STRING)) ; Ο κωδικός του εργαστηριακού τμήματος.
	(slot PREFERENCE (type INTEGER)) ; Ο αριθμός προτίμησης του σπουδαστή.
	(slot INITIAL-PREFERENCE (type INTEGER)) ; Ο αριθμός προτίμησης όταν ξεκίνησε το σύστημα (για χρήση σε στατιστικά).
)

(deftemplate MAIN::labHours
	"Δομή που αποθηκεύει πληροφορίες για τις ώρες/ημέρες που διδάσκεται ένα εργαστηριακό τμήμα."
	(slot labID (type STRING)) ; Ο κωδικός του εργαστηριακού τμήματος.
	(slot labDay (type STRING)) ; ID της ημέρας (0 Δευτέρα, 1 Τρίτη κτλ.)
	(slot labStartTime (type INTEGER)) ; Ώρα έναρξης εργαστηρίου (πχ 16)
	(slot labEndTime (type INTEGER)) ; Ώρα λήξης εργαστηρίου (πχ 18)
)

(deftemplate MAIN::labInfo
	"Δομή που αποθηκεύει πληροφορίες για ένα εργαστηριακό τμήμα."
	(slot labID (type STRING)) ; Ο κωδικός του εργαστηριακού τμήματος.
	(slot courseID (type STRING)) ; Ο κωδικός του μαθήματος.
	(slot curSize (type INTEGER)) ; Τρέχων αριθμός εγγεγραμμένων σπουδαστών
	(slot maxSize (type INTEGER)) ; Μέγιστος αριθμός εγγεγραμμένων σπουδαστών
)

(defquery get-preferences
	"Βρίσκει τις προτιμήσεις ενός σπουδαστή για ένα συγκεκριμένο μάθημα."
	(declare (variables ?AM ?courseID))
	(MAIN::labInfo (courseID ?courseID) (labID ?labID)) ; Βρίσκουμε τα εργαστήρια που ανήκουν σε αυτό το courseID
	(MAIN::studentPreference (AM ?AM) (labID ?labID)) ; Ελέγχουμε αν ο σπουδαστής έχει κάποια από αυτά στις προτιμήσεις του
)

(deffunction student-has-labs-left (?AM ?courseID)
	(if (> (count-query-results get-preferences ?AM ?courseID) 0) then
		(return TRUE)
	else
		(return FALSE)
	)
)

(deffunction addRegistration (?AM ?labID ?courseID ?initialPref ?successful ?details)
	"Προσθέτει μια εγγραφή (επιτυχημένη η αποτυχημένη) στη λίστα με τα facts και στη βάση δεδομένων. Σε περίπτωση αποτυχημένης εγγραφής
	ελέγχει αν ο σπουδαστής έχει άλλες προτιμήσεις για το συγκεκριμένο μάθημα και αν δεν έχει τότε προσθέτει άλλη μια κατάλληλη εγγραφή."
	(bind ?reg (new Registration ?AM ?labID ?courseID ?initialPref ?successful ?details))
	(add ?reg)
	(?*regUpdater* addRegistration ?reg)
	; Αν η εγγραφή δεν είναι επιτυχημένη τότε ελέγχεται η περίπτωση του να μην έχει άλλες προτιμήσεις σε αυτό το μάθημα ο σπουδαστής
	(if (and (eq ?successful "false") (not (student-has-labs-left ?AM ?courseID))) then
		;(printout t "test" crlf)
		(bind ?reg (new Registration ?AM "0" ?courseID ?initialPref "false" "failedAllLabs"))
		(add ?reg)
		(?*regUpdater* addRegistration ?reg)
	)
)