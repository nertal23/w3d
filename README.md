# exportorders

# Synopsis
Welcome to W3D ExportOrder on Magento 2.0 Installation! We're glad to see you interested in our extension. 
First time in the market, Magento 2 W3D ExportOrder is created to be compatible with Magento 2.
This project aims to facilitate the process of exporting orders in different formats (in database table, csv file and xml file) just by changing some simple configuration options in the backend.


# Step 1: Verify your prerequisites
Use the following table to verify you have the correct prerequisites to install the Magento software.

Prerequisite                                                              
Magento version Community Edition 2.0 

How to check
Go to admin page, you can see version of Magento 2 at left bottom page


# Step 2: Pre-Installation
The Magento front end relies heavily on caching to provide a faster experience to customer. This is a wonderful tool, but can wreak havoc during the installation process. To ensure that cache is not the cause of any problem, you'd better turn it off. This can be done from the admin console by navigating to the Cache Management page (System->Cache Management), selecting all caches, clicking "disable" from the drop-down menu, and submitting the change.

You also should run the Magento software in developer mode when you’re extending or customizing it. You can use this command line to show current mode:
php bin/magento deploy:mode:show
Use this command to change to developer mode :
php bin/magento deploy:mode:set developer


# Step 3: Install and verify the installation
-Install by Composer : You can install the module by Composer (If your server supports Composer). 
You now need to edit Magento 2’s composer.json file by writing the following code that will add your module:
"repositories": [
   {
     "type": "vcs",
     "url": "https://github.com/nertal23/w3d"
   }
 ]
If your module is still in development then also change the following code within composer.json from stable to dev:
"minimum-stability": "dev",
Please go to the Magento folder and run the command:
composer require w3d/exportorders

-Install by uploading files:
You can download as "zip" file and unzip W3D ExportOrder extension or clone this repository by the following commands:
Use SSH: git clone git@github.com:nertal23/w3d.git
Use HTTPS: git clone https://github.com/nertal23/w3d.git
When you have completed, you will have a folder containing all files of this extension. Then, please create the folder app/code/W3D/ExportOrder and copy all files which you have downloaded to that folder.

After that, please upload the app folder to your Magento 2 root folder.

Then you open a terminal application, change to magento root directory and use command line 
cd [magento 2 root folder]
php bin/magento module:enable W3D_ExportOrder
php bin/magento setup:upgrade

After that, if your website is in the production mode, please run the command:
php bin/magento setup:static-content:deploy
Finally, coming back to Magento 2 admin to check if W3D ExportOrder extension is installed properly






