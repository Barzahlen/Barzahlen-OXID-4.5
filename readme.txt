==Title==
Barzahlen Payment Module (OXID eShop 4.5)

==Author==
Zerebro Internet GmbH

==Prefix==
bz

==Version==
1.1.4

==Link==
http://www.barzahlen.de

==Mail==
support@barzahlen.de

==Description==
Integrates Barzahlen payment solution into OXID eSales.

==Extend==
*payment
--getSandbox
--getPartner

*thankyou
--init
--render

*oxpaymentgateway
--executePayment

*oxorder
--cancelOrder
--delete

*navigation
--_doStartUpChecks

==Installation==
* copy contents from copy_this directory into the shop root
* use Service/Tools in admin area to upload install.sql
* activate Barzahlen module
* clear tmp directory

==Modules==
payment => barzahlen/views/barzahlen_payment
thankyou => barzahlen/views/barzahlen_thankyou
oxpaymentgateway => barzahlen/core/barzahlen_payment_gateway
oxorder => barzahlen/core/barzahlen_order
navigation => barzahlen/core/barzahlen_navigation

==Ressources==
Full User Manual: http://www.barzahlen.de/partner/integration/shopsysteme/4/oxid-eshop