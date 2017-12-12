#! /bin/sh


# Taken from http://wiki.openstreetmap.org/wiki/Nominatim/Installation
cat >> ${PGDATA}/postgresql.conf <<EOF
max_connections = 512
shared_buffers = 2GB
maintenance_work_mem = 10GB
work_mem = 50MB
effective_cache_size = 24GB
synchronous_commit = off
checkpoint_timeout = 10min
checkpoint_completion_target = 0.9
fsync = off # For initial import
full_page_writes = off # For initial import
max_wal_size = 4GB
min_wal_size = 256MB
EOF
