<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//

/**
 * Language file: shop.inc.php
 * Provides language strings.
 * Language: English
 */

$l_shop["user_saved_ok"] = "L'utilisateur '%s' a �t� enregistr� avec succ�s";
$l_shop["user_saved_nok"] = "L'utilisateur '%s' ne peut pas �tre enregistrer!";
$l_shop["nothing_to_save"] = "Rien � enregristrer!";
$l_shop["username_exists"] = "L'Identifiant '%s' existe d�j�!";
$l_shop["username_empty"] = "L'Identifiant n'est pas rempli!";
$l_shop["user_deleted"] = "L'utilisateur '%s' a �t� supprim� avec succ�s!";
$l_shop["nothing_to_delete"] = "Rien � supprimer!";
$l_shop["delete_last_user"] = "Au moins un administrateur est indispensable pour l'administration.\\nVous ne pouvez pas supprimer l'administrateur.";
$l_shop["modify_last_admin"] = "Au moins un administrateur est indispensable pour l'administration.\\nVous ne pouvez pas changer les droits de l'administrateur.";
$l_shop["no_order_there"] = "Aucune commande ouvert!";

$l_shop["user_data"] = "Donn�es de l'utilisateur";
$l_shop["first_name"] = "Pr�nom";
$l_shop["second_name"] = "Nom";
$l_shop["username"] = "Identifiant";
$l_shop["password"] = "Mot de passe";

$l_shop["workspace_specify"] = "Sp�cifier l'�space de travail";
$l_shop["permissions"] = "Droits";
$l_shop["user_permissions"] = "Redacteur";
$l_shop["admin_permissions"] = "Administrateur";

$l_shop["password_alert"] = "Il faut que le mot de passe a au moins une longeur de 4 chiffres";
$l_shop["delete_alert"] = "Tous les donn�es de l'utilisateur '%s' seront supprimer.\\n �tes-vous s�r?";

$l_shop["created_by"] = "Cr�� par";
$l_shop["changed_by"] = "Chang� par";

$l_shop["no_perms"] = "Vous n'avez pas l'autorisation, d'effectuer cette option!";
$l_shop["ue_data"] = "Aper�u pour";

$l_shop["stat"] = "�valuation statistique";
$l_shop["del_shop"] = "�tes-vous s�r de supprimer cette commande?";
$l_shop["order_liste"] = "Tous les commandes du client:";

$l_shop["einfueg"] = "Add item";
$l_shop["pref"] = "Shop setting";
$l_shop["waehrung"] = "Monnaie";
$l_shop["mwst"] = "Sales tax";
$l_shop["mwst_expl"] = "Depuis Since la version 3.5 il est possible d'utiliser plusieurs taux de TVA, qui sont sauvegard�s directement dans la commande avec l'article. Cette valeur ici, est seulement utilis� pour des commandes anciennes. Changements de cette valeur influencent tout les commandes qui ont �t� fait sans le taux de TVA standard ou avec un taux de tva qui a �t� sauvegard� directement avec l'article.";
$l_shop["format"] = "Number format";
$l_shop["pageMod"] = "Entr�e par Page";

$l_shop["bestellungvom"] = "Commande du";
$l_shop["keinedaten"] = "Aucun param�tre a �t� rendu";
$l_shop["datum"] = "Date"; // TRANSLATE
$l_shop["anzahl"] = "Nombre de commande";
$l_shop["umsatzgesamt"] = "total";
$l_shop["Artikel"] = "Article";
$l_shop["Anzahl"] = "Nombre";
$l_shop["variant"] = "Variante";
$l_shop["customField"] = "Champ personnalis�";
$l_shop["customFieldDesc"] = "Saisissez de la fa�on: <i>nom1=valeur1;nom2=valeur2; ... </i>";
$l_shop["Titel"] = "Titre";
$l_shop["Beschreibung"] = "Description"; // TRANSLATE
$l_shop["Gesamt"] = "Total"; // TRANSLATE
$l_shop["jsanzahl"] = "S\'il vous pla�t saisissez la quantit� de l'article";

