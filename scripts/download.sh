#!/bin/bash
#transmission-gtk -m $1
#transmission-cli -w /mnt/diskG/films/ $1
#надо написать для нескольких торрентов
#ключ -p указывает порт (по умолчанию это 51413)
#соответственно нужен инкремент для каждого торрента + 1
#можно пропинговать порты
#можно узнать существует ли порт
#netstat -n | grep 51413
i=51413;
while [ $i -le 51433 ]
  do
  IP=$(netstat -n | grep $i | tail -n 1 | awk '{print($4)}')
  PORT=${IP##*:}
  if [ -z "$PORT" ]
    then
      #echo "transmission-cli -p $i -w /home/leo/Загрузки/ $1"
      transmission-cli -p $i -w /home/leo/ $1
      break
    #else
      #echo "continue $PORT"
      #continue
  fi
  #echo $i
  i=$[ $i + 1 ]
done
#sleep 3
#PID=$(ps aux | awk '$13~/'$1'/{print($2)}')
#DBLOGIN=
#DBPASSWORD=
#DBNAME=
#MYPID=$(echo $PID | awk 'NR~/1/{print($1)}')
#mysql -u $DBLOGIN -p$DBPASSWORD -D $DBNAME -e "UPDATE torrents SET \`pid\`='$MYPID' WHERE \`torrent\`='$1'"

#transmission-cli --finish <script>
#Указать скрипт, который будет закидывать в БД о завершении загрузки
#Добавить в базу строчку где будет храниться pid, но в transmission-cli --finish <script> указать пустой после завершения скачивания
#ps aux | awk '$13~/Iron_Man.mkv_37716.torrent/{print($2)}' - номер pid'а, который нужно будет убить по завершению либо по требованию пользователя:
#kill -9 $(ps aux | awk '$13~/Iron_Man.mkv_37716.torrent/{print($2)}')
#
