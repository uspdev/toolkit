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
        git checkout master || git checkout main
        git pull
        cd $BASE_DIR
    else
        git clone git@github.com:$SRC $DST
    fi
    # rm -rf vendor/$SRC
    # ln -s $PWD/$DST vendor/$SRC
}

clone_update "cache"
clone_update "laravel-tools"
clone_update "laravel-usp-theme"
clone_update "replicado"
clone_update "senhaunica-socialite"
clone_update "utils"
clone_update "wsfoto"

echo ""
echo "Projetos em Uspdev-projects atualizados !!"
