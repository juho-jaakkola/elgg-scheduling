<?php

return array(
	'scheduling:date_format' => 'D j/n/Y',
	'scheduling' => 'Programmazione',
	'scheduling:add' => 'Nuovo sondaggio',
	'item:object:scheduling_poll' => 'Sondaggi per le programmazioni',
	'item:object:scheduling_poll_slot' => 'Orari del sondaggio per la programmazione',
	'scheduling:edit:time' => 'Modifica gli orari',
	'scheduling:slot:title' => 'Orario %s',
	'scheduling:column:add' => 'Aggiungi colonna',
	'scheduling:row:copy' => 'Duplica riga',
	'scheduling:row:delete' => 'Elimina riga',
	'scheduling:error:invalid_format' => "L'ora deve essere nel formato OO:MM",
	'scheduling:add_day' => 'Aggiungi un giorno',
	'scheduling:group:enable' => 'Abilita lo strumento programmazione per il gruppo',
	
	'scheduling:owner_block' => 'Programmazione',
	'scheduling:owner_block:group' => 'Programmazione del gruppo',
	
	'scheduling:save:success' => 'Sondaggio per la programmazione salvato',
	'scheduling:save:error' => 'Qualcosa non ha funzionato. per favore verifica che i valori inseriti siano validi.',
	'scheduling:error:cannot_edit' => 'Non sei autorizzato/a a modificare questo contenuto',
	'scheduling:delete:success' => 'Sondaggio per la programmazione eliminato',
	'scheduling:delete:error' => 'Eliminazione sondaggio non riuscita',
	
	// form
	'scheduling:form:anwser:yes' => 'Yes',
	'scheduling:form:anwser:maybe' => '(Yes)',
	'scheduling:form:anwser:no' => 'No',
	'scheduling:form:anwser:title:yes' => 'Yes',
	'scheduling:form:anwser:title:maybe' => 'If necessary',
	'scheduling:form:anwser:title:no' => 'No',
	'scheduling:poll:type:label' => 'Advance Poll',
	'scheduling:poll:type:title' => 'Get 3 choices, Yes, Maybe, No',
	'scheduling:poll:picked:date:label' => 'Selected Dates:',
	'scheduling:poll:pick:date' => 'Pick some dates',
	'scheduling:poll:pick:date:instruction' => 'Just click on date in the calendar to add it. Just click on it in the list to delete this date.',
	'scheduling:poll:copy:first:line' => 'Copy all the first line value to others',
	'scheduling:poll:delete:title' => 'Delete this row',
	'scheduling:poll:duplicate:title' => 'Duplicate this row',
	'scheduling:form:answer:not:available' => 'Not available',
        
	// notification
	'scheduling:notify:publish:body' => '%s ha creato un nuovo sondaggio per la programmazione: "%s"

%s',
	'scheduling:notify:publish:summary' => '%s ha creato un nuovo sondaggio per la programmazione: %s',
	'scheduling:notify:update:subject' => 'Sondaggio per la programmazione aggiornato',
	'scheduling:notify:update:body' => '%s ha aggiornato il sondaggio per la programmazione "%s" a cui hai già risposto.

Verifica se la tua risposta deve essere modificata:
%s',
	'scheduling:notify:publish:subject' => 'Nuovo sondaggio per la programmazione',
	'scheduling:notify:update:summary' => '%s ha aggiornato il sondaggio per la programmazione: %s',
	'river:create:object:scheduling_poll' => '%s ha creato il nuovo sondaggio per la programmazione %s',
	// Breadcrumb
	'scheduling:breadcrumb:add:days' => 'Add days',
	'scheduling:breadcrumb:add:slots' => 'Add Slots',
);
