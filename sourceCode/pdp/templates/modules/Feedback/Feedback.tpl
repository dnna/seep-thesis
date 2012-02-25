{* Smarty template *}

{assign var="pageTitle" value="Σχόλια/Αναφορά Προβλημάτων"}
{include file="templates/header.tpl"}

<div>
	<h2 class="sectiontitle">{$pageTitle}</h2>
	<div class="sectioncontent">
                <p>Μπορείτε να χρησιμοποιήσετε την παρακάτω φόρμα για να μας αποστέλετε<BR>
                σχόλια, παρατηρήσεις, αναφορές σφαλμάτων (bugs) ή οτι άλλο κρίνετε χρήσιμο.</p>
                <p>Η διεύθυνση E-Mail είναι προαιρετική, εάν δεν την εισάγετε τότε η φόρμα είναι ανώνυμη.</p>
                <form action="?module=Feedback&ProcessFeedback" id="statementForm" method="POST">
                    <p>Διεύθυνση E-Mail:<BR>
                    <input type="text" name="email" /><BR></p>
                    <p>Περιγραφή:<BR>
                    <textarea name="comments" rows="15" cols="50" onKeyDown="limitText(this.form.comments,this.form.countdown,1000);"
                    onKeyUp="limitText(this.form.comments,this.form.countdown,1000);"></textarea><br>
                    <font size="1">(Μέγιστοι χαρακτήρες: 1000)<br>
                    Σας απομένουν <input readonly type="text" name="countdown" size="3" value="1000"> χαρακτήρες.</font></p>
                    <p><input type="submit" value="Αποστολή" /></p>
                </form>
	</div>
</div>

{include file="templates/footer.tpl"}