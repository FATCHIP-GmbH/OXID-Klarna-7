SET @@session.sql_mode = '';
REPLACE INTO `oxorder` (OXID,OXSHOPID,OXUSERID,OXORDERDATE,OXORDERNR,OXBILLCOMPANY,OXBILLEMAIL,OXBILLFNAME,OXBILLLNAME,OXBILLSTREET,OXBILLSTREETNR,OXBILLADDINFO,OXBILLUSTID,OXBILLCITY,OXBILLCOUNTRYID,OXBILLSTATEID,OXBILLZIP,
OXBILLFON,OXBILLFAX,OXBILLSAL,OXDELCOMPANY,OXDELFNAME,OXDELLNAME,OXDELSTREET,OXDELSTREETNR,OXDELADDINFO,OXDELCITY,OXDELCOUNTRYID,OXDELSTATEID,OXDELZIP,OXDELFON,OXDELFAX,OXDELSAL,OXPAYMENTID,OXPAYMENTTYPE,OXTOTALNETSUM,OXTOTALBRUTSUM,
OXTOTALORDERSUM,OXARTVAT1,OXARTVATPRICE1,OXARTVAT2,OXARTVATPRICE2,OXDELCOST,OXDELVAT,OXPAYCOST,OXPAYVAT,OXWRAPCOST,OXWRAPVAT,OXGIFTCARDCOST,OXGIFTCARDVAT,OXCARDID,OXCARDTEXT,OXDISCOUNT,OXEXPORT,OXBILLNR,OXBILLDATE,OXTRACKCODE,OXSENDDATE,
OXREMARK,OXVOUCHERDISCOUNT,OXCURRENCY,OXCURRATE,OXFOLDER,OXTRANSID,OXPAYID,OXXID,OXPAID,OXSTORNO,OXIP,OXTRANSSTATUS,OXLANG,OXINVOICENR,OXDELTYPE,OXTIMESTAMP,OXISNETTOMODE)
VALUES ('16302e97f6249f2babcdef65004954b1', 1, 'oxdefaultadmin', DATE_FORMAT(NOW() - interval 1 YEAR, '%Y-%m-%d 17:07:50'), 33, '', 'info@topconcepts.de', 'Greg', 'Dabrowski', 'Maple Street', '2425', '', '', 'Any City', 'a7c40f631fc920687.20179984', '', '21079', '217-8918712',
'217-8918713', 'Mr', '', 'Gregory', 'Dabrowski', 'Karnapp', '25', '', 'Hamburg', 'a7c40f631fc920687.20179984', '', '21079', '', '', 'MR', 'abdfbd0bf9731848116f5d4b10b1b093', 'klarna_checkout', 402.52, 479, 479, 19, 76.48, 0, 0, 0, 19, 0, 0, 0, 0, 0, 19,
'', '', 0, 0, '', '0000-00-00', '', DATE_FORMAT(NOW() - interval 1 YEAR, '%Y-%m-%d 17:07:50'), '', 0, 'EUR', 1, 'ORDERFOLDER_NEW', '', '', '', DATE_FORMAT(NOW() - interval 1 YEAR, '%Y-%m-%d 17:07:50'), 0, '', 'OK', 0, 0, 'oxidstandard', DATE_FORMAT(NOW() - interval 1 YEAR, '%Y-%m-%d 17:07:50'), 0);
Replace into oxobject2group set oxid = 'f9cfaecdc7407ef7b2d492fd1c7e8f83',oxshopid = '1',oxobjectid = 'klarna_checkout',oxgroupsid = 'oxidforeigncustomer';
Replace into oxobject2group set oxid = '555af1a5813deff89ebcf0a785031666',oxshopid = '1',oxobjectid = 'klarna_checkout',oxgroupsid = 'oxidsmallcust';
Replace into oxobject2group set oxid = '24d980f108a5d5116a0c029add8ce6a8',oxshopid = '1',oxobjectid = 'klarna_checkout',oxgroupsid = 'oxidgoodcust';
Replace into oxobject2group set oxid = 'aa688c851d95893ea62c3d0f67de897c',oxshopid = '1',oxobjectid = 'klarna_checkout',oxgroupsid = 'oxiddealer';
Replace into oxobject2group set oxid = '7795b0a18b3f765eae2945bf8535af02',oxshopid = '1',oxobjectid = 'klarna_checkout',oxgroupsid = 'oxidnewcustomer';
Replace into oxobject2group set oxid = 'b228afd82364b7ecf162d46e1e57b7cf',oxshopid = '1',oxobjectid = 'klarna_checkout',oxgroupsid = 'oxidcustomer';
Replace into oxobject2group set oxid = 'e6436b702cb96414a845b033787ddc5c',oxshopid = '1',oxobjectid = 'klarna_checkout',oxgroupsid = 'oxidmiddlecust';
Replace into oxobject2group set oxid = '388d094bdb9e8086c914c54b4062915f',oxshopid = '1',oxobjectid = 'klarna_checkout',oxgroupsid = 'oxidnewsletter';
Replace into oxobject2group set oxid = 'f59a8c2c5540c3d5a5ea8371b5459382',oxshopid = '1',oxobjectid = 'klarna_checkout',oxgroupsid = 'oxidnotyetordered';
Replace into oxobject2group set oxid = '1efc7c25a6a313357c20881703730516',oxshopid = '1',oxobjectid = 'klarna_checkout',oxgroupsid = 'oxidpowershopper';
Replace into oxobject2group set oxid = 'f3802278871f8d3c7ae01e4c421f1571',oxshopid = '1',oxobjectid = 'klarna_checkout',oxgroupsid = 'oxidpricea';
Replace into oxobject2group set oxid = '59bd4145b32e793a41f054591cb34a2d',oxshopid = '1',oxobjectid = 'klarna_checkout',oxgroupsid = 'oxidpriceb';
Replace into oxobject2group set oxid = 'fafb982bda51903451e57947d5366f55',oxshopid = '1',oxobjectid = 'klarna_checkout',oxgroupsid = 'oxidpricec';
Replace into oxobject2group set oxid = '3fee7fdf3e3717afdffc768bbbdb3a38',oxshopid = '1',oxobjectid = 'klarna_checkout',oxgroupsid = 'oxidadmin';
Replace into oxobject2group set oxid = '48607f29b17cdc0861cfc901d538a1bd',oxshopid = '1',oxobjectid = 'klarna',oxgroupsid = 'oxidforeigncustomer';
Replace into oxobject2group set oxid = 'be103aab157a4429a2173f072201f07a',oxshopid = '1',oxobjectid = 'klarna',oxgroupsid = 'oxidsmallcust';
Replace into oxobject2group set oxid = '2d2f5c2f962fbdd2782c87b733d17f2c',oxshopid = '1',oxobjectid = 'klarna',oxgroupsid = 'oxidgoodcust';
Replace into oxobject2group set oxid = 'f34ef2babf20cac11ad808e7032f9664',oxshopid = '1',oxobjectid = 'klarna',oxgroupsid = 'oxiddealer';
Replace into oxobject2group set oxid = 'b8a08f94cbcc56f8f2042e83dc7f4f93',oxshopid = '1',oxobjectid = 'klarna',oxgroupsid = 'oxidnewcustomer';
Replace into oxobject2group set oxid = '5f3d915b47e382434fb406637216c607',oxshopid = '1',oxobjectid = 'klarna',oxgroupsid = 'oxidcustomer';
Replace into oxobject2group set oxid = 'f7071ac1ab00ab9749d44da060bc52b5',oxshopid = '1',oxobjectid = 'klarna',oxgroupsid = 'oxidmiddlecust';
Replace into oxobject2group set oxid = 'd70201269fb31b840ade1cc7e85aa7f2',oxshopid = '1',oxobjectid = 'klarna',oxgroupsid = 'oxidnewsletter';
Replace into oxobject2group set oxid = '6db119c51150dda91666c81aabdbf1c8',oxshopid = '1',oxobjectid = 'klarna',oxgroupsid = 'oxidnotyetordered';
Replace into oxobject2group set oxid = 'c1c058bde7a20f5f9c4d235cede72a77',oxshopid = '1',oxobjectid = 'klarna',oxgroupsid = 'oxidpowershopper';
Replace into oxobject2group set oxid = '2d838e80e5dd92726cdc5d6736b84667',oxshopid = '1',oxobjectid = 'klarna',oxgroupsid = 'oxidpricea';
Replace into oxobject2group set oxid = '6af230ab9820fdb8d24a0a0484db60b1',oxshopid = '1',oxobjectid = 'klarna',oxgroupsid = 'oxidpriceb';
Replace into oxobject2group set oxid = '5d447d09d0238f40579932846958f224',oxshopid = '1',oxobjectid = 'klarna',oxgroupsid = 'oxidpricec';
Replace into oxobject2group set oxid = 'a94b24ca6b11718ff60b8e0d4c18a99f',oxshopid = '1',oxobjectid = 'klarna',oxgroupsid = 'oxidadmin';

