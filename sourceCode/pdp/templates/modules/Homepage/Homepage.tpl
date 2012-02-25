{* Smarty template *}

{assign var="pageTitle" value="Αρχική Σελίδα"}
{include file="templates/header.tpl"}

<div>
	<h2 class="sectiontitle">{$pageTitle}</h2> 
	<p class="sectioncontent">
                <strong>Για αυθεντικοποίηση μπορείτε να χρησιμοποιήσετε το λογαριασμό που έχετε στο<BR>
                    <a href="http://eclass.cs.teiath.gr">http://eclass.cs.teiath.gr</a></strong><BR>
                <BR>
                <strong>Υλοποιήθηκε στα πλαίσια της πτυχιακής εργασίας του Δημοσθένη Νικούδη<BR>
                για το Τεχνολογικό Εκπαιδευτικό Ίδρυμα Αθήνας</strong><BR>
                <BR>
                <strong>Σύστημα κληρώσεων:</strong><BR>
                Έμπειρο Σύστημα υλοποιημένο σε Java/Jess.<BR>
                <BR>
                <strong>Περιβάλλον Δήλωσης Προτιμήσεων:</strong><BR>
                PHP, MySQL και SOAP Client.
	</p>
</div>

{include file="templates/footer.tpl"}