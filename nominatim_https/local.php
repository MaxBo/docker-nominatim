<?php
 // General settings
 @define('CONST_Database_DSN', 'pgsql://nominatim@' . getenv('PGHOST') . ':5432/nominatim'); // <driver>://<username>:<password>@<host>:<port>/<database>
 @define('CONST_Website_BaseURL', '/nominatim/');
 // Software versions
 @define('CONST_Postgresql_Version', '9.6');
 @define('CONST_Postgis_Version', '2.3');
 // background map as https
 @define('CONST_Map_Tile_URL', 'https://maps.wikimedia.org/osm-intl/{z}/{x}/{y}.png');
?>
