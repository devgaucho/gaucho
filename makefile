COMPOSER:= 	composer
JS_SOURCES := 	js/inc/jquery.js \
	js/inc/rotas.js \
	js/inc/jquery.js \
	js/inc/chaplin.js \
	js/inc/spa.js \
	js/script.js
LESS := 	lessc
PHP := 		php
TERSER := 	terser
clean:
	rm -f public/css/style.css public/js/script.js
dump:
	$(COMPOSER) dump-autoload
install: dump vendor
mig:
	$(PHP) bin/mig.php
off:
	touch off
on:
	rm -f off
public/css/style.css: less/style.less
	$(LESS) $< $@ --clean-css
public/js/script.js: $(JS_SOURCES)
	$(TERSER) $^ --output $@ --compress
pull:
	git pull origin main
run:
	cd public && php -S localhost:8080
spa:
	$(PHP) bin/spa.php	
static: clean spa public/css/style.css public/js/script.js
vendor: composer.json composer.lock
	$(COMPOSER) install