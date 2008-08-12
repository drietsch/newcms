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

$l_shop["user_saved_ok"] = "El usuario '%s' fue salvado exitosamente";
$l_shop["user_saved_nok"] = "El usuario '%s' no puede ser salvado!";
$l_shop["nothing_to_save"] = "Nada para salvar!";
$l_shop["username_exists"] = "El nombre de usuario '%s' ya existe!";
$l_shop["username_empty"] = "El nombre de usuario no ha sido llenado!";
$l_shop["user_deleted"] = "El usuario '%s' fue borrado exitosamente!";
$l_shop["nothing_to_delete"] = "Nada para borrar!";
$l_shop["delete_last_user"] = "Para la administración se requiere por lo menos de un administrador.\\nUd no puede borrar el administrador.";
$l_shop["modify_last_admin"] = "Para la administración se requiere por lo menos de un administrador.\\nUd no puede cambiar los privilegios del administrador.";
$l_shop["no_order_there"] = "¡Ningúna orden abierta!!";

$l_shop["user_data"] = "Data del usuario";
$l_shop["first_name"] = "Nombre";
$l_shop["second_name"] = "Apellido";
$l_shop["username"] = "Nombre de usuario";
$l_shop["password"] = "Contraseña";

$l_shop["workspace_specify"] = "Especificar área de trabajo";
$l_shop["permissions"] = "Privilegios";
$l_shop["user_permissions"] = "Editor"; // TRANSLATE
$l_shop["admin_permissions"] = "Administrador";

$l_shop["password_alert"] = "La contraseña debe de tener al menos 4 carácteres";
$l_shop["delete_alert"] = "Borrar todo el data del usuario para el nombre de usuario '%s'.\\n Está UD seguro?";

$l_shop["created_by"] = "Creado por";
$l_shop["changed_by"] = "Cambiado por";

$l_shop["no_perms"] = "UD no tiene permiso para usar esta opción!";
$l_shop["ue_data"] = "Vista general de ";

$l_shop["stat"] = "Evaluación de estadísticas";
$l_shop["del_shop"] = "¿Está UD seguro que quiere borrar esta orden?";
$l_shop["order_liste"] = "Todas las ordenes del cliente";

$l_shop["einfueg"] = "Add item";
$l_shop["pref"] = "Shop setting";
$l_shop["waehrung"] = "Divisa";
$l_shop["mwst"] = "Sales tax";
$l_shop["mwst_expl"] = "Desde la versión 3.5 es posible usar diversas tasas de IVA las cuales son guardadas directamente con el artículo dentro de la orden. El valor almacenado aquí es usado solo por órdenes más viejas. Los cambios en este valor afectan a todas las órdenes hechas sin una tasa de IVA por defecto en la tasa de IVA del artículo almacenado.";
$l_shop["format"] = "Number format";
$l_shop["pageMod"] = "Registros por Página";

$l_shop["bestellungvom"] = "Orden de";
$l_shop["keinedaten"] = "Ningún parámetro aprobado";
$l_shop["datum"] = "Fecha";
$l_shop["anzahl"] = "Cantidad de ordenes";
$l_shop["umsatzgesamt"] = "Total de ventas";
$l_shop["Artikel"] = "Artículo";
$l_shop["Anzahl"] = "Cantidad";
$l_shop["variant"] = "Variante";
$l_shop["customField"] = "Campo personalizado";
$l_shop["customFieldDesc"] = "Insertar como: <i>name1=wert1;name2=wert2;...</i>";
$l_shop["Titel"] = "Title"; // TRANSLATE
$l_shop["Beschreibung"] = "Description"; // TRANSLATE
$l_shop["Gesamt"] = "Total"; // TRANSLATE
$l_shop["jsanzahl"] = "Por favor, entre la cantidad de artículo";

$l_shop["geloscht"] = "El registro fue borrado éxitosamente.";
$l_shop["loscht"] = "Registro borrado";

$l_shop["selectYear"] = "Seleccionar Año";
$l_shop["selectMonth"] = "Selccionar Mes";
$l_shop["jsanz"] = "Por favor, entre la cantidad!";
$l_shop["keinezahl"] = "Su entrada no es un número!";
$l_shop["jsbetrag"] = "Por favor, entre el importe";
$l_shop["jsloeschen"] = "Está UD seguro que desea borrar este artículo? Este proceso no es reversible.";
$l_shop["Preis"] = "Precio";
$l_shop["MwSt"] = "Impuesto de ventas.";
$l_shop["gesamtpreis"] = "Precio total";
$l_shop["plusVat"] = "plus IVA";
$l_shop["includedVat"] = "contiene IVA";

