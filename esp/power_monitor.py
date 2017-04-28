import socket
import network
import machine
import time
from ADS1x15 import ADS1115 

sensor_adj_above_20W = [0.845, 0.419, 0.419]
sensor_adj_below_20W = [0.845, 0.419, 0.419]
wlan_ssid='ssid'
wlan_pass='pass'
service_url='http://comeserver.com/'
service_secret='somepassword'


sta_if = network.WLAN(network.STA_IF)
ap_if = network.WLAN(network.AP_IF)
sta_if.active(True)
sta_if.connect(wlan_ssid, wlan_pass)
sta_if.ifconfig()

service_url=service_url + 'update_values.php?pass=' + service_secret
i2c = machine.I2C(-1, machine.Pin(5), machine.Pin(4))
ads = ADS1115(i2c)
ads.gain = 2

def reboot_sequence(point):
    print ('Got exception at: %s. Rebooting' % point)
    time.sleep(5)
    machine.reset()
def http_get(url):
    _, _, host, path = url.split('/', 3)
    try:
        addr = socket.getaddrinfo(host, 80)[0][-1]
        s = socket.socket()
        s.connect(addr)
        s.send(bytes('GET /%s HTTP/1.0\r\nHost: %s\r\nUser-Agent: https://github.com/Seitanas/\r\n\r\n' % (path, host), 'utf8'))
        while True:
            data = s.recv(100)
            if data:
                print(str(data, 'utf8'), end='')
            else:
                break
        s.close()
    except:
        reboot_sequence('http_get')
def read_sensor(sensor_id):
    x = 0
    value = 0
    tmp = 0
    while x < 40:
        try:
            tmp = ads.read(sensor_id) 
        except:
            reboot_sequence('sensor_read')
        if tmp < 0: # check if gol negative wave reading
            tmp = tmp * -1 # invert voltage
        if tmp <= 3 : # treat low values as noise
            tmp = 0
        if value < tmp: #get peak voltage
            value = tmp
        x += 1
    print ("value ", value)
    if value > 20:
        value = value * sensor_adj_above_20W[sensor_id]
    else:
        value = value * sensor_adj_below_20W[sensor_id]
    return value

while True:
    reading_array = []
    sensor_nr=0
    while sensor_nr < 3:
        value = read_sensor(sensor_nr)
        reading_array.append(value)
        print (value)
        sensor_nr += 1
    http_get(service_url + '&sensor1=%s' % reading_array[0] + '&sensor2=%s' % reading_array[1] + '&sensor3=%s' % reading_array[2] )
    time.sleep(10)
