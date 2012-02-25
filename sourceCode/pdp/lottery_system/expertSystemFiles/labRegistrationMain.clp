(defmodule SHIFT_PHASE)
	(defrule bumpPreference
		"Ανεβάζουμε την προτίμηση για αυτούς που δεν κατάφεραν να γραφτούν"
		(declare (no-loop TRUE)) ; Για αποφυγή λανθασμένων μειώσεων
		(bumpPreferences ?AM ?courseID)
		; Αντλούμε πληροφορίες για το εργαστήριο και το απορρίπτουμε εάν είναι για άλλο μάθημα
		(MAIN::labInfo (labID ?labID) (courseID ?courseID))
		?m <- (MAIN::studentPreference (AM ?AM) (labID ?labID) (PREFERENCE ?pref))
		(test (> ?pref 1))
		=>
		;(printout t "SHIFT_PHASE: Bumping Preference for AM: " ?AM " on labID: " ?labID " To: " (- ?pref 1) crlf) ; DEBUG
		(modify ?m (PREFERENCE (- ?pref 1)))
	)
	
	(defrule removeBumpPreferences
		"Αφαιρεί το fact bumpPreferences όταν η χρησιμότητα του τελειώσει."
		(declare (salience -1))
		?r <- (bumpPreferences ?AM ?courseID)
		=>
		;(printout t "SHIFT_PHASE: Removing bumpPreferences for AM: " ?AM " on courseID: " ?courseID crlf) ; DEBUG
		(retract ?r)
	)

(defmodule POST_REGISTRATION_TASKS)
	(defrule removeOtherLabsOfSameCourse
		"Αφαίρεση των δηλώσεων για τα υπόλοιπα εργαστηριακά τμήματα του μαθήματος, αφού ο σπουδαστής έχει γραφτεί σε ένα"
		;(declare (salience 1))
		(MAIN::Registration (AM ?AM) (courseID ?courseID) (successful TRUE)) ; Αν ο σπουδαστής έχει ήδη γραφτεί κάπου από το σύστημα
		(MAIN::labInfo (labID ?labID) (courseID ?courseID)) ; Συσχέτιση του μαθήματος με τα εργαστήρια του
		?r <- (MAIN::studentPreference (AM ?AM) (labID ?labID)) ; Βρίσκουμε τη σχετική εγγραφή και την μαρκάρουμε για να την αφαιρέσουμε
		=>
		(retract ?r)
		;(printout t "Removed (studentPreference (AM " ?AM ") (labID " ?labID "))" crlf) ; DEBUG
	)
	
	(defrule conflict
		"Αν έχει δηλώσει 2 τμήματα την ίδια ώρα και γράφτηκε στο 1 τότε σβήνουμε το άλλο από την δήλωση και ανεβάζουμε τα άλλα"
		(MAIN::labHours (labID ?labID) (labDay ?lday) (labStartTime ?lst) (labEndTime ?let))
		(MAIN::Registration (AM ?AM) (labID ?labID) (successful TRUE))
		(MAIN::labHours (labID ?labID2) (labDay ?lday) (labStartTime ?lst) (labEndTime ?let)) ; Αν υπάρχει άλλο εργαστήριο ίδια ώρα και ημέρα
		(MAIN::labInfo (labID ?labID2) (courseID ?courseID)) ; Συσχετισμός του labID του συγκρουόμενου εργαστηρίου με το courseID
		?r <- (MAIN::studentPreference (AM ?AM) (labID ?labID2) (PREFERENCE 1) (INITIAL-PREFERENCE ?initialPref)) ; Και ο σπουδαστής το έχει στη λίστα του με προτίμηση 1
		=>
		;(printout t "Conflicting hours for AM: " ?AM " on courseID: " ?courseID " labID: " ?labID " and labID: " ?labID2 crlf) ; DEBUG
		(retract ?r) ; Διαγράφουμε τη δήλωση του σπουδαστή για το συγκεκριμένου τμήμα του δεύτερου μαθήματος
		(addRegistration ?AM ?labID2 ?courseID ?initialPref "false" "conflict")
		(assert (SHIFT_PHASE::bumpPreferences ?AM ?courseID)) ; Προσθέτουμε κατάλληλο fact για να γνωρίζει το σύστημα ότι πρόκειται για σύγκρουση και να ανεβάσει προταιρεότητες
		(focus SHIFT_PHASE) ; Προχωράμε σε φάση ολίσθησης για να αναπροσαρμοστούν οι προτεραιότητες
		(run)
	)