$l_shop["geloscht"] = "L'enregistrement a �t� supprim� avec succ�s.";
$l_shop["loscht"] = "Enregistrement supprim�";
$l_shop["orderDoesNotExist"] = "This order does not exist any more."; // TRANSLATE

$l_shop["selectYear"] = "Choisissez l'ann�e";
$l_shop["selectMonth"] = "Choisissez le mois";
$l_shop["jsanz"] = "S\'il vous pla�t saisissez le nombre";
$l_shop["keinezahl"] = "Votreentr�e n'est pas un nombre";
$l_shop["jsbetrag"] = "S\'il vous pla�t saisissez la somme";
$l_shop["jsloeschen"] = "�tes-vous s�re, que vous voulez vraiment supprimer cet article? Ce processus Dieser est irreversible.";
$l_shop["Preis"] = "Prix";
$l_shop["MwSt"] = "TVA";
$l_shop["gesamtpreis"] = "Prix Compl�t";
$l_shop["plusVat"] = "plus TVA";
$l_shop["includedVat"] = "contient TVA";

$l_shop["bestellnr"] = "Num�ro de commande:";
$l_shop["bearbeitet"] = "Trait� le:";
$l_shop["bezahlt"] = "Pay� le:";
$l_shop["datumeingabe"] = "Il faut que vous saisissez la date en format dd.mm.yy .";

$l_shop["order_data"] = "Donn�es de Commande/Client";
$l_shop["ordered_articles"] = "Articles command�s";
$l_shop["order_comments"] = "Commentaires suppl�mentaire pour cette commande";
$l_shop["order_view"] = "Order summary"; // TRANSLATE
$l_shop["bestelldatum"] = "Date de la Commande:";
$l_shop["jsdatum"] = "S\'il vous pla�t, saisissez une date";
$l_shop["unbearb"] = "Non trait�";
$l_shop["unbezahlt"] = "Davon unbezahlt";
$l_shop["schonbezahlt"] = "Non pay�";
$l_shop["monat"] = "Mois";
$l_shop["bestellung"] = "Commande";


$l_shop["noRecordAlert"] = "Aucune entr�e a �t� trouv� pour cette <strong>ID-de-Classe</strong>.<br />";
$l_shop["noRecordAlert"] .=" S'il vous pla�t changez auf pr�f�rence pour �diter ou r�-entr�e!";
$l_shop["einfueg"] = "Ajouter un article";
$l_shop["pref"] = "Pr�f�rences";
$l_shop["paymentP"] = "Fournisseur de Paiement";
$l_shop["waehrung"] = "Monnaie";
$l_shop["mwst"] = "TVA";
$l_shop["format"] = "Format de nombre";

$l_shop["revenue_list"] = "Chiffre d'affaires annuel: ";
$l_shop["anual"] = "Ann�e ";
$l_shop["selYear"] = "S�lection ";

// shop_extend
$l_shop["ArtList"] = "Liste de tous les articles";
$l_shop["ArtName"] = "Nom de l'article";
$l_shop["ArtID"] = "ID"; // TRANSLATE
$l_shop["docType"] = "Type"; // TRANSLATE
$l_shop["artCreate"] = "Date de Cr�ation";
$l_shop["artCreateAlt"] = "Trier par date de cr�ation";
$l_shop["artMod"] = "Derni�re mis-�-jour";
$l_shop["artPub"] = "Publi� le:";
$l_shop["artModAlt"] = "Trier par derni�re mis-�-jour";
$l_shop["artHas"] = "Variantes";
$l_shop["artHasAlt"] = "Trier par (a/n'a pas de) Variantes";
$l_shop["artNameAlt"] = "Trier par nom d'article ";
$l_shop["artIDAlt"] = "Trier par ID ";
$l_shop["classSel"] = "Classes de Boutique disponible: ";

