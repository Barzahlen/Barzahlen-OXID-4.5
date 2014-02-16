ALTER TABLE `oxorder`
ADD `BZTRANSACTION` INT( 11 ) NOT NULL DEFAULT 0,
ADD `BZSTATE` ENUM( 'pending', 'paid', 'expired' ) NOT NULL,
ADD `BZREFUNDS` MEDIUMTEXT NOT NULL;

INSERT INTO `oxtplblocks` (`OXID`, `OXACTIVE`, `OXSHOPID`, `OXTEMPLATE`, `OXBLOCKNAME`, `OXPOS`, `OXFILE`, `OXMODULE`) VALUES
('barzahlen_select_payment_1', 1, 'oxbaseshop', 'page/checkout/payment.tpl', 'select_payment', 1, 'page/checkout/payment/select_payment', 'barzahlen'),
('barzahlen_payment_error_1', 1, 'oxbaseshop', 'page/checkout/payment.tpl', 'checkout_payment_errors', 1, 'page/checkout/payment/checkout_payment_errors', 'barzahlen'),
('barzahlen_thankyou_1', 1, 'oxbaseshop', 'page/checkout/thankyou.tpl', 'checkout_thankyou_info', 1, 'page/checkout/thankyou/checkout_thankyou_info', 'barzahlen');

INSERT INTO `oxpayments` (`OXID`, `OXACTIVE`, `OXDESC`, `OXADDSUM`, `OXADDSUMTYPE`, `OXADDSUMRULES`, `OXFROMBONI`, `OXFROMAMOUNT`, `OXTOAMOUNT`, `OXVALDESC`, `OXCHECKED`, `OXDESC_1`, `OXVALDESC_1`, `OXDESC_2`, `OXVALDESC_2`, `OXDESC_3`, `OXVALDESC_3`, `OXLONGDESC`, `OXLONGDESC_1`, `OXLONGDESC_2`, `OXLONGDESC_3`, `OXSORT`, `OXTSPAYMENTID`) VALUES
('oxidbarzahlen', 1, 'Barzahlen', 0, 'abs', 0, 0, 0, 1000, '', 0, 'Barzahlen', '', '', '', '', '', '', '', '', '', -1, '');