update oxconfig set oxvarvalue ='a:2:{s:2:\"de\";s:7:\"Deutsch\";s:2:\"en\";s:7:\"English\";}' where oxvarname='aLanguages' and oxshopid=1;
update oxconfig set oxvarvalue='1' where oxvarname='blIsKlarnaTestMode' and oxshopid=1;
update oxconfig set oxvarvalue='1' where oxvarname='blKlarnaLoggingEnabled' and oxshopid=1;
update oxconfig set oxvarvalue='1' where oxvarname='blKlarnaSendProductUrls' and oxshopid=1;
update oxconfig set oxvarvalue='1' where oxvarname='blKlarnaSendImageUrls' and oxshopid=1;
update oxconfig set oxvarvalue='' where oxvarname='blKlarnaEnableAnonymization' and oxshopid=1;
update oxconfig set oxvarvalue='KCO' where oxvarname='sKlarnaActiveMode' and oxshopid=1;
update oxconfig set oxvarvalue='K501664_9c5b3285c29f' where oxvarname='sKlarnaMerchantId' and oxshopid=1;
update oxconfig set oxvarvalue='7NvBzZ5irjFqXcbA' where oxvarname='sKlarnaPassword' and oxshopid=1;
update oxconfig set oxvarvalue='Produktname' where oxvarname='sKlarnaAnonymizedProductTitle_DE' and oxshopid=1;
update oxconfig set oxvarvalue='Product name' where oxvarname='sKlarnaAnonymizedProductTitle_EN' and oxshopid=1;