(defmodule LAB_REGISTRATION_MAIN)
	(defrule registerStudentToLab
		?r1 <- (MAIN::studentPreference (AM ?AM) (labID ?labID) (PREFERENCE 1) (INITIAL-PREFERENCE ?initialPref)) ; Επιλέγουμε την πρώτη προτεραιότητα
		; Συσχετίζουμε το labID με τις υπόλοιπες πληροφορίες για το εργαστήριο
		?rlab_1 <- (MAIN::labInfo (labID ?labID) (courseID ?courseID) (curSize ?curSize) (maxSize ?maxSize))
		;(MAIN::labHours (labID ?labID) (labDay ?lday) (labStartTime ?lst) (labEndTime ?let))
		;(not (MAIN::Registration (AM ?AM) (labID ?labID) (successful TRUE))) ; Ελέγχουμε ότι ο σπουδαστής δεν έχει γραφτεί ήδη στο μάθημα
		(test (< ?curSize ?maxSize)) ; Ελέγχουμε ότι το εργαστήριο δεν έχει γεμίσει
		=>
		;(printout t "AM:" ?AM " labID:" ?labID " courseID:" ?courseID " CurSize:" (+ ?curSize 1) " MaxSize:" ?maxSize crlf) ; DEBUG
		(retract ?r1) ; Αφαίρεση της συγκεκριμένης προτίμισης από τον σπουδαστή
		(modify ?rlab_1 (curSize (+ ?curSize 1))) ; Αύξηση του αριθμού σπουδαστών στο εργαστήριο
		(addRegistration ?AM ?labID ?courseID ?initialPref "true" "") ; Εγγραφή του σπουδαστή
		; Δίνουμε το focus στο module των εργασιών που έπονται της επιτυχημένης εγγραφής
		(focus POST_REGISTRATION_TASKS)
		(run)
	)
	
	(defrule failedCozFull
		?r1 <- (MAIN::studentPreference (AM ?AM) (labID ?labID)(PREFERENCE 1) (INITIAL-PREFERENCE ?initialPref)) ; Επιλέγουμε την πρώτη προτεραιότητα
		; Συσχετίζουμε το labID με τις υπόλοιπες πληροφορίες για το εργαστήριο
		(MAIN::labInfo (labID ?labID) (courseID ?courseID) (curSize ?curSize) (maxSize ?maxSize))
		;(MAIN::labHours (labID ?labID) (labDay ?lday) (labStartTime ?lst) (labEndTime ?let))
		;(not (Registration (AM ?AM) (labID ?labID) (successful TRUE))) ; Ελέγχουμε ότι ο σπουδαστής δεν έχει γραφτεί ήδη στο μάθημα
		(test (>= ?curSize ?maxSize)) ; Ελέγχουμε ότι το εργαστήριο έχει γεμίσει
		=>
		;(printout t "FAILED AM:" ?AM " labID:" ?labID " courseID:" ?courseID " CurSize:" ?curSize " MaxSize:" ?maxSize crlf) ; DEBUG
		(retract ?r1) ; Αφαίρεση της συγκεκριμένης προτίμισης από τον σπουδαστή
		(addRegistration ?AM ?labID ?courseID ?initialPref "false" "labFull")
		(assert (SHIFT_PHASE::bumpPreferences ?AM ?courseID))
		(focus SHIFT_PHASE) ; Προχωράμε σε φάση ολίσθησης για να αναπροσαρμοστούν οι προτεραιότητες
		(run)
	)