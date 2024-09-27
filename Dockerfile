FROM tomsik68/xampp:8
WORKDIR /www
RUN mkdir CityWatch
COPY . CityWatch/
CMD ["/bin/bash", "-c", "/opt/lampp/lampp start && sleep 10 && \
    DB_EXISTS=$( /opt/lampp/bin/mysql -e 'SHOW DATABASES LIKE \"CityWatch\";' ) && \
    if [ -z \"$DB_EXISTS\" ]; then \
    /opt/lampp/bin/mysql -e 'CREATE DATABASE CityWatch' && \
    /opt/lampp/bin/mysql CityWatch < /www/CityWatch/CityWatch-database.sql; \
    fi && \
    tail -f /opt/lampp/logs/error_log"]