update oxconfig set oxvarvalue='1' where oxvarname='blKlarnaAllowSeparateDeliveryAddress' and oxshopid=1;
update oxconfig set oxvarvalue='1' where oxvarname='blKlarnaMandatoryPhone' and oxshopid=1;
update oxconfig set oxvarvalue='1' where oxvarname='blKlarnaMandatoryBirthDate' and oxshopid=1;
update oxconfig set oxvarvalue='1' where oxvarname='blKlarnaEnableAutofocus' and oxshopid=1;
update oxconfig set oxvarvalue='1' where oxvarname='blKlarnaEnablePreFilling' and oxshopid=1;
update oxconfig set oxvarvalue='1' where oxvarname='blKlarnaPreFillNotification' and oxshopid=1;
update oxconfig set oxvarvalue='DE' where oxvarname='sKlarnaDefaultCountry' and oxshopid=1;
update oxconfig set oxvarvalue='2' where oxvarname='iKlarnaActiveCheckbox' and oxshopid=1;
update oxconfig set oxvarvalue='2' where oxvarname='iKlarnaValidation' and oxshopid=1;

Replace into oxconfig (oxid, oxshopid, oxmodule, oxvarname, oxvartype, oxvarvalue) values('669f53a8778b395e8b02ba711374f05b', '1', 'tcklarna', 'sKlarnaTermsConditionsURI_DE', 'str', 'https://demohost.topconcepts.net/henrik/4_0_0/ce_601/source/AGB/' );
Replace into oxconfig (oxid, oxshopid, oxmodule, oxvarname, oxvartype, oxvarvalue) values('550b1b135330a4dc04dbea59cdcad076', '1', 'tcklarna', 'sKlarnaCancellationRightsURI_DE', 'str', 'https://demohost.topconcepts.net/henrik/4_0_0/ce_601/source/Widerrufsrecht/' );
Replace into oxconfig (oxid, oxshopid, oxmodule, oxvarname, oxvartype, oxvarvalue) values('dadb50653184eda34746b9b900b84fcc', '1', 'tcklarna', 'sKlarnaShippingDetails_DE', 'str', 'Wir kümmern uns schnellstens um den Versand!' );
Replace into oxconfig (oxid, oxshopid, oxmodule, oxvarname, oxvartype, oxvarvalue) values('dc95164913be4015fc570a2e80ee1468', '1', 'tcklarna', 'sKlarnaTermsConditionsURI_EN', 'str', 'https://demohost.topconcepts.net/henrik/4_0_0/ce_601/source/terms/' );
Replace into oxconfig (oxid, oxshopid, oxmodule, oxvarname, oxvartype, oxvarvalue) values('744e20e55593c0fe3a752f706f10c3de', '1', 'tcklarna', 'sKlarnaCancellationRightsURI_EN', 'str', 'https://demohost.topconcepts.net/henrik/4_0_0/ce_601/source/withdrawal/' );
Replace into oxconfig (oxid, oxshopid, oxmodule, oxvarname, oxvartype, oxvarvalue) values('0ddcd4b8df2950a85402157e5c21ebe3', '1', 'tcklarna', 'sKlarnaShippingDetails_EN', 'str', "We\'ll take care of quick shipping!" );

