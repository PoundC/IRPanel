#!/usr/bin/env bash
sleep 180
screen -S IRPanel -dm bash -c '/var/www/irpanel/bin/cake i_r_c_bot'
