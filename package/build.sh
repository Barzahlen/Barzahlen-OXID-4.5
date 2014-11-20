#!/bin/bash
DST="barzahlen_oxid_4.5_plugin_v1.2.0"
if [ -d $DST ]; then
rm -R $DST
fi
mkdir -p $DST/src/changed_full/out/azure/de
mkdir -p $DST/src/changed_full/out/azure/en
mkdir -p $DST/src/copy_this/admin
mkdir -p $DST/src/copy_this/modules
mkdir -p $DST/src/copy_this/out/admin/de
mkdir -p $DST/src/copy_this/out/admin/en
mkdir -p $DST/src/copy_this/out/admin/tpl
mkdir -p $DST/src/copy_this/views
cp license.txt $DST/license.txt
cp readme.txt $DST/readme.txt
cp changelog.txt $DST/src/changelog.txt
cp extends.txt $DST/src/extends.txt
cp ../install.sql $DST/src/install.sql
cp ../install_ee.sql $DST/src/install_ee.sql
cp ../update.sql $DST/src/update.sql
cp ../src/admin/barzahlen_settings.php $DST/src/copy_this/admin/barzahlen_settings.php
cp ../src/admin/barzahlen_transactions.php $DST/src/copy_this/admin/barzahlen_transactions.php
cp -r ../src/modules/barzahlen/ $DST/src/copy_this/modules/barzahlen/
cp ../src/out/admin/de/barzahlen_lang.php $DST/src/copy_this/out/admin/de/barzahlen_lang.php
cp ../src/out/admin/en/barzahlen_lang.php $DST/src/copy_this/out/admin/en/barzahlen_lang.php
cp ../src/out/admin/tpl/barzahlen_settings.tpl $DST/src/copy_this/out/admin/tpl/barzahlen_settings.tpl
cp ../src/out/admin/tpl/barzahlen_transactions.tpl $DST/src/copy_this/out/admin/tpl/barzahlen_transactions.tpl
cp ../src/out/azure/de/barzahlen_lang.php $DST/src/changed_full/out/azure/de/barzahlen_lang.php
cp ../src/out/azure/en/barzahlen_lang.php $DST/src/changed_full/out/azure/en/barzahlen_lang.php
cp ../src/views/barzahlen_callback.php $DST/src/copy_this/views/barzahlen_callback.php
zip -r $DST.zip $DST/*
rm -R $DST