Replace into oxconfig (oxid, oxshopid, oxmodule, oxvarname, oxvartype, oxvarvalue) values('3344c6128d6cbf3c1bc04c285a0e6e0a', '1', 'tcklarna', 'blKlarnaDisplayBuyNow', 'bool', '1' );

update oxconfig set oxvarvalue='<script src=\"https://embed.bannerflow.com/599d7ec18d988017005eb27d?targeturl=https%3A//www.klarna.com&politeloading=off&merchantid={{merchantid}}&responsive=on\" async></script>' where oxvarname='sKlarnaBannerSrc_EN' and oxshopid=1;
update oxconfig set oxvarvalue='1' where oxvarname='sKlarnaFooterDisplay' and oxshopid=1;
update oxconfig set oxvarvalue='<script src=\"https://embed.bannerflow.com/599d7ec18d988017005eb279?targeturl=https%3A//www.klarna.com&politeloading=off&merchantid={{merchantid}}&responsive=on\" async></script>' where oxvarname='sKlarnaBannerSrc_DE' and oxshopid=1;
update oxconfig set oxvarvalue='longBlack' where oxvarname='tcklarna_sKlFooterValue' and oxshopid=1;
update oxconfig set oxvarvalue='a:0:{}' where oxvarname='aKlarnaDesign' and oxshopid=1;

update oxcountry set oxactive = '1' where oxcountry.oxid = 'a7c40f631fc920687.20179984'; # DE
update oxcountry set oxactive = '1' where oxcountry.oxid = 'a7c40f6320aeb2ec2.72885259'; # AT
update oxcountry set oxactive = '1' where oxcountry.oxid = '8f241f11095363464.89657222'; # AD
update oxcountry set oxactive = '1' where oxcountry.oxid = '8f241f11095306451.36998225'; # AF

Replace into oxobject2payment set oxid = 'a91137a798f381fc9ff3186a8118edeb',oxpaymentid = 'klarna_checkout',oxobjectid = 'oxidstandard',oxtype = 'oxdelset';
Replace into oxobject2payment set oxid = '8dfdf7adfd765ef5f7417301a8355fa5',oxpaymentid = 'klarna',oxobjectid = 'oxidstandard',oxtype = 'oxdelset';
Replace into oxobject2payment set oxid = 'b03b358a40933adcfb1af61a65675faa',oxpaymentid = 'klarna_checkout',oxobjectid = '1b842e732a23255b1.91207750',oxtype = 'oxdelset';
Replace into oxobject2payment set oxid = '6c18199d3e1d71f9ced52b0e45df1c49',oxpaymentid = 'klarna',oxobjectid = '1b842e732a23255b1.91207750',oxtype = 'oxdelset';
Replace into oxobject2payment set oxid = '596423d183fe0c4e08dd098c9a321a7e',oxpaymentid = 'klarna_checkout',oxobjectid = '1b842e732a23255b1.91207751',oxtype = 'oxdelset';
Replace into oxobject2payment set oxid = '039e9f03b01ad423f8faff7ff548d342',oxpaymentid = 'klarna',oxobjectid = '1b842e732a23255b1.91207751',oxtype = 'oxdelset';

