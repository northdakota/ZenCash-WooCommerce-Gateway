# ZenCash-WooCommerce-Gateway
A WooCommerce extension for accepting ZenCash

## Dependancies
This plugin is rather simple but there are a few things that need to be set up before hand.

* A web server! Ideally with the most recent versions of PHP and mysql

* A ZenCash wallet. You can find wallets [here](https://zencash.com/wallets/)

* [WordPress](https://wordpress.org)
Wordpress is the backend tool that is needed to use WooCommerce and this ZenCash plugin

* [WooCommerce](https://woocommerce.com)
This ZenCash plugin is an extension of WooCommerce, which works with WordPress

## Step 1: Activating the plugin
* Downloading: First of all, you will need to download the plugin. You can download the latest release as a .zip file from https://github.com/northdakota/ZenCash-WooCommerce-Gateway/releases If you wish, you can also download the latest source code from GitHub. This can be done with the command `git clone https://github.com/northdakota/ZenCash-WooCommerce-Gateway.git` or can be downloaded as a zip file from the GitHub web page.

* Unzip the file if you downloaded the zip from the releases page [here](https://github.com/northdakota/ZenCash-WooCommerce-Gateway/releases).

* Put the plugin in the correct directory: You will need to put the folder named `zencash` from this repo/unzipped release into the wordpress plugins directory. This can be found at `path/to/wordpress/folder/wp-content/plugins`

* Activate the plugin from the WordPress admin panel: Once you login to the admin panel in WordPress, click on "Installed Plugins" under "Plugins". Then simply click "Activate" where it says "ZenCash - WooCommerce Gateway"

## Step 2 Option 1: Use your wallet address

* Get your ZenCash wallet address starting with 'zn' and set up it on configuration page.

## Step 2 Option 2: Get a ZenCash daemon to connect to (*prefered*)

### Running a full node yourself

To do this: start the ZenCash daemon on your server and leave it running in the background. 
You can install your ZenCash Full Node using following [guide](https://medium.com/@jm9k/how-to-setup-up-a-zencash-node-a-guide-for-complete-noobs-d585216d289a)
The first time that you start your node, the zend daemon will download and sync the entire zencash blockchain. 
This can take several hours and is best done on a machine with at least 4GB of ram, 
an SSD hard drive (with at least 20GB of free space), and a high speed internet connection.

### Setup your zencash rpc connection

* On server where your full node located you need to change/add following lines to config file situated at `~/.zen/zen.conf`

```
rpcuser=RANDOMUSER
rpcpassword=RANDOMPASSWORD
rpcport=18231
rpcallowip=127.0.0.1
server=1
daemon=1
```
Please change `rpcuser` and `rpcpassword` to secure credentials, and don't pass them to any third party peoples. 
Change rpcallowip to your server ip where wordpress is installed. If you don't know your server ip address you can use following string `0.0.0.0/0`, but keep in mind thats not secure to use it.
When you change these parameters, restart ZenCash node using following commands

```
zen-cli stop
zend
```

## Step 3: Setup ZenCash Gateway in WooCommerce

* Navigate to the "settings" panel in the WooCommerce widget in the WordPress admin panel.

* Click on "Checkout"

* Select "ZenCash GateWay"

* Check the box labeled "Enable this payment gateway"

If You chose to use zencash address:

* Enter your ZenCash wallet address in the box labled "ZenCash Address".

If you chose to use zencash-wallet-rpc:

* Enter the IP address of your server (where your full node is installed) in the box labeled "ZenCash wallet rpc Host/IP"

* Enter the port number of the Wallet RPC in the box labeled "ZenCash wallet rpc port" (will be `18231` if you used the above example).

* Enter the password to your rpc server.

Finally:

* Click on "Save changes"

## Donating to the Devs :)
ZenCash Address : `znpGHmPqoqkDpCoar7wfU3m1wgG6suph8oV`
