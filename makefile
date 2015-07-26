default: prod

push:
	git push

prod: push
	ssh najomi 'cd ru.najomi.org; git pull;  make install; make up'
	curl http://ru.najomi.org/update-db > /dev/null 2> /dev/null

up: cc log-chown
	chown -R :www-data cache 
	chmod -R g+w cache

install:
	git submodule update --init --recursive
	chown -R :www-data cache 
	chmod -R g+w cache
	chown :www-data log
	chmod g+w log

log-chown:
	chown :www-data log
	chmod g+w log

cc:
	rm -rf cache/*

