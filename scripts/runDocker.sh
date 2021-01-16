#!/bin/bash

../artisan queue:work --timeout=0  --tries=1 --daemon

