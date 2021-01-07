#!/bin/bash

DBUSER=root
DBPASSWORD=qt67uy
DATABASE=torrent

for i in public/torrents/*; do mysql -u$DBUSER -p$DBPASSWORD -D$DATABASE -e "INSERT INTO torrent (\`created_at\`, \`updated_at\`,\`user\`, \`torrent\`, \`download\`, \`when_downloaded\`) VALUES (now(), now(),'admin', '${i##*/}', 1, now())" ; done
