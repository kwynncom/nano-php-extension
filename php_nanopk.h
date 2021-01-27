#define PHP_NANOPK_EXTNAME "nanopk"
#define PHP_NANOPK_VERSION "0.0.14"

PHP_FUNCTION(nanopk);
PHP_FUNCTION(nanopkavg);
PHP_FUNCTION(nanotime);
PHP_FUNCTION(nanotime_array);
PHP_FUNCTION(rdtscp);
PHP_FUNCTION(uptime);

#define NANOPK_UNS      1
#define NANOPK_TSC      2
#define NANOPK_PID      4
#define NANOPK_U        8
#define NANOPK_UNSOI   16
#define NANOPK_UNSOF   32
#define NANOPK_VERSION 64
#define NANOPK_ALL 0xffff
