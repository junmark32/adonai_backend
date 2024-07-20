@echo off
cd C:\laragon\www\adonbacked
vendor\bin\spark.exe cron:update-appointment-status