update oxconfig set oxvarvalue='1' where oxvarname='blKlarnaEmdCustomerAccountInfo' and oxshopid=1;
update oxconfig set oxvarvalue='1' where oxvarname='blKlarnaEmdPaymentHistoryFull' and oxshopid=1;
update oxconfig set oxvarvalue='1' where oxvarname='blKlarnaEmdPassThrough' and oxshopid=1;

replace into oxuser set oxid = '92ebae5067055431aeaaa6f75bd9a131',oxactive = '1',oxshopid = '1',oxusername = 'steffen@topconcepts.de',oxpassword = 'c25361e25237112e0c584f9816dfd3975ffe150abc7db2cc1d1b4231c8171991b4e732556ab0cf0dadf4733f72442aba066fba1fa55af8479a9384b4dc57592a',oxpasssalt = '3d96584d0378f0a7ecb95db0086a2f70',
oxustid = '',oxcompany = '',oxfname = 'Henrik',oxlname = 'Steffen',oxstreet = 'Karnapp',oxstreetnr = '25',oxaddinfo = '',oxcity = 'Hamburg',oxcountryid = 'a7c40f631fc920687.20179984',oxstateid = '',oxzip = '21079',oxfon = '040/30306900',oxfax = '',oxsal = 'MR',oxboni = '1000',oxregister = '2018-03-22 17:56:04',oxprivfon = '',
oxmobfon = '',oxbirthdate = '1978-03-06',oxurl = '',oxupdatekey = '',oxupdateexp = '0',oxpoints = '0';

replace into oxobject2group set oxid = '68ba74e29a0cc7f6618606bf623b6941',oxshopid = '1',oxobjectid = '92ebae5067055431aeaaa6f75bd9a131',oxgroupsid = 'oxidnewcustomer';
replace into oxobject2group set oxid = '2d3bb655a05283ced8b2739af1cb62fd',oxshopid = '1',oxobjectid = '92ebae5067055431aeaaa6f75bd9a131',oxgroupsid = 'oxidnotyetordered';
Replace into oxobject2payment set oxid = '59e77f69092c584bb1b26426184653b7',oxpaymentid = 'klarna_checkout',oxobjectid = 'a7c40f631fc920687.20179984',oxtype = 'oxcountry';
Replace into oxobject2payment set oxid = '2a8ccf084fd92557af37be1930cafd88',oxpaymentid = 'klarna_checkout',oxobjectid = 'a7c40f6320aeb2ec2.72885259',oxtype = 'oxcountry';
Replace into oxobject2payment set oxid = '2a8ccf084fd92557af37be1930cafd54',oxpaymentid = 'klarna_checkout',oxobjectid = '8f241f11095363464.89657222',oxtype = 'oxcountry';


REPLACE INTO oxuser (OXID,OXACTIVE,OXRIGHTS,OXSHOPID,OXUSERNAME,OXPASSWORD,OXPASSSALT,OXCUSTNR,OXUSTID,OXCOMPANY,OXFNAME,OXLNAME,OXSTREET,OXSTREETNR,OXADDINFO,OXCITY,OXCOUNTRYID,OXSTATEID,OXZIP,OXFON,OXFAX,OXSAL,OXBONI,OXCREATE,OXREGISTER,OXPRIVFON,OXMOBFON,OXBIRTHDATE,OXURL,OXUPDATEKEY,OXUPDATEEXP,OXPOINTS,OXTIMESTAMP)
VALUES
('oxdefaultadmin', '1', 'malladmin', '1', 'info@topconcepts.de', 'a3dd89af395ff1cc82a4062b1d1035a5a73c3943f1e143c2bbb1e987de6eab78d606dae96a8f416e767f8b6148457dde75b75b7ef81a5551cddf8964bc133f51', '38431f33c5fceee570059c68fca93569', '3', '', '', 'Greg', 'Dabrowski', 'Maple Street', '2425', '', 'Any City', 'a7c40f631fc920687.20179984', '', '21079', '217-8918712', '217-8918713', 'Mr', '1000', '2003-01-01 00:00:00', '2003-01-01 00:00:00', '', '02178 918712', '1988-01-01', '', '', '0', '0', '2018-03-28 18:01:24'),
('not_registered', '1', '', '1', 'not_registered@topconcepts.de', '', '', '4', '', '', 'Greg', 'Dabrowski', 'Maple Street', '2425', '', 'Any City', 'a7c40f631fc920687.20179984', '', '21079', '217-8918712', '217-8918713', 'Mr', '1000', '2003-01-01 00:00:00', '2003-01-01 00:00:00', '', '02178 918712', '1988-01-01', '', '', '0', '0', '2018-03-28 18:01:24');

