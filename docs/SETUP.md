# Setup Scheduler & Queue

## Queue Worker (Supervisor contoh)
```
[program:7play-queue]
command=php /var/www/7play/artisan queue:work --queue=default --sleep=3 --tries=3 --backoff=5
process_name=%(program_name)s_%(process_num)02d
autostart=true
autorestart=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/log/supervisor/7play-queue.log
```

## Scheduler (cron)
```
* * * * * php /var/www/7play/artisan schedule:run >> /dev/null 2>&1
```

## Local Development
- Jalankan `php artisan schedule:work` untuk scheduler
- Jalankan `php artisan queue:work` untuk worker

## Catatan
- Gunakan `QUEUE_CONNECTION=database` dan migrasikan tabel jobs.
- Pastikan mailer terkonfigurasi untuk pengiriman e-ticket.
