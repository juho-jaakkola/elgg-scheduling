<?php

return array(
	'scheduling' => 'Aikataulutus',
	'scheduling:add' => 'Lisää uusi kysely',
	'item:object:scheduling_poll' => 'Aikataulukysely',
	'item:object:scheduling_poll_slot' => 'Aikataulukyselyn vaihtoehto',
	'scheduling:date_format' => 'D j.n.Y',
	'scheduling:edit:time' => 'Muokkaa aikoja',
	'scheduling:slot:title' => 'Aika %s',
	'scheduling:column:add' => 'Lisää sarake',
	'scheduling:row:copy' => 'Kopioi rivi',
	'scheduling:row:delete' => 'Poista rivi',
	'scheduling:error:invalid_format' => 'Ajan pitää olla muodossa HH:MM',
	'scheduling:add_day' => 'Lisää päivä',
	'scheduling:group:enable' => 'Ota käyttöön ryhmän aikataulutyökalu',

	'scheduling:owner_block' => 'Aikataulutus',
	'scheduling:owner_block:group' => 'Ryhmän aikataulutus',

	'scheduling:save:success' => 'Kysely tallennettu',
	'scheduling:save:error' => 'Jotakin meni pieleen. Tarkista, että syöttämäsi tiedot ovat oikein.',
	'scheduling:save:error:no:days' => 'You must select at least one date.',
	'scheduling:error:cannot_edit' => 'Sinulla ei ole oikeuksia tämän kyselyn muokkaamiseen',
	'scheduling:delete:success' => 'Kysely poistettu',
	'scheduling:delete:error' => 'Kyselyn poistaminen epäonnistui',
	
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
	
	// Notifications
	'scheduling:notify:publish:subject' => 'Uusi aikataulukysely',
	'scheduling:notify:publish:body' => '%s lisäsi uuden aikataulukyselyn: "%s"

%s',
	'scheduling:notify:publish:summary' => '%s lisäsi uuden aikataulukyselyn: "%s"',
	'scheduling:notify:update:subject' => 'Päivittynyt aikataulukysely',
	'scheduling:notify:update:body' => '%s on päivittänyt kyselyä "%s", johon olet vastannut aiemmin.

Tarkista, vaikuttavatko muutokset aikaisemman antamaasi vastaukseen:
%s',
	'scheduling:notify:update:summary' => '%s on päivittänyt kyselyä: %s',

	'river:create:object:scheduling_poll' => '%s lisäsi uuden aikataulukyselyn %s',
	// Breadcrumb
	'scheduling:breadcrumb:add:days' => 'Add days',
	'scheduling:breadcrumb:add:slots' => 'Add Slots',
);