REPLACE INTO oxarticles (OXID,OXSHOPID,OXPARENTID,OXACTIVE,OXHIDDEN,OXACTIVEFROM,OXACTIVETO,OXARTNUM,OXEAN,OXDISTEAN,OXMPN,OXTITLE,OXSHORTDESC,OXPRICE,OXBLFIXEDPRICE,OXPRICEA,OXPRICEB,OXPRICEC,OXBPRICE,OXTPRICE,OXUNITNAME,OXUNITQUANTITY,OXEXTURL,OXURLDESC,OXURLIMG,OXVAT,OXTHUMB,OXICON,OXPIC1,OXPIC2,OXPIC3,OXPIC4,OXPIC5,OXPIC6,OXPIC7,OXPIC8,OXPIC9,OXPIC10,OXPIC11,OXPIC12,OXWEIGHT,OXSTOCK,OXSTOCKFLAG,OXSTOCKTEXT,OXNOSTOCKTEXT,OXDELIVERY,OXINSERT,OXTIMESTAMP,OXLENGTH,OXWIDTH,OXHEIGHT,OXFILE,OXSEARCHKEYS,OXTEMPLATE,OXQUESTIONEMAIL,
OXISSEARCH,OXISCONFIGURABLE,OXVARNAME,OXVARSTOCK,OXVARCOUNT,OXVARSELECT,OXVARMINPRICE,OXVARMAXPRICE,OXVARNAME_1,OXVARSELECT_1,OXVARNAME_2,OXVARSELECT_2,OXVARNAME_3,OXVARSELECT_3,OXTITLE_1,OXSHORTDESC_1,OXURLDESC_1,OXSEARCHKEYS_1,OXTITLE_2,OXSHORTDESC_2,OXURLDESC_2,OXSEARCHKEYS_2,OXTITLE_3,OXSHORTDESC_3,OXURLDESC_3,OXSEARCHKEYS_3,OXBUNDLEID,OXFOLDER,OXSUBCLASS,
OXSTOCKTEXT_1,OXSTOCKTEXT_2,OXSTOCKTEXT_3,OXNOSTOCKTEXT_1,OXNOSTOCKTEXT_2,OXNOSTOCKTEXT_3,OXSORT,OXSOLDAMOUNT,OXNONMATERIAL,OXFREESHIPPING,OXREMINDACTIVE,OXREMINDAMOUNT,OXAMITEMID,OXAMTASKID,OXVENDORID,OXMANUFACTURERID,OXSKIPDISCOUNTS,OXRATING,OXRATINGCNT,OXMINDELTIME,OXMAXDELTIME,OXDELTIMEUNIT,OXUPDATEPRICE,OXUPDATEPRICEA,OXUPDATEPRICEB,OXUPDATEPRICEC,OXUPDATEPRICETIME,OXISDOWNLOADABLE,OXSHOWCUSTOMAGREEMENT)
VALUES
('adc5ee42bd3c37a27a488769d22ad9ed', '1', '', '1', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '3102', '', '', '', 'Neoprenanzug NPX VAMP', 'Preiswerter Neoprenanzug für Frauen - Semidry', '179', '0', '0', '0', '0', '0', '229', '', '0', '', '', '', NULL, 'vamp_su9448_th_th.jpg', 'vamp_su9448_ico_ico.jpg', 'vamp_su9448_z1.jpg', '', '', '', '', '', '', '', '', '', '', '', '0', '1', '1', '', '', '0000-00-00', '2010-12-09', '2017-10-19 16:39:08', '0', '0', '0', '', '', '', '', '1', '0', '', '0', '0', '', '179', '0',
'', '', '', '', '', '', 'Wetsuit NPX VAMP', 'Semidry wetsuit for women', '', 'wetsuit, suit, semidry, npx, neoprene, vamp, 2010', '', '', '', '', '', '', '', '', '', '', 'oxarticle', '', '', '', '', '', '', '0', '0', '0', '0', '0', '0', '', '', '', 'dc5ec524a9aa6175cf7a498d70ce510a', '0', '0', '0', '3', '4', 'DAY', '0', '0', '0', '0', '0000-00-00 00:00:00', '0', '1'),
('ed6573c0259d6a6fb641d106dcb2faec', '1', '', '1', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2103', '', '', '', 'Wakeboard LIQUID FORCE GROOVE 2010', 'Stylisches Wakeboard mit traumhafter Performance', '329', '0', '0', '0', '0', '0', '399', '', '0', '', '', '', NULL, '', '', 'lf_groove_2010_1.jpg', 'lf_groove_2010_deck_1.jpg', 'lf_groove_2010_bottom_1.jpg', '', '', '', '', '', '', '', '', '', '0', '4', '1', '', '', '0000-00-00', '2010-12-09', '2018-03-22 12:22:17', '0', '0', '0', '',
'wakeboarding, wake, board, liquid force, groove', '', '', '1', '0', '', '0', '0', '', '329', '329', '', '', '', '', '', '', 'Wakeboard GROOVE', 'A stylish wakeboard with a fabtastic performance', '', 'wakeboarding, wake, board, liquid force, groove', '', '', '', '', '', '', '', '', '', '', 'oxarticle', '', '', '', '', '', '', '0', '6', '0', '0', '0', '0', '', '', '', 'adc6df0977329923a6330cc8f3c0a906', '0', '0', '0', '1', '3', 'DAY', '0', '0', '0', '0', '0000-00-00 00:00:00', '0', '1'),
('very_expensive', '1', '', '1', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2401', '', '', '', 'Bindung OBRIEN DECADE CT 2010', 'Geringes Gewicht, beste Performance!', '1000002', '0', '0', '0', '0', '0', '399', '', '0', '', '', '', NULL, '', '', 'obrien_decade_ct_boot_2010_1.jpg', '', '', '', '', '', '', '', '', '', '', '', '0', '15', '1', '', '', '0000-00-00', '2010-12-06', '2018-04-12 14:43:43', '0', '0', '0', '', 'bindung, decade, schuh, wakeboarding', '', '', '1', '0', '', '0', '0', '', '1000002', '1000002',
'', '', '', '', '', '', 'Binding OBRIEN DECADE CT 2010', 'Less weight, best performance!', '', 'binding, decade, boot, wakeboarding', '', '', '', '', '', '', '', '', '', '', 'oxarticle', '', '', '', '', '', '', '0', '2', '0', '0', '0', '0', '', '', '', '', '0', '0', '0', '4', '6', 'DAY', '0', '0', '0', '0', '0000-00-00 00:00:00', '0', '1');

