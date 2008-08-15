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

$l_shop["user_saved_ok"] = "User '%s' has been successfully saved.";
$l_shop["user_saved_nok"] = "User '%s' cannot be saved!";
$l_shop["nothing_to_save"] = "There is nothing to save!";
$l_shop["username_exists"] = "User name '%s' already exists!";
$l_shop["username_empty"] = "User name has not been filled in!";
$l_shop["user_deleted"] = "User '%s' has been successfully deleted. ";
$l_shop["nothing_to_delete"] = "There is nothing to delete!";
$l_shop["delete_last_user"] = "At least one administrator is required for administration.\\nYou cannot delete the administrator.";
$l_shop["modify_last_admin"] = "At least one administrator is required for administration.\\nYou cannot change the administrator's privileges.";
$l_shop["no_order_there"] = "No order opened!";

$l_shop["user_data"] = "User details";
$l_shop["first_name"] = "First name";
$l_shop["second_name"] = "Last name";
$l_shop["username"] = "User name";
$l_shop["password"] = "Password";

$l_shop["workspace_specify"] = "Specify work area ";
$l_shop["permissions"] = "Privileges";
$l_shop["user_permissions"] = "Editor";
$l_shop["admin_permissions"] = "Administrator";

$l_shop["password_alert"] = "The password must be at least 4 characters long.";
$l_shop["delete_alert"] = "Delete all user details for user name '%s'.\\n Are you sure?";

$l_shop["created_by"] = "Created by";
$l_shop["changed_by"] = "Changed by";

$l_shop["no_perms"] = "You do not have permission to use this option!";
$l_shop["ue_data"] = "Overview for ";

$l_shop["stat"] = "Statistical evaluation";
$l_shop["del_shop"] = "Are you sure that you want to delete this order?";
$l_shop["order_liste"] = "All customer's orders:";

$l_shop["einfueg"] = "Add item";
$l_shop["pref"] = "Shop setting";
$l_shop["waehrung"] = "Currency";
$l_shop["mwst"] = "Sales tax";
$l_shop["mwst_expl"] = "Since version 3.5 it is possible to use several vat rates, which are saved directly with the article whithin the order. The value stored here is used only for older orders. Changes on this value affect all orders made without default vat rate or directly on article stored vat rate.";
$l_shop["format"] = "Number format";
$l_shop["pageMod"] = "Records per Page";

$l_shop["bestellungvom"] = "Order of";
$l_shop["keinedaten"] = "No parameter passed";
$l_shop["datum"] = "Date";
$l_shop["anzahl"] = "Order quantity";
$l_shop["umsatzgesamt"] = "Sales total";
$l_shop["Artikel"] = "Item";
$l_shop["Anzahl"] = "Quantity";
$l_shop["variant"] = "Variant";
$l_shop["customField"] = "Custom Field";
$l_shop["customFieldDesc"] = "Insert like: <i>name1=wert1;name2=wert2; ... </i>";
$l_shop["Titel"] = "Title";
$l_shop["Beschreibung"] = "Description";
$l_shop["Gesamt"] = "Total";
$l_shop["jsanzahl"] = "Please enter the item quantity.";

$l_shop["geloscht"] = "Record successfully deleted.";
$l_shop["loscht"] = "Record deleted.";
$l_shop["orderDoesNotExist"] = "This order does not exist any more.";

$l_shop["selectYear"] = "Select Year";
$l_shop["selectMonth"] = "Select Month";
$l_shop["jsanz"] = "Please enter the quantity.";
$l_shop["keinezahl"] = "Your input is not a number!";
$l_shop["jsbetrag"] = "Please enter the amount.";
$l_shop["jsloeschen"] = "Are you sure that you want to delete this item? This process cannot be reversed.";
$l_shop["Preis"] = "Price";
$l_shop["MwSt"] = "Sales tax";
$l_shop["gesamtpreis"] = "Total price";
$l_shop["plusVat"] = "plus VAT";
$l_shop["includedVat"] = "contains VAT";

$l_shop["bestellnr"] = "Order no.:";
$l_shop["bearbeitet"] = "Processed on:";
$l_shop["bezahlt"] = "Paid on:";
$l_shop["datumeingabe"] = "You must enter the date in the format mm/dd/yy.";

