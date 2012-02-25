{* Smarty template *}

<head>
    <title>Εγγεγραμένοι Φοιτητές</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
    <table border="1">
        <thead>
            <tr><th>Α.Μ.</th><th>Όνομα</th></tr>
        </thead>
        <tbody>
        {foreach from=$students key=k item=curStudent}
            <tr><td>{$curStudent.username|substr:2}</td><td>{$curStudent.name}</td></tr>
        {/foreach}
        </tbody>
    </table>
    <form action="">
        <input type="button" name="close" value="Κλείσιμο" onClick="self.close();" />
    </form>
</body>