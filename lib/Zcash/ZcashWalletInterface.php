<?php
/**
 * Created by HeximCZ
 * Date: 5/27/17 2:55 PM
 */

namespace Hexim\HeximZcashBundle\Zcash;

interface ZcashWalletInterface
{

    public function getWalletInfo();
    public function listTransactions($count = 10, $from = 0, $includeWatchOnly = false);
    public function getNewAddress();
    public function z_getNewAddress();
    public function getReceivedByAddress($address,$confirmed = 1);

/*
addmultisigaddress nrequired ["key",...] ( "account" )
backupwallet "destination"
dumpprivkey "zcashaddress"
dumpwallet "filename"
encryptwallet "passphrase"
getaccount "zcashaddress"
getaccountaddress "account"
getaddressesbyaccount "account"
getbalance ( "account" minconf includeWatchonly )
getnewaddress ( "account" )
getrawchangeaddress
getreceivedbyaccount "account" ( minconf )
getreceivedbyaddress "zcashaddress" ( minconf )
gettransaction "txid" ( includeWatchonly )
getunconfirmedbalance
getwalletinfo
importaddress "address" ( "label" rescan )
importprivkey "zcashprivkey" ( "label" rescan )
importwallet "filename"
keypoolrefill ( newsize )
listaccounts ( minconf includeWatchonly)
listaddressgroupings
listlockunspent
listreceivedbyaccount ( minconf includeempty includeWatchonly)
listreceivedbyaddress ( minconf includeempty includeWatchonly)
listsinceblock ( "blockhash" target-confirmations includeWatchonly)
listtransactions ( "account" count from includeWatchonly)
listunspent ( minconf maxconf  ["address",...] )
lockunspent unlock [{"txid":"txid","vout":n},...]
move "fromaccount" "toaccount" amount ( minconf "comment" )
sendfrom "fromaccount" "tozcashaddress" amount ( minconf "comment" "comment-to" )
sendmany "fromaccount" {"address":amount,...} ( minconf "comment" ["address",...] )
sendtoaddress "zcashaddress" amount ( "comment" "comment-to" subtractfeefromamount )
setaccount "zcashaddress" "account"
settxfee amount
signmessage "zcashaddress" "message"
z_exportkey "zaddr"
z_exportwallet "filename"
z_getbalance "address" ( minconf )
z_getnewaddress
z_getoperationresult (["operationid", ... ])
z_getoperationstatus (["operationid", ... ])
z_gettotalbalance ( minconf )
z_importkey "zkey" ( rescan startHeight )
z_importwallet "filename"
z_listaddresses
z_listoperationids
z_listreceivedbyaddress "address" ( minconf )
z_sendmany "fromaddress" [{"address":... ,"amount":...},...] ( minconf ) ( fee )
zcbenchmark benchmarktype samplecount
zcrawjoinsplit rawtx inputs outputs vpub_old vpub_new
zcrawkeygen
zcrawreceive zcsecretkey encryptednote
zcsamplejoinsplit
*/
}