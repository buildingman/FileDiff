#!/bin/python
import subprocess
import time

p = subprocess.Popen('tail -F file.log', shell=True, stdout=subprocess.PIPE,stderr=subprocess.PIPE,)
while True:
   line = p.stdout.readline()
   if line:
        print line
        time.sleep(1)