$l_shop["bestellnr"] = "Orden número.:";
$l_shop["bearbeitet"] = "Procesado en:";
$l_shop["bezahlt"] = "Pagado en:";
$l_shop["datumeingabe"] = "UD debe entrar la fecha en el formato dd.mm.aa.";

$l_shop["order_data"] = "Orden y<br>data de usuario";
$l_shop["ordered_articles"] = "Artículos ordenados";
$l_shop["order_comments"] = "Comentarios adicionales para esta orden";

$l_shop["bestelldatum"] = "Fecha de orden:";
$l_shop["jsdatum"] = "Por favor, entre la fecha";
$l_shop["unbearb"] = "Sin procesar";
$l_shop["unbezahlt"] = "No pagado";
$l_shop["schonbezahlt"] = "Pagado";
$l_shop["monat"] = "Mes";
$l_shop["bestellung"] = "Orden";


$l_shop["noRecordAlert"] = "Ningún registro ha sido encontrado para esta <strong>Class-ID</strong>.<br />";
$l_shop["noRecordAlert"] .=" ¡Por favor cambie a las Preferencias para modificar o reingresar!";
$l_shop["einfueg"] = "Agregar un Artículo";
$l_shop["pref"] = "Preferencias";
$l_shop["paymentP"] = "Proveedor de Pago";
$l_shop["waehrung"] = "Divisa";
$l_shop["mwst"] = "IVA";
$l_shop["format"] = "Formato de Número";

$l_shop["revenue_list"] = "Volumen de Venta Anual: ";
$l_shop["anual"] = "Año";
$l_shop["selYear"] = "Selección ";

// shop_extend
$l_shop["ArtList"] = "Lista de todos los artículos";
$l_shop["ArtName"] = "Nombre el Artículo ";
$l_shop["ArtID"] = "ID"; // TRANSLATE
$l_shop["docType"] = "Tipo";
$l_shop["artCreate"] = "Fecha de Creación";
$l_shop["artCreateAlt"] = "Ordenar por fecha de Creación";
$l_shop["artMod"] = "Última Actualización";
$l_shop["artPub"] = "Publicada en:";
$l_shop["artModAlt"] = "Ordenar por última actualización";
$l_shop["artHas"] = "Variantes";
$l_shop["artHasAlt"] = "Ordenar por Variantes (tiene/no tiene)";
$l_shop["artNameAlt"] = "Ordenar por Nombres de Artículos";
$l_shop["artIDAlt"] = "Ordenar por ID";
$l_shop["classSel"] = "Tipos de Compras disponibles: ";

// shop_revenue
$l_shop["artName"] = "Nombre del Artículo";
$l_shop["artPrice"] = "Precio";
$l_shop["artOrdD"] = "Fecha para la Orden";
$l_shop["artID"] = "ID del Artículo";
$l_shop["artPay"] = "Pagado";

$l_shop["artTotal"] = "Total de Artículos";
$l_shop["currPage"] = "Página";

$l_shop["noRecord"] = "¡Ningún registro fue encontrado!";
$l_shop["artNPay"] = "Pendiente";
$l_shop["isObj"] = "Objeto";
$l_shop["isDoc"] = "Documento";
$l_shop["classID"] = "ID de Clase";
$l_shop["classIDext"] = "* ID-Objeto-Compra[ID,ID,ID ..]";
$l_shop["paypal"] = "PayPal"; // TRANSLATE
$l_shop["saferpay"] = "Saferpay"; // TRANSLATE
$l_shop["lc"] = "Código del País";
$l_shop["paypalLcTxt"] = "* (ISO)"; // TRANSLATE
$l_shop["paypalbusiness"] = "Negocio";
$l_shop["paypalbTxt"] = "* Correo de PayPal";



