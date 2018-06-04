#!/bin/bash

# By https://github.com/obihann/archey-osx/blob/master/bin/archey

distro="macOS $(sw_vers -productVersion)"
kernel=$(uname)
uptime=$(uptime | sed 's/.*up \([^,]*\), .*/\1/')
shell="$SHELL"
terminal="$TERM ${TERM_PROGRAM//_/ }"
cpu=$(sysctl -n machdep.cpu.brand_string)
battery=$(ioreg -c AppleSmartBattery -r | awk '$1~/Capacity/{c[$1]=$3} END{OFMT="%.2f%"; max=c["\"MaxCapacity\""]; if (max>0) { print 100*c["\"CurrentCapacity\""]/max;} }')
ram="$(( $(sysctl -n hw.memsize) / 1024 ** 3  )) GB"
disk=$(df | head -2 | tail -1 | awk '{print $5}')

RED=$(tput       setaf 1 2>/dev/null)
GREEN=$(tput     setaf 2 2>/dev/null)
YELLOW=$(tput    setaf 3 2>/dev/null)
BLUE=$(tput      setaf 4 2>/dev/null)
PURPLE=$(tput    setaf 5 2>/dev/null)
textColor=$(tput setaf 6 2>/dev/null)
normal=$(tput    sgr0 2>/dev/null)

echo -e "
${GREEN#  }                 ###
${GREEN#  }               ####
${GREEN#  }               ###
${GREEN#  }       #######    #######          ${textColor}Distro: ${normal}${distro}${normal}
${YELLOW# }     ######################        ${textColor}Kernel: ${normal}${kernel}${normal}
${YELLOW# }    #####################          ${textColor}Uptime: ${normal}${uptime}${normal}
${RED#    }    ####################           ${textColor}Shell:  ${normal}${shell}${normal}
${RED#    }    ####################           ${textColor}Termi.: ${normal}${terminal}${normal}
${RED#    }    #####################          ${textColor}CPU:    ${normal}${cpu}${normal}
${PURPLE# }     ######################        ${textColor}Memory: ${normal}${ram}${normal}
${PURPLE# }      ####################         ${textColor}Disk:   ${normal}${disk}${normal}
${BLUE#   }        ################           ${textColor}Batte.: ${normal}${battery}%${normal}
${BLUE#   }         ####     #####${normal}"