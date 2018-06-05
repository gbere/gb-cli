#!/bin/bash

distro="$(uname -v)"
kernel=$(uname)
uptime=$(uptime | sed 's/.*up \([^,]*\), .*/\1/')
shell="$SHELL"
terminal="$TERM ${TERM_PROGRAM//_/ }"
cpu=$(cat /proc/cpuinfo | grep 'model name' | uniq | sed -r 's/.*: //')
ram="$(( $(grep MemTotal /proc/meminfo | awk '{print $2}') / 1024 / 1024 )) GB"
disk=$(df -h .  | awk 'NR==2{print $5}')

textColor=$(tput setaf 6 2>/dev/null)
normal=$(tput    sgr0 2>/dev/null)

echo -e "
${textColor}Distro: ${normal}${distro}${normal}
${textColor}Kernel: ${normal}${kernel}${normal}
${textColor}Uptime: ${normal}${uptime}${normal}
${textColor}Shell:  ${normal}${shell}${normal}
${textColor}Termi.: ${normal}${terminal}${normal}
${textColor}CPU:    ${normal}${cpu}${normal}
${textColor}Memory: ${normal}${ram}${normal}
${textColor}Disk:   ${normal}${disk}${normal}
"