$l_shop["paypalSB"] = "Cuenta";
$l_shop["paypalSBTxt"] = " Cuenta de prueba o cuenta real";
$l_shop["saferpayTermLang"] = "Language"; // TRANSLATE
$l_shop["saferpayID"] = "ID-Cuenta";
$l_shop["saferpayIDTxt"] = "* Número de Serie";
$l_shop["saferpayNo"] = "No"; // TRANSLATE
$l_shop["saferpayYes"] = "Sí";
$l_shop["saferpayLcTxt"] = "* en, de, fr, it"; // TRANSLATE
$l_shop["saferpaybusiness"] = "Propietario de la Tienda";
$l_shop["saferpaybTxt"] = "* Notificar correo";
$l_shop["saferpayAllowCollect"] = "¿Permitir recolectar?";
$l_shop["saferpayAllowCollectTxt"] = "* ¡Ver manual de saferpay!";
$l_shop["saferpayDelivery"] = "¿Formulario adicional?";
$l_shop["saferpayDeliveryTxt"] = "* para entrega de dirección";
$l_shop["saferpayUnotify"] = "Confirmación";
$l_shop["saferpayUnotifyTxt"] = "* Confirmar correo al cliente";
$l_shop["saferpayProviderset"] = "Conjunto de proveedores";
$l_shop["saferpayProvidersetTxt"] = "* ¡Separado por comas!";
$l_shop["saferpayCMDPath"] = "exec-path"; // TRANSLATE
$l_shop["saferpayCMDPathTxt"] = "* p.ej. /usr/local/bin/";
$l_shop["saferpayconfPath"] = "conf-path"; // TRANSLATE
$l_shop["saferpayconfPathTxt"] = "* camino al saferpay";
$l_shop["saferpaydesc"] = "Descripción";
$l_shop["saferpaydescTxt"] = "* p.ej. orden";
$GLOBALS["l_shop"]["saferpayError"] = "El Saferpay no está correctamente instalado. Por favor configure su cuenta. Saferpay ha devuelto las siguientes variables:\n<br/>";
$l_shop["NoRevenue"] = "No hay ningún ingreso dentro del período de tiempo seleccionado";


$l_shop["FormFieldsTxt"] = "Campos disponibles para las transmiciones al proveedor de pagos";
$l_shop["fieldForname"] = "Nombre";
$l_shop["fieldSurname"] = "Apellido";
$l_shop["fieldStreet"] = "Calle";
$l_shop["fieldZip"] = "C.P.";
$l_shop["fieldCity"] = "Ciudad";
$l_shop["fieldEmail"] = "E-Mail";
$l_shop["SelectAll"]= "Todo";
$l_shop["plzh"] = "comodín";
$l_shop["lastOrder"] = "Last order - Nr.: %s, %s"; // TRANSLATE
$l_shop["sl"] = "-"; // TRANSLATE
$l_shop["treeYear"] = "Año";


// vats dialogs
$l_shop['vat']['save_success'] = 'IVA guardado exitósamente.';
$l_shop['vat']['save_error'] = 'No se pudo guardar el IVA.';
$l_shop['vat']['delete_success'] = 'IVA eliminado exitósamente.';
$l_shop['vat']['delete_error'] = 'No se pudo eliminar el IVA.';

$l_shop['vat']['new_vat_name'] = 'Nuevo IVA';
$l_shop['vat']['js_confirm_delete'] = '¿Está seguro de que desea eliminar el IVA seleccionado?';

$l_shop['vat']['vat_form_id'] = 'Id'; // TRANSLATE
$l_shop['vat']['vat_form_name'] = 'Nombre';
$l_shop['vat']['vat_form_vat'] = 'Tasa de IVA';
$l_shop['vat']['vat_form_standard'] = 'Estándar';
$l_shop['vat']['vat_edit_form_headline'] = 'Editar tasa de IVA';
$l_shop['vat']['vat_edit_form_headline_box'] = 'Edit VAT rate'; // TRANSLATE
$l_shop['vat']['vat_edit_form_yes'] = 'Sí';
$l_shop['vat']['vat_edit_form_no'] = 'No'; // TRANSLATE

$l_shop['vat_country']['box_headline'] = 'Clientes de cuales estados tienen que pagar VAT';
$l_shop['vat_country']['defaultReturn'] = 'Valor predefinido';
$l_shop['vat_country']['defaultReturn_desc'] = 'El valor predefinido determina el resultado de we:ifShopPayVat, si ninguna de las siguientes reglas coincide. Si no hay reglas definidas, el valor predefinido es devuelto';
$l_shop['vat_country']['stateField'] = 'Campo de País';
$l_shop['vat_country']['stateField_desc'] = 'Seleccione el campo del Módulo Cliente conteniendo el país de origen (dirección de facturación). Esto es usado para decidir, si el cliente tiene que pagar IVA o no.';
$l_shop['vat_country']['statesLiableToVat'] = 'Estados propensos al IVA';
$l_shop['vat_country']['statesLiableToVat_desc'] = 'Clientes de estos países tienen que pagar IVA.';
$l_shop['vat_country']['statesNotLiableToVat'] = 'Estados no propensos al IVA';
$l_shop['vat_country']['statesNotLiableToVat_desc'] = 'Clientes de estos países no tienen que pagar IVA.';