// shop_revenue
$l_shop["artName"] = "Nom d'Article";
$l_shop["artPrice"] = "Prix";
$l_shop["artOrdD"] = "Date de Commande";
$l_shop["artID"] = "ID-Article";
$l_shop["artPay"] = "Pay�";

$l_shop["artTotal"] = "Article total"; // TRANSLATE
$l_shop["currPage"] = "Page"; // TRANSLATE

$l_shop["noRecord"] = "Aucune entr�e trouv�e";
$l_shop["artNPay"] = "en suspens";
$l_shop["isObj"] = "Object"; // TRANSLATE
$l_shop["isDoc"] = "Document"; // TRANSLATE
$l_shop["classID"] = "ID-Classe";
$l_shop["classIDext"] = "* ID-Classe-Boutique- [ID,ID,ID ..]";
$l_shop["paypal"] = "PayPal"; // TRANSLATE
$l_shop["saferpay"] = "Saferpay"; // TRANSLATE
$l_shop["lc"] = "Code de pays";
$l_shop["paypalLcTxt"] = "* (ISO)"; // TRANSLATE
$l_shop["paypalbusiness"] = "Business"; // TRANSLATE
$l_shop["paypalbTxt"] = "* Email de PayPal";



$l_shop["paypalSB"] = "Compte";
$l_shop["paypalSBTxt"] = " Compte de Test ou Live";
$l_shop["saferpayTermLang"] = "Language"; // TRANSLATE
$l_shop["saferpayID"] = "ID-Account";
$l_shop["saferpayIDTxt"] = "* Nr de Serie";
$l_shop["saferpayNo"] = "Non";
$l_shop["saferpayYes"] = "Oui";
$l_shop["saferpayLcTxt"] = "* en, de, fr, it"; // TRANSLATE
$l_shop["saferpaybusiness"] = "Op�rateur de boutique";
$l_shop["saferpaybTxt"] = "* information par email";
$l_shop["saferpayAllowCollect"] = "permettre de collecter?";
$l_shop["saferpayAllowCollectTxt"] = "* regardez dans le manuel de saferpay !";
$l_shop["saferpayDelivery"] = "Formulaire suppl.?";
$l_shop["saferpayDeliveryTxt"] = "* pour l'adresse de livraison";
$l_shop["saferpayUnotify"] = "Confirmation"; // TRANSLATE
$l_shop["saferpayUnotifyTxt"] = "* Mail de Confirmation au Client";
$l_shop["saferpayProviderset"] = "Providerset"; // TRANSLATE
$l_shop["saferpayProvidersetTxt"] = "* s�par�-par-virgule!";
$l_shop["saferpayCMDPath"] = "exec-path"; // TRANSLATE
$l_shop["saferpayCMDPathTxt"] = "* p.ex. /usr/local/bin/";
$l_shop["saferpayconfPath"] = "conf-path"; // TRANSLATE
$l_shop["saferpayconfPathTxt"] = "* chemin de saferpay";
$l_shop["saferpaydesc"] = "Description"; // TRANSLATE
$l_shop["saferpaydescTxt"] = "* p.ex. commande";
$GLOBALS["l_shop"]["saferpayError"] = "Saferpay n'est pas correctement install�. S'il vous pla�t configurez votre compte. Saferpay retourne les variables suivantes:\n<br/>";
$l_shop["NoRevenue"] = "Il n'y a aucun rendement dans la period s�l�ction�e.";


$l_shop["FormFieldsTxt"] = "Champs disponible pour la transmission au fournisseur de paiement";
$l_shop["fieldForname"] = "Pr�nom";
$l_shop["fieldSurname"] = "Nom de Famille";
$l_shop["fieldStreet"] = "Rue";
$l_shop["fieldZip"] = "Code Postale";
$l_shop["fieldCity"] = "Ville";
$l_shop["fieldEmail"] = "E-Mail";
$l_shop["SelectAll"]= "Tous";
$l_shop["plzh"] = "joker";
$l_shop["lastOrder"] = "Last order - Nr.: %s, %s";
$l_shop["orderNo"] = "No.: %s vom %s"; // TRANSLATE
$l_shop["sl"] = "-"; // TRANSLATE
$l_shop["treeYear"] = "Ann�e";


