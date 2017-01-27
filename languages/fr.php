<?php 
 
return array( 
    'scheduling' => 'Planificateur', 
    'scheduling:add' => 'Ajouter une nouvelle réunion à planifier', 
    'item:object:scheduling_poll' => 'Sondage planificateur', 
    'item:object:scheduling_poll_slot' => 'Créneaux horaire', 
    'scheduling:date_format' => 'D n/j/Y', 
    'scheduling:edit:time' => 'Changer les horaires', 
    'scheduling:slot:title' => 'Créneau %s', 
    'scheduling:column:add' => 'Ajouter une colonne', 
    'scheduling:row:copy' => 'Dupliquer la ligne', 
    'scheduling:row:delete' => 'Supprimer la ligne', 
    'scheduling:error:invalid_format' => 'L\'horaire doit être au format HH:MM', 
    'scheduling:add_day' => 'Ajouter une nouvelle journée', 
    'scheduling:group:enable' => 'Autorisé la création de planification dans les groupes', 
 
    'scheduling:owner_block' => 'planificateur', 
    'scheduling:owner_block:group' => 'planificateur de groupe', 
 
    'scheduling:save:success' => 'Sondage enregistré', 
    'scheduling:save:error' => 'Une erreur s\'est produit. Vérifier que les valeurs soient correctes.', 
    'scheduling:error:cannot_edit' => 'Vous n\'êtes pas autorisé à modifier ce contenu', 
    'scheduling:delete:success' => 'Sondage supprimé', 
    'scheduling:delete:error' => 'La suppression du sondage à échouée', 
 
    // form
    'scheduling:form:anwser:yes' => 'Oui',
    'scheduling:form:anwser:maybe' => '(Oui)',
    'scheduling:form:anwser:no' => 'Non',
    'scheduling:form:anwser:title:yes' => 'Oui',
    'scheduling:form:anwser:title:maybe' => 'Si nécessaire',
    'scheduling:form:anwser:title:no' => 'Non',
    'scheduling:poll:type:label' => 'Sondage avancé',
    'scheduling:poll:type:title' => 'Réponse à 3 possibilités, Oui, Non, Peut être',
    'scheduling:poll:picked:date:label' => 'Dates selectionnées:',
    'scheduling:poll:pick:date' => 'Choississez des dates',
    'scheduling:poll:pick:date:instruction' => 'Cliquez sur le calendrier pour ajouter une date. Cliquez sur une des dates dans la liste pour la supprimer.',
    'scheduling:poll:copy:first:line' => 'Copiez les valeurs de la premiere ligne sur l\'ensemble des colonnes.',
    'scheduling:form:answer:not:available' => 'Pas disponible',
    
    // Notifications 
    'scheduling:notify:publish:subject' => 'Nouveau sondage du planificateur', 
    'scheduling:notify:publish:body' => '%s as créé un nouveau sondage du planificateur: "%s" 
 
%s', 
    'scheduling:notify:publish:summary' => '%s as créé un nouveau sondage du planificateur: %s', 
    'scheduling:notify:update:subject' => 'Mettre a jour le sondage', 
    'scheduling:notify:update:body' => '%s as mis à jour le sondage du planificateur "%s" auquel vous aviez répondu. 
 
Vous devriez vérifier si votre réponse nécessite  une mise à jour: 
%s', 
    'scheduling:notify:update:summary' => '%s as mis à jour le sondage du planificateur: %s', 
 
    'river:create:object:scheduling_poll' => '%s as créé un nouveau sondage du planificateur %s', 
); 