$l_shop["order_data"] = "Order and<br>user details";
$l_shop["ordered_articles"] = "Items ordered";
$l_shop["order_comments"] = "Further comments to this order";
$l_shop["order_view"] = "Order summary";
$l_shop["bestelldatum"] = "Order date:";
$l_shop["jsdatum"] = "Please enter the date.";
$l_shop["unbearb"] = "Unprocessed";
$l_shop["unbezahlt"] = "Unpaid";
$l_shop["schonbezahlt"] = "Paid";
$l_shop["monat"] = "Month";
$l_shop["bestellung"] = "Order";


$l_shop["noRecordAlert"] = "No record has been found for this <strong>Class-ID</strong>.<br />";
$l_shop["noRecordAlert"] .=" Please switch to Preferences for modifying or reentry !";
$l_shop["einfueg"] = "Add an Article";
$l_shop["pref"] = "Preferences";
$l_shop["paymentP"] = "Payment Provider";
$l_shop["waehrung"] = "Currency";
$l_shop["mwst"] = "VAT";
$l_shop["format"] = "Numberformat";

$l_shop["revenue_list"] = "Annual Turnover: ";
$l_shop["anual"] = "Year ";
$l_shop["selYear"] = "Selection ";

// shop_extend
$l_shop["ArtList"] = "List of all articles";
$l_shop["ArtName"] = "Article Name ";
$l_shop["ArtID"] = "ID";
$l_shop["docType"] = "Type";
$l_shop["artCreate"] = "Creation Date";
$l_shop["artCreateAlt"] = "Sort for Creation Date";
$l_shop["artMod"] = "Last Updated";
$l_shop["artPub"] = "Published on:";
$l_shop["artModAlt"] = "Sort for Last Updated";
$l_shop["artHas"] = "Variants";
$l_shop["artHasAlt"] = "Sort for (has/has no) Variants";
$l_shop["artNameAlt"] = "Sort articles by name ";
$l_shop["artIDAlt"] = "Sort articles by ID ";
$l_shop["classSel"] = "available Shop-Classes: ";

// shop_revenue
$l_shop["artName"] = "Article Name";
$l_shop["artPrice"] = "Price";
$l_shop["artOrdD"] = "Date of Order";
$l_shop["artID"] = "Article-ID";
$l_shop["artPay"] = "Paid";

$l_shop["artTotal"] = "Article total";
$l_shop["currPage"] = "Page";

$l_shop["noRecord"] = "No record found!";
$l_shop["artNPay"] = "pending";
$l_shop["isObj"] = "Object";
$l_shop["isDoc"] = "Document";
$l_shop["classID"] = "Class-ID";
$l_shop["classIDext"] = "* Shop-Object-ID [ID,ID,ID ..]";
$l_shop["paypal"] = "PayPal";
$l_shop["saferpay"] = "Saferpay";
$l_shop["lc"] = "Country Code";
$l_shop["paypalLcTxt"] = "* (ISO)";
$l_shop["paypalbusiness"] = "Business";
$l_shop["paypalbTxt"] = "* PayPal E-Mail";



$l_shop["paypalSB"] = "Account";
$l_shop["paypalSBTxt"] = " Test or Live Account";
$l_shop["saferpayTermLang"] = "Language";
$l_shop["saferpayID"] = "Account-ID";
$l_shop["saferpayIDTxt"] = "* Serial-No";
$l_shop["saferpayNo"] = "No";
$l_shop["saferpayYes"] = "Yes";
$l_shop["saferpayLcTxt"] = "* en, de, fr, it";
$l_shop["saferpaybusiness"] = "Shop Owner";
$l_shop["saferpaybTxt"] = "* Notify Email";
$l_shop["saferpayAllowCollect"] = "allow collect?";
$l_shop["saferpayAllowCollectTxt"] = "* see saferpay Manual !";
$l_shop["saferpayDelivery"] = "additional. Form?";
$l_shop["saferpayDeliveryTxt"] = "* for Deliveryaddress";
$l_shop["saferpayUnotify"] = "Confirmation";
$l_shop["saferpayUnotifyTxt"] = "* Confirmmail to Customer";
$l_shop["saferpayProviderset"] = "Providerset";
$l_shop["saferpayProvidersetTxt"] = "* comma-separated!";
$l_shop["saferpayCMDPath"] = "exec-path";
$l_shop["saferpayCMDPathTxt"] = "* z.B. /usr/local/bin/";
$l_shop["saferpayconfPath"] = "conf-path";
$l_shop["saferpayconfPathTxt"] = "* path to saferpay";
$l_shop["saferpaydesc"] = "Description";
$l_shop["saferpaydescTxt"] = "* e.g. order";
$GLOBALS["l_shop"]["saferpayError"] = "Saferpay isn't correctly installed. Please configure your Accout. saferpay has been given back the following variables:\n<br/>";
$l_shop["NoRevenue"] = "There is no Revenue within the selected period of time";


