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
      echo "transmission-cli -p $i -w /mnt/diskG/films/ $1"
      transmission-cli -p $i -w /mnt/diskG/films/ $1
      break
    else
      echo "continue $PORT"
      #continue
  fi
  echo $i
  i=$[ $i + 1 ]
done
#transmission-cli --finish <script>
#Указать скрипт, который будет закидывать в БД о завершении загрузки