// vats dialogs
$l_shop['vat']['save_success'] = 'TVA enregistr�e avec succ�s.';
$l_shop['vat']['save_error'] = 'La TVA n\'a pas pu �tre enregistr�e.';
$l_shop['vat']['delete_success'] = 'La TVA a �t� supprim�e avec succ�s.';
$l_shop['vat']['delete_error'] = 'La TVA n\'a pas pu �tre supprim�e.';

$l_shop['vat']['new_vat_name'] = 'Nouveau TVA';
$l_shop['vat']['js_confirm_delete'] = 'Supprimer vraiment la TVA choissi?';

$l_shop['vat']['vat_form_id'] = 'Id'; // TRANSLATE
$l_shop['vat']['vat_form_name'] = 'Nom';
$l_shop['vat']['vat_form_vat'] = 'Tau de TVA';
$l_shop['vat']['vat_form_standard'] = 'Standard'; // TRANSLATE
$l_shop['vat']['vat_edit_form_headline'] = '�diter le taux de TVA';
$l_shop['vat']['vat_edit_form_headline_box'] = '�diter le taux de TVA';
$l_shop['vat']['vat_edit_form_yes'] = 'Oui';
$l_shop['vat']['vat_edit_form_no'] = 'Non';

$l_shop['vat_country']['box_headline'] = 'Ensemble de r�gles: Des clients de quels pays doivent payer une TVA';
$l_shop['vat_country']['defaultReturn'] = 'Valeur standard';
$l_shop['vat_country']['defaultReturn_desc'] = 'La valeur standar d�finit le r�sultat de we:ifShopPayVat, si aucune des r�gles suivantes ne s\'assortit. Si aucune r�gle est d�fini, la valeur standard est utilis�e';
$l_shop['vat_country']['stateField'] = 'Champ de pays';
$l_shop['vat_country']['stateField_desc'] = 'Choisissez le champ du gestion clients qui contient le pays d\'origine (Adresse de facture. Il est utilis� pour d�finir, si un clients doit payer la TVA ou pas.';
$l_shop['vat_country']['statesLiableToVat'] = 'Pays expos�s � la TVA';
$l_shop['vat_country']['statesLiableToVat_desc'] = 'Client de ces pays doivent payer de TVA.';
$l_shop['vat_country']['statesNotLiableToVat'] = 'Pays non expos�s � la TVA';
$l_shop['vat_country']['statesNotLiableToVat_desc'] = 'Client de ces pays ne doivent pas payer de TVA.';

$l_shop['vat_country']['statesSpecialRules'] = 'Pays avec r�gles sp�ciales';
$l_shop['vat_country']['statesSpecialRules_desc'] = 'Clients de ces pays paient la TVA seulement, si une r�gle suppl�mentaire s\'assorti.';
$l_shop['vat_country']['statesSpecialRules_condition'] = 'R�gle';
$l_shop['vat_country']['statesSpecialRules_result'] = 'R�sultat';

$l_shop['vat_country']['condition_is_empty'] = 'Vide';
$l_shop['vat_country']['condition_is_set'] = 'Remplis';

$l_shop['shipping']['shipping_package'] = 'Shipping and handling'; // TRANSLATE
$l_shop['shipping']['prices_are_net'] = 'Les prix sont nets';
$l_shop['shipping']['insert_packaging'] = 'Taux existants';
$l_shop['shipping']['payment_provider'] = 'Fornisseur de paiement';
$l_shop['shipping']['revenue_view'] = 'Articles- / Redements';

$l_shop['preferences']['customerFields'] = "Champs de client<br />(gestion de clients)";
$l_shop['preferences']['orderCustomerFields'] = 'Champs de client<br />(Commande)';

$l_shop['preferences']['customerdata'] = 'Donn�es de clients';
$l_shop['preferences']['explanation_customer_odercustomer'] = 'Explication: Ces donn�es sont seulement enregistr�es avec la commande, les donn�es du gestions de client ne seront pas affect�es.';