$l_shop["FormFieldsTxt"] = "Available fields for transmitting to a payment provider";
$l_shop["fieldForname"] = "Forename";
$l_shop["fieldSurname"] = "Surname";
$l_shop["fieldStreet"] = "Street";
$l_shop["fieldZip"] = "Zip";
$l_shop["fieldCity"] = "City";
$l_shop["fieldEmail"] = "E-mail";
$l_shop["SelectAll"]= "All";
$l_shop["plzh"] = "wildcard";
$l_shop["lastOrder"] = "Last order - No.: %s, %s";
$l_shop["orderNo"] = "No.: %s vom %s";
$l_shop["sl"] = "-";
$l_shop["treeYear"] = "Year";


// vats dialogs
$l_shop['vat']['save_success'] = 'Saved VAT successfully.';
$l_shop['vat']['save_error'] = 'Could not save VAT.';
$l_shop['vat']['delete_success'] = 'Deleted VAT successsfully.';
$l_shop['vat']['delete_error'] = 'Could not delete VAT.';

$l_shop['vat']['new_vat_name'] = 'New VAT';
$l_shop['vat']['js_confirm_delete'] = 'Really delete selected VAT?';

$l_shop['vat']['vat_form_id'] = 'Id';
$l_shop['vat']['vat_form_name'] = 'Name';
$l_shop['vat']['vat_form_vat'] = 'VAT rate';
$l_shop['vat']['vat_form_standard'] = 'Standard';
$l_shop['vat']['vat_edit_form_headline'] = 'Edit VAT rate';
$l_shop['vat']['vat_edit_form_headline_box'] = 'Edit VAT rate';
$l_shop['vat']['vat_edit_form_yes'] = 'Yes';
$l_shop['vat']['vat_edit_form_no'] = 'No';

$l_shop['vat_country']['box_headline'] = 'Ruleset: Customers of which states have to pay VAT';
$l_shop['vat_country']['defaultReturn'] = 'Default value';
$l_shop['vat_country']['defaultReturn_desc'] = 'Default value determines the result of we:ifShopPayVat, if none of the following rules is matching. If no rule is defined, the dafault value is returned';
$l_shop['vat_country']['stateField'] = 'Field of Country';
$l_shop['vat_country']['stateField_desc'] = 'Select the field of the Customer Module containing the country of origin (billing adress). It is used to decide, whether the customer has to pay VAT or not.';
$l_shop['vat_country']['statesLiableToVat'] = 'States liable to VAT';
$l_shop['vat_country']['statesLiableToVat_desc'] = 'Customer from these countries, must pay VAT.';
$l_shop['vat_country']['statesNotLiableToVat'] = 'States not liable to VAT';
$l_shop['vat_country']['statesNotLiableToVat_desc'] = 'Customer from these countries must not pay VAT.';

$l_shop['vat_country']['statesSpecialRules'] = 'States with special rules';
$l_shop['vat_country']['statesSpecialRules_desc'] = 'Customer from these countries only have to pay VAT, if also an additional rule matches.';
$l_shop['vat_country']['statesSpecialRules_condition'] = 'Additional Rule';
$l_shop['vat_country']['statesSpecialRules_result'] = 'Result';

