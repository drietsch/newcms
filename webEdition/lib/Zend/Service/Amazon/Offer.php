<?php

/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Zend_Service
 * @subpackage Amazon
 * @copyright  Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: Offer.php,v 1.1 2008/05/13 13:41:29 holger.meyer Exp $
 */


/**
 * @category   Zend
 * @package    Zend_Service
 * @subpackage Amazon
 * @copyright  Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Service_Amazon_Offer
{
    /**
     * Parse the given Offer element
     *
     * @param  DOMElement $dom
     * @return void
     */
    public function __construct(DOMElement $dom)
    {
        $xpath = new DOMXPath($dom->ownerDocument);
        $xpath->registerNamespace('az', 'http://webservices.amazon.com/AWSECommerceService/2005-10-05');
        $this->MerchantId = (string) $xpath->query('./az:Merchant/az:MerchantId/text()', $dom)->item(0)->data;
        $this->GlancePage = (string) $xpath->query('./az:Merchant/az:GlancePage/text()', $dom)->item(0)->data;
        $this->Condition = (string) $xpath->query('./az:OfferAttributes/az:Condition/text()', $dom)->item(0)->data;
        $this->OfferListingId = (string) $xpath->query('./az:OfferListing/az:OfferListingId/text()', $dom)->item(0)->data;
        $this->Price = (int) $xpath->query('./az:OfferListing/az:Price/az:Amount/text()', $dom)->item(0)->data;
        $this->CurrencyCode = (string) $xpath->query('./az:OfferListing/az:Price/az:CurrencyCode/text()', $dom)->item(0)->data;
        $this->Availability = (string) $xpath->query('./az:OfferListing/az:Availability/text()', $dom)->item(0)->data;
        $result = $xpath->query('./az:OfferListing/az:IsEligibleForSuperSaverShipping/text()', $dom);
        if ($result->length >= 1) {
            $this->IsEligibleForSuperSaverShipping = (bool) $result->item(0)->data;
        }
    }
}