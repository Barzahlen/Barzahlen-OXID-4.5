<?php
/**
 * Barzahlen Payment Module (OXID eShop)
 *
 * NOTICE OF LICENSE
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; version 3 of the License
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see http://www.gnu.org/licenses/
 *
 * @copyright   Copyright (c) 2012 Zerebro Internet GmbH (http://www.barzahlen.de)
 * @author      Alexander Diebler
 * @license     http://opensource.org/licenses/GPL-3.0  GNU General Public License, version 3 (GPL-3.0)
 */

require_once getShopBasePath() . 'modules/barzahlen/api/loader.php';

class barzahlen_payment_gateway extends barzahlen_payment_gateway_parent {

  protected $_sLastError = "barzahlen";
  protected $_sModuleId = 'module:barzahlen';
  const LOGFILE = "barzahlen.log";

  /**
   * Executes payment, returns true on success.
   *
   * @param double $dAmount Goods amount
   * @param object &$oOrder User ordering object
   *
   * @return bool
   */
  public function executePayment($dAmount, &$oOrder) {

    if ($oOrder->oxorder__oxpaymenttype->value != 'oxidbarzahlen') {
      return parent::executePayment($dAmount, $oOrder);
    }

    $country = oxNew("oxcountry");
    $country->load($oOrder->oxorder__oxbillcountryid->rawValue);

    $api = $this->_getBarzahlenApi($oOrder);

    $customerEmail = $oOrder->oxorder__oxbillemail->rawValue;
    $customerStreetNr = $oOrder->oxorder__oxbillstreet->rawValue .' '. $oOrder->oxorder__oxbillstreetnr->rawValue;
    $customerZipcode = $oOrder->oxorder__oxbillzip->rawValue;
    $customerCity = $oOrder->oxorder__oxbillcity->rawValue;
    $customerCountry = $country->oxcountry__oxisoalpha2->rawValue;
    $orderId = $oOrder->oxorder__oxordernr->value;
    $amount = $oOrder->oxorder__oxtotalordersum->value;
    $currency = $oOrder->oxorder__oxcurrency->rawValue;
    $payment = new Barzahlen_Request_Payment($customerEmail, $customerStreetNr, $customerZipcode, $customerCity, $customerCountry, $amount, $currency, $orderId);

    try {
      $api->handleRequest($payment);
    }
    catch (Exception $e) {
      oxUtils::getInstance()->writeToLog(date('c') . " Transaction/Create failed: " . $e . "\r\r", self::LOGFILE);
    }

    if($payment->isValid()) {
      oxSession::setVar('barzahlenInfotextOne', (string)$payment->getInfotext1());
      $oOrder->oxorder__bztransaction = new oxField((int)$payment->getTransactionId());
      $oOrder->oxorder__bzstate = new oxField('pending');
      $oOrder->save();
      return true;
    }
    else {
      return false;
    }
  }

  /**
   * Prepares a Barzahlen API object for the payment request.
   *
   * @param object $oOrder User ordering object
   * @return Barzahlen_Api
   */
  protected function _getBarzahlenApi($oOrder) {

    $oxConfig = oxConfig::getInstance();
    $sShopId = $oxConfig->getShopId();
    $sModule = $this->_sModuleId;

    $shopId = $oxConfig->getShopConfVar('bzShopId', $sShopId, $sModule);
    $paymentKey = $oxConfig->getShopConfVar('bzPaymentKey', $sShopId, $sModule);
    $sandbox = $oxConfig->getShopConfVar('bzSandbox', $sShopId, $sModule);
    $debug = $oxConfig->getShopConfVar('bzDebug', $sShopId, $sModule);

    $api = new Barzahlen_Api($shopId, $paymentKey, $sandbox);
    $api->setDebug($debug, self::LOGFILE);
    $api->setLanguage($this->_getOrderLanguage($oOrder));
    return $api;
  }

  /**
   * Gets the order language code.
   *
   * @param object $oOrder User ordering object
   * @return string
   */
  protected function _getOrderLanguage($oOrder) {

    $oxConfig = oxConfig::getInstance();
    $lgConfig = $oxConfig->getShopConfVar('aLanguageParams');

    return array_search($oOrder->getOrderLanguage(), $lgConfig);
  }
}
?>