$l_shop['vat_country']['condition_is_empty'] = 'Empty';
$l_shop['vat_country']['condition_is_set'] = 'Filled';

$l_shop['shipping']['shipping_package'] = 'Shipping and handling';
$l_shop['shipping']['prices_are_net'] = 'Prices are net';
$l_shop['shipping']['insert_packaging'] = 'Existing rates';
$l_shop['shipping']['payment_provider'] = 'Payment Provider';
$l_shop['shipping']['revenue_view'] = 'Articles- / Revenues';

$l_shop['preferences']['customerFields'] = "Customer fields<br />(Customer Module)";
$l_shop['preferences']['orderCustomerFields'] = 'Customer fields<br />(Order)';

$l_shop['preferences']['customerdata'] = 'Customer Data';
$l_shop['preferences']['explanation_customer_odercustomer'] = 'Explanation: These data is only saved within the order, the data of the Customer Module will not be touched.';

$l_shop['order']['edit_order_customer'] = 'Edit data of customer within this order.';
$l_shop['order']['open_customer'] = 'Open this customer in customer management module.';

$l_shop['edit_order']['shipping_costs'] = 'Shipping cost';
$l_shop['edit_order']['js_edit_custom_cart_field'] = 'New value for %s:.';
$l_shop['edit_order']['js_edit_cart_field_noFieldname'] = 'Please enter a fieldname.';
$l_shop['edit_order']['js_saved_cart_field_success'] = 'Saved shopping cart field "%s".';
$l_shop['edit_order']['js_saved_cart_field_error'] = 'Shopping cart field "%s" could not be saved.';
$l_shop['edit_order']['js_delete_cart_field'] = 'Should the the field %s be deleted from the order?';
$l_shop['edit_order']['js_delete_cart_field_success'] = 'The field %s was deleted from this order.';
$l_shop['edit_order']['js_delete_cart_field_error'] = 'The field %s could not be deleted from this order.';
$l_shop['edit_order']['js_saved_shipping_success'] = 'Saved shipping costs.';
$l_shop['edit_order']['js_saved_shipping_error']   = 'Shipping costs could not be saved.';
$l_shop['edit_order']['js_saved_customer_success'] = 'Customer data saved successfully.';
$l_shop['edit_order']['js_saved_customer_error']   = 'Could not save customer data.';
$l_shop['edit_order']['js_edit_vat']   = 'Please insert the new VAT rate.';

$l_shop['edit_order']['calculate_vat']   = 'Calculate VAT';
$l_shop['edit_order']['js_saved_calculateVat_success'] = 'Changes saved.';
$l_shop['edit_order']['js_saved_calculateVat_error'] = 'Could not save changes.';


$l_shop['orderList']['noOrders'] = 'This customer has not ordered anything so far.';
$l_shop['orderList']['order'] = 'order';
$l_shop['orderList']['orderDate'] = 'ordered on';
$l_shop['orderList']['orderPayed'] = 'payed on';
$l_shop['orderList']['orderEdited'] = 'processed on';

$l_shop['add_article']['title'] = 'Add article';
$l_shop['add_article']['entry_x_to_y_from_z'] = 'Entry %s to %s of %s';
$l_shop['add_article']['empty_articles'] = 'No Articles found.';

$l_shop['edit_shipping_cost']['title'] = 'Edit shipping costs';
$l_shop['edit_shipping_cost']['vatRate'] = 'VAT rate';
$l_shop['edit_shipping_cost']['isNet'] = 'is net';

$l_shop['add_shop_field'] = 'Add field to this Order';
$l_shop['field_name'] = 'Name';
$l_shop['field_value'] = 'Value';
$l_shop['field_empty_js_alert'] = 'Fieldname must not be empty';

$l_shop['edit_article_variants'] = 'Edit shop article variants';
$l_shop['new_entry'] = 'New entry';

$l_paypal['head_title']    = 'Processing Payment';
$l_paypal['redirect_auto'] = 'Please wait while your payment is processed. You will be redirected to PayPal shortly.';
$l_paypal['redirect_man']  = 'If you are not automatically redirected within the next 5 seconds, please click the "PayPal" button.';
?>