$l_shop['vat_country']['statesSpecialRules'] = 'Estados con reglas especiales';
$l_shop['vat_country']['statesSpecialRules_desc'] = 'Clientes de estos países solo tienen que pagar IVA si además una regla adicional coincide.';
$l_shop['vat_country']['statesSpecialRules_condition'] = 'Regal Adicional';
$l_shop['vat_country']['statesSpecialRules_result'] = 'Resultado';

$l_shop['vat_country']['condition_is_empty'] = 'Vacío';
$l_shop['vat_country']['condition_is_set'] = 'Lleno';

$l_shop['shipping']['shipping_package'] = 'Manipulando y enviando';
$l_shop['shipping']['prices_are_net'] = 'Los precios son netos';
$l_shop['shipping']['insert_packaging'] = 'Tasas existentes';
$l_shop['shipping']['payment_provider'] = 'Proveedor de pagos';
$l_shop['shipping']['revenue_view'] = 'Artículos- / Ingresos';

$l_shop['preferences']['customerFields'] = "Campos clientes<br />(Módulo Cliente)";
$l_shop['preferences']['orderCustomerFields'] = 'Campos clientes<br />(orden)';

$l_shop['preferences']['customerdata'] = 'Datos del cliente';
$l_shop['preferences']['explanation_customer_odercustomer'] = 'Explicación: Estos datos son solo guardados dentro de la orden, los datos del Módulo Cliente no serán afectados.';

$l_shop['order']['edit_order_customer'] = 'Editar datos del cliente dentro de la orden.';
$l_shop['order']['open_customer'] = 'Abrir este cliente en el Módulo de Administración de Clientes.';

$l_shop['edit_order']['shipping_costs'] = 'Costo de envío';
$l_shop['edit_order']['js_edit_custom_cart_field'] = 'Nuevo valor para %s:.';
$l_shop['edit_order']['js_edit_cart_field_noFieldname'] = 'Por favor introduzca un nombre del campo.';
$l_shop['edit_order']['js_saved_cart_field_success'] = 'Campo carro de compras guardado "%s".';
$l_shop['edit_order']['js_saved_cart_field_error'] = 'el campo carro de compras "%s" no pudo ser guardado.';
$l_shop['edit_order']['js_delete_cart_field'] = 'El campo %s debe ser eliminado de la orden?';
$l_shop['edit_order']['js_delete_cart_field_success'] = 'El campo %s fue eliminado de esta orden.';
$l_shop['edit_order']['js_delete_cart_field_error'] = 'El campo %s no puedo ser eliminado de esta orden.';
$l_shop['edit_order']['js_saved_shipping_success'] = 'Costos de envío guardados.';
$l_shop['edit_order']['js_saved_shipping_error']   = 'Los costos de envío no puedieron ser guardados.';
$l_shop['edit_order']['js_saved_customer_success'] = 'Los datos de clientes se guardaron exitósamente.';
$l_shop['edit_order']['js_saved_customer_error']   = 'No se puedieron guardar los datos del cliente.';
$l_shop['edit_order']['js_edit_vat']   = 'Por favor inserte la nueva tasa de IVA.';

$l_shop['edit_order']['calculate_vat']   = 'Calcular IVA';
$l_shop['edit_order']['js_saved_calculateVat_success'] = 'Cambiar guardados.';
$l_shop['edit_order']['js_saved_calculateVat_error'] = 'No se pudo guardar los cambios.';


$l_shop['orderList']['noOrders'] = 'Este cliente no ha ordenado nada hasta ahora.';
$l_shop['orderList']['order'] = 'Orden';
$l_shop['orderList']['orderDate'] = 'Ordenado en';
$l_shop['orderList']['orderPayed'] = 'Pagado en';
$l_shop['orderList']['orderEdited'] = 'Procesado en';

$l_shop['add_article']['title'] = 'Agregar Artículo';
$l_shop['add_article']['entry_x_to_y_from_z'] = 'Entrar %s a %s de %s';
$l_shop['add_article']['empty_articles'] = 'No se encontraron artículos.';

$l_shop['edit_shipping_cost']['title'] = 'Editar costos de envío';
$l_shop['edit_shipping_cost']['vatRate'] = 'Tasa de IVA';
$l_shop['edit_shipping_cost']['isNet'] = 'Es neto';

$l_shop['add_shop_field'] = 'Add field to this Order'; // TRANSLATE
$l_shop['field_name'] = 'Nombre';
$l_shop['field_value'] = 'valor';
$l_shop['field_empty_js_alert'] = 'Fieldname must not be empty'; // TRANSLATE

$l_shop['edit_article_variants'] = 'Edit shop article variants'; // TRANSLATE
$l_shop['new_entry'] = 'New entry'; // TRANSLATE
?>