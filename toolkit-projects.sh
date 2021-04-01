#!/bin/bash
# Vamos clonar os repositórios foco do toolkit para podermos modificar e atualizar
# e linkar na pasta vendor/uspdev

BASE_DIR=$PWD
ORG="uspdev"
DST_DIR="uspdev-projects"

clone_update() {
    local SRC=$ORG/$1
    local DST=$DST_DIR/$1
    echo -n "$DST.. "
    if [[ -d $DST ]]; then
        cd $DST
        git pull
        cd $BASE_DIR
    else
        git clone git@github.com:$SRC $DST
    fi
    rm -rf vendor/$SRC
    ln -s $PWD/$DST vendor/$SRC
}

clone_update "replicado"
clone_update "laravel-usp-theme"
clone_update "wsfoto"
clone_update "utils"

echo ""
echo "Projetos em Uspdev-projects linkados no vendor !!"
