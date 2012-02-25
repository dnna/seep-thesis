(defmodule SHIFT_PHASE)
	(defrule bumpPreference
		"���������� ��� ��������� ��� ������ ��� ��� ��������� �� ��������"
		(declare (no-loop TRUE)) ; ��� ������� ����������� ��������
		(bumpPreferences ?AM ?courseID)
		; �������� ����������� ��� �� ���������� ��� �� ������������ ��� ����� ��� ���� ������
		(MAIN::labInfo (labID ?labID) (courseID ?courseID))
		?m <- (MAIN::studentPreference (AM ?AM) (labID ?labID) (PREFERENCE ?pref))
		(test (> ?pref 1))
		=>
		;(printout t "SHIFT_PHASE: Bumping Preference for AM: " ?AM " on labID: " ?labID " To: " (- ?pref 1) crlf) ; DEBUG
		(modify ?m (PREFERENCE (- ?pref 1)))
	)
	
	(defrule removeBumpPreferences
		"������� �� fact bumpPreferences ���� � ����������� ��� ���������."
		(declare (salience -1))
		?r <- (bumpPreferences ?AM ?courseID)
		=>
		;(printout t "SHIFT_PHASE: Removing bumpPreferences for AM: " ?AM " on courseID: " ?courseID crlf) ; DEBUG
		(retract ?r)
	)

(defmodule POST_REGISTRATION_TASKS)
	(defrule removeOtherLabsOfSameCourse
		"�������� ��� �������� ��� �� �������� ������������ ������� ��� ���������, ���� � ���������� ���� ������� �� ���"
		;(declare (salience 1))
		(MAIN::Registration (AM ?AM) (courseID ?courseID) (successful TRUE)) ; �� � ���������� ���� ��� ������� ����� ��� �� �������
		(MAIN::labInfo (labID ?labID) (courseID ?courseID)) ; ��������� ��� ��������� �� �� ���������� ���
		?r <- (MAIN::studentPreference (AM ?AM) (labID ?labID)) ; ��������� �� ������� ������� ��� ��� ���������� ��� �� ��� �����������
		=>
		(retract ?r)
		;(printout t "Removed (studentPreference (AM " ?AM ") (labID " ?labID "))" crlf) ; DEBUG
	)
	
	(defrule conflict
		"�� ���� ������� 2 ������� ��� ���� ��� ��� �������� ��� 1 ���� �������� �� ���� ��� ��� ������ ��� ���������� �� ����"
		(MAIN::labHours (labID ?labID) (labDay ?lday) (labStartTime ?lst) (labEndTime ?let))
		(MAIN::Registration (AM ?AM) (labID ?labID) (successful TRUE))
		(MAIN::labHours (labID ?labID2) (labDay ?lday) (labStartTime ?lst) (labEndTime ?let)) ; �� ������� ���� ���������� ���� ��� ��� �����
		(MAIN::labInfo (labID ?labID2) (courseID ?courseID)) ; ����������� ��� labID ��� ������������� ����������� �� �� courseID
		?r <- (MAIN::studentPreference (AM ?AM) (labID ?labID2) (PREFERENCE 1) (INITIAL-PREFERENCE ?initialPref)) ; ��� � ���������� �� ���� ��� ����� ��� �� ��������� 1
		=>
		;(printout t "Conflicting hours for AM: " ?AM " on courseID: " ?courseID " labID: " ?labID " and labID: " ?labID2 crlf) ; DEBUG
		(retract ?r) ; ����������� �� ������ ��� ��������� ��� �� ������������� ����� ��� �������� ���������
		(addRegistration ?AM ?labID2 ?courseID ?initialPref "false" "conflict")
		(assert (SHIFT_PHASE::bumpPreferences ?AM ?courseID)) ; ����������� ��������� fact ��� �� �������� �� ������� ��� ��������� ��� ��������� ��� �� �������� ��������������
		(focus SHIFT_PHASE) ; ��������� �� ���� ��������� ��� �� ���������������� �� ��������������
		(run)
	)

(defmodule LAB_REGISTRATION_MAIN)
	(defrule registerStudentToLab
		?r1 <- (MAIN::studentPreference (AM ?AM) (labID ?labID) (PREFERENCE 1) (INITIAL-PREFERENCE ?initialPref)) ; ���������� ��� ����� �������������
		; ������������ �� labID �� ��� ��������� ����������� ��� �� ����������
		?rlab_1 <- (MAIN::labInfo (labID ?labID) (courseID ?courseID) (curSize ?curSize) (maxSize ?maxSize))
		;(MAIN::labHours (labID ?labID) (labDay ?lday) (labStartTime ?lst) (labEndTime ?let))
		;(not (MAIN::Registration (AM ?AM) (labID ?labID) (successful TRUE))) ; ��������� ��� � ���������� ��� ���� ������� ��� ��� ������
		(test (< ?curSize ?maxSize)) ; ��������� ��� �� ���������� ��� ���� �������
		=>
		;(printout t "AM:" ?AM " labID:" ?labID " courseID:" ?courseID " CurSize:" (+ ?curSize 1) " MaxSize:" ?maxSize crlf) ; DEBUG
		(retract ?r1) ; �������� ��� ������������� ���������� ��� ��� ���������
		(modify ?rlab_1 (curSize (+ ?curSize 1))) ; ������ ��� ������� ���������� ��� ����������
		(addRegistration ?AM ?labID ?courseID ?initialPref "true" "") ; ������� ��� ���������
		; ������� �� focus ��� module ��� �������� ��� ������� ��� ������������ ��������
		(focus POST_REGISTRATION_TASKS)
		(run)
	)
	
	(defrule failedCozFull
		?r1 <- (MAIN::studentPreference (AM ?AM) (labID ?labID)(PREFERENCE 1) (INITIAL-PREFERENCE ?initialPref)) ; ���������� ��� ����� �������������
		; ������������ �� labID �� ��� ��������� ����������� ��� �� ����������
		(MAIN::labInfo (labID ?labID) (courseID ?courseID) (curSize ?curSize) (maxSize ?maxSize))
		;(MAIN::labHours (labID ?labID) (labDay ?lday) (labStartTime ?lst) (labEndTime ?let))
		;(not (Registration (AM ?AM) (labID ?labID) (successful TRUE))) ; ��������� ��� � ���������� ��� ���� ������� ��� ��� ������
		(test (>= ?curSize ?maxSize)) ; ��������� ��� �� ���������� ���� �������
		=>
		;(printout t "FAILED AM:" ?AM " labID:" ?labID " courseID:" ?courseID " CurSize:" ?curSize " MaxSize:" ?maxSize crlf) ; DEBUG
		(retract ?r1) ; �������� ��� ������������� ���������� ��� ��� ���������
		(addRegistration ?AM ?labID ?courseID ?initialPref "false" "labFull")
		(assert (SHIFT_PHASE::bumpPreferences ?AM ?courseID))
		(focus SHIFT_PHASE) ; ��������� �� ���� ��������� ��� �� ���������������� �� ��������������
		(run)
	)