REPLACE INTO oxaddress (OXID,OXUSERID,OXADDRESSUSERID,OXCOMPANY,OXFNAME,OXLNAME,OXSTREET,OXSTREETNR,OXADDINFO,OXCITY,OXCOUNTRY,OXCOUNTRYID,OXSTATEID,OXZIP,OXFON,OXFAX,OXSAL,OXTIMESTAMP)
VALUES
('41b545c65fe99ca2898614e563a7108f', 'oxdefaultadmin', '', '', 'Gregory', 'Dabrowski', 'Karnapp', '25', '', 'Hamburg', '', 'a7c40f631fc920687.20179984', '', '21079', '', '', 'MR', '2018-03-22 11:33:29'),
('41b545c65fe99ca2898614e563a7108a', '92ebae5067055431aeaaa6f75bd9a131', '', '', 'Gregory', 'Dabrowski', 'Karnapp', '25', '', 'Hamburg', '', 'a7c40f631fc920687.20179984', '', '21079', '', '', 'MR', '2018-03-22 11:33:29'),
('41b545c65fe99ca2898614e563a7108b', '92ebae5067055431aeaaa6f75bd9a132', '', '', 'Gregory', 'Dabrowski', 'Karnapp', '25', '', 'Hamburg', '', 'a7c40f631fc920687.20179984', '', '21079', '', '', 'MR', '2018-03-22 11:33:29'),
('invalid', 'fake-user', '', '', 'Gregory', 'Dabrowski', '', '25', '', '', '', 'a7c40f631fc920687.20179984', '', '21079', '', '', 'MR', '2018-03-22 11:33:29');