$l_shop['order']['edit_order_customer'] = '�diter les donn�es du client dans cette commande.';
$l_shop['order']['open_customer'] = 'Ovrir ce client dans le module gestion clients.';

$l_shop['edit_order']['shipping_costs'] = 'Frais de livraison';
$l_shop['edit_order']['js_edit_custom_cart_field'] = 'Nouvelle valuer pour %s:.';
$l_shop['edit_order']['js_edit_cart_field_noFieldname'] = 'S\'il vous pla�t saisissez un nom de champ.';
$l_shop['edit_order']['js_saved_cart_field_success'] = 'Le champ du panier de commande "%s" a �t� enregistr�e.';
$l_shop['edit_order']['js_saved_cart_field_error'] = 'Le champ du panier de commande "%s" n\'a pas pu �tre enregistr�.';
$l_shop['edit_order']['js_delete_cart_field'] = 'Supprimer le champ %s de la commande?';
$l_shop['edit_order']['js_delete_cart_field_success'] = 'Le champ  %s a �t� supprim� de cette commande.';
$l_shop['edit_order']['js_delete_cart_field_error'] = 'Le champ %s n\'a pas pu �tre supprim� de cette commande.';
$l_shop['edit_order']['js_saved_shipping_success'] = 'Les frais de livraison ont �t� enregistr�s.';
$l_shop['edit_order']['js_saved_shipping_error']   = 'Les frais de livraison n\'ont pas pu �tre enregistr�s.';
$l_shop['edit_order']['js_saved_customer_success'] = 'Les donn�es de client ont �t� enregistr�es avec succ�s.';
$l_shop['edit_order']['js_saved_customer_error']   = 'Les donn�es de client n\'ont pas pu �tre enregistr�es.';
$l_shop['edit_order']['js_edit_vat']   = 'S\'il vous pla�t saisissez la nouvelle TVA.';

$l_shop['edit_order']['calculate_vat']   = 'Calculer la TVA';
$l_shop['edit_order']['js_saved_calculateVat_success'] = 'Les modifications ont �t� enregistr�s.';
$l_shop['edit_order']['js_saved_calculateVat_error'] = 'Les modifications n\'ont pas pu �tre enregistr�es.';


$l_shop['orderList']['noOrders'] = 'Ce clinet n\'a encore rien command�.';
$l_shop['orderList']['order'] = 'commande';
$l_shop['orderList']['orderDate'] = 'command� le ';
$l_shop['orderList']['orderPayed'] = 'pay� le';
$l_shop['orderList']['orderEdited'] = 'trait�e le';

$l_shop['add_article']['title'] = 'Ajouter un article';
$l_shop['add_article']['entry_x_to_y_from_z'] = 'Entr�e %s � %s de %s';
$l_shop['add_article']['empty_articles'] = 'Aucun article a �t� trouv�.';

$l_shop['edit_shipping_cost']['title'] = '�diter le frais de livraison';
$l_shop['edit_shipping_cost']['vatRate'] = 'Taux de TVA';
$l_shop['edit_shipping_cost']['isNet'] = 'indication net';

$l_shop['add_shop_field'] = 'Add field to this Order'; // TRANSLATE
$l_shop['field_name'] = 'Nom';
$l_shop['field_value'] = 'Valeur';
$l_shop['field_empty_js_alert'] = 'Fieldname must not be empty'; // TRANSLATE

$l_shop['edit_article_variants'] = 'Edit shop article variants'; // TRANSLATE
$l_shop['new_entry'] = 'New entry'; // TRANSLATE

$l_paypal['head_title']    = 'Processing Payment'; // TRANSLATE
$l_paypal['redirect_auto'] = 'Please wait while your payment is processed. You will be redirected to PayPal shortly.'; // TRANSLATE
$l_paypal['redirect_man']  = 'If you are not automatically redirected within the next 5 seconds, please click the "PayPal" button.'; // TRANSLATE
?>