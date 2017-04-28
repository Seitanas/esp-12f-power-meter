# ESP-12f power monitor.

Power meter based on ESP-12f module.
Power data is read from split core current sensors by ADS1115 module.

ESP module sends data via WIFI to remote web server.



Requirements:  
WEB: PHP MySQL  
ESP: Micropython firmware  
  
  
## Installaton 

  
Populate database with sql/db.sql file  
Configure your portal/config.php  
Configure esp/power_monitor.py  
Copy files from portal/ to your webserver.  
After esp module is powered on, it should start sending data to your portal.  
  
  
## Some screenshots:  
  
  
![alt text](https://raw.githubusercontent.com/Seitanas/esp-12f-power-meter/master/img/screenshot1.png)  
![alt text](https://raw.githubusercontent.com/Seitanas/esp-12f-power-meter/master/img/img1.jpg)  
![alt text](https://raw.githubusercontent.com/Seitanas/esp-12f-power-meter/master/img/img2.jpg)  
![alt text](https://raw.githubusercontent.com/Seitanas/esp-12f-power-meter/master/img/img3.jpg)  
![alt text](https://raw.githubusercontent.com/Seitanas/esp-12f-power-meter/master/img/img4.jpg)  
![alt text](https://raw.githubusercontent.com/Seitanas/esp-12f-power-meter/master/img/img5.jpg)  