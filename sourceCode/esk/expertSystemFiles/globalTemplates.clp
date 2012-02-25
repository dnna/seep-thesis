(import archon.lottery.RegistrationUpdater.*)

;(defglobal ?*regUpdater* = (new archon.lottery.RegistrationUpdater.RegistrationUpdater)) ; ������������� ���������������� ��� ��� Java

(deftemplate Registration
	(declare (from-class Registration)
			 (include-variables TRUE)
	)
)

(deftemplate MAIN::studentPreference
	"���� ��� ���������� ��� ��������� ���� ��������� ��� ��� ������������ �����."
	(slot AM (type STRING)) ; � ������� ������� ��� ���������.
	(slot labID (type STRING)) ; � ������� ��� ������������� ��������.
	(slot PREFERENCE (type INTEGER)) ; � ������� ���������� ��� ���������.
	(slot INITIAL-PREFERENCE (type INTEGER)) ; � ������� ���������� ���� �������� �� ������� (��� ����� �� ����������).
)

(deftemplate MAIN::labHours
	"���� ��� ���������� ����������� ��� ��� ����/������ ��� ���������� ��� ������������ �����."
	(slot labID (type STRING)) ; � ������� ��� ������������� ��������.
	(slot labDay (type STRING)) ; ID ��� ������ (0 �������, 1 ����� ���.)
	(slot labStartTime (type INTEGER)) ; ��� ������� ����������� (�� 16)
	(slot labEndTime (type INTEGER)) ; ��� ����� ����������� (�� 18)
)

(deftemplate MAIN::labInfo
	"���� ��� ���������� ����������� ��� ��� ������������ �����."
	(slot labID (type STRING)) ; � ������� ��� ������������� ��������.
	(slot courseID (type STRING)) ; � ������� ��� ���������.
	(slot curSize (type INTEGER)) ; ������ ������� ������������� ����������
	(slot maxSize (type INTEGER)) ; �������� ������� ������������� ����������
)

(defquery get-preferences
	"������� ��� ����������� ���� ��������� ��� ��� ������������ ������."
	(declare (variables ?AM ?courseID))
	(MAIN::labInfo (courseID ?courseID) (labID ?labID)) ; ��������� �� ���������� ��� ������� �� ���� �� courseID
	(MAIN::studentPreference (AM ?AM) (labID ?labID)) ; ��������� �� � ���������� ���� ������ ��� ���� ���� ����������� ���
)

(deffunction student-has-labs-left (?AM ?courseID)
	(if (> (count-query-results get-preferences ?AM ?courseID) 0) then
		(return TRUE)
	else
		(return FALSE)
	)
)

(deffunction addRegistration (?AM ?labID ?courseID ?initialPref ?successful ?details)
	"��������� ��� ������� (����������� � �����������) ��� ����� �� �� facts ��� ��� ���� ���������. �� ��������� ������������ ��������
	������� �� � ���������� ���� ����� ����������� ��� �� ������������ ������ ��� �� ��� ���� ���� ��������� ���� ��� ��������� �������."
	(bind ?reg (new Registration ?AM ?labID ?courseID ?initialPref ?successful ?details))
	(add ?reg)
	(?*regUpdater* addRegistration ?reg)
	; �� � ������� ��� ����� ����������� ���� ��������� � ��������� ��� �� ��� ���� ����� ����������� �� ���� �� ������ � ����������
	(if (and (eq ?successful "false") (not (student-has-labs-left ?AM ?courseID))) then
		;(printout t "test" crlf)
		(bind ?reg (new Registration ?AM "0" ?courseID ?initialPref "false" "failedAllLabs"))
		(add ?reg)
		(?*regUpdater* addRegistration ?reg)
	)
)