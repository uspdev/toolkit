#!/bin/bash
# Vamos clonar os repositórios foco do toolkit para podermos modificar e atualizar
# e linkar na pasta vendor/uspdev

BASE_DIR=$PWD
DST_DIR="uspdev"

RED='\033[0;34m'
NC='\033[0m' # No Color

clone_update() {
    local SRC=uspdev/$1
    local DST=$DST_DIR/$1
    printf "${RED} $DST ..${NC}\n"

    if [[ -d $DST ]]; then
        cd $DST
        git checkout master || git checkout main
        git pull
        cd $BASE_DIR
    else
        git clone git@github.com:$SRC $DST
    fi
}

clone_update "cache"
clone_update "laravel-tools"
clone_update "laravel-usp-theme"
clone_update "laravel-replicado"
clone_update "replicado"
clone_update "senhaunica-socialite"
clone_update "utils"
clone_update "wsfoto"

echo ""
echo "Projetos em uspdev/ atualizados !!"