REPLACE INTO oxcategories (OXID,OXPARENTID,OXLEFT,OXRIGHT,OXROOTID,OXSORT,OXACTIVE,OXHIDDEN,OXSHOPID,OXTITLE,OXDESC,OXLONGDESC,OXTHUMB,OXTHUMB_1,OXTHUMB_2,OXTHUMB_3,OXEXTLINK,OXTEMPLATE,OXDEFSORT,OXDEFSORTMODE,OXPRICEFROM,OXPRICETO,OXACTIVE_1,OXTITLE_1,OXDESC_1,OXLONGDESC_1,OXACTIVE_2,OXTITLE_2,OXDESC_2,OXLONGDESC_2,OXACTIVE_3,OXTITLE_3,OXDESC_3,OXLONGDESC_3,OXICON,OXPROMOICON,OXVAT,OXSKIPDISCOUNTS,OXSHOWSUFFIX,OXTIMESTAMP)
VALUES ('fadcb6dd70b9f6248efa425bd159684e', 'oxrootid', 1, 2, 'fadcb6dd70b9f6248efa425bd159684e', 4, 1, 0, 1, 'Angebote', '', '', 'angebote_1_tc.jpg', 'special_offers_1_tc.jpg', '', '', '', '', '', 0, 0, 0, 1, 'Special Offers', '', '', 0, '', '', '', 0, '', '', '', '', '', NULL, 0, 1, '2017-10-19 16:39:08');
REPLACE INTO oxobject2category (OXID, OXOBJECTID, OXCATNID, OXPOS, OXTIME, OXTIMESTAMP)
VALUES ('adc5ee42bd3c37a27a488769dabcd9ed', 'adc5ee42bd3c37a27a488769d22ad9ed', 'fadcb6dd70b9f6248efa425bd159684e', 0, 0, '2018-04-10 11:11:02');
REPLACE INTO oxmanufacturers (OXID,OXSHOPID,OXACTIVE,OXICON,OXTITLE,OXSHORTDESC,OXTITLE_1,OXSHORTDESC_1,OXTITLE_2,OXSHORTDESC_2,OXTITLE_3,OXSHORTDESC_3,OXSHOWSUFFIX,OXTIMESTAMP)
VALUES ('3a909e7c886063857e86982c7a3c5b84', 1, 1, 'mauirippers_1_mico.png', 'Mauirippers', '', 'Mauirippers', '', '', '', '', '', 0, '2017-10-19 16:39:08');
REPLACE INTO `oxwrapping` (OXID,OXSHOPID,OXACTIVE,OXACTIVE_1,OXACTIVE_2,OXACTIVE_3,OXTYPE,OXNAME,OXNAME_1,OXNAME_2,OXNAME_3,OXPIC,OXPRICE,OXTIMESTAMP)
VALUES
('81b40cf210343d625.49755120', '1', '1', '1', '1', '1', 'WRAP', 'Gelbe Sterne', 'Yellow stars', '', '', 'img_geschenkpapier_1_gelb_wp.gif', '2.95', '2017-10-19 16:39:08'),
('81b40cf0cd383d3a9.70988998', '1', '1', '1', '1', '1', 'CARD', 'Haifisch', 'Shark', '', '', 'img_ecard_03_wp.jpg', '3', '2017-10-19 16:39:08');
REPLACE INTO `oxdiscount` (OXID,OXSHOPID,OXACTIVE,OXACTIVEFROM,OXACTIVETO,OXTITLE,OXTITLE_1,OXTITLE_2,OXTITLE_3,OXAMOUNT,OXAMOUNTTO,OXPRICETO,OXPRICE,OXADDSUMTYPE,OXADDSUM,OXITMARTID,OXITMAMOUNT,OXITMMULTIPLE,OXSORT,OXTIMESTAMP)
VALUES ('9fc3e801da9cdd0b2.74513077', 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '10% ab 200 Euro Einkaufswert', '10% on 200 Euro or more', '', '', 0, 999999, 999999, 200, '%', 10, '', 0, 0, 20, '2018-04-23 